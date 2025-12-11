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
$cta_text = htmlspecialchars(trim($_POST['cta_text']), ENT_QUOTES, 'UTF-8');
$cta_link = htmlspecialchars(trim($_POST['cta_link']), ENT_QUOTES, 'UTF-8');
$hero_image = htmlspecialchars(trim($_POST['hero_image']), ENT_QUOTES, 'UTF-8');

// Validate required fields
if (empty($title)) {
    header('Location: ../employee/home_about.php?error=required');
    exit;
}

// Check if hero content exists
$existing = $db->query("SELECT * FROM hero_content WHERE is_active = 1 LIMIT 1")->fetchArray();

if ($existing) {
    // Update existing record
    $query = "UPDATE hero_content SET 
              title = '$title', 
              subtitle = '$subtitle', 
              cta_text = '$cta_text', 
              cta_link = '$cta_link', 
              hero_image = '$hero_image',
              updated_at = CURRENT_TIMESTAMP
              WHERE is_active = 1";
} else {
    // Insert new record
    $query = "INSERT INTO hero_content (title, subtitle, cta_text, cta_link, hero_image, is_active) 
              VALUES ('$title', '$subtitle', '$cta_text', '$cta_link', '$hero_image', 1)";
}

if ($db->query($query)) {
    header('Location: ../employee/home_about.php?success=hero');
} else {
    header('Location: ../employee/home_about.php?error=update');
}
exit;
?>