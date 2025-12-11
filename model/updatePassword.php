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

$currentPassword = $_POST['current_password'];
$newPassword = $_POST['new_password'];
$confirmPassword = $_POST['confirm_password'];

// Validate passwords match
if ($newPassword !== $confirmPassword) {
    header('Location: ../change-password.php?error=match');
    exit;
}

// Validate password length
if (strlen($newPassword) < 6) {
    header('Location: ../change-password.php?error=length');
    exit;
}

// Get current user data
$userId = $_SESSION['userId'];
$user = $db->query("SELECT u_password FROM users WHERE u_id = '$userId'")->fetchArray();

// Verify current password
if (sha1($currentPassword) !== $user['u_password']) {
    header('Location: ../change-password.php?error=current');
    exit;
}

// Update password
$hashedNewPassword = sha1($newPassword);
$query = "UPDATE users SET u_password = '$hashedNewPassword' WHERE u_id = '$userId'";

if ($db->query($query)) {
    header('Location: ../change-password.php?success=1');
} else {
    header('Location: ../change-password.php?error=update');
}
exit;
?>