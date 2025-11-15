
 <?php
require("../config/main.php");


$myid = $_SESSION['userId'];


$connect = mysqli_connect("localhost", "root", "", "repo");

if ($_FILES["file"]["size"] > 0){
    $file = explode(".", $_FILES["file"]["name"]);


    if (end($file) == "csv"){



        $open = fopen( $_FILES["file"]["tmp_name"], "r");
        while(($data = fgetcsv($open)) !== false){
            $name = mysqli_real_escape_string($connect, $data[0]);
            $email = mysqli_real_escape_string($connect, $data[1]);
            $query = "insert into users(u_name, u_email, u_password, u_type, u_img, u_stamp) values ('$data[0]', '$data[1]', default, 3, default, default)";
            mysqli_query($connect, $query);
        }
        fclose($open);
        echo 1;

    } else{
        echo 2;
    }
}

