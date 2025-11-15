<?php
require("../config/main.php");
$old = sha1($_POST['old']);
$pass = sha1($_POST['pass']);

$myid = $_SESSION['userId'];

$check = $db->query("SELECT * FROM users WHERE u_password = '$old' and u_id=$myid")->fetchArray();

if($check){
    $save = $db->query("UPDATE `users` SET `u_password` = '$pass' WHERE `users`.`u_id` = $myid");
    if ($save) {
        echo 1;
        
    }
    else echo 2;
}else{
    echo 3;
}

    


?>