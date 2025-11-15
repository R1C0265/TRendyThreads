<?php

require("../config/main.php");

$active=2;
//load header content
$link=1;
include('header.php');

?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Projects</h3>
                        <!--<h6 class="font-weight-normal mb-0">All systems are running smoothly! You have <span
                                class="text-primary">3 unread alerts!</span></h6>-->
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">All Projects</h4>
                        <a class="btn btn-danger" onclick="topdf()">Download pdf</a>
                        <div class="table-responsive">
                            <table class="table table-striped datatable" id="usertable">
                                <thead>
                                    <tr>
                                        <th>
                                        Name
                                        </th>
                                        <th>
                                            Desc
                                        </th>
                                        <th>
                                            Student
                                        </th>
                                        <th>
                                            State
                                        </th>
                                        <th>
                                            added
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php
                                    $pr = $db->query("SELECT * FROM project p INNER JOIN users u ON p.student=u.u_id ")->fetchAll();


                                    foreach ($pr as $res) {
                                        $supervisorName  =  $db->query("SELECT * FROM project p INNER JOIN users u ON u.u_id=p.lecture WHERE p.pr_id = {$res['pr_id']}")->fetchArray();
                                        ?>
                                    <tr>
                                        <td>
                                            <a href="project-single.php?project=<?php echo $res['pr_id'] ?>"><?php echo $res['pr_name'] ?></a>
                                        </td>
                                        <td>
                                            <p class="truncate"><?php echo readMore($res['pr_desc'], 20) ?></p>
                                        </td>
                                        <td>
                                            <?php echo $res['u_name'] ?>
                                        </td>
                                        <td>
                                        <?php
                                            if($res['pr_state']==0){
                                                echo "Not Supervised";
                                            }else if(($res['pr_state']==1)){
                                                echo "Supervised By {$supervisorName['u_name']} "  ;
                                            }else if($res['pr_state']==2){
                                            echo "Submitted FD to {$supervisorName['u_name']}";
                                            }else if($res['pr_state']==3){
                                                echo "Finished";
                                            }
                                            
                                        ?>
                                        </td>
                                        <td>
                                            <?php echo dateStr($res['u_stamp']) ?>
                                        </td>
                                    </tr>
                                    <?php
                                    } ?>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>




        <?php  include('footer.php'); ?>

        <script>
        function topdf() {
            var doc = new jsPDF();
            //doc.text(20, 20, "Hello!");
            //let finalY = doc.lastAutoTable.finalY; // The y position on the page
            doc.autoTable({
                html: '#usertable'
            });


            doc.save('All Users_<?php print date('d-m-Y'); ?>.pdf');
        }
        </script>