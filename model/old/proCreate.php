<?php
require("../config/main.php");
$name = $_POST['name'];
$desc = $_POST['desc'];
$myid = $_SESSION['userId'];


//student name
$student = $db->query("select u_name from users where u_id = $myid")->fetchArray();

//check name
$check=$db->query("SELECT * FROM project WHERE pr_name = '$name'")->fetchArray();
if(!$check){
    //file
$target_dir = "../images/uploads/";

$file=basename($_FILES["file"]['name']);
$target_file = $target_dir . basename($_FILES["file"]["name"]);

$path = $target_dir.$file;
$ext=pathinfo($file,PATHINFO_EXTENSION);


    if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
        $upl = $db->query("INSERT INTO `project` (`pr_id`, `pr_name`, `student`, `lecture`, `pr_desc`, `pr_state`, `pr_stamp`) 
        VALUES (NULL, '$name', '$myid', '0', '$desc', '0', current_timestamp())");
    
        $prid = $upl->lastInsertID(); 
        $fil = $db->query("INSERT INTO `pr_docs` (`pd_id`, `type`, `file`, `stamp`, `pr_id`) VALUES (NULL, 'Concept Note', '{$student['u_name']} Concept Note', current_timestamp(),$prid)");
        rename($target_file, $target_dir . $student['u_name']." Concept Note");
        echo 1;
    }
    else{
        echo "image upload error";
    }
}
else{
    echo "3";
}

