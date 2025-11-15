<?php
require("../config/main.php");
$userID = $_SESSION['userId'];
$id = $_POST['id'];

/*
 * TODO: NAME EACH DOCUMENTATION AS IT COMES
 * TODO: TRACK THE PROJECT STATE
 * TODO: */


//Documents

const CONCEPT_NOTE = 'concept note';
const USE_CASES = 'uses cases';
const UML_DOCUMENTS = 'uml documents';
const SRS_DOCUMENT = 'srs document';
const SDD_DOCUMENT = 'sdd document';
const FINAL_DOCUMENTATION = 'final documentation';
const DOC_ZIP = 'doc zip';




//get student name
$student = $db->query("select u_name from users where u_id = $userID")->fetchArray();

//GET project
$project = $db->query("select pr_id from project where student = $userID")->fetchArray();


//check name
$check=$db->query("SELECT type FROM pr_docs WHERE pr_id = {$project['pr_id']} and type = 'concept note'")->fetchArray();
$checkUseCases = $db->query("SELECT type FROM pr_docs WHERE pr_id = {$project['pr_id']} and type = 'Use Case Document'")->fetchArray();
$checkUml = $db->query("select type from pr_docs where  pr_id = {$project['pr_id']} and type = 'UML Document'")->fetchArray();
$checkSrs = $db->query("select type from pr_docs where  pr_id = {$project['pr_id']} and type = 'SRS Document'")->fetchArray();
$checkDDS = $db->query("select type from pr_docs where  pr_id = {$project['pr_id']} and type = 'DDS Document'")->fetchArray();
$checkFinal = $db->query("select type from pr_docs where  pr_id = {$project['pr_id']} and type = 'Final Documentation'")->fetchArray();
$checkDocZip = $db->query("select type from pr_docs where  pr_id = {$project['pr_id']} and type = 'Final Project'")->fetchArray();


$target_dir = "../images/uploads/";
$file=basename($_FILES["file"]['name']);
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$path = $target_dir.$file;
$ext=pathinfo($file,PATHINFO_EXTENSION);




if(!$check){


    //check if use cases uploaded

        //file

    if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){

            $fil = $db->query("INSERT INTO `pr_docs` (`pd_id`, `type`, `file`, `stamp` , `pr_id`) VALUES (NULL, 'Concept Note', '{$student['u_name']} concept note.pdf', current_timestamp(), $id)");
            rename($target_file, $target_dir . "{$student['u_name']} concept note.pdf");

            echo 1;
        }
        else{
            echo "image upload error";
        }

}else if(!$checkUseCases){
    //file

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

        $fil = $db->query("INSERT INTO `pr_docs` (`pd_id`, `type`, `file`, `stamp` , `pr_id`) VALUES (NULL, 'Use Case Document', '{$student['u_name']} Use Case Document.pdf', current_timestamp(), $id)");
        rename($target_file, $target_dir . "{$student['u_name']} Use Case Document.pdf");
        echo 1;
    }
} else if (!$checkUml) {
    //file

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

        $fil = $db->query("INSERT INTO `pr_docs` (`pd_id`, `type`, `file`, `stamp` , `pr_id`) VALUES (NULL, 'UML Document', '{$student['u_name']} UML Document.pdf', current_timestamp(), $id)");
        rename($target_file, $target_dir . "{$student['u_name']} UML Document.pdf");
        echo 1;
    }
}
else if(!$checkSrs){
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

        $fil = $db->query("INSERT INTO `pr_docs` (`pd_id`, `type`, `file`, `stamp` , `pr_id`) VALUES (NULL, 'SRS Document', '{$student['u_name']} SRS Document.pdf', current_timestamp(), $id)");
        rename($target_file, $target_dir . "{$student['u_name']} SRS Document.pdf");
        echo 1;
    }
}else if(!$checkDDS){
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

        $fil = $db->query("INSERT INTO `pr_docs` (`pd_id`, `type`, `file`, `stamp` , `pr_id`) VALUES (NULL, 'DDS Document', '{$student['u_name']} DDS Document.pdf', current_timestamp(), $id)");
        rename($target_file, $target_dir . "{$student['u_name']} DDS Document.pdf");
        echo 1;
    }
}else if(!$checkFinal){
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

        $fil = $db->query("INSERT INTO `pr_docs` (`pd_id`, `type`, `file`, `stamp` , `pr_id`) VALUES (NULL, 'Final Documentation', '{$student['u_name']} Final Documentation.pdf', current_timestamp(), $id)");
        rename($target_file, $target_dir . "{$student['u_name']} Final Documentation.pdf");
        echo 1;
    }
} else if(!$checkDocZip){
    if($ext = '.zip'){
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

            $fil = $db->query("INSERT INTO `pr_docs` (`pd_id`, `type`, `file`, `stamp` , `pr_id`) VALUES (NULL, 'Final Project Zip', '{$student['u_name']} Final Project.zip', current_timestamp(), $id)");
            rename($target_file, $target_dir . "{$student['u_name']} Final Project.zip");

            echo 1;
        }
    } else{
        echo 2;
    }

} else{
    echo 3;
}
