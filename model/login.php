<?php
include("../config/main.php");

$email = $_POST['email'];
$password = $_POST['password'];

// Get user by email using prepared statement
$user = $db->query("SELECT * FROM users WHERE u_email = ?", $email)->fetchArray();

if ($user) {
    // Check if password uses old SHA1 format (40 characters)
    if (strlen($user['u_password']) === 40) {
        // Legacy SHA1 verification
        if (sha1($password) === $user['u_password']) {
            // Upgrade to bcrypt on successful login
            $new_hash = password_hash($password, PASSWORD_DEFAULT);
            $db->query("UPDATE users SET u_password = ? WHERE u_id = ?", $new_hash, $user['u_id']);
            
            // Set session
            $_SESSION['userName'] = $user['u_name'];
            $_SESSION['userId'] = $user['u_id'];
            $_SESSION['userEmail'] = $user['u_email'];
            $_SESSION['userImg'] = $user['u_img'];
            $_SESSION['userType'] = $user['u_type'];
            
            echo $user['u_type'];
        } else {
            echo 5; // Wrong password
        }
    } else {
        // Modern bcrypt verification
        if (password_verify($password, $user['u_password'])) {
            // Set session
            $_SESSION['userName'] = $user['u_name'];
            $_SESSION['userId'] = $user['u_id'];
            $_SESSION['userEmail'] = $user['u_email'];
            $_SESSION['userImg'] = $user['u_img'];
            $_SESSION['userType'] = $user['u_type'];
            
            echo $user['u_type'];
        } else {
            echo 5; // Wrong password
        }
    }
} else {
    echo 5; // User not found
}
?>