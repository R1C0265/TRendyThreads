<?php
include("../config/main.php");

// Check if user is logged in and is employee
if (!isset($_SESSION['userId']) || $_SESSION['userType'] != '2') {
    header('Location: ../signin.php');
    exit;
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../employee/home_about.php');
    exit;
}

// Sanitize input
$title = htmlspecialchars(trim($_POST['title']), ENT_QUOTES, 'UTF-8');
$subtitle = htmlspecialchars(trim($_POST['subtitle']), ENT_QUOTES, 'UTF-8');
$description = htmlspecialchars(trim($_POST['description']), ENT_QUOTES, 'UTF-8');
$image_path = htmlspecialchars(trim($_POST['image_path']), ENT_QUOTES, 'UTF-8');
$video_url = htmlspecialchars(trim($_POST['video_url']), ENT_QUOTES, 'UTF-8');

// Validate required fields
if (empty($title)) {
    header('Location: ../employee/home_about.php?error=required');
    exit;
}

// Check if about content exists
$existing = $db->query("SELECT * FROM about_content WHERE is_active = 1 LIMIT 1")->fetchArray();

if ($existing) {
    // Update existing record
    $query = "UPDATE about_content SET 
              title = '$title', 
              subtitle = '$subtitle', 
              description = '$description', 
              image_path = '$image_path', 
              video_url = '$video_url',
              updated_at = CURRENT_TIMESTAMP
              WHERE is_active = 1";
} else {
    // Insert new record
    $query = "INSERT INTO about_content (title, subtitle, description, image_path, video_url, is_active) 
              VALUES ('$title', '$subtitle', '$description', '$image_path', '$video_url', 1)";
}

if ($db->query($query)) {
    header('Location: ../employee/home_about.php?success=about');
} else {
    header('Location: ../employee/home_about.php?error=update');
}
exit;
?>