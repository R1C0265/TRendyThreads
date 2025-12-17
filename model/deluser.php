<?php
require_once '../config/main.php';
require_once 'notificationHelper.php';

$id = $_POST['id'];

// Get user name before deletion
$user = $db->query("SELECT u_name FROM users WHERE u_id = ?", $id)->fetch();

$del = $db->query("DELETE FROM users WHERE u_id = ?", $id);

if ($del) {
    if ($user) {
        notifyItemDeleted('user', $user['u_name'], $id);
    }
    echo 1;
} else {
    echo 2;
}