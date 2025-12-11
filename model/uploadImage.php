<?php
include("../config/main.php");

// Check if user is logged in and is employee
if (!isset($_SESSION['userId']) || $_SESSION['userType'] != '2') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['image'])) {
    echo json_encode(['success' => false, 'message' => 'No image uploaded']);
    exit;
}

$uploadDir = '../assets/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$file = $_FILES['image'];
$fileName = $file['name'];
$fileTmpName = $file['tmp_name'];
$fileSize = $file['size'];
$fileError = $file['error'];

// Get file extension
$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
$allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

// Validate file
if ($fileError !== 0) {
    echo json_encode(['success' => false, 'message' => 'Error uploading file']);
    exit;
}

if (!in_array($fileExt, $allowedExts)) {
    echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, GIF, WEBP allowed']);
    exit;
}

if ($fileSize > 5000000) { // 5MB limit
    echo json_encode(['success' => false, 'message' => 'File too large. Max 5MB allowed']);
    exit;
}

// Generate unique filename
$newFileName = uniqid('img_', true) . '.' . $fileExt;
$uploadPath = $uploadDir . $newFileName;

if (move_uploaded_file($fileTmpName, $uploadPath)) {
    $relativePath = 'assets/uploads/' . $newFileName;
    echo json_encode(['success' => true, 'path' => $relativePath]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
}
?>