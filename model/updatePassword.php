<?php
include("../config/main.php");

// Check if user is logged in
if (!isset($_SESSION['userId']) || ($_SESSION['userType'] != '3' && $_SESSION['userType'] != '2')) {
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
    if ($_SESSION['userType'] == '2') {
        header('Location: ../employee/change-password.php?error=match');
    } else {
        header('Location: ../change-password.php?error=match');
    }
    exit;
}

// Validate password length
if (strlen($newPassword) < 6) {
    if ($_SESSION['userType'] == '2') {
        header('Location: ../employee/change-password.php?error=length');
    } else {
        header('Location: ../change-password.php?error=length');
    }
    exit;
}

// Get current user data
$userId = $_SESSION['userId'];
$user = $db->query("SELECT u_password FROM users WHERE u_id = '$userId'")->fetchArray();

// Verify current password
if (sha1($currentPassword) !== $user['u_password']) {
    if ($_SESSION['userType'] == '2') {
        header('Location: ../employee/change-password.php?error=current');
    } else {
        header('Location: ../change-password.php?error=current');
    }
    exit;
}

// Update password
$hashedNewPassword = sha1($newPassword);
$query = "UPDATE users SET u_password = '$hashedNewPassword' WHERE u_id = '$userId'";

if ($db->query($query)) {
    if ($_SESSION['userType'] == '2') {
        header('Location: ../employee/change-password.php?success=1');
    } else {
        header('Location: ../change-password.php?success=1');
    }
} else {
    if ($_SESSION['userType'] == '2') {
        header('Location: ../employee/change-password.php?error=update');
    } else {
        header('Location: ../change-password.php?error=update');
    }
}
exit;
?>