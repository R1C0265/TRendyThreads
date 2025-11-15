<?php
 require("../config/main.php");
$prodName = $_POST["productName"];


//check if product is in 
$getData = $db->query("SELECT * from products where product_name = {$prodName}");


//GET project
    
if(!$getData){
    $target_dir = "../images/TEST/";
    $file=basename($_FILES["file"]['name']);
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $path = $target_dir.$file;
    $ext=pathinfo($file,PATHINFO_EXTENSION);
        
} else{
    echo 2;

    }

