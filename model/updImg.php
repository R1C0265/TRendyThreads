<?php
require("../config/main.php");


$myid = $_SESSION['userId'];

$db = new Database();

$target_dir = "../images/user/";

$file=basename($_FILES["file"]['name']);
$target_file = $target_dir . basename($_FILES["file"]["name"]);

$path = $target_dir.$file;
$ext=pathinfo($file,PATHINFO_EXTENSION);


    if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){

        $fil = $db->query("UPDATE users SET u_img = '$file' WHERE u_id=$myid");
        $_SESSION['userImg']=$file;
        echo 1;
    }
    else{
        echo 3;
}
