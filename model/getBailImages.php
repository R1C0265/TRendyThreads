<?php
require_once '../config/main.php';

if (isset($_GET['bail_id'])) {
    $bail_id = $_GET['bail_id'];
    
    $images = $db->query(
        "SELECT id, image_path, is_primary FROM bail_images WHERE bail_id = ? ORDER BY is_primary DESC, created_at ASC",
        $bail_id
    )->fetchAll();
    
    echo json_encode(['success' => true, 'images' => $images]);
} else {
    echo json_encode(['success' => false, 'message' => 'Bail ID required']);
}
?>