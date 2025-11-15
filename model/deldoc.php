<?php
require("../config/main.php");

$id = $_POST['id'];

$del =$db->query("delete FROM pr_docs WHERE pd_id =$id");

if($del) echo 1;
else echo 2;