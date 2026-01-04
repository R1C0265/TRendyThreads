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

$cartId = (int)$_POST['cart_id'];
$quantity = (int)$_POST['quantity'];
$userId = $_SESSION['userId'];

if ($cartId <= 0 || $quantity <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid cart ID or quantity']);
    exit;
}

try {
    // Verify cart item belongs to user
    $cartItem = $db->query("SELECT * FROM cart WHERE id = ? AND user_id = ?", $cartId, $userId)->fetchArray();
    
    if (!$cartItem) {
        echo json_encode(['success' => false, 'message' => 'Cart item not found']);
        exit;
    }
    
    // Update quantity
    $db->query("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?", $quantity, $cartId, $userId);
    
    echo json_encode(['success' => true, 'message' => 'Cart updated']);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>