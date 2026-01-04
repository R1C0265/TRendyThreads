<?php
require("../config/main.php");
$name = $_POST['name'];
$email = $_POST['email'];

$myid = $_SESSION['userId'];


    $save = $db->query("UPDATE `users` SET `u_name` = '$name', `u_email` = '$email' WHERE `users`.`u_id` = $myid");
    if ($save) {
        echo 1;
        $_SESSION['userName'] = $name;
        $_SESSION['userEmail'] = $email;
    }
    else echo 2;


?>