<?php

require("../config/main.php");

$active=1;
//load header content
$link=1;
include('header.php');
$myid = $_SESSION['userId'];

?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Welcome <?php echo $_SESSION['userName'] ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card tale-bg">
                    <div class="card-people mt-auto">
                        <img src="../images/dashboard/people.svg" alt="people">
                        <div class="weather-info">
                            <div class="d-flex">
                                    <!--<div>
                                        <h2 class="mb-0 font-weight-normal"><i class="icon-sun mr-2"></i>31<sup>C</sup></h2>
                                    </div>
                                    <div class="ml-2">
                                        <h4 class="location font-weight-normal">Bangalore</h4>
                                        <h6 class="font-weight-normal">India</h6>
                                    </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="col-md-6 grid-margin transparent">
                <div class="row">
                    <h3 class="ml-3"><b>Cart List <i class="ti-shopping-cart-full icon menu-icon"></i></b></h3>
                        <?php
                        $numberOfItemsInCart = $db->query("SELECT count(*) FROM cart JOIN users ON cart.u_id = users.u_id JOIN products ON products.product_id  = cart.product_id where users.u_id = $myid and cart.cart_state = 1")->fetchArray();
                        $itemsInCart = $db->query("SELECT cart.product_amount_added, products.product_name, products.product_price FROM cart  JOIN  products ON products.product_id  = cart.product_id where cart.u_id = $myid and cart.cart_state = 1")->fetchAll();
                        
                        if(!$numberOfItemsInCart){
                            ?>
                    <div class="col-md-12 mb-4 stretch-card transparent" >
                        <div class="card card-tale" style="background-color: #BABABA">
                            <div class="card-body">
                                <p class="mb-3 mt-3">No Items in Cart</p>
                                <a class="btn btn-primary" href="products.php"> <i class="icon-arrow-right"></i> View Products in <u>Store</u></a>
                            </div>
                        </div>
                    </div>
                            <?php
                        }

                        ?>
                       
                    <div class="col-md-12  order-md-last">
                            <h4 class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-primary">Your Cart</span>
                                <span class="badge bg-primary rounded-pill"><?php echo $numberOfItemsInCart["count(*)"]?></span>

                            </h4>
                    
                            <ul class="list-group mb-3">
                            <?php foreach($itemsInCart as $items){?>
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0"><?php echo $items["product_name"] ?></h6>
                                        <small class="text-muted"><?php echo $items["product_amount_added"] ?></small>
                                    </div>
                                    <span class="text-muted"><?php echo $items["product_price"] ?></span>
                                </li>               
                            <?php 
                                }?>

                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Total (MWK)</span>
                                    <strong><?php echo 2 ?></strong>
                                </li>
                            </ul>

                            <div class="row ">
                            <div class="col-md-6 grid-margin transparent" >
                                <a class="btn btn-primary" href="products.php"> <i class="icon-arrow"></i>Back to Store</a>
                            </div>
                            <div class="col-md-6 grid-margin transparent" >
                                <a class="btn btn-success" href="cart.php"> <i class="icon-ca"></i>Go to Checkout</a>
                            </div>
                            </div>

                    </div>
                
                   
                    
                    
                </div>
                
            </div>
        </div>
        <?php  include('footer.php'); ?>
    </div>
</div>
    
    
        


