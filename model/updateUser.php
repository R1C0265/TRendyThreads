<?php
require_once '../config/main.php';
require_once 'notificationHelper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['u_id'])) {
    $u_id = $_POST['u_id'];
    $u_name = $_POST['u_name'] ?? null;
    $u_email = $_POST['u_email'] ?? null;
    $u_phone = $_POST['u_phone'] ?? null;
    $u_type = $_POST['u_type'] ?? null;
    $u_address = $_POST['u_address'] ?? null;
    $u_password = $_POST['u_password'] ?? null;

    // Check if email already exists for other users
    $existing = $db->query("SELECT u_id FROM users WHERE u_email = ? AND u_id != ?", $u_email, $u_id)->fetchArray();
    if ($existing) {
        echo 3; // Email already exists
        exit;
    }

    // Build update query
    if (!empty($u_password)) {
        $hashed_password = password_hash($u_password, PASSWORD_DEFAULT);
        $update = $db->query(
            "UPDATE users SET u_name = ?, u_email = ?, u_phone = ?, u_type = ?, u_address = ?, u_password = ? WHERE u_id = ?",
            $u_name, $u_email, $u_phone, $u_type, $u_address, $hashed_password, $u_id
        );
    } else {
        $update = $db->query(
            "UPDATE users SET u_name = ?, u_email = ?, u_phone = ?, u_type = ?, u_address = ? WHERE u_id = ?",
            $u_name, $u_email, $u_phone, $u_type, $u_address, $u_id
        );
    }
    
    if ($update) {
        echo 1; // Success
    } else {
        echo 2; // Database error
    }
}
?>