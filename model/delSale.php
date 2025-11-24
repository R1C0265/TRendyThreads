<?php
require_once '../config/main.php';
header('Content-Type: application/json');

$sale_id = intval($_POST['sale_id'] ?? 0);

if ($sale_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid sale ID']);
    exit;
}

// Delete the sale
$query = "DELETE FROM purchases WHERE p_id = ?";
$stmt = $db->connection->prepare($query);
$stmt->bind_param("i", $sale_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Sale deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete sale']);
}

$stmt->close();