<?php
require("../config/main.php");

$id = $_POST['id'];

$del =$db->query("delete FROM appointment WHERE ap_id =$id");

if($del) echo 1;
else echo 2;