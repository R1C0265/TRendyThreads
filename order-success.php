<?php
require_once 'partials/header.php';

if (!isset($_SESSION['userId']) || !isset($_GET['order'])) {
    header('Location: index.php');
    exit;
}

$orderId = (int)$_GET['order'];
$userId = $_SESSION['userId'];

// Get order details
$order = $db->query("SELECT * FROM orders WHERE id = ? AND user_id = ?", $orderId, $userId)->fetchArray();

if (!$order) {
    header('Location: index.php');
    exit;
}

// Get order items with bail details
$orderItems = $db->query("
    SELECT oi.*, b.b_name as product_name, b.b_items_count,
           CONCAT('assets/img/bails/', LOWER(REPLACE(b.b_name, ' ', '-')), '.jpg') as product_image_location
    FROM order_items oi 
    JOIN bails b ON oi.product_id = b.b_id 
    WHERE oi.order_id = ?
", $orderId)->fetchAll();
?>

<main class="main">
    <section class="order-success-section section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5">
                        <div class="success-icon mb-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h1 class="text-success">Order Placed Successfully!</h1>
                        <p class="lead">Thank you for your purchase. Your order has been received and is being processed.</p>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Order Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <strong>Order Number:</strong> #<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?>
                                </div>
                                <div class="col-md-6">
                                    <strong>Order Date:</strong> <?php echo date('F j, Y', strtotime($order['created_at'])); ?>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <strong>Total Amount:</strong> MWK <?php echo number_format($order['total_amount'], 2); ?>
                                </div>
                                <div class="col-md-6">
                                    <strong>Payment Status:</strong> 
                                    <span class="badge bg-success"><?php echo ucfirst($order['payment_status']); ?></span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <strong>Shipping Address:</strong>
                                <address class="mt-2">
                                    <?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?>
                                </address>
                            </div>

                            <h6>Order Items:</h6>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orderItems as $item): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="<?php echo htmlspecialchars($item['product_image_location']); ?>" 
                                                             class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                        <div>
                                                            <?php echo htmlspecialchars($item['product_name']); ?>
                                                            <small class="text-muted d-block"><?php echo $item['b_items_count']; ?> items per bail</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?php echo $item['quantity']; ?> bails</td>
                                                <td>MWK <?php echo number_format($item['price'], 2); ?></td>
                                                <td>MWK <?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="store.php" class="btn btn-primary me-2">Continue Shopping</a>
                        <a href="index.php" class="btn btn-outline-secondary">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
.order-success-section {
    padding: 60px 0;
}

.success-icon {
    animation: bounce 1s ease-in-out;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}
</style>

<?php require_once 'partials/footer.php'; ?>