<?php

require("../config/main.php");

$active=1;
//load header content
$link=1;
include('header.php');
//customers
$userDetails = $db->query("SELECT * from users where u_id = 2")->fetchArray();

    ?>
    <div class="main-panel">
        <div class="content-wrapper ">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold"><?php echo $userDetails['u_name'];?></h3>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-4 col-xl-4 mb-4 mb-xl-0">
                            <img src="<?php echo $userDetails["product_image_location"];?>"
                                    class="card-img-top"
                                    alt="<?php echo $productDetails["product_image_alt"];?>"
                                />
                            
                            <p><?php echo $productDetails["product_description"];  ?></p>
                            <br>
                            <a data-toggle="modal" data-target="#addDoc" href="#" class="btn btn-success">Add <i class="ti ti-plus icon"></i></a>
                            <a data-toggle="modal" data-target="#addDoc" href="#" class="btn btn-dark"> Edit <i class="ti ti-pencil icon"></i></a>
                            <a href="#deleteDoc" class="btn btn-danger">Delete<i class="ti ti-trash icon"></i></a>
                        </div>

                        <div class="col-8 col-xl-8 mb-4 mb-xl-0">
                        <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">All Products</h4>
                        <a class="btn btn-danger" onclick="topdf()">Download pdf</a>
                        <div class="table-responsive">
                            <table class="table table-striped datatable" id="usertable">
                                <thead>
                                    <tr>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Amount Remaining
                                        </th>
                                        <th>
                                            Price
                                        </th>
                                        <th>
                                            Category
                                        </th>
                                        <th>
                                    
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="table table-active">
                                    <?php 
                                    $productDetails1 = $db->query("SELECT * from products")->fetchAll();
                                    foreach ($productDetails1 as $deets) {
                                        ?>
                                    <tr>
                                        
                                        <td>
                                            <a href=""><?php echo $deets['product_name'] ?></a>
                                        </td>
                                        <td>
                                        <?php echo $deets['product_amount'] ?>
                                        </td>
                                        <td>
                                        <?php echo $deets['product_price'] ?>
                                        </td>
                                        <td>
                                        <?php echo $deets['product_category'] ?>
                                        </td>
                                        <td>
                                        Delete <i class="icon icon-ga"></i>
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
            </div>
        </div>

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
    </div>

    
     


    
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