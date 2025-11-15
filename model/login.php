<?php

include("../config/main.php");


$email = $_POST['email'];
$pass = sha1($_POST['password']);

//check email $ password
$check = $db->query("SELECT * FROM users WHERE u_email='$email' AND u_password='$pass'")->fetchArray();
if ($check) {
    //start session
    $_SESSION['userName'] = $check['u_name'];
    $_SESSION['userId'] = $check['u_id'];
    $_SESSION['userEmail'] = $check['u_email'];
    $_SESSION['userImg'] = $check['u_img'];
    $_SESSION['userType'] = $check['u_type'];

    echo $check['u_type'];;
} else {
    //flag error code
    echo 5;
}
