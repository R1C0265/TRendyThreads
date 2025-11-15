<?php

require_once ("../controller/Database.php");

class Essential extends Database{

    function changeState($projectID, $state){
        $db = new Database();
        $db->query("update project set pr_state = $state where pr_id = $projectID");

    }

}