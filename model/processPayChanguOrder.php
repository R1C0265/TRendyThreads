<?php
include(dirname(__DIR__) . "/config/main.php");
require_once dirname(__DIR__) . "/config/paychangu.php";
require_once 'notificationHelper.php';

if (!isset($_SESSION['userId'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$userId = $_SESSION['userId'];

// Get form data
$firstName = htmlspecialchars(trim($_POST['first_name'] ?? ''));
$lastName = htmlspecialchars(trim($_POST['last_name'] ?? ''));
$email = htmlspecialchars(trim($_POST['email'] ?? ''));
$address = htmlspecialchars(trim($_POST['address'] ?? 'N/A'));
$city = htmlspecialchars(trim($_POST['city'] ?? 'N/A'));
$state = htmlspecialchars(trim($_POST['state'] ?? 'N/A'));
$zip = htmlspecialchars(trim($_POST['zip'] ?? 'N/A'));
$phoneNumber = htmlspecialchars(trim($_POST['phone_number'] ?? ''));
$amount = floatval($_POST['amount'] ?? 0);

// Debug: Log received data
error_log('PayChangu form data: ' . json_encode($_POST));

// Validate only essential fields for PayChangu
if (empty($firstName) || empty($email) || empty($phoneNumber) || $amount <= 0) {
    $missingFields = [];
    if (empty($firstName)) $missingFields[] = 'first_name';
    if (empty($email)) $missingFields[] = 'email';
    if (empty($phoneNumber)) $missingFields[] = 'phone_number';
    if ($amount <= 0) $missingFields[] = 'amount';
    
    echo json_encode([
        'success' => false, 
        'message' => 'Required fields missing: ' . implode(', ', $missingFields),
        'debug' => $_POST
    ]);
    exit;
}

try {
    // Get cart items
    $cartItems = $db->query("
        SELECT c.*, b.b_name as product_name, b.b_avg_price_per_item as product_price, b.b_stock_quantity 
        FROM cart c 
        JOIN bails b ON c.product_id = b.b_id 
        WHERE c.user_id = ?
    ", $userId)->fetchAll();
    
    if (empty($cartItems)) {
        echo json_encode(['success' => false, 'message' => 'Cart is empty']);
        exit;
    }
    
    // Calculate total
    $subtotal = 0;
    foreach ($cartItems as $item) {
        $subtotal += (float)$item['product_price'] * $item['quantity'];
    }
    $tax = $subtotal * 0.08;
    $shipping = $subtotal > 50 ? 0 : 9.99;
    $total = $subtotal + $tax + $shipping;
    
    // Verify amount matches calculated total
    if (abs($amount - $total) > 0.01) {
        echo json_encode(['success' => false, 'message' => 'Amount mismatch']);
        exit;
    }
    
    // Create shipping address (handle optional fields)
    $fullName = trim("$firstName $lastName");
    $addressLine = !empty($address) && $address !== 'N/A' ? $address : 'Address not provided';
    $cityStateZip = [];
    if (!empty($city) && $city !== 'N/A') $cityStateZip[] = $city;
    if (!empty($state) && $state !== 'N/A') $cityStateZip[] = $state;
    if (!empty($zip) && $zip !== 'N/A') $cityStateZip[] = $zip;
    
    $shippingAddress = $fullName . "\n" . $addressLine;
    if (!empty($cityStateZip)) {
        $shippingAddress .= "\n" . implode(', ', $cityStateZip);
    }
    
    // Create order with pending payment status
    $db->query("INSERT INTO orders (user_id, total_amount, payment_method, shipping_address, payment_status) VALUES (?, ?, ?, ?, ?)", 
               $userId, $total, 'paychangu', $shippingAddress, 'pending');
    
    $orderId = $db->lastInsertID();
    
    // Create order items
    foreach ($cartItems as $item) {
        if ($item['b_stock_quantity'] < $item['quantity']) {
            echo json_encode(['success' => false, 'message' => 'Not enough stock for ' . $item['product_name']]);
            exit;
        }
        
        $db->query("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)",
                   $orderId, $item['product_id'], $item['quantity'], $item['product_price']);
    }
    
    // Prepare PayChangu payment request
    $transactionId = 'TT_' . $orderId . '_' . time();
    
    $paymentData = [
        'tx_ref' => $transactionId,
        'amount' => $amount,
        'currency' => 'MWK',
        'email' => $email,
        'phone_number' => $phoneNumber,
        'fullname' => "$firstName $lastName",
        'callback_url' => PayChanguConfig::WEBHOOK_URL,
        'return_url' => PayChanguConfig::RETURN_URL . '?order=' . $orderId,
        'customization' => [
            'title' => 'Trendy Threads Payment',
            'description' => "Order #$orderId - Secondhand Clothing"
        ]
    ];
    
    // Store transaction details
    $db->query("INSERT INTO payment_transactions (order_id, transaction_id, payment_method, amount, status) VALUES (?, ?, ?, ?, ?)",
               $orderId, $transactionId, 'paychangu', $amount, 'pending');
    
    // Check if we have real PayChangu credentials
    $secretKey = PayChanguConfig::getSecretKey();
    
    if ($secretKey === 'your_test_secret_key_here' || $secretKey === 'your_live_secret_key_here') {
        // Demo mode - simulate PayChangu response
        echo json_encode([
            'success' => true,
            'transaction_id' => $transactionId,
            'order_id' => $orderId,
            'message' => 'DEMO MODE: PayChangu payment initiated. In real mode, customer would receive mobile money prompt.',
            'demo_mode' => true
        ]);
    } else {
        // Make real API call to PayChangu
        $response = makePayChanguRequest('/payments', $paymentData);
        
        if ($response && isset($response['status']) && $response['status'] === 'success') {
            // PayChangu returns a payment link or processes directly
            if (isset($response['data']['link'])) {
                echo json_encode([
                    'success' => true,
                    'payment_url' => $response['data']['link'],
                    'transaction_id' => $transactionId,
                    'order_id' => $orderId
                ]);
            } else {
                // Direct mobile money processing
                echo json_encode([
                    'success' => true,
                    'transaction_id' => $transactionId,
                    'order_id' => $orderId,
                    'message' => 'Payment initiated. Please check your phone for mobile money prompt.'
                ]);
            }
        } else {
            // Payment initiation failed
            $errorMessage = isset($response['message']) ? $response['message'] : 'Payment initiation failed';
            
            // Update transaction status
            $db->query("UPDATE payment_transactions SET status = 'failed' WHERE transaction_id = ?", $transactionId);
            
            echo json_encode(['success' => false, 'message' => $errorMessage]);
        }
    }
    
} catch (Exception $e) {
    error_log('PayChangu payment error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Payment processing error. Please try again.']);
}

function makePayChanguRequest($endpoint, $data) {
    $url = PayChanguConfig::getBaseUrl() . $endpoint;
    $secretKey = PayChanguConfig::getSecretKey();
    
    $headers = [
        'Authorization: Bearer ' . $secretKey,
        'Content-Type: application/json',
        'Accept: application/json'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_error($ch)) {
        error_log('PayChangu cURL error: ' . curl_error($ch));
        curl_close($ch);
        return false;
    }
    
    curl_close($ch);
    
    if ($httpCode !== 200) {
        error_log('PayChangu HTTP error: ' . $httpCode . ' - ' . $response);
        return false;
    }
    
    return json_decode($response, true);
}
?>