<?php
require_once '../config/database.php';

if ($_POST['id']) {
    $sql = "UPDATE notifications SET n_is_read = TRUE WHERE n_id = ?";
    $db->query($sql, $_POST['id']);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>