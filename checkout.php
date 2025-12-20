<?php
require_once 'partials/header.php';

// Check if user is logged in
if (!isset($_SESSION['userId'])) {
    header('Location: signin.php');
    exit;
}

$userId = $_SESSION['userId'];

// Get cart items with bail details
$cartItems = $db->query("
    SELECT c.*, b.b_name as product_name, b.b_avg_price_per_item as product_price, b.b_items_count,
           CONCAT('assets/img/bails/', LOWER(REPLACE(b.b_name, ' ', '-')), '.jpg') as product_image_location
    FROM cart c 
    JOIN bails b ON c.product_id = b.b_id 
    WHERE c.user_id = ?
", $userId)->fetchAll();

if (empty($cartItems)) {
    header('Location: cart.php');
    exit;
}

// Calculate totals
$subtotal = 0;
foreach ($cartItems as $item) {
    $subtotal += (float)$item['product_price'] * $item['quantity'];
}
$tax = $subtotal * 0.08;
$shipping = $subtotal > 50 ? 0 : 9.99;
$total = $subtotal + $tax + $shipping;

// Get user info
$user = $db->query("SELECT * FROM users WHERE u_id = ?", $userId)->fetchArray();
?>

<main class="main">
    <section class="checkout-section section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="mb-4">Checkout</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <form id="checkoutForm">
                        <!-- Shipping Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Shipping Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">First Name</label>
                                            <input type="text" class="form-control" name="first_name" 
                                                   value="<?php echo htmlspecialchars($user['u_name'] ?? ''); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" class="form-control" name="last_name" 
                                                   value="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" 
                                           value="<?php echo htmlspecialchars($user['u_email'] ?? ''); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">City</label>
                                            <input type="text" class="form-control" name="city" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">State</label>
                                            <input type="text" class="form-control" name="state" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">ZIP Code</label>
                                            <input type="text" class="form-control" name="zip" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Payment Method</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i>
                                    <strong>Demo Mode:</strong> This is a demonstration checkout. No real payment will be processed.
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" value="paychangu" id="paychangu" checked>
                                    <label class="form-check-label" for="paychangu">
                                        <i class="bi bi-phone"></i> PayChangu (Mobile Money)
                                        <small class="d-block text-muted">Airtel Money, TNM Mpamba, Bank Transfer</small>
                                    </label>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" value="stripe" id="stripe">
                                    <label class="form-check-label" for="stripe">
                                        <i class="bi bi-credit-card"></i> Credit Card (Stripe)
                                    </label>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" value="paypal" id="paypal">
                                    <label class="form-check-label" for="paypal">
                                        <i class="bi bi-paypal"></i> PayPal
                                    </label>
                                </div>
                                
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" value="demo" id="demo">
                                    <label class="form-check-label" for="demo">
                                        <i class="bi bi-cash"></i> Demo Payment (Testing)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-4">
                    <!-- Order Summary -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <!-- Cart Items -->
                            <div class="order-items mb-3">
                                <?php foreach ($cartItems as $item): ?>
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="<?php echo htmlspecialchars($item['product_image_location']); ?>" 
                                             class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                        <div class="flex-grow-1">
                                            <small class="d-block"><?php echo htmlspecialchars($item['product_name']); ?></small>
                                            <small class="text-muted">Qty: <?php echo $item['quantity']; ?> bails (<?php echo $item['quantity'] * $item['b_items_count']; ?> items)</small>
                                        </div>
                                        <small>$<?php echo number_format((float)$item['product_price'] * $item['quantity'], 2); ?></small>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <hr>
                            
                            <!-- Totals -->
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>MWK <?php echo number_format($subtotal, 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax:</span>
                                <span>MWK <?php echo number_format($tax, 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Shipping:</span>
                                <span><?php echo $shipping > 0 ? 'MWK ' . number_format($shipping, 2) : 'FREE'; ?></span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <strong>Total:</strong>
                                <strong>MWK <?php echo number_format($total, 2); ?></strong>
                            </div>
                            
                            <button type="button" class="btn btn-primary w-100 mb-2" onclick="processOrder()">
                                Place Order
                            </button>
                            <a href="cart.php" class="btn btn-outline-secondary w-100">
                                Back to Cart
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
function processOrder() {
    const form = document.getElementById('checkoutForm');
    const formData = new FormData(form);
    
    // Basic validation
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    
    if (paymentMethod === 'paychangu') {
        // PayChangu payment processing
        processPayChanguPayment(formData);
    } else if (paymentMethod === 'demo') {
        // Demo payment - just process the order
        processOrderDemo(formData);
    } else if (paymentMethod === 'stripe') {
        alert('Stripe integration would be implemented here. For demo, use "Demo Payment" option.');
    } else if (paymentMethod === 'paypal') {
        alert('PayPal integration would be implemented here. For demo, use "Demo Payment" option.');
    }
}

function processPayChanguPayment(formData) {
    // Get total amount from the page
    const totalText = document.querySelector('.card-body strong:last-child').textContent;
    const amount = totalText.replace('MWK ', '').replace(',', '');
    
    // Show mobile money input modal
    const phoneNumber = prompt('Enter your mobile money number (e.g., 0881234567):');
    if (!phoneNumber) return;
    
    // Validate phone number format
    if (!/^(088|099|085|084)\d{7}$/.test(phoneNumber)) {
        alert('Please enter a valid Malawian mobile number (088xxxxxxx, 099xxxxxxx, 085xxxxxxx, or 084xxxxxxx)');
        return;
    }
    
    // Add PayChangu specific data
    formData.append('payment_method', 'paychangu');
    formData.append('phone_number', phoneNumber);
    formData.append('amount', amount);
    
    // Show loading
    const button = document.querySelector('button[onclick="processOrder()"]');
    const originalText = button.textContent;
    button.textContent = 'Processing Payment...';
    button.disabled = true;
    
    $.ajax({
        url: 'model/processPayChanguOrder.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            const response = JSON.parse(data);
            if (response.success) {
                if (response.demo_mode) {
                    // Demo mode - show message and simulate success
                    alert(response.message);
                    setTimeout(() => {
                        alert('DEMO: Simulating successful payment...');
                        window.location.href = 'order-success.php?order=' + response.order_id;
                    }, 2000);
                } else if (response.payment_url) {
                    // Redirect to PayChangu payment page
                    window.location.href = response.payment_url;
                } else {
                    alert('Payment initiated! Please check your phone for the mobile money prompt.');
                    // Poll for payment status
                    checkPaymentStatus(response.transaction_id, response.order_id);
                }
            } else {
                let errorMsg = 'Error: ' + response.message;
                if (response.debug) {
                    console.log('Debug info:', response.debug);
                    errorMsg += '\n\nCheck browser console for debug info.';
                }
                alert(errorMsg);
                button.textContent = originalText;
                button.disabled = false;
            }
        },
        error: function() {
            alert('Error processing payment. Please try again.');
            button.textContent = originalText;
            button.disabled = false;
        }
    });
}

function checkPaymentStatus(transactionId, orderId) {
    const checkInterval = setInterval(() => {
        $.ajax({
            url: 'model/checkPaymentStatus.php',
            type: 'POST',
            data: { transaction_id: transactionId },
            success: function(data) {
                const response = JSON.parse(data);
                if (response.status === 'completed') {
                    clearInterval(checkInterval);
                    alert('Payment successful!');
                    window.location.href = 'order-success.php?order=' + orderId;
                } else if (response.status === 'failed') {
                    clearInterval(checkInterval);
                    alert('Payment failed. Please try again.');
                    location.reload();
                }
                // Continue polling if status is 'pending'
            }
        });
    }, 3000); // Check every 3 seconds
    
    // Stop polling after 5 minutes
    setTimeout(() => {
        clearInterval(checkInterval);
        alert('Payment timeout. Please check your order status or contact support.');
    }, 300000);
}

function processOrderDemo(formData) {
    formData.append('payment_method', 'demo');
    
    $.ajax({
        url: 'model/processOrder.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            const response = JSON.parse(data);
            if (response.success) {
                alert('Order placed successfully! Order ID: ' + response.order_id);
                window.location.href = 'order-success.php?order=' + response.order_id;
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function() {
            alert('Error processing order. Please try again.');
        }
    });
}
</script>

<?php require_once 'partials/footer.php'; ?>