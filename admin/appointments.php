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
                        <h3 class="font-weight-bold">Appointments</h3>
                        <!--<h6 class="font-weight-normal mb-0">All systems are running smoothly! You have <span
                                class="text-primary">3 unread alerts!</span></h6>-->
                    </div>
                    <div class="col-12 col-xl-4">


                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">All Appointments</h4>
                        <a class="btn btn-danger" onclick="topdf()">Download pdf</a>
                        <div class="table-responsive">
                            <table class="table table-striped datatable" id="usertable">
                                <thead>
                                    <tr>
                                        <th>
                                            Lecturer
                                        </th>
                                        <th>
                                            Student
                                        </th>
                                        <th>
                                            Reason
                                        </th>
                                        <th>
                                            Date
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $all  = $db->query("SELECT * FROM appointment a INNER JOIN users u ON u.u_id=a.lecture")->fetchAll();
                                    foreach ($all as $res) {
                                        $uid = $res['student'];
                                        $stu = $db->query("SELECT * FROM users WHERE u_id=$uid")->fetchArray();

                                        ?>
                                    <tr>

                                        <td>
                                           <?php echo $res['u_name'] ?>
                                        </td>
                                        <td>
                                        <?php echo $stu['u_name'] ?>
                                        </td>
                                        <td>
                                        <?php echo $res['ap_title'] ?>
                                        </td>
                                        <td>
                                        <?php echo dateStr($res['stamp']) ?>
                                        </td>
                                    </tr>


                                    <?php
                                    
                                    }
                                    ?>
                                    


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


            doc.save('All appointments<?php print date('d-m-Y'); ?>.pdf');
        }
        </script>