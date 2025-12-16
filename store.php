<?php
require_once 'partials/header.php';
$isLoggedIn = isset($_SESSION['userId']);
$userType = $_SESSION['userType'] ?? null;

// Get filter parameters
$category = $_GET['category'] ?? '';
$search = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? 'name';

// Build query for products
$whereClause = "WHERE 1=1";
$params = [];

if ($category) {
    $whereClause .= " AND product_category = ?";
    $params[] = $category;
}

if ($search) {
    $whereClause .= " AND (product_name LIKE ? OR product_description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$orderClause = "ORDER BY ";
switch ($sort) {
    case 'price_low':
        $orderClause .= "CAST(product_price AS DECIMAL) ASC";
        break;
    case 'price_high':
        $orderClause .= "CAST(product_price AS DECIMAL) DESC";
        break;
    case 'name':
    default:
        $orderClause .= "product_name ASC";
        break;
}

// Fetch products
if (empty($params)) {
    $products = $db->query("SELECT * FROM products $whereClause $orderClause")->fetchAll();
} else {
    $products = $db->query("SELECT * FROM products $whereClause $orderClause", ...$params)->fetchAll();
}

// Get categories for filter
$categories = $db->query("SELECT DISTINCT product_category FROM products ORDER BY product_category")->fetchAll();

// Get cart count for logged in users
$cartCount = 0;
if ($isLoggedIn) {
    $cartResult = $db->query("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?", $_SESSION['userId'])->fetchArray();
    $cartCount = $cartResult['total'] ?? 0;
}
?>
<main class="main">
  <!-- Store Header -->
  <section class="store-header section light-background">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <h1 class="mb-3">Our Store</h1>
          <p class="lead">Discover the latest trends in fashion and style</p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <?php if ($isLoggedIn): ?>
            <a href="cart.php" class="btn btn-primary">
              <i class="bi bi-cart"></i> Cart (<?php echo $cartCount; ?>)
            </a>
          <?php else: ?>
            <a href="signin.php" class="btn btn-outline-primary">Sign In to Shop</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- Store Filters -->
  <section class="store-filters section">
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <div class="filter-sidebar">
            <h5>Filters</h5>
            
            <!-- Search -->
            <div class="mb-4">
              <label class="form-label">Search Products</label>
              <form method="GET" class="d-flex">
                <input type="text" class="form-control" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search...">
                <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
                <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort); ?>">
                <button type="submit" class="btn btn-outline-secondary ms-2">
                  <i class="bi bi-search"></i>
                </button>
              </form>
            </div>

            <!-- Categories -->
            <div class="mb-4">
              <label class="form-label">Categories</label>
              <div class="list-group">
                <a href="?sort=<?php echo $sort; ?>&search=<?php echo $search; ?>" 
                   class="list-group-item list-group-item-action <?php echo empty($category) ? 'active' : ''; ?>">
                  All Categories
                </a>
                <?php foreach ($categories as $cat): ?>
                  <a href="?category=<?php echo urlencode($cat['product_category']); ?>&sort=<?php echo $sort; ?>&search=<?php echo $search; ?>" 
                     class="list-group-item list-group-item-action <?php echo $category === $cat['product_category'] ? 'active' : ''; ?>">
                    <?php echo htmlspecialchars($cat['product_category']); ?>
                  </a>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-9">
          <!-- Sort Options -->
          <div class="d-flex justify-content-between align-items-center mb-4">
            <p class="mb-0"><?php echo count($products); ?> products found</p>
            <div class="d-flex align-items-center">
              <label class="form-label me-2 mb-0">Sort by:</label>
              <select class="form-select" style="width: auto;" onchange="window.location.href='?category=<?php echo $category; ?>&search=<?php echo $search; ?>&sort=' + this.value">
                <option value="name" <?php echo $sort === 'name' ? 'selected' : ''; ?>>Name</option>
                <option value="price_low" <?php echo $sort === 'price_low' ? 'selected' : ''; ?>>Price: Low to High</option>
                <option value="price_high" <?php echo $sort === 'price_high' ? 'selected' : ''; ?>>Price: High to Low</option>
              </select>
            </div>
          </div>

          <!-- Products Grid -->
          <div class="row g-4">
            <?php if (empty($products)): ?>
              <div class="col-12">
                <div class="text-center py-5">
                  <i class="bi bi-search display-1 text-muted"></i>
                  <h3 class="mt-3">No products found</h3>
                  <p class="text-muted">Try adjusting your search or filter criteria</p>
                </div>
              </div>
            <?php else: ?>
              <?php foreach ($products as $product): ?>
                <div class="col-lg-4 col-md-6">
                  <div class="product-card card h-100 shadow-sm">
                    <div class="product-image">
                      <img src="<?php echo htmlspecialchars($product['product_image_location']); ?>" 
                           class="card-img-top" 
                           alt="<?php echo htmlspecialchars($product['product_image_alt']); ?>"
                           style="height: 250px; object-fit: cover;">
                      <div class="product-overlay">
                        <button class="btn btn-primary btn-sm" onclick="viewProduct(<?php echo $product['product_id']; ?>)">
                          <i class="bi bi-eye"></i> View
                        </button>
                        <?php if ($isLoggedIn): ?>
                          <button class="btn btn-success btn-sm" onclick="addToCart(<?php echo $product['product_id']; ?>)">
                            <i class="bi bi-cart-plus"></i> Add to Cart
                          </button>
                        <?php endif; ?>
                      </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                      <h5 class="card-title"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                      <p class="card-text text-muted small flex-grow-1">
                        <?php echo htmlspecialchars(substr($product['product_description'], 0, 100)) . '...'; ?>
                      </p>
                      <div class="d-flex justify-content-between align-items-center mt-auto">
                        <span class="h5 text-primary mb-0">$<?php echo number_format((float)$product['product_price'], 2); ?></span>
                        <span class="badge bg-secondary"><?php echo htmlspecialchars($product['product_category']); ?></span>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- Product Modal -->
