<?php

require("../config/main.php");

$active=1;
//load header content
$link=1;
include('header.php');

//getpr
$myid = $_SESSION['userId'];

    ?>
<div class="main-panel" style="width: 100% !important">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Project Archive</h3>
                        <!--<h6 class="font-weight-normal mb-0">All systems are running smoothly! You have <span
                                class="text-primary">3 unread alerts!</span></h6>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="row" >
            <?php
                    $pr = $db->query("SELECT * FROM project p INNER JOIN users u  ON u.u_id= p.student WHERE p.pr_state=2")->fetchAll();

                    if(!$pr){
                        ?>
                        <div class="col-xl-12">
                        <div class="card card-primary">
                        <div class="card-body">
                            <h4 class="mb-3 text-center">No Projects in Archive</h4>
                            

                        </div>
                    </div>
                    <div class="col-xl-4">
                        <?php
                    }
                    foreach($pr as $res){
                        ?>

            <div class="col-xl-4">
                <a href="project-single.php?project=<?php echo $res['pr_id']?>">
                    <div class="card card-tale">
                        <div class="card-body">
                            <h4 class="mb-3"><?php echo $res['pr_name'] ?></h4>
                            <p><?php echo readMore($res['pr_desc'] ,90);  ?> </p>
                            <small>by: <?php echo $res['u_name'] ?></small>

                        </div>
                    </div>
                </a>
            </div>


            <?php
                    }
                ?>


        </div>
    </div>




    <!-- Modal -->


    <!-- Modal -->


    <?php  include('footer.php'); ?>