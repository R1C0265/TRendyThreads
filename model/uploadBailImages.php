<?php
require_once '../config/main.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bail_id = $_POST['bail_id'];
    $uploaded_files = [];
    
    // Create upload directory if it doesn't exist
    $upload_dir = '../assets/img/bails/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Check current image count
    $current_count = $db->query("SELECT COUNT(*) as count FROM bail_images WHERE bail_id = ?", $bail_id)->fetchArray();
    $current_images = $current_count['count'];
    
    if (isset($_FILES['images'])) {
        $files = $_FILES['images'];
        $file_count = count($files['name']);
        
        // Check if adding new images would exceed limit
        if ($current_images + $file_count > 20) {
            echo json_encode(['success' => false, 'message' => 'Cannot upload more than 20 images per bail']);
            exit;
        }
        
        for ($i = 0; $i < $file_count; $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                $file_name = $files['name'][$i];
                $file_tmp = $files['tmp_name'][$i];
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                
                // Validate file type
                $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($file_ext, $allowed_types)) {
                    continue;
                }
                
                // Generate unique filename
                $new_filename = 'bail_' . $bail_id . '_' . time() . '_' . $i . '.' . $file_ext;
                $upload_path = $upload_dir . $new_filename;
                
                if (move_uploaded_file($file_tmp, $upload_path)) {
                    // Save to database
                    $image_path = 'assets/img/bails/' . $new_filename;
                    $is_primary = ($current_images == 0 && $i == 0) ? 1 : 0; // First image is primary
                    
                    $db->query(
                        "INSERT INTO bail_images (bail_id, image_path, is_primary) VALUES (?, ?, ?)",
                        $bail_id, $image_path, $is_primary
                    );
                    
                    $uploaded_files[] = $image_path;
                    $current_images++;
                }
            }
        }
    }
    
    echo json_encode(['success' => true, 'uploaded_files' => $uploaded_files]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>