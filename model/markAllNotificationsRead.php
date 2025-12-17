<?php
require_once '../config/database.php';

$sql = "UPDATE notifications SET n_is_read = TRUE WHERE n_is_read = FALSE";
$db->query($sql);
echo json_encode(['success' => true]);
?>