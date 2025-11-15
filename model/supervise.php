<?php
require("../config/main.php");

$id = $_POST['id'];
$myid = $_SESSION['userId'];

$del =$db->query("UPDATE project set lecture=$myid WHERE pr_id =$id");
$dupd =$db->query("UPDATE project set pr_state='1' WHERE pr_id =$id");
if($del) echo 1;
else echo 2;