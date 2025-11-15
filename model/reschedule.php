<?php
require("../config/main.php");

$id = $_POST['apid'];
$date = $_POST['date_'];
$myid = $_SESSION['userId'];

$del =$db->query("UPDATE appointment set date_='$date' WHERE ap_id =$id");
$del2 =$db->query("UPDATE appointment set state='3' WHERE ap_id =$id");


if($del) echo 1;
else echo 2;