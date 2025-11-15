<?php

require("../config/main.php");

$active=1;
//load header content
$link=1;
include('header.php');

//getpr
$pr = $_GET['project'];
$pr = $db->query("SELECT * FROM project p INNER JOIN users u ON u.u_id=p.lecture WHERE p.pr_id = $pr")->fetchArray();
if($pr){
    //project there
    $prid = $pr['pr_id'];
    $usr = $pr['student'];
    $std = $db->query("SELECT * FROM users WHERE u_id = $usr")->fetchArray();
    ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-8 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold"><?php echo $pr['pr_name'] ?></h3>
                        <h6 class="font-weight-normal mb-0">Created on <span
                                class="text-primary"><?php echo dateStr( $pr['pr_stamp']) ?></span></h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 grid-margin stretcrd">
                <div class="card tale-bg p-12">
                    <div class="card-body mt-auto">
                        <h3>About Project</h3>
                        <hr />
                        <p><?php echo $pr['pr_desc'] ?></p>
                        <p>Superviser: <?php if($pr['lecture']==0) echo "No supervisor yet!";
                        
                        else echo $pr['u_name']?></p>
                        <hr />
                        Project by: <?php echo $std['u_name'] ?>
                    </div>
                </div>

            </div>
            <div class="col-md-5 grid-margin stretch-card">
                <div class="card tale-bg">
                    <div class="card-body mt-auto">
                    <h3>Project Documents</h3>
                        <div class="row">
                            <?php
                            $get = $db->query("SELECT * FROM pr_docs WHERE pr_id=$prid")->fetchAll();
                            foreach($get as $r){
                            
                            ?>
                            <div class="col-md-6 mb-4 stretch-card transparent">
                                <div class="card card-tale">
                                    <div class="card-body mt-auto">
                                        <p class="mb-1"><?php echo $r['type'] ?></p>                        
                                        <a href="../images/uploads/<?php echo $r['file'] ?>"><i
                                                class="icon-download text-primary"></i></a>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <?php
}
else{
    ?>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h3 class="font-weight-bold">Please Create a project first</h3>
                            <!--<h6 class="font-weight-normal mb-0">All systems are running smoothly! You have <span
                                class="text-primary">3 unread alerts!</span></h6>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card tale-bg">
                        <div class="card-people mt-auto">
                            <br /><br /><br /><br /><br />
                            <a data-toggle="modal" data-target="#exampleModal" style="width: 100%; height: 40vh"
                                class="text-center btn btn-default"> <i class="icon-plus mb-3"></i><br />Create
                                Project</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <?php
}

?>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Project</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="pt-3" id="register" enctype="multipart/formdata">
                            <div class="form-group">
                                <label>Project Name</label>
                                <div class="input-group">
                                    <input type="text" required name="name" class="form-control form-control-lg "
                                        placeholder="Project Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Project Description</label>
                                <div class="input-group">
                                    <textarea type="text" required name="desc" class="form-control form-control-lg "
                                        placeholder="Project Description"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>SRS Document</label><br />
                                <input class="form-control form-control-lg " type="file" name="file" required
                                    accept=".docx,.doc,.pdf">

                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="btnSub" type="submit">Upload </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addDoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Project Document</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="pt-3" id="addDocument" enctype="multipart/formdata">
                            <div class="form-group">
                                <label>Document Type</label>
                                <div class="input-group">
                                    <input type="text" required name="type" class="form-control form-control-lg "
                                        placeholder="Username">
                                </div>
                            </div>

                            <input value="<?php echo $pr['pr_id'] ?>" name="id" hidden>

                            <div class="form-group">
                                <label> Document</label><br />
                                <input class="form-control form-control-lg " type="file" name="file" required
                                    accept=".docx,.doc,.pdf">

                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="btnSub" type="submit">Create</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>


        <?php  include('footer.php'); ?>
        <script>
        function deleteDoc(id) {
            var formValues = {
                id: id
            };
            $.post("../model/deldoc.php", formValues, function(data) {
                        // Display the returned data in browser
                        console.log(data);
                        if (data == 1) {
                            alert("Document Deleted!");
                            setTimeout(function(e) {
                                location.reload();
                            }, 500);
                        } else {
                            alert("Error Encountered");
                        }
                    });
                }

                    $("#register").submit(function(e) {
                        e.preventDefault();
                        var pass = $("#password").val();

                        $.ajax({
                            url: "../model/proCreate.php",
                            type: "POST",
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            beforeSend: function() {
                                $("#btnSub").addClass("disabled");
                                $("#btnSub").html("Processing");

                            },
                            success: function(data) {
                                console.log(data);
                                if (data == 1) {

                                    setTimeout(function() {
                                        alert("Project Created!");
                                        window.location.reload();
                                    }, 500);
                                } else if (data == 3) {
                                    alert("Project already exists in system!");
                                } else {
                                    //user not found
                                    alert("Error Creating Account!");
                                }
                            },
                            error: function() {}
                        });


                    });

                    $("#addDocument").submit(function(e) {
                        e.preventDefault();


                        $.ajax({
                            url: "../model/addDoc.php",
                            type: "POST",
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            beforeSend: function() {
                                $("#btnSub").addClass("disabled");
                                $("#btnSub").html("Processing");

                            },
                            success: function(data) {
                                console.log(data);
                                if (data == 1) {

                                    setTimeout(function() {
                                        alert("Document Added!");
                                        window.location.reload();
                                    }, 500);
                                } else if (data == 3) {
                                    alert("Document already exists in system!");
                                } else {
                                    //user not found
                                    alert("Error uploading Document!");
                                }
                            },
                            error: function() {}
                        });


                    });
        </script>