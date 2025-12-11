<?php
include("../config/main.php");

// Check if user is logged in and is employee
if (!isset($_SESSION['userId']) || $_SESSION['userType'] != '2') {
    header('Location: ../signin.php');
    exit;
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Get and sanitize input
$bail_id = (int)$_POST['bail_id'];
$name = htmlspecialchars(trim($_POST['b_name']), ENT_QUOTES, 'UTF-8');
$items_count = (int)$_POST['b_items_count'];
$avg_price = (float)$_POST['b_avg_price_per_item'];
$stock_quantity = (int)$_POST['b_stock_quantity'];
$purchase_date = $_POST['b_purchase_date'];
$status = $_POST['b_status'];
$description = htmlspecialchars(trim($_POST['b_description']), ENT_QUOTES, 'UTF-8');

// Validate required fields
if (empty($name) || $items_count <= 0 || $avg_price <= 0) {
    echo json_encode(['success' => false, 'message' => 'Required fields missing or invalid']);
    exit;
}

// Update bail record
$query = "UPDATE bails SET 
          b_name = '$name',
          b_items_count = $items_count,
          b_avg_price_per_item = $avg_price,
          b_stock_quantity = $stock_quantity,
          b_purchase_date = '$purchase_date',
          b_status = '$status',
          b_description = '$description',
          b_updated_date = CURRENT_TIMESTAMP
          WHERE b_id = $bail_id";

if ($db->query($query)) {
    echo json_encode(['success' => true, 'message' => 'Bail updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update bail']);
}
exit;
?>