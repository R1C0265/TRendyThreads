<?php
include(dirname(__DIR__) . "/config/main.php");

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'Product ID required']);
    exit;
}

$productId = (int)$_GET['id'];

try {
    $product = $db->query("SELECT * FROM products WHERE product_id = ?", $productId)->fetchArray();
    
    if ($product) {
        echo json_encode($product);
    } else {
        echo json_encode(['error' => 'Product not found']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>