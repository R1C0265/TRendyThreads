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
$userId = $_SESSION['userId'];

if ($cartId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid cart ID']);
    exit;
}

try {
    // Verify cart item belongs to user and delete
    $result = $db->query("DELETE FROM cart WHERE id = ? AND user_id = ?", $cartId, $userId);
    
    if ($db->affectedRows() > 0) {
        echo json_encode(['success' => true, 'message' => 'Item removed from cart']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Cart item not found']);
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>