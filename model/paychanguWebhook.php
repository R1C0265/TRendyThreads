<?php
include(dirname(__DIR__) . "/config/main.php");
require_once dirname(__DIR__) . "/config/paychangu.php";
require_once 'notificationHelper.php';

// Log webhook for debugging
error_log('PayChangu Webhook received: ' . file_get_contents('php://input'));

// Get the raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Verify webhook signature (if PayChangu provides one)
$headers = getallheaders();
$signature = $headers['X-PayChangu-Signature'] ?? '';

if (!verifyWebhookSignature($input, $signature)) {
    http_response_code(401);
    exit('Unauthorized');
}

if (!$data || !isset($data['tx_ref'])) {
    http_response_code(400);
    exit('Invalid data');
}

$transactionId = $data['tx_ref'];
$status = $data['status'] ?? '';
$amount = $data['amount'] ?? 0;

try {
    // Get transaction from database
    $transaction = $db->query("SELECT * FROM payment_transactions WHERE transaction_id = ?", $transactionId)->fetchArray();
    
    if (!$transaction) {
        error_log('PayChangu webhook: Transaction not found - ' . $transactionId);
        http_response_code(404);
        exit('Transaction not found');
    }
    
    // Verify amount matches
    if (abs($amount - $transaction['amount']) > 0.01) {
        error_log('PayChangu webhook: Amount mismatch - Expected: ' . $transaction['amount'] . ', Received: ' . $amount);
        http_response_code(400);
        exit('Amount mismatch');
    }
    
    $orderId = $transaction['order_id'];
    
    if ($status === 'successful' || $status === 'completed') {
        // Payment successful
        $db->query("UPDATE payment_transactions SET status = 'completed' WHERE transaction_id = ?", $transactionId);
        $db->query("UPDATE orders SET payment_status = 'paid' WHERE id = ?", $orderId);
        
        // Complete the order
        completeOrder($orderId);
        
        error_log('PayChangu webhook: Payment completed for order ' . $orderId);
        
    } elseif ($status === 'failed' || $status === 'cancelled') {
        // Payment failed
        $db->query("UPDATE payment_transactions SET status = 'failed' WHERE transaction_id = ?", $transactionId);
        $db->query("UPDATE orders SET payment_status = 'failed' WHERE id = ?", $orderId);
        
        error_log('PayChangu webhook: Payment failed for order ' . $orderId);
    }
    
    // Respond with success
    http_response_code(200);
    echo 'OK';
    
} catch (Exception $e) {
    error_log('PayChangu webhook error: ' . $e->getMessage());
    http_response_code(500);
    exit('Internal error');
}

function verifyWebhookSignature($payload, $signature) {
    // If PayChangu doesn't provide signature verification, return true for now
    // In production, implement proper signature verification
    return true;
    
    // Example signature verification (adjust based on PayChangu's method):
    // $secretKey = PayChanguConfig::getSecretKey();
    // $expectedSignature = hash_hmac('sha256', $payload, $secretKey);
    // return hash_equals($expectedSignature, $signature);
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
        $itemCount = count($orderItems);
        notifySaleCompleted($user['u_name'], "$itemCount items (PayChangu)", $order['total_amount'], $orderId);
        
    } catch (Exception $e) {
        error_log('Order completion error: ' . $e->getMessage());
    }
}
?>