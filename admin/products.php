<?php

require("../config/main.php");

$active=1;
//load header content
$link=1;
include('header.php');

$productDetails = $db->query("SELECT * from products")->fetchArray();

    ?>
    <div class="main-panel">
        <div class="content-wrapper ">
            <div class="row" >
                <div class="col-12 col-xl-8 mb-4 mb-xl-0" id="productNameTag" hidden>
                    <h3 class="font-weight-bold"><?php echo $productDetails['product_name'];?></h3>
                </div>
           
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-3 col-xl-3 mb-4 mb-xl-0" id="productInformationTag" hidden>
                            <img src="<?php echo $productDetails["product_image_location"];?>"
                                    class="card-img-top"
                                    alt="<?php echo $productDetails["product_image_alt"];?>"
                                />
                            
                            <p><?php echo $productDetails["product_description"];  ?></p>
                            <br>
                            <a data-toggle="modal" data-target="#addProducts" href="#" class="btn btn-success">Add <i class="ti ti-plus icon"></i></a>
                            <a data-toggle="modal" data-target="#addDoc" href="#" class="btn btn-dark"> Edit <i class="ti ti-pencil icon"></i></a>
                            <br>
                            <a href="#" class="btn btn-primary">Add New Category <i class="icon icon-paper"></i> </a>

                        </div>

                        <div id="#tableEdit" class="col-9 col-xl-9 mb-4 mb-xl-0">
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
                                                    <td onclick="viewProduct()">
                                                        <?php echo $deets['product_name'] ?>
                                                    </td>
                                                    
                                                    <td onclick="viewProduct()">
                                                    <?php echo $deets['product_amount'] ?>
                                                    </td>
                                                    
                                                    <td onclick="viewProduct()">
                                                    <?php echo $deets['product_price'] ?>
                                                    </td>
                                                    
                                                    <td onclick="viewProduct()">
                                                    <?php echo $deets['product_category'] ?>
                                                    </td>
                                                    
                                                    <td>
                                                        <button class="btn btn-danger"><i class="text-white icon icon-trash"></i></button>
                                                    </td>
                                               </tr>


                                                <?php
                                               $prodcts [] = $deets["product_name"]; 
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
        </div>

        <div class="modal fade" id="addProducts" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="pt-3" id="addProduct" enctype="multipart/formdata">
                            <div class="form-group">
                                <label>Product Name</label>
                                <div class="input-group">
                                    <input type="text"  required name="productName" class="form-control form-control-lg "
                                        placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Amount In Stock</label>
                                <div class="input-group">
                                    <input type="number" required name="type" class="form-control form-control-lg "
                                        placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <div class="justify-content-end d-flex">
                                    <div class="input-group dropdown flex-md-grow-1 flex-xl-grow-0">
                                        <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button"
                                            id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="true">
                                            <i></i> Legends Golf Shirts
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                            <a class="dropdown-item" href="#">Golf Shirts</a>
                                            <a class="dropdown-item" href="#">T-Shirts</a>
                                            <a class="dropdown-item" href="#">Track Suits</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Price Of Product</label>
                                <div class="input-group">
                                    <input type="number" required name="type" class="form-control form-control-lg "
                                        placeholder="In MWK">
                                </div>
                            </div>
                            <div class="form-group">
                                <label> Image Of Product</label><br/>
                                <input class="form-control form-control-lg " type="file" name="file" required
                                    accept=".svg,.jpg,.jpeg">

                            </div>
                            <div class="form-group">
                                <label>Image Description</label>
                                <div class="input-group">
                                    <input type="text" required name="type" class="form-control form-control-lg "
                                        placeholder="e.g. an image of a flower">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Brief Description of Product</label>
                                <div class="input-group">
                                    <textarea  name="description" class="form-control form-control-lg"
                                        placeholder="You can briefly describe your product here(Optional)." id="description"></textarea>
                                </div>
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
        function viewProduct(){
            if( $("#productNameTag").attr("hidden") == true){

            }else{
                 $("#productNameTag").removeAttr("hidden")
            $("#productInformationTag").removeAttr("hidden")
       
            }
           

        }

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

                    $("#addProduct").submit(function(e) {
                        e.preventDefault();
                        $.ajax({
                            url: "../model/addProduct.php",
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
                                        alert("Product Added Successfully");
                                        window.location.reload();
                                    }, 500);
                                } else if (data == 2) {
                                    alert("The Product already exists in system!");
                                } else {
                                    //user not found
                                    alert("Error uploading your Product. Contact the Administrator.");
                                }
                            },
                            error: function() {}
                        });


                    });
        </script>