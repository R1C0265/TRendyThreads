<?php
include(dirname(__DIR__) . "/config/main.php");

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'Product ID required']);
    exit;
}

$productId = (int)$_GET['id'];

try {
    $bail = $db->query("SELECT *, b_id as product_id, b_name as product_name, b_description as product_description, b_avg_price_per_item as product_price FROM bails WHERE b_id = ?", $productId)->fetchArray();
    
    if ($bail) {
        // Add default image and category
        $bail['product_image_location'] = 'assets/img/bails/' . strtolower(str_replace(' ', '-', $bail['product_name'])) . '.jpg';
        $bail['product_image_alt'] = $bail['product_name'] . ' - Secondhand Clothing Bundle';
        $bail['product_category'] = 'Secondhand Clothing Bundle';
        echo json_encode($bail);
    } else {
        echo json_encode(['error' => 'Bail not found']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>