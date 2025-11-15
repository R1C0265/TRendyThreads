<?php

require("../config/main.php");

$active=1;
//load header content
$link=1;
include('header.php');

//// DASH-INFO ////
//users
$products= $db->query("SELECT COUNT(*) as num FROM products where product_amount != 0 ")->fetchArray();
//custpmers
$registeredCustomers= $db->query("SELECT COUNT(*) as num FROM users where u_id = 2")->fetchArray();
//Customers that have Used the Cart
$itemsRunOut= $db->query("SELECT COUNT(*) as num FROM products where product_amount = 0 ")->fetchArray();
//Total Purchases
$purchases= $db->query("SELECT COUNT(*) as num FROM purchases")->fetchArray();

?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Welcome <?php echo $_SESSION['userName'] ?></h3>
                       <!-- <h6 class="font-weight-normal mb-0">All systems are running smoothly! You have <span
                                class="text-primary">3 unread alerts!</span></h6>-->
                    </div>
                    <!-- <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button"
                                    id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="true">
                                    <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                    <a class="dropdown-item" href="#">January - March</a>
                                    <a class="dropdown-item" href="#">March - June</a>
                                    <a class="dropdown-item" href="#">June - August</a>
                                    <a class="dropdown-item" href="#">August - November</a>
                                </div>
                            </div>
                        </div>
                    </div> -->
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
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-tale">
                            <a style="text-decoration: none; color: #f2f2f2" href="products.php">
                            <div class="card-body">
                                <p class="mb-4">Products Currently Availlable</p>
                                <p class="fs-30 mb-2"><?php echo $products['num'] ?></p>
                                
                            </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue">
                        <a style="text-decoration: none; color: #f2f2f2" href="customers.php">
                            <div class="card-body">
                                <p class="mb-4">Registered Customers</p>
                                <p class="fs-30 mb-2"><?php echo $registeredCustomers['num'] ?></p>
                                
                            </div>
                        </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                        <div class="card card-light-danger">
                        <a style="text-decoration: none; color: #f2f2f2" href="products.php">
                            <div class="card-body">
                                <p class="mb-4">Items that Have Run Out</p>
                                <p class="fs-30 mb-3"><?php echo $itemsRunOut['num'] ?></p>
                                
                            </div>
                        </a>
                        </div>
                    </div>
                    <div class="col-md-6 stretch-card transparent">
                        <div class="card card-light-blue">
                        <a style="text-decoration: none; color: #f2f2f2" href="purchases.php">
                            <div class="card-body">
                                <p class="mb-4">Sales This Month</p>
                                <p class="fs-30 mb-2"><?php echo $purchases['num'] ?></p>
                                
                            </div>
                        </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php  include('footer.php'); ?>