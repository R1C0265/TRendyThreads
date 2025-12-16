<?php
include(dirname(__DIR__) . "/config/main.php");

// Check if user is logged in
if (!isset($_SESSION['userId'])) {
    echo json_encode(['success' => false, 'message' => 'Please log in to add items to cart']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$userId = $_SESSION['userId'];
$productId = (int)$_POST['product_id'];
$quantity = (int)$_POST['quantity'];

if ($productId <= 0 || $quantity <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product or quantity']);
    exit;
}

try {
    // Check if product exists
    $product = $db->query("SELECT * FROM products WHERE product_id = ?", $productId)->fetchArray();
    if (!$product) {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
        exit;
    }
    
    // Check if item already in cart
    $existingItem = $db->query("SELECT * FROM cart WHERE user_id = ? AND product_id = ?", $userId, $productId)->fetchArray();
    
    if ($existingItem) {
        // Update quantity
        $newQuantity = $existingItem['quantity'] + $quantity;
        $db->query("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?", $newQuantity, $userId, $productId);
    } else {
        // Add new item
        $db->query("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)", $userId, $productId, $quantity);
    }
    
    echo json_encode(['success' => true, 'message' => 'Item added to cart']);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>