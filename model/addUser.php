<?php
require_once '../config/main.php';
require_once 'notificationHelper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $u_name = $_POST['u_name'] ?? null;
        $u_email = $_POST['u_email'] ?? null;
        $u_phone = $_POST['u_phone'] ?? null;
        $u_password = $_POST['u_password'] ?? null;
        $u_type = $_POST['u_type'] ?? '3'; // Default to customer
        $u_address = $_POST['u_address'] ?? null;

        // Validate required fields
        if (empty($u_name) || empty($u_email) || empty($u_password)) {
            echo 4; // Missing required fields
            exit;
        }

        // Hash password using bcrypt (secure)
        $hashed_password = password_hash($u_password, PASSWORD_DEFAULT);

        // Check if email already exists
        $existing = $db->query("SELECT u_id FROM users WHERE u_email = ?", $u_email)->fetchArray();
        if ($existing) {
            echo 3; // Email already exists
            exit;
        }

        // Insert user
        $save = $db->query(
            "INSERT INTO users (u_name, u_email, u_phone, u_password, u_type, u_address) VALUES (?, ?, ?, ?, ?, ?)",
            $u_name, $u_email, $u_phone, $hashed_password, $u_type, $u_address
        );
        
        if ($save) {
            $user_id = $db->lastInsertID();
            
            // Add notification (don't fail if this fails)
            try {
                notifyUserRegistered($u_name, $user_id);
            } catch (Exception $e) {
                // Log error but don't fail registration
                error_log("Notification failed: " . $e->getMessage());
            }
            
            echo 1; // Success
        } else {
            echo 2; // Database error
        }
    } catch (Exception $e) {
        // Log the actual error
        error_log("Registration error: " . $e->getMessage());
        echo 2; // Database error
    }
} else {
    echo 0; // Invalid request method
}
?>
