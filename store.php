<?php
require_once 'partials/header.php';
$isLoggedIn = isset($_SESSION['userId']);
$userType = $_SESSION['userType'] ?? null;

// Get filter parameters
$category = $_GET['category'] ?? '';
$search = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? 'name';

// Build query for bails (secondhand clothing bundles)
$whereClause = "WHERE b_status = 'available' AND b_stock_quantity > 0";
$params = [];

if ($search) {
    $whereClause .= " AND (b_name LIKE ? OR b_description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$orderClause = "ORDER BY ";
switch ($sort) {
    case 'price_low':
        $orderClause .= "b_avg_price_per_item ASC";
        break;
    case 'price_high':
        $orderClause .= "b_avg_price_per_item DESC";
        break;
    case 'stock':
        $orderClause .= "b_stock_quantity DESC";
        break;
    case 'name':
    default:
        $orderClause .= "b_name ASC";
        break;
}

// Fetch available bails
if (empty($params)) {
    $products = $db->query("SELECT *, b_id as product_id, b_name as product_name, b_description as product_description, b_avg_price_per_item as product_price FROM bails $whereClause $orderClause")->fetchAll();
} else {
    $products = $db->query("SELECT *, b_id as product_id, b_name as product_name, b_description as product_description, b_avg_price_per_item as product_price FROM bails $whereClause $orderClause", ...$params)->fetchAll();
}

// Add default image for bails
foreach ($products as &$product) {
    $imageName = strtolower(str_replace(' ', '-', $product['product_name'])) . '.jpg';
    $imagePath = 'assets/img/bails/' . $imageName;
    
    // Check if specific bail image exists, otherwise use placeholder
    if (file_exists($imagePath)) {
        $product['product_image_location'] = $imagePath;
    } else {
        $product['product_image_location'] = 'assets/img/hero-img.png'; // Fallback to hero image
    }
    
    $product['product_image_alt'] = $product['product_name'] . ' - Secondhand Clothing Bundle';
    $product['product_category'] = 'Secondhand Clothing Bundle';
}

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
          <h1 class="mb-3">Secondhand Clothing Bails</h1>
          <p class="lead">Quality secondhand clothing bundles from international donors</p>
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

            <!-- Bail Info -->
            <div class="mb-4">
              <div class="alert alert-info">
                <h6><i class="bi bi-info-circle"></i> About Our Bails</h6>
                <small>Each bail contains multiple secondhand clothing items from international donors. Perfect for resellers or bulk buyers.</small>
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
              <select class="form-select" style="width: auto;" onchange="window.location.href='?search=<?php echo $search; ?>&sort=' + this.value">
                <option value="name" <?php echo $sort === 'name' ? 'selected' : ''; ?>>Name</option>
                <option value="price_low" <?php echo $sort === 'price_low' ? 'selected' : ''; ?>>Price: Low to High</option>
                <option value="price_high" <?php echo $sort === 'price_high' ? 'selected' : ''; ?>>Price: High to Low</option>
                <option value="stock" <?php echo $sort === 'stock' ? 'selected' : ''; ?>>Stock Available</option>
              </select>
            </div>
          </div>

          <!-- Products Grid -->
          <div class="row g-4">
            <?php if (empty($products)): ?>
              <div class="col-12">
                <div class="text-center py-5">
                  <i class="bi bi-archive display-1 text-muted"></i>
                  <h3 class="mt-3">No bails available</h3>
                  <p class="text-muted">Check back soon for new secondhand clothing bundles</p>
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
                           style="height: 250px; object-fit: cover;"
                           onerror="this.src='assets/img/hero-img.png'">
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
                        <?php echo htmlspecialchars(substr($product['product_description'] ?? 'Quality secondhand clothing bundle', 0, 100)) . '...'; ?>
                      </p>
                      <div class="mb-2">
                        <small class="text-muted">
                          <i class="bi bi-box"></i> <?php echo $product['b_items_count']; ?> items per bail
                        </small>
                      </div>
                      <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div>
                          <span class="h5 text-primary mb-0">MWK <?php echo number_format((float)$product['product_price'], 2); ?></span>
                          <small class="text-muted d-block">per item avg</small>
                        </div>
                        <div class="text-end">
                          <span class="badge bg-success"><?php echo $product['b_stock_quantity']; ?> in stock</span>
                        </div>
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
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="productModalTitle">Bail Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="productModalBody">
        <!-- Product details will be loaded here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <div id="modalCartButton"></div>
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

.product-modal-image {
  max-height: 500px;
  width: 100%;
  object-fit: cover;
  border-radius: 10px;
  cursor: pointer;
  transition: transform 0.3s ease;
}

.product-modal-image:hover {
  transform: scale(1.05);
}

.bail-info-card {
  background: #f8f9fa;
  border-radius: 10px;
  padding: 20px;
  margin-bottom: 20px;
}

.badge-large {
  font-size: 0.9rem;
  padding: 8px 12px;
}
</style>

<script>
function viewProduct(productId) {
  // Load product details and images via AJAX
  Promise.all([
    $.get('model/getProduct.php', { id: productId }),
    $.get('model/getBailImages.php', { bail_id: productId })
  ]).then(function([productData, imagesData]) {
    const product = JSON.parse(productData);
    const images = JSON.parse(imagesData);
    
    $('#productModalTitle').text(product.product_name + ' - Secondhand Clothing Bail');
    
    // Build image gallery
    let imageGallery = '';
    if (images.success && images.images.length > 0) {
      const primaryImage = images.images.find(img => img.is_primary) || images.images[0];
      
      imageGallery = `
        <div class="text-center">
          <img src="${primaryImage.image_path}" 
               class="product-modal-image mb-3" 
               id="mainImage"
               alt="${product.product_name}" 
               onclick="openImageFullscreen(this.src)">
          
          <div class="d-flex justify-content-center gap-2 flex-wrap">
            ${images.images.map(img => `
              <img src="${img.image_path}" 
                   class="img-thumbnail" 
                   style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;" 
                   onclick="changeMainImage('${img.image_path}')"
                   ${img.is_primary ? 'style="border: 3px solid #007bff;"' : ''}>
            `).join('')}
          </div>
          <p class="text-muted mt-2 small">Click thumbnails to change main image • Click main image for fullscreen</p>
        </div>
      `;
    } else {
      imageGallery = `
        <div class="text-center">
          <img src="${product.product_image_location}" 
               class="product-modal-image" 
               alt="${product.product_image_alt}" 
               onerror="this.src='assets/img/hero-img.png'"
               onclick="openImageFullscreen(this.src)">
          <p class="text-muted mt-2 small">Click image to view fullscreen</p>
        </div>
      `;
    }
    
    const modalContent = `
      <div class="row">
        <div class="col-lg-6">
          ${imageGallery}
        </div>
        <div class="col-lg-6">
          <div class="bail-info-card">
              <h3 class="text-primary mb-3">${product.product_name}</h3>
              
              <div class="row mb-3">
                <div class="col-6">
                  <div class="text-center p-3 bg-white rounded">
                    <h4 class="text-success mb-1">MWK ${parseFloat(product.product_price).toFixed(2)}</h4>
                    <small class="text-muted">Per item average</small>
                  </div>
                </div>
                <div class="col-6">
                  <div class="text-center p-3 bg-white rounded">
                    <h4 class="text-info mb-1">MWK ${parseFloat(product.b_total_value || product.product_price * product.b_items_count).toFixed(2)}</h4>
                    <small class="text-muted">Total bail value</small>
                  </div>
                </div>
              </div>
              
              <div class="mb-3">
                <span class="badge bg-info badge-large me-2">
                  <i class="bi bi-box"></i> ${product.b_items_count} items per bail
                </span>
                <span class="badge bg-success badge-large">
                  <i class="bi bi-check-circle"></i> ${product.b_stock_quantity} bails available
                </span>
              </div>
              
              <div class="mb-3">
                <h6>Description:</h6>
                <p class="text-muted">${product.product_description || 'Quality secondhand clothing bundle from international donors. Each bail contains a variety of clothing items perfect for resale or personal use.'}</p>
              </div>
              
              <div class="mb-3">
                <h6>Bail Information:</h6>
                <ul class="list-unstyled text-muted">
                  <li><i class="bi bi-globe text-info"></i> Sourced from international donors</li>
                  <li><i class="bi bi-recycle text-success"></i> Sustainable secondhand clothing</li>
                  <li><i class="bi bi-shop text-primary"></i> Perfect for retail resale</li>
                  <li><i class="bi bi-people text-warning"></i> Bulk buying opportunity</li>
                </ul>
              </div>
          </div>
        </div>
      </div>
    `;
      
    $('#productModalBody').html(modalContent);
      
      // Update modal footer with cart button
      const cartButton = `
        <?php if ($isLoggedIn): ?>
        <div class="d-flex align-items-center">
          <div class="input-group me-3" style="width: 150px;">
            <button class="btn btn-outline-secondary" type="button" onclick="changeQuantity(-1)">-</button>
            <input type="number" class="form-control text-center" id="quantity" value="1" min="1" max="${product.b_stock_quantity}">
            <button class="btn btn-outline-secondary" type="button" onclick="changeQuantity(1)">+</button>
          </div>
          <button class="btn btn-primary btn-lg" onclick="addToCart(${product.product_id}, document.getElementById('quantity').value)">
            <i class="bi bi-cart-plus"></i> Add ${product.b_items_count} Items to Cart
          </button>
        </div>
        <?php else: ?>
        <a href="signin.php" class="btn btn-primary btn-lg">
          <i class="bi bi-person-plus"></i> Sign In to Purchase
        </a>
        <?php endif; ?>
      `;
      
      $('#modalCartButton').html(cartButton);
      const modal = new bootstrap.Modal(document.getElementById('productModal'));
      modal.show();
    }).catch(function() {
      alert('Error loading product details');
    });
}

function changeMainImage(imageSrc) {
  const mainImage = document.getElementById('mainImage');
  if (mainImage) {
    mainImage.src = imageSrc;
  }
}

function addToCart(productId, quantity = 1) {
  <?php if ($isLoggedIn): ?>
  console.log('Adding to cart:', productId, quantity);
  $.ajax({
    url: 'model/addToCart.php',
    type: 'POST',
    data: { product_id: productId, quantity: quantity },
    success: function(data) {
      console.log('Response:', data);
      try {
        const response = JSON.parse(data);
        if (response.success) {
          alert('Bail added to cart!');
          location.reload();
        } else {
          alert('Error: ' + response.message);
        }
      } catch (e) {
        console.error('JSON parse error:', e);
        alert('Server response error: ' + data);
      }
    },
    error: function(xhr, status, error) {
      console.error('AJAX error:', status, error);
      alert('Network error: ' + error);
    }
  });
  <?php else: ?>
  window.location.href = 'signin.php';
  <?php endif; ?>
}

function changeQuantity(change) {
  const quantityInput = document.getElementById('quantity');
  if (!quantityInput) return;
  
  const currentValue = parseInt(quantityInput.value);
  const maxValue = parseInt(quantityInput.getAttribute('max'));
  const newValue = currentValue + change;
  
  if (newValue >= 1 && newValue <= maxValue) {
    quantityInput.value = newValue;
  }
}

function openImageFullscreen(imageSrc) {
  const fullscreenModal = `
    <div class="modal fade" id="imageModal" tabindex="-1">
      <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-dark">
          <div class="modal-header border-0">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body d-flex align-items-center justify-content-center">
            <img src="${imageSrc}" class="img-fluid" style="max-height: 90vh; max-width: 90vw;">
          </div>
        </div>
      </div>
    </div>
  `;
  
  // Remove existing image modal if any
  const existingModal = document.getElementById('imageModal');
  if (existingModal) {
    existingModal.remove();
  }
  
  // Add new modal to body
  document.body.insertAdjacentHTML('beforeend', fullscreenModal);
  
  // Show the modal
  const modal = new bootstrap.Modal(document.getElementById('imageModal'));
  modal.show();
  
  // Remove modal from DOM when hidden
  document.getElementById('imageModal').addEventListener('hidden.bs.modal', function() {
    this.remove();
  });
}
</script>

<?php
require_once 'partials/footer.php';
?>