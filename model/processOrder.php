<?php
include(dirname(__DIR__) . "/config/main.php");

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
$firstName = htmlspecialchars(trim($_POST['first_name']));
$lastName = htmlspecialchars(trim($_POST['last_name']));
$email = htmlspecialchars(trim($_POST['email']));
$address = htmlspecialchars(trim($_POST['address']));
$city = htmlspecialchars(trim($_POST['city']));
$state = htmlspecialchars(trim($_POST['state']));
$zip = htmlspecialchars(trim($_POST['zip']));
$paymentMethod = htmlspecialchars(trim($_POST['payment_method']));

// Validate required fields
if (empty($firstName) || empty($lastName) || empty($email) || empty($address) || empty($city) || empty($state) || empty($zip)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

try {
    // Get cart items
    $cartItems = $db->query("
        SELECT c.*, p.product_name, p.product_price 
        FROM cart c 
        JOIN products p ON c.product_id = p.product_id 
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
    
    // Create shipping address
    $shippingAddress = "$firstName $lastName\n$address\n$city, $state $zip";
    
    // Create order
    $db->query("INSERT INTO orders (user_id, total_amount, payment_method, shipping_address, payment_status) VALUES (?, ?, ?, ?, ?)", 
               $userId, $total, $paymentMethod, $shippingAddress, 'paid');
    
    $orderId = $db->lastInsertID();
    
    // Create order items
    foreach ($cartItems as $item) {
        $db->query("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)",
                   $orderId, $item['product_id'], $item['quantity'], $item['product_price']);
    }
    
    // Clear cart
    $db->query("DELETE FROM cart WHERE user_id = ?", $userId);
    
    echo json_encode(['success' => true, 'order_id' => $orderId, 'message' => 'Order placed successfully']);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>