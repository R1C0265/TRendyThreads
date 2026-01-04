<?php
require_once '../config/main.php';

class ImageManager {
    private $db;
    private $upload_dir = '../assets/uploads/';
    private $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    private $max_size = 5000000; // 5MB
    
    public function __construct($database) {
        $this->db = $database;
        if (!is_dir($this->upload_dir)) {
            mkdir($this->upload_dir, 0755, true);
        }
    }
    
    /**
     * Upload image with automatic cleanup of previous image
     */
    public function uploadImage($file, $section = null, $record_id = null) {
        // Validate file
        $validation = $this->validateFile($file);
        if (!$validation['success']) {
            return $validation;
        }
        
        // Delete previous image if updating
        if ($section && $record_id) {
            $this->deletePreviousImage($section, $record_id);
        }
        
        // Generate unique filename
        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $new_filename = uniqid('img_', true) . '.' . $file_ext;
        $upload_path = $this->upload_dir . $new_filename;
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
            return [
                'success' => true,
                'path' => 'assets/uploads/' . $new_filename,
                'filename' => $new_filename
            ];
        } else {
            return ['success' => false, 'message' => 'Failed to upload image'];
        }
    }
    
    /**
     * Validate uploaded file
     */
    private function validateFile($file) {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'Upload error occurred'];
        }
        
        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($file_ext, $this->allowed_types)) {
            return ['success' => false, 'message' => 'Invalid file type. Only ' . implode(', ', $this->allowed_types) . ' allowed'];
        }
        
        if ($file['size'] > $this->max_size) {
            return ['success' => false, 'message' => 'File too large. Max 5MB allowed'];
        }
        
        return ['success' => true];
    }
    
    /**
     * Delete previous image when updating
     */
    private function deletePreviousImage($section, $record_id) {
        $table_config = [
            'hero' => ['table' => 'hero_content', 'field' => 'hero_image', 'id_field' => 'id'],
            'about' => ['table' => 'about_content', 'field' => 'image_path', 'id_field' => 'id'],
            'user' => ['table' => 'users', 'field' => 'u_img', 'id_field' => 'u_id']
        ];
        
        if (!isset($table_config[$section])) {
            return false;
        }
        
        $config = $table_config[$section];
        $current = $this->db->query(
            "SELECT {$config['field']} FROM {$config['table']} WHERE {$config['id_field']} = ?", 
            $record_id
        )->fetchArray();
        
        if ($current && !empty($current[$config['field']])) {
            $old_file = '../' . $current[$config['field']];
            if (file_exists($old_file)) {
                unlink($old_file);
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Clean up orphaned images (images not referenced in database)
     */
    public function cleanupOrphanedImages() {
        $files = glob($this->upload_dir . '*');
        $orphaned = [];
        
        foreach ($files as $file) {
            if (is_file($file)) {
                $filename = basename($file);
                $relative_path = 'assets/uploads/' . $filename;
                
                // Check if image is referenced in any table
                $tables_to_check = [
                    'hero_content' => 'hero_image',
                    'about_content' => 'image_path',
                    'users' => 'u_img',
                    'bail_images' => 'image_path'
                ];
                
                $is_referenced = false;
                foreach ($tables_to_check as $table => $field) {
                    $result = $this->db->query("SELECT COUNT(*) as count FROM $table WHERE $field = ?", $relative_path)->fetchArray();
                    if ($result['count'] > 0) {
                        $is_referenced = true;
                        break;
                    }
                }
                
                if (!$is_referenced) {
                    $orphaned[] = $file;
                    unlink($file); // Delete orphaned file
                }
            }
        }
        
        return $orphaned;
    }
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check authorization
    if (!isset($_SESSION['userId']) || $_SESSION['userType'] != '2') {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }
    
    $imageManager = new ImageManager($db);
    
    $action = $_POST['action'] ?? 'upload';
    
    switch ($action) {
        case 'upload':
            if (!isset($_FILES['image'])) {
                echo json_encode(['success' => false, 'message' => 'No image uploaded']);
                exit;
            }
            
            $section = $_POST['section'] ?? null;
            $record_id = $_POST['record_id'] ?? null;
            
            $result = $imageManager->uploadImage($_FILES['image'], $section, $record_id);
            echo json_encode($result);
            break;
            
        case 'cleanup':
            $orphaned = $imageManager->cleanupOrphanedImages();
            echo json_encode([
                'success' => true, 
                'message' => 'Cleanup completed',
                'deleted_files' => count($orphaned),
                'files' => array_map('basename', $orphaned)
            ]);
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
}
?>