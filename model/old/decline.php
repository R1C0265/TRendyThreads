<?php
require("../config/main.php");

$id = $_POST['id'];

$myid = $_SESSION['userId'];


$del =$db->query("UPDATE appointment set state='2' WHERE ap_id =$id");


if($del) echo 1;
else echo 2;