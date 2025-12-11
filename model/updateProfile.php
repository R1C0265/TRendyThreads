<?php
include("../config/main.php");

// Check if user is logged in
if (!isset($_SESSION['userId']) || $_SESSION['userType'] != '3') {
    header('Location: ../signin.php');
    exit;
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../profile.php');
    exit;
}

// Sanitize and validate input
$name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
$phone = htmlspecialchars(trim($_POST['phone']), ENT_QUOTES, 'UTF-8');
$address = htmlspecialchars(trim($_POST['address']), ENT_QUOTES, 'UTF-8');

// Validate required fields
if (empty($name) || empty($email)) {
    header('Location: ../edit-profile.php?error=required');
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../edit-profile.php?error=email');
    exit;
}

// Update user data
$userId = $_SESSION['userId'];
$query = "UPDATE users SET u_name = '$name', u_email = '$email', u_phone = '$phone', u_address = '$address' WHERE u_id = '$userId'";

if ($db->query($query)) {
    // Update session data
    $_SESSION['userName'] = $name;
    $_SESSION['userEmail'] = $email;
    
    // Redirect with success message
    header('Location: ../profile.php?success=1');
} else {
    // Redirect with error
    header('Location: ../edit-profile.php?error=update');
}
exit;
?>