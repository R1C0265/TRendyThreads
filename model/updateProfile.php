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

// Update user data using prepared statement
$userId = $_SESSION['userId'];
$update = $db->query(
    "UPDATE users SET u_name = ?, u_email = ?, u_phone = ?, u_address = ? WHERE u_id = ?",
    $name, $email, $phone, $address, $userId
);

if ($update) {
    // Update session data
    $_SESSION['userName'] = $name;
    $_SESSION['userEmail'] = $email;
    
    // Redirect based on user type
    if ($_SESSION['userType'] == '2') {
        header('Location: ../employee/profile.php?success=1');
    } else {
        header('Location: ../profile.php?success=1');
    }
} else {
    // Redirect with error based on user type
    if ($_SESSION['userType'] == '2') {
        header('Location: ../employee/edit-profile.php?error=update');
    } else {
        header('Location: ../edit-profile.php?error=update');
    }
}
exit;
?>