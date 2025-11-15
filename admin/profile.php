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
                        <h3 class="font-weight-bold">Profile</h3>
                        
                    </div>
                    <div class="col-12 col-xl-4">


                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update info</h4>

                        <form class="forms-sample" id="updInfo">
                            <div class="form-group">
                                <label for="exampleInputUsername1">Username</label>
                                <input type="text" class="form-control" name="name"
                                    value="<?php echo $_SESSION['userName'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?php echo $_SESSION['userEmail'] ?>">
                            </div>


                            <button type="submit" class="btn btn-primary mr-2">Update Info</button>

                        </form>
                        <hr />
                        <h4>Update Password</h4>
                        <form id="updPass">
                            <div class="form-group">
                                <label for="pass1">Old Password</label>
                                <input type="password" minlength="8" class="form-control" required name="old"
                                    placeholder="Old Password">
                            </div>
                            <div class="form-group">
                                <label for="pass1">New Password</label>
                                <input type="password" minlength="8" class="form-control" required name="pass"
                                    id="pass1" placeholder="New Password">
                            </div>
                            <div class="form-group">
                                <label for="pass2">Confirm Password</label>
                                <input type="password" minlength="8" required class="form-control" id="pass2"
                                    placeholder="Confirm Password">
                            </div>

                            <button type="submit" class="btn btn-primary mr-2">Update Info</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <center>
                            <img src="../images/user/<?php echo $_SESSION['userImg'] ?>" width="20%">
                            <h3><?php echo $_SESSION['userName'] ?></h3>
                            <p><?php echo $_SESSION['userEmail'] ?></p>
                        </center>

                        <hr />
                        <br />

                        <h3>Update Image</h3>

                        <form id="updImg" enctype="multipart/formdata">
                            <div class="form-group">
                                <label for="exampleInputConfirmPassword1">Image</label>
                                <input required type="file" accept=".png,.jpg,.svg,.jpeg,.gif" name="file" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Update Image</button>
                        </form>

                    </div>
                </div>
            </div>

        </div>




        <?php  include('footer.php'); ?>

        <script>
        $("#updInfo").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "../model/updInfo.php",
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
                            alert("Information Updated!");
                            window.location.reload();
                        }, 500);
                    } else if (data == 3) {
                        alert("Email already exists in system!");
                    } else {
                        //user not found
                        alert("Error updating Information!");
                    }
                },
                error: function() {}
            });

        });


        $("#updPass").submit(function(e) {
            e.preventDefault();
            var pass = $("#pass1").val();
            var pass2 = $("#pass2").val();

            if (pass != pass2) {
                alert("New Password and confirm password do not match");
            } else {
                $.ajax({
                    url: "../model/updPass.php",
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
                                alert("Information updated!");
                                window.location.reload();
                            }, 500);
                        } else if (data == 3) {
                            alert("Old and New Passwords do not match");
                        } else {
                            //user not found
                            alert("Error updating Information!");
                        }
                    },
                    error: function() {}
                });
            }
        });

        $("#updImg").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "../model/updImg.php",
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
                            alert("Information updated!");
                            window.location.reload();
                        }, 500);
                    } else if (data == 3) {
                        alert("Passwords do not match");
                    } else {
                        //user not found
                        alert("Error updating Information!");
                    }
                },
                error: function() {}
            });

        });
        </script>