<?php
require_once '../config/main.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['image_id'])) {
    $image_id = $_POST['image_id'];
    
    // Get image info before deletion
    $image = $db->query("SELECT image_path FROM bail_images WHERE id = ?", $image_id)->fetchArray();
    
    if ($image) {
        // Delete from database
        $db->query("DELETE FROM bail_images WHERE id = ?", $image_id);
        
        // Delete physical file
        $file_path = '../' . $image['image_path'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Image not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>