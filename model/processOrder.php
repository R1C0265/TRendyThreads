<?php
include(dirname(__DIR__) . "/config/main.php");
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
    // Get cart items with bail details
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
    
    // Create shipping address
    $shippingAddress = "$firstName $lastName\n$address\n$city, $state $zip";
    
    // Create order
    $db->query("INSERT INTO orders (user_id, total_amount, payment_method, shipping_address, payment_status) VALUES (?, ?, ?, ?, ?)", 
               $userId, $total, $paymentMethod, $shippingAddress, 'paid');
    
    $orderId = $db->lastInsertID();
    
    // Create order items and update bail stock
    foreach ($cartItems as $item) {
        // Check if enough stock available
        if ($item['b_stock_quantity'] < $item['quantity']) {
            echo json_encode(['success' => false, 'message' => 'Not enough stock for ' . $item['product_name']]);
            exit;
        }
        
        // Insert order item
        $db->query("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)",
                   $orderId, $item['product_id'], $item['quantity'], $item['product_price']);
        
        // Update bail stock
        $newStock = $item['b_stock_quantity'] - $item['quantity'];
        $db->query("UPDATE bails SET b_stock_quantity = ? WHERE b_id = ?", $newStock, $item['product_id']);
        
        // Mark bail as sold if stock reaches 0
        if ($newStock <= 0) {
            $db->query("UPDATE bails SET b_status = 'sold' WHERE b_id = ?", $item['product_id']);
        }
    }
    
    // Clear cart
    $db->query("DELETE FROM cart WHERE user_id = ?", $userId);
    
    // Get customer name for notification
    $customer = $db->query("SELECT u_name FROM users WHERE u_id = ?", $userId)->fetch();
    $itemCount = count($cartItems);
    
    // Add notification for online sale
    notifySaleCompleted($customer['u_name'], "$itemCount items (Online)", $total, $orderId);
    
    echo json_encode(['success' => true, 'order_id' => $orderId, 'message' => 'Order placed successfully']);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>