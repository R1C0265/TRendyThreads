<?php

require("../config/main.php");

$active=1;
//load header content
$link=1;
include('header.php');


//getpr
$myid = $_SESSION['userId'];

/*TODO: create a join with the user, products and cart

create panels for seller to add products and information for users
*/

/*

$cartInfo = $db->query("SELECT * from cart where customer_id = $myid and cart_state = 1")->fetchArray();
/**
 * the states depend on the success of a purchase
 * 0 - Purchases incomplete or removed from cart without purchase
 * 1 - Items are currently in the cart
 * 2 - Purchase has been madae from cart
 */
 $numberOfItemsInCart = $db->query("SELECT count(*) FROM cart JOIN users ON cart.u_id = users.u_id JOIN products ON products.product_id  = cart.product_id where users.u_id = $myid and cart.cart_state = 1")->fetchArray();
 $itemsInCart = $db->query("SELECT cart.product_amount_added, products.product_name, products.product_price FROM cart  JOIN  products ON products.product_id  = cart.product_id where cart.u_id = $myid and cart.cart_state = 1")->fetchAll();
 
 ?>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h2 class="font-weight-bold">Checkout</h2>
                            <!--<h6 class="font-weight-normal mb-0">All systems are running smoothly! You have <span
                                class="text-primary">3 unread alerts!</span></h6>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
      
<div class="container">
 
 
  <main>
    <?php
      if($numberOfItemsInCart["count(*)"] == 0){?>
      
  <div class="row g-5">
      <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Your Cart</span>
          <span class="badge bg-primary rounded-pill">0</span>
        </h4>
        <ul class="list-group mb-3">
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Items Added to Cart will appear here</h6>
              <small class="text-muted">No Items added Yet</small>
            </div>
          </li>
        </ul>

    </div>  
      
        <?php }else if($numberOfItemsInCart["count(*)"] > 0){
        ?>
    <div class="row g-5">
      <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Your Cart</span>
          <span class="badge bg-primary rounded-pill"><?php echo $numberOfItemsInCart["count(*)"]?></span>
        </h4>
        
        
          <ul class="list-group mb-3">
           <?php foreach($itemsInCart as $items){?>
            <li class="list-group-item d-flex justify-content-between lh-sm">
              <div>
                <h6 class="my-0"><?php echo $items["product_name"] ?></h6>
                <small class="text-muted"><?php echo "300000" ?></small>
              </div>
              <span class="text-muted"><?php echo $items["product_price"] ?></span>
            </li>
            <?php 
          }?>

            <li class="list-group-item d-flex justify-content-between">
              <span>Total (MWK)</span>
              <?php 
               
              ?>
              <strong><?php echo "450000" ?></strong>
            </li>
            
          </ul>
          
      </div>

      <?php
  
    
      }
      ?>
      <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Payment</h4>
        <form class="needs-validation" novalidate>
          

          <div class="my-3">
            <div class="form-check">
              <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked required>
              <label class="form-check-label" for="credit">Credit card</label>
            </div>
            <div class="form-check">
              <input id="debit" name="paymentMethod" type="radio" class="form-check-input" required>
              <label class="form-check-label" for="debit">Debit card</label>
            </div>
            <div class="form-check">
              <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" required>
              <label class="form-check-label" for="paypal">PayPal</label>
            </div>
            <div class="form-check">
              <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" required>
              <label class="form-check-label" for="paypal">Airtel Money</label>
            </div>
            <div class="form-check">
              <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" required>
              <label class="form-check-label" for="paypal">Mpamba</label>
            </div>
          </div>

          <div class="row gy-3">
            <div class="col-md-6">
              <label for="cc-name" class="form-label">Name on card</label>
              <input type="text" class="form-control" id="cc-name" placeholder="" required>
              <small class="text-muted">Full name as displayed on card</small>
              <div class="invalid-feedback">
                Name on card is required
              </div>
            </div>

            <div class="col-md-6">
              <label for="cc-number" class="form-label">Credit card number</label>
              <input type="text" class="form-control" id="cc-number" placeholder="" required>
              <div class="invalid-feedback">
                Credit card number is required
              </div>
            </div>

            <div class="col-md-3">
              <label for="cc-expiration" class="form-label">Expiration</label>
              <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
              <div class="invalid-feedback">
                Expiration date required
              </div>
            </div>

            <div class="col-md-3">
              <label for="cc-cvv" class="form-label">CVV</label>
              <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
              <div class="invalid-feedback">
                Security code required
              </div>
            </div>
          </div>

          <hr class="my-4">

          <button class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</button>
        </form>
      </div>
    </div>
  </main>
  
  </div>
</div>




        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Appointment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="pt-3" id="addap" enctype="multipart/formdata">
                            <div class="form-group">
                                <label>Appointment Purpose</label>
                                <div class="input-group">
                                    <input type="text" required name="purpose" class="form-control form-control-lg "
                                        placeholder="Purpose">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Appointment Date</label>
                                <div class="input-group">
                                    <input type="datetime-local" required name="date_" class="form-control form-control-lg "
                                        placeholder="Project Description"></input>
                                </div>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="btnSub" type="submit">Save </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal -->


        <?php  include('footer.php'); ?>
        <script>
            function topdf() {
            var doc = new jsPDF();
            //doc.text(20, 20, "Hello!");
            //let finalY = doc.lastAutoTable.finalY; // The y position on the page
            doc.autoTable({
                html: '#usertable'
            });


            doc.save('Appointments_<?php print date('d-m-Y'); ?>.pdf');
        }
        function deleteAp(id) {
            var formValues = {
                id: id
            };
            $.post("../model/delap.php", formValues, function(data) {
                        // Display the returned data in browser
                        console.log(data);
                        if (data == 1) {
                            alert("Appointment Deleted!");
                            setTimeout(function(e) {
                                location.reload();
                            }, 500);
                        } else {
                            alert("Error Encountered");
                        }
                    });
                }

                    $("#addap").submit(function(e) {
                        e.preventDefault();
                        

                        $.ajax({
                            url: "../model/addap.php",
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
                                        alert("Appointment Submitted!");
                                        window.location.reload();
                                    }, 500);
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