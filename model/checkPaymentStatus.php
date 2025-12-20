<?php
include(dirname(__DIR__) . "/config/main.php");
require_once dirname(__DIR__) . "/config/paychangu.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$transactionId = $_POST['transaction_id'] ?? '';

if (empty($transactionId)) {
    echo json_encode(['success' => false, 'message' => 'Transaction ID required']);
    exit;
}

try {
    // Check local transaction status first
    $transaction = $db->query("SELECT * FROM payment_transactions WHERE transaction_id = ?", $transactionId)->fetchArray();
    
    if (!$transaction) {
        echo json_encode(['success' => false, 'message' => 'Transaction not found']);
        exit;
    }
    
    // If already completed or failed, return that status
    if ($transaction['status'] !== 'pending') {
        echo json_encode(['status' => $transaction['status']]);
        exit;
    }
    
    // Check with PayChangu API
    $response = checkPayChanguTransaction($transactionId);
    
    if ($response && isset($response['status'])) {
        $paymentStatus = 'pending'; // default
        
        if ($response['status'] === 'successful' || $response['status'] === 'completed') {
            $paymentStatus = 'completed';
            
            // Update local records
            $db->query("UPDATE payment_transactions SET status = 'completed' WHERE transaction_id = ?", $transactionId);
            $db->query("UPDATE orders SET payment_status = 'paid' WHERE id = ?", $transaction['order_id']);
            
            // Complete the order (update stock, clear cart, etc.)
            completeOrder($transaction['order_id']);
            
        } elseif ($response['status'] === 'failed' || $response['status'] === 'cancelled') {
            $paymentStatus = 'failed';
            
            // Update local records
            $db->query("UPDATE payment_transactions SET status = 'failed' WHERE transaction_id = ?", $transactionId);
            $db->query("UPDATE orders SET payment_status = 'failed' WHERE id = ?", $transaction['order_id']);
        }
        
        echo json_encode(['status' => $paymentStatus]);
    } else {
        // API call failed, keep as pending
        echo json_encode(['status' => 'pending']);
    }
    
} catch (Exception $e) {
    error_log('Payment status check error: ' . $e->getMessage());
    echo json_encode(['status' => 'pending']);
}

function checkPayChanguTransaction($transactionId) {
    $url = PayChanguConfig::getBaseUrl() . '/payments/verify/' . $transactionId;
    $secretKey = PayChanguConfig::getSecretKey();
    
    $headers = [
        'Authorization: Bearer ' . $secretKey,
        'Content-Type: application/json',
        'Accept: application/json'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_error($ch)) {
        error_log('PayChangu status check cURL error: ' . curl_error($ch));
        curl_close($ch);
        return false;
    }
    
    curl_close($ch);
    
    if ($httpCode !== 200) {
        error_log('PayChangu status check HTTP error: ' . $httpCode);
        return false;
    }
    
    return json_decode($response, true);
}

function completeOrder($orderId) {
    global $db;
    
    try {
        // Get order items
        $orderItems = $db->query("
            SELECT oi.*, b.b_stock_quantity 
            FROM order_items oi 
            JOIN bails b ON oi.product_id = b.b_id 
            WHERE oi.order_id = ?
        ", $orderId)->fetchAll();
        
        // Update bail stock
        foreach ($orderItems as $item) {
            $newStock = $item['b_stock_quantity'] - $item['quantity'];
            $db->query("UPDATE bails SET b_stock_quantity = ? WHERE b_id = ?", $newStock, $item['product_id']);
            
            // Mark bail as sold if stock reaches 0
            if ($newStock <= 0) {
                $db->query("UPDATE bails SET b_status = 'sold' WHERE b_id = ?", $item['product_id']);
            }
        }
        
        // Get order details for notification
        $order = $db->query("SELECT * FROM orders WHERE id = ?", $orderId)->fetchArray();
        $user = $db->query("SELECT u_name FROM users WHERE u_id = ?", $order['user_id'])->fetchArray();
        
        // Clear user's cart
        $db->query("DELETE FROM cart WHERE user_id = ?", $order['user_id']);
        
        // Add notification
        require_once 'notificationHelper.php';
        $itemCount = count($orderItems);
        notifySaleCompleted($user['u_name'], "$itemCount items (PayChangu)", $order['total_amount'], $orderId);
        
    } catch (Exception $e) {
        error_log('Order completion error: ' . $e->getMessage());
    }
}
?>