<?php

require("../config/main.php");

$active=1;
//load header content
$link=1;
include('header.php');

//getpr
$myid = $_SESSION['userId'];

$products = $db->query("select * from products where product_amount > 0")->fetchAll();
    ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="    row">
                    <div class="col-6 col-xl-6 mb-4 mb-xl-0">
                        <h2 class="font-weight-bold">Available Products</h2>
                    </div>
                    <div class="col-6 col-xl-6 mb-4 mb-xl-0">
                        <ul class="navbar-nav mr-lg-2">
                            <li class="nav-item nav-search d-none d-lg-block">
                                <div class="input-group">
                                    <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                                        <span class="input-group-text" id="search">
                                          <i class="icon-search"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php
            if(!$products){
                ?>
        <div class="row" >
            <div class="col-xl-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <h4 class="mb-3 text-center">Sorry, No Products Are Available At This Time.</h4>
                    </div>
                </div>
            </div>
        </div>
                <?php
                }?>

        <div class="row">
            <section">
                <div class="container py-5">
                    <div class="row">
                        <?php

                        foreach ($products as $prLoop){
                            ?>
                        <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                            <div class="card">
                    
                                    <a href="product-single.php?product=<?php echo $prLoop["product_id"]?>">
                                        <!-- <div class="d-flex justify-content-between p-3">
                                            <p class="lead mb-0">Today's Combo Offer</p>
                                            <div class="bg-info rounded-circle d-flex align-items-center justify-content-center shadow-1-strong"
                                                    style="width: 35px; height: 35px;">
                                                <p class="text-white mb-0 small">x4</p>
                                            </div>
                                        </div>-->
                                    <img
                                            src="<?php echo $prLoop["product_image_location"];?>"
                                            class="card-img-top"
                                            alt="laptop"

                                    />
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <p class="small"><a href="#!" class="text-muted"><?php echo $prLoop['product_category']?></a></p>
                                            <!--<p class="small text-danger"><s>$1099</s></p>-->
                                        </div>

                                        <div class="d-flex justify-content-between mb-3">
                                            <h5 class="mb-0"><?php echo $prLoop['product_name']?></h5>
                                            <h5 class="text-dark mb-0">MWK <?php echo $prLoop["product_price"]?></h5>
                                        </div>

                                        <div class="d-flex justify-content-between mb-2">
                                            <p class="text-muted mb-0">Available: <span class="fw-bold"><?php echo $prLoop["product_amount"]?></span></p>
                                            
                                            <div class="ms-auto text-warning">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <a href="#" class="btn btn-primary">Add to Cart</a>
                                        </div>
                                    </div>
                                </a>
                               
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </section>
        </div>
        <?php
            include('footer.php'); ?>
    </div>
</div>