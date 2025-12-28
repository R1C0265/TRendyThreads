<?php
require_once '../config/main.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['u_id'])) {
    $u_id = $_POST['u_id'];
    
    $user = $db->query("SELECT * FROM users WHERE u_id = ?", $u_id)->fetchArray();
    
    if ($user) {
        // Don't send password back
        unset($user['u_password']);
        echo json_encode($user);
    } else {
        echo json_encode(['error' => 'User not found']);
    }
}
?>