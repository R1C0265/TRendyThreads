<?php
require_once '../config/main.php';
require_once 'notificationHelper.php';

$id = $_POST['bail_id'];

// Get bail name before deletion
$bail = $db->query("SELECT b_name FROM bails WHERE b_id = ?", $id)->fetch();

$del = $db->query("DELETE FROM bails WHERE b_id = ?", $id);

if ($del) {
    if ($bail) {
        notifyItemDeleted('bail', $bail['b_name'], $id);
    }
    echo 1;
} else {
    echo 2;
}