<div class="modal fade" id="productModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="productModalTitle">Product Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="productModalBody">
        <!-- Product details will be loaded here -->
      </div>
    </div>
  </div>
</div>

<style>
.product-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  overflow: hidden;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.product-image {
  position: relative;
  overflow: hidden;
}

.product-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0,0,0,0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
  opacity: 1;
}

.filter-sidebar {
  background: #f8f9fa;
  padding: 20px;
  border-radius: 10px;
  position: sticky;
  top: 20px;
}

.store-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 60px 0;
}

.store-header h1 {
  color: white;
}
</style>

<script>
function viewProduct(productId) {
  // Load product details via AJAX
  $.ajax({
    url: 'model/getProduct.php',
    type: 'GET',
    data: { id: productId },
    success: function(data) {
      const product = JSON.parse(data);
      $('#productModalTitle').text(product.product_name);
      $('#productModalBody').html(`
        <div class="row">
          <div class="col-md-6">
            <img src="${product.product_image_location}" class="img-fluid rounded" alt="${product.product_image_alt}">
          </div>
          <div class="col-md-6">
            <h4>$${parseFloat(product.product_price).toFixed(2)}</h4>
            <p class="text-muted">${product.product_category}</p>
            <p>${product.product_description}</p>
            <?php if ($isLoggedIn): ?>
            <div class="mt-4">
              <div class="input-group mb-3" style="width: 150px;">
                <button class="btn btn-outline-secondary" type="button" onclick="changeQuantity(-1)">-</button>
                <input type="number" class="form-control text-center" id="quantity" value="1" min="1">
                <button class="btn btn-outline-secondary" type="button" onclick="changeQuantity(1)">+</button>
              </div>
              <button class="btn btn-primary" onclick="addToCart(${product.product_id}, document.getElementById('quantity').value)">
                <i class="bi bi-cart-plus"></i> Add to Cart
              </button>
            </div>
            <?php else: ?>
            <div class="mt-4">
              <a href="signin.php" class="btn btn-primary">Sign In to Purchase</a>
            </div>
            <?php endif; ?>
          </div>
        </div>
      `);
      $('#productModal').modal('show');
    }
  });
}

function addToCart(productId, quantity = 1) {
  <?php if ($isLoggedIn): ?>
  $.ajax({
    url: 'model/addToCart.php',
    type: 'POST',
    data: { product_id: productId, quantity: quantity },
    success: function(data) {
      const response = JSON.parse(data);
      if (response.success) {
        alert('Product added to cart!');
        location.reload(); // Refresh to update cart count
      } else {
        alert('Error: ' + response.message);
      }
    }
  });
  <?php else: ?>
  window.location.href = 'signin.php';
  <?php endif; ?>
}

function changeQuantity(change) {
  const quantityInput = document.getElementById('quantity');
  const currentValue = parseInt(quantityInput.value);
  const newValue = currentValue + change;
  if (newValue >= 1) {
    quantityInput.value = newValue;
  }
}
</script>

<?php
require_once 'partials/footer.php';
?>