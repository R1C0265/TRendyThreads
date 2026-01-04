<?php
require_once '../config/main.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['image_id']) && isset($_POST['bail_id'])) {
    $image_id = $_POST['image_id'];
    $bail_id = $_POST['bail_id'];
    
    // First, remove primary status from all images of this bail
    $db->query("UPDATE bail_images SET is_primary = 0 WHERE bail_id = ?", $bail_id);
    
    // Then set the selected image as primary
    $db->query("UPDATE bail_images SET is_primary = 1 WHERE id = ?", $image_id);
    
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>