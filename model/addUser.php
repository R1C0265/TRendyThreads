<?php
require_once '../config/main.php';
require_once 'notificationHelper.php';
$name = $_POST['name'];
$email = $_POST['email'];


$check = $db->query("SELECT * FROM users WHERE u_email='$email'")->fetchArray();
if($check){
    echo 3;
}else{
    //add to db
    $save = $db->query("INSERT INTO `users` (`u_id`, `u_name`, `u_email`, `u_password`, `u_type`, `u_img`, `u_stamp`) VALUES (NULL, '$name', '$email', default, 3, 'user.svg', current_timestamp())");
    if($save) {
        $user_id = $db->lastInsertID();
        notifyCustomerRegistered($name, $user_id);
        echo 1;
    } else {
        echo 2;
    }
}

?>