<?php
require_once '../config/main.php';

// Check authorization
if (!isset($_SESSION['userId']) || $_SESSION['userType'] != '2') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['image'])) {
    echo json_encode(['success' => false, 'message' => 'No image uploaded']);
    exit;
}

$section = $_POST['section'] ?? null; // 'hero' or 'about'

if (!in_array($section, ['hero', 'about'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid section']);
    exit;
}

$uploadDir = '../assets/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$file = $_FILES['image'];
$fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

// Validate file
if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Upload error occurred']);
    exit;
}

if (!in_array($fileExt, $allowedExts)) {
    echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, GIF, WEBP allowed']);
    exit;
}

if ($file['size'] > 5000000) { // 5MB limit
    echo json_encode(['success' => false, 'message' => 'File too large. Max 5MB allowed']);
    exit;
}

// Fixed filename based on section
$newFileName = $section . '_image.' . $fileExt;
$uploadPath = $uploadDir . $newFileName;

// Delete old image if exists
if (file_exists($uploadPath)) {
    unlink($uploadPath);
}

// Upload new image
if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
    $relativePath = 'assets/uploads/' . $newFileName;
    
    // Update database
    $table = $section === 'hero' ? 'hero_content' : 'about_content';
    $field = $section === 'hero' ? 'hero_image' : 'image_path';
    
    // Check if record exists
    $existing = $db->query("SELECT id FROM $table WHERE is_active = 1 LIMIT 1")->fetchArray();
    
    if ($existing) {
        // Update existing
        $db->query("UPDATE $table SET $field = ? WHERE is_active = 1", $relativePath);
    } else {
        // Create new record with default values
        if ($section === 'hero') {
            $db->query(
                "INSERT INTO hero_content (title, subtitle, cta_text, cta_link, hero_image, is_active) VALUES (?, ?, ?, ?, ?, 1)",
                'The latest Threads & Fashion', 'Only dress with the best.', 'Shop Now', '#about', $relativePath
            );
        } else {
            $db->query(
                "INSERT INTO about_content (title, description, image_path, is_active) VALUES (?, ?, ?, 1)",
                'About Us', 'Learn more about our company and mission.', $relativePath
            );
        }
    }
    
    // Add notification
    require_once 'notificationHelper.php';
    notifyImageUploaded($section, $relativePath);
    
    echo json_encode(['success' => true, 'path' => $relativePath]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
}
?>