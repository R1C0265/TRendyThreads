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
    SELECT c.*, b.b_name as product_name, b.b_avg_price_per_item as product_price, b.b_items_count, b.b_stock_quantity,
           CONCAT('assets/img/bails/', LOWER(REPLACE(b.b_name, ' ', '-')), '.jpg') as product_image_location,
           CONCAT(b.b_name, ' - Secondhand Clothing Bundle') as product_image_alt
    FROM cart c 
    JOIN bails b ON c.product_id = b.b_id 
    WHERE c.user_id = ?
    ORDER BY c.created_at DESC
", $userId)->fetchAll();

// Calculate totals
$subtotal = 0;
foreach ($cartItems as $item) {
    $subtotal += (float)$item['product_price'] * $item['quantity'];
}
$tax = $subtotal * 0.08; // 8% tax
$shipping = $subtotal > 50 ? 0 : 9.99; // Free shipping over $50
$total = $subtotal + $tax + $shipping;
?>

<main class="main">
    <section class="cart-section section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="mb-4">Shopping Cart</h1>
                </div>
            </div>

            <?php if (empty($cartItems)): ?>
                <div class="row">
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="bi bi-cart-x display-1 text-muted"></i>
                            <h3 class="mt-3">Your cart is empty</h3>
                            <p class="text-muted">Add some products to get started</p>
                            <a href="store.php" class="btn btn-primary">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="cart-items">
                            <?php foreach ($cartItems as $item): ?>
                                <div class="cart-item card mb-3" data-item-id="<?php echo $item['id']; ?>">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-2">
                                                <img src="<?php echo htmlspecialchars($item['product_image_location']); ?>" 
                                                     class="img-fluid rounded" 
                                                     alt="<?php echo htmlspecialchars($item['product_image_alt']); ?>"
                                                     style="height: 80px; object-fit: cover;">
                                            </div>
                                            <div class="col-md-4">
                                                <h5 class="mb-1"><?php echo htmlspecialchars($item['product_name']); ?></h5>
                                                <p class="text-muted mb-0">MWK <?php echo number_format((float)$item['product_price'], 2); ?> per item avg</p>
                                                <small class="text-muted"><?php echo $item['b_items_count']; ?> items per bail</small>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group" style="width: 120px;">
                                                    <button class="btn btn-outline-secondary btn-sm" type="button" 
                                                            onclick="updateQuantity(<?php echo $item['id']; ?>, <?php echo $item['quantity'] - 1; ?>)">-</button>
                                                    <input type="number" class="form-control form-control-sm text-center" 
                                                           value="<?php echo $item['quantity']; ?>" 
                                                           onchange="updateQuantity(<?php echo $item['id']; ?>, this.value)"
                                                           min="1">
                                                    <button class="btn btn-outline-secondary btn-sm" type="button" 
                                                            onclick="updateQuantity(<?php echo $item['id']; ?>, <?php echo $item['quantity'] + 1; ?>)">+</button>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <strong>MWK <?php echo number_format((float)$item['product_price'] * $item['quantity'], 2); ?></strong>
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-outline-danger btn-sm" 
                                                        onclick="removeFromCart(<?php echo $item['id']; ?>)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="cart-summary card">
                            <div class="card-header">
                                <h5 class="mb-0">Order Summary</h5>
                            </div>
                            <div class="card-body">
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
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>Total:</strong>
                                    <strong>MWK <?php echo number_format($total, 2); ?></strong>
                                </div>
                                
                                <?php if ($subtotal < 50 && $shipping > 0): ?>
                                    <div class="alert alert-info small">
                                        <i class="bi bi-info-circle"></i>
                                        Add MWK <?php echo number_format(50 - $subtotal, 2); ?> more for free shipping!
                                    </div>
                                <?php endif; ?>
                                
                                <button class="btn btn-primary w-100 mb-2" onclick="proceedToCheckout()">
                                    Proceed to Checkout
                                </button>
                                <a href="store.php" class="btn btn-outline-secondary w-100">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<script>
function updateQuantity(cartId, newQuantity) {
    if (newQuantity < 1) {
        removeFromCart(cartId);
        return;
    }
    
    $.ajax({
        url: 'model/updateCart.php',
        type: 'POST',
        data: { cart_id: cartId, quantity: newQuantity },
        success: function(data) {
            const response = JSON.parse(data);
            if (response.success) {
                location.reload();
            } else {
                alert('Error: ' + response.message);
            }
        }
    });
}

function removeFromCart(cartId) {
    if (confirm('Remove this item from cart?')) {
        $.ajax({
            url: 'model/removeFromCart.php',
            type: 'POST',
            data: { cart_id: cartId },
            success: function(data) {
                const response = JSON.parse(data);
                if (response.success) {
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            }
        });
    }
}

function proceedToCheckout() {
    window.location.href = 'checkout.php';
}
</script>

<?php require_once 'partials/footer.php'; ?>