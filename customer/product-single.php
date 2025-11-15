<?php

require("../config/main.php");

$active=1;
//load header content
$link=1;
include('header.php');

//getpr
$productId = $_GET['product'];
$productDetails = $db->query("SELECT * FROM products where product_id = $productId")->fetchArray();
if($productDetails){


    ?>
    <div class="main-panel">
        <div class="content-wrapper ">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold"><?php echo $productDetails['product_name'];?></h3>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-5 col-xl-6 mb-4 mb-xl-0">
                            <img src="<?php echo $productDetails["product_image_location"];?>"
                                    class="card-img-top"
                                    alt="<?php echo $productDetails["product_image_alt"];?>"
                                />
                        </div>

                        <div class="col-7 col-xl-4 mb-4 mb-xl-0">
                            <p><?php echo $productDetails["product_description"];  ?></p>
                            <h5>In Stock: <?php echo $productDetails["product_amount"];  ?></h5>
                            <br>
                            <a data-toggle="modal" data-target="#addDoc" href="#" class="btn btn-success">Add to cart <i class="ti-shopping-cart icon"></i></a>
                            <button href="#" class="btn btn-danger">Buy Now <i class="ti ti-receipt icon"></i></a>

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

    <?php
} else{
    echo "mbola";
}
    ?>
    
     


    
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