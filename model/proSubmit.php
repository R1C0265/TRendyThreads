<?php
require("../config/main.php");
$myid = $_SESSION['userId'];

$checkState = $db->query("select pr_state from project where student = $myid")->fetchArray();

if($checkState['pr_state'] == '1'){
    $fil = $db->query("UPDATE project SET pr_state = '2' WHERE student=$myid");
    echo 1;
} else if($checkState['pr_state'] == '2'){
    $fil = $db->query("UPDATE project SET pr_state = '1' WHERE student=$myid");
    echo 2;
} else{
    echo 3;
}


