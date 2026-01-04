<?php
require("../config/main.php");

$myid = $_SESSION['userId'];
$type = $_POST['purpose'];
$date = $_POST['date_'];

$le = $db->query("SELECT * FROM users u INNER JOIN project p ON u.u_id=p.student WHERE u_id=$myid")->fetchArray();
$lid= $le['lecture'];
//add
$q = $db->query("INSERT INTO `appointment` (`ap_id`, `student`, `lecture`, `ap_title`, `date_`, `state`, `stamp`) VALUES (NULL, '$myid', '$lid', '$type', '$date', '0', current_timestamp())");

if($q) echo 1;
else echo 2;
