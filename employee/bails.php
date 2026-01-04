<?php
$page_title = "Bails - Trendy Threads";
require_once 'partials/header.php';

// Get filter parameters
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';
$dateFrom = $_GET['date_from'] ?? '';
$dateTo = $_GET['date_to'] ?? '';

// Build query with filters
$whereClause = "WHERE 1=1";
$params = [];

if ($search) {
    $whereClause .= " AND (b_name LIKE ? OR b_description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if ($status) {
    $whereClause .= " AND b_status = ?";
    $params[] = $status;
}

if ($dateFrom) {
    $whereClause .= " AND b_purchase_date >= ?";
    $params[] = $dateFrom;
}

if ($dateTo) {
    $whereClause .= " AND b_purchase_date <= ?";
    $params[] = $dateTo;
}

$sql = "SELECT b_id, b_name, b_items_count, b_purchase_date, b_status, b_stock_quantity 
        FROM bails $whereClause ORDER BY b_created_date DESC";

if (empty($params)) {
    $bails = $db->query($sql)->fetchAll();
} else {
    $bails = $db->query($sql, ...$params)->fetchAll();
}



// --- END: PHP Data Fetching ---
?>
<div class="container-fluid py-2">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-3">
                        <h6 class="text-white text-capitalize mb-0">Bails Available</h6>
                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#addBailModal"><i class="fa fa-plus me-2"></i>Add Bail</button>
                    </div>
                </div>
                <div class="card-body px-3 pb-2 pt-3">
                    <form method="GET" id="filterForm">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search by bail name or description">
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" name="status">
                                    <option value="">All Status</option>
                                    <option value="unopened" <?php echo $status === 'unopened' ? 'selected' : ''; ?>>Unopened (Not Priced)</option>
                                    <option value="available" <?php echo $status === 'available' ? 'selected' : ''; ?>>Available (For Sale)</option>
                                    <option value="sold" <?php echo $status === 'sold' ? 'selected' : ''; ?>>Sold (Purchased)</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="date_from" value="<?php echo htmlspecialchars($dateFrom); ?>" placeholder="From Date">
                            </div>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="date_to" value="<?php echo htmlspecialchars($dateTo); ?>" placeholder="To Date">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-sm me-2">Filter</button>
                                <a href="bails.php" class="btn btn-secondary btn-sm">Clear</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center justify-content-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bail Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Items Available</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Purchase Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Stock Quantity</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($bails)): ?>
                                    <?php foreach ($bails as $bail):
                                        // Calculate Stock Level and determine progress bar color
                                        // We use b_items_count as the total capacity for stock level calculation.
                                        $stock_percentage = ($bail['b_stock_quantity'] / $bail['b_items_count']) * 100;
                                        $stock_percentage = round($stock_percentage); // Round for display

                                        $bar_color = 'bg-gradient-success';
                                        if ($stock_percentage < 30) {
                                            $bar_color = 'bg-gradient-danger';
                                        } elseif ($stock_percentage < 70) {
                                            $bar_color = 'bg-gradient-warning';
                                        } else {
                                            $bar_color = 'bg-gradient-success'; // Default color for > 70%
                                        }

                                        // Note: Assuming you can fetch 'b_description' for showBailDetail 
                                        // You might need an AJAX call later for description, or fetch it now.
                                        // For now, we'll pass placeholder data if not fetched.
                                        $description = "Description not fetched in the main query.";

                                        // Status Mapping for display
                                        $display_status = htmlspecialchars(ucfirst($bail['b_status']));

                                        // Image/Logo: Use a standard placeholder or logic to select an image
                                        $image_src = 'assets/img/small-logos/logo-asana.svg'; // Placeholder
                                    ?>

                                        <tr
                                            onclick="showBailDetail(
                                        '<?php echo $bail['b_id']; ?>', 
                                        '<?php echo htmlspecialchars($bail['b_name']); ?>', 
                                        '<?php echo $bail['b_items_count']; ?>', 
                                        '<?php echo $bail['b_purchase_date']; ?>', 
                                        '<?php echo $bail['b_status']; ?>', 
                                        '<?php echo $stock_percentage; ?>', 
                                        '<?php echo $description; ?>'
                                    )"
                                            style="cursor: pointer;">

                                            <td>
                                                <div class="d-flex px-2">
                                                    <div>
                                                        <img src="<?php echo $image_src; ?>" class="avatar avatar-sm rounded-circle me-2" alt="bail-logo">
                                                    </div>
                                                    <div class="my-auto">
                                                        <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($bail['b_name']); ?></h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0"><?php echo $bail['b_items_count']; ?></p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0"><?php echo $bail['b_purchase_date']; ?></p>
                                            </td>
                                            <td>
                                                <span class="text-xs font-weight-bold"><?php echo $display_status; ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <span class="me-2 text-xs font-weight-bold"><?php echo $stock_percentage; ?>%</span>
                                                    <div>
                                                        <div class="progress">
                                                            <div class="progress-bar <?php echo $bar_color; ?>" role="progressbar" aria-valuenow="<?php echo $stock_percentage; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $stock_percentage; ?>%;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <button class="btn btn-link text-secondary mb-0" onclick="event.stopPropagation();">
                                                    <i class="fa fa-ellipsis-v text-xs"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No bails found in the database.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Bail Modal -->
<div class="modal fade" id="addBailModal" tabindex="-1" aria-labelledby="addBailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-dark">
                <h5 class="modal-title text-white" id="addBailModalLabel">Add New Bail</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addBailForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bailName" class="form-label">Bail Name *</label>
                                <input type="text" class="form-control" id="bailName" name="b_name" placeholder="Enter bail name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bailItemsCount" class="form-label">Items Count (Amount of items when Bail was opened)*</label>
                                <input type="number" class="form-control" id="bailItemsCount" name="b_items_count" placeholder="Enter items count" value="1" required min="1">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bailAvgPrice" class="form-label">Avg Price Per Item (MWK) *</label>
                                <input type="number" class="form-control" id="bailAvgPrice" name="b_avg_price_per_item" placeholder="Enter average price" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bailStockQuantity" class="form-label">Stock Quantity(Number of Items Remaining)</label>
                                <input type="number" class="form-control" id="bailStockQuantity" name="b_stock_quantity" placeholder="Enter stock quantity" value="1" min="1">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bailPurchaseDate" class="form-label">Purchase Date *</label>
                                <input type="date" class="form-control" id="bailPurchaseDate" name="b_purchase_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bailStatus" class="form-label">Status</label>
                                <select class="form-control" id="bailStatus" name="b_status">
                                    <option value="unopened">Unopened (Not yet priced/displayed)</option>
                                    <option value="available">Available (Ready for sale)</option>
                                    <option value="sold">Sold (Purchased)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bailDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="bailDescription" name="b_description" placeholder="Enter bail description" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Bail Images (Max 4)</label>
                        <input type="file" class="form-control" name="bail_images[]" multiple accept="image/*" id="bailImages">
                        <small class="text-muted">Select up to 4 images for this bail</small>
                        <div id="imagePreview" class="mt-2 d-flex flex-wrap gap-2"></div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="btnSub" ">Save Bail</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Bail Detail Modal -->
<div class=" modal fade" id="bailDetailModal" tabindex="-1" aria-labelledby="bailDetailModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-gradient-dark">
                                <h5 class="modal-title text-white" id="bailDetailModalLabel">Bail Details</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Keep existing detail fields -->
                                <input type="hidden" id="currentBailId" value="">

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6 class="text-dark mb-2">Bail Name</h6>
                                        <p class="text-muted" id="detailBailName">-</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-dark mb-2">Status</h6>
                                        <p class="text-muted" id="detailBailStatus">-</p>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6 class="text-dark mb-2">Items Available</h6>
                                        <p class="text-muted" id="detailBailItems">-</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-dark mb-2">Stock Quantity</h6>
                                        <p class="text-muted" id="detailBailStock">-</p>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6 class="text-dark mb-2">Purchase Date</h6>
                                        <p class="text-muted" id="detailBailPurchaseDate">-</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-dark mb-2">Stock Level</h6>
                                        <div id="detailBailProgressBar">
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-dark mb-2">Description</h6>
                                        <p class="text-muted" id="detailBailDescription">-</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="text-dark mb-3">Bail Images</h6>
                                        <div id="bailImagesContainer" class="d-flex flex-wrap gap-3 mb-3">
                                            <!-- Images will be loaded here -->
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="showImageUpload()">Add Images</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="editImages()">Edit Images</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Image upload section (hidden by default) -->
                                <div id="imageUploadSection" class="row mt-3" style="display: none;">
                                    <div class="col-12">
                                        <div class="border rounded p-3">
                                            <h6>Upload New Images</h6>
                                            <input type="file" class="form-control mb-2" id="newBailImages" multiple accept="image/*">
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-sm btn-success" onclick="uploadImages()">Upload</button>
                                                <button type="button" class="btn btn-sm btn-secondary" onclick="hideImageUpload()">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" onclick="showDeleteConfirmation()">Delete</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="editBail()">Edit</button>
                            </div>
                        </div>
                    </div>
            </div>

            <!-- Edit Bail Modal -->
            <div class="modal fade" id="editBailModal" tabindex="-1" aria-labelledby="editBailModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-primary">
                            <h5 class="modal-title text-white" id="editBailModalLabel">Edit Bail</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editBailForm">
                                <input type="hidden" id="editBailId" name="bail_id">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="editBailName" class="form-label">Bail Name *</label>
                                            <input type="text" class="form-control" id="editBailName" name="b_name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="editBailItemsCount" class="form-label">Items Count *</label>
                                            <input type="number" class="form-control" id="editBailItemsCount" name="b_items_count" required min="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="editBailAvgPrice" class="form-label">Avg Price Per Item (MWK) *</label>
                                            <input type="number" class="form-control" id="editBailAvgPrice" name="b_avg_price_per_item" step="0.01" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="editBailStockQuantity" class="form-label">Stock Quantity</label>
                                            <input type="number" class="form-control" id="editBailStockQuantity" name="b_stock_quantity" min="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="editBailPurchaseDate" class="form-label">Purchase Date *</label>
                                            <input type="date" class="form-control" id="editBailPurchaseDate" name="b_purchase_date" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="editBailStatus" class="form-label">Status</label>
                                            <select class="form-control" id="editBailStatus" name="b_status">
                                                <option value="unopened">Unopened (Not yet priced/displayed)</option>
                                                <option value="available">Available (Ready for sale)</option>
                                                <option value="sold">Sold (Purchased)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="editBailDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="editBailDescription" name="b_description" rows="3"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="btnUpdateBail" form="editBailForm">Update Bail</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-danger">
                            <h5 class="modal-title text-white" id="deleteConfirmModalLabel">Confirm Delete</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this bail?</p>
                            <p class="text-danger"><strong>This action cannot be undone.</strong></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn" onclick="deleteBail()">Yes, Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Images Modal -->
            <div class="modal fade" id="editImagesModal" tabindex="-1" aria-labelledby="editImagesModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-info">
                            <h5 class="modal-title text-white" id="editImagesModalLabel">Manage Bail Images</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="editImagesContainer" class="row g-3">
                                <!-- Images will be loaded here -->
                            </div>

                            <hr class="my-4">

                            <div class="mb-3">
                                <h6>Upload New Images</h6>
                                <input type="file" class="form-control" id="editNewImages" multiple accept="image/*">
                                <small class="text-muted">Maximum 4 images total per bail</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" onclick="uploadNewImages()">Upload Selected</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            <script src="../assets/js/jquery-3.7.1.min.js"></script>
            <script>
                // Image preview functionality
                document.getElementById('bailImages').addEventListener('change', function(e) {
                    const files = e.target.files;
                    const preview = document.getElementById('imagePreview');
                    preview.innerHTML = '';

                    if (files.length > 4) {
                        alert('Maximum 4 images allowed');
                        e.target.value = '';
                        return;
                    }

                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'img-thumbnail';
                            img.style.width = '80px';
                            img.style.height = '80px';
                            img.style.objectFit = 'cover';
                            preview.appendChild(img);
                        };

                        reader.readAsDataURL(file);
                    }
                });

                $("#addBailForm").submit(function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: "../model/addBail.php",
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
                                alert("Bail added successfully!");
                                $('#addBailModal').modal('hide');
                                window.location.reload();
                            } else {
                                alert("Error in insertion. Server returned: " + data);
                            }
                            $("#btnSub").removeClass("disabled");
                            $("#btnSub").html("Save Bail");
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error(
                                "AJAX error:",
                                textStatus,
                                errorThrown,
                                "response:",
                                jqXHR.responseText
                            );
                            alert(
                                "Request failed: " + textStatus + " — see console for details."
                            );
                            $("#btnSub").prop("disabled", false).text("Save Bail");
                        },
                    });
                });
            </script>

            <script>
                function showBailDetail(id, name, items, purchaseDate, status, stockLevel, description) {
                    // Store the bail ID for deletion
                    document.getElementById('currentBailId').value = id;

                    // Set the bail details
                    document.getElementById('detailBailName').textContent = name;
                    document.getElementById('detailBailStatus').textContent = status.charAt(0).toUpperCase() + status.slice(1);
                    document.getElementById('detailBailItems').textContent = items;
                    document.getElementById('detailBailStock').textContent = stockLevel + '%';
                    document.getElementById('detailBailPurchaseDate').textContent = purchaseDate;
                    document.getElementById('detailBailDescription').textContent = description;

                    // Update progress bar color based on stock level
                    let barColor = 'bg-gradient-success';
                    if (stockLevel < 30) {
                        barColor = 'bg-gradient-danger';
                    } else if (stockLevel < 70) {
                        barColor = 'bg-gradient-warning';
                    }

                    document.getElementById('detailBailProgressBar').innerHTML = `
        <div class="progress">
            <div class="progress-bar ${barColor}" role="progressbar" aria-valuenow="${stockLevel}" aria-valuemin="0" aria-valuemax="100" style="width: ${stockLevel}%"></div>
        </div>
    `;

                    // Load bail images
                    loadBailImages(id);

                    // Show the modal
                    const modal = new bootstrap.Modal(document.getElementById('bailDetailModal'));
                    modal.show();
                }

                function loadBailImages(bailId) {
                    $.get('../model/getBailImages.php', {
                        bail_id: bailId
                    }, function(response) {
                        const container = document.getElementById('bailImagesContainer');

                        if (response.success && response.images.length > 0) {
                            container.innerHTML = response.images.map(img => `
                <div class="position-relative" style="width: 100px; height: 100px;">
                    <img src="../${img.image_path}" class="img-thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                    ${img.is_primary ? '<span class="badge bg-primary position-absolute top-0 start-0">Primary</span>' : ''}
                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" 
                            onclick="deleteImage(${img.id})" style="padding: 2px 6px;">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            `).join('');
                        } else {
                            container.innerHTML = '<p class="text-muted">No images uploaded</p>';
                        }
                    }, 'json');
                }

                function showImageUpload() {
                    document.getElementById('imageUploadSection').style.display = 'block';
                }

                function hideImageUpload() {
                    document.getElementById('imageUploadSection').style.display = 'none';
                    document.getElementById('newBailImages').value = '';
                }

                function uploadImages() {
                    const bailId = document.getElementById('currentBailId').value;
                    const fileInput = document.getElementById('newBailImages');

                    if (fileInput.files.length === 0) {
                        alert('Please select images to upload');
                        return;
                    }

                    const formData = new FormData();
                    formData.append('bail_id', bailId);

                    for (let i = 0; i < fileInput.files.length; i++) {
                        formData.append('images[]', fileInput.files[i]);
                    }

                    $.ajax({
                        url: '../model/uploadBailImages.php',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            const result = typeof response === 'string' ? JSON.parse(response) : response;

                            if (result.success) {
                                alert('Images uploaded successfully!');
                                loadBailImages(bailId);
                                hideImageUpload();
                            } else {
                                alert('Error: ' + result.message);
                            }
                        },
                        error: function() {
                            alert('Error uploading images');
                        }
                    });
                }

                function deleteImage(imageId) {
                    if (confirm('Are you sure you want to delete this image?')) {
                        $.post('../model/deleteBailImage.php', {
                            image_id: imageId
                        }, function(response) {
                            const result = typeof response === 'string' ? JSON.parse(response) : response;

                            if (result.success) {
                                const bailId = document.getElementById('currentBailId').value;
                                loadBailImages(bailId);
                                // Refresh edit modal if open
                                if ($('#editImagesModal').hasClass('show')) {
                                    loadEditImages(bailId);
                                }
                            } else {
                                alert('Error deleting image');
                            }
                        }, 'json');
                    }
                }

                function editImages() {
                    const bailId = document.getElementById('currentBailId').value;
                    loadEditImages(bailId);
                    const modal = new bootstrap.Modal(document.getElementById('editImagesModal'));
                    modal.show();
                }

                function loadEditImages(bailId) {
                    $.get('../model/getBailImages.php', {
                        bail_id: bailId
                    }, function(response) {
                        const container = document.getElementById('editImagesContainer');

                        if (response.success && response.images.length > 0) {
                            container.innerHTML = response.images.map(img => `
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <img src="../${img.image_path}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    ${img.is_primary ? '<span class="badge bg-primary">Primary</span>' : '<button class="btn btn-sm btn-outline-primary" onclick="setPrimaryImage(' + img.id + ')">Set Primary</button>'}
                                </div>
                                <button class="btn btn-sm btn-danger" onclick="deleteImageFromEdit(' + img.id + ')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
                        } else {
                            container.innerHTML = '<div class="col-12"><p class="text-muted text-center">No images uploaded</p></div>';
                        }
                    }, 'json');
                }

                function setPrimaryImage(imageId) {
                    const bailId = document.getElementById('currentBailId').value;

                    $.post('../model/setPrimaryImage.php', {
                        image_id: imageId,
                        bail_id: bailId
                    }, function(response) {
                        const result = typeof response === 'string' ? JSON.parse(response) : response;

                        if (result.success) {
                            loadEditImages(bailId);
                            loadBailImages(bailId);
                        } else {
                            alert('Error setting primary image');
                        }
                    }, 'json');
                }

                function deleteImageFromEdit(imageId) {
                    if (confirm('Are you sure you want to delete this image?')) {
                        $.post('../model/deleteBailImage.php', {
                            image_id: imageId
                        }, function(response) {
                            const result = typeof response === 'string' ? JSON.parse(response) : response;

                            if (result.success) {
                                const bailId = document.getElementById('currentBailId').value;
                                loadEditImages(bailId);
                                loadBailImages(bailId);
                            } else {
                                alert('Error deleting image');
                            }
                        }, 'json');
                    }
                }

                function uploadNewImages() {
                    const bailId = document.getElementById('currentBailId').value;
                    const fileInput = document.getElementById('editNewImages');

                    if (fileInput.files.length === 0) {
                        alert('Please select images to upload');
                        return;
                    }

                    const formData = new FormData();
                    formData.append('bail_id', bailId);

                    for (let i = 0; i < fileInput.files.length; i++) {
                        formData.append('images[]', fileInput.files[i]);
                    }

                    $.ajax({
                        url: '../model/uploadBailImages.php',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            const result = typeof response === 'string' ? JSON.parse(response) : response;

                            if (result.success) {
                                alert('Images uploaded successfully!');
                                loadEditImages(bailId);
                                loadBailImages(bailId);
                                document.getElementById('editNewImages').value = '';
                            } else {
                                alert('Error: ' + result.message);
                            }
                        },
                        error: function() {
                            alert('Error uploading images');
                        }
                    });
                }

                function showDeleteConfirmation() {
                    // Hide detail modal
                    const detailModal = bootstrap.Modal.getInstance(document.getElementById('bailDetailModal'));
                    detailModal.hide();

                    // Show confirmation modal
                    const confirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
                    confirmModal.show();
                }

                function editBail() {
                    // Get current bail data from detail modal
                    const bailId = document.getElementById('currentBailId').value;
                    const bailName = document.getElementById('detailBailName').textContent;
                    const bailStatus = document.getElementById('detailBailStatus').textContent.toLowerCase();
                    const bailItems = document.getElementById('detailBailItems').textContent;
                    const bailPurchaseDate = document.getElementById('detailBailPurchaseDate').textContent;

                    // Hide detail modal
                    const detailModal = bootstrap.Modal.getInstance(document.getElementById('bailDetailModal'));
                    detailModal.hide();

                    // Populate edit form
                    document.getElementById('editBailId').value = bailId;
                    document.getElementById('editBailName').value = bailName;
                    document.getElementById('editBailItemsCount').value = bailItems;
                    document.getElementById('editBailStatus').value = bailStatus;
                    document.getElementById('editBailPurchaseDate').value = bailPurchaseDate;

                    // Show edit modal
                    const editModal = new bootstrap.Modal(document.getElementById('editBailModal'));
                    editModal.show();
                }

                // Handle edit form submission
                $("#editBailForm").submit(function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: "../model/updateBail.php",
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $("#btnUpdateBail").prop("disabled", true).html("Updating...");
                        },
                        success: function(data) {
                            const response = typeof data === 'string' ? JSON.parse(data) : data;

                            if (response.success) {
                                const modal = bootstrap.Modal.getInstance(document.getElementById('editBailModal'));
                                modal.hide();
                                alert("Bail updated successfully!");
                                window.location.reload();
                            } else {
                                alert("Error: " + response.message);
                            }

                            $("#btnUpdateBail").prop("disabled", false).html("Update Bail");
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error("AJAX error:", textStatus, errorThrown);
                            alert("Request failed: " + textStatus);
                            $("#btnUpdateBail").prop("disabled", false).html("Update Bail");
                        }
                    });
                });

                function deleteBail() {
                    const bailId = document.getElementById('currentBailId').value;

                    $.ajax({
                        url: "../model/delBail.php",
                        type: "POST",
                        data: {
                            bail_id: bailId
                        },
                        dataType: "json",
                        beforeSend: function() {
                            $("#confirmDeleteBtn").prop("disabled", true).html("Deleting...");
                        },
                        /* 
                        The revenant
                        RRR
                        te life of pi
                        me time
                        success: function(response) {
                            if (response.success) {
                                // Hide confirmation modal
                                const confirmModal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
                                confirmModal.hide();
                                
                                alert("Bail deleted successfully!");
                                window.location.reload();
                            } else {
                                alert("Error: " + response.message);
                                $("#confirmDeleteBtn").prop("disabled", false).html("Yes, Delete");
                            }
                        }, */
                        success: function(data) {
                            console.log(data);
                            if (data == 1) {
                                // Hide confirmation modal
                                const confirmModal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
                                confirmModal.hide();
                                alert("Bail deleted successfully!");
                                window.location.reload();
                            } else {
                                // show server response for debugging
                                alert("Error: " + response.message);
                                $("#confirmDeleteBtn").prop("disabled", false).html("Yes, Delete");
                            }

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error("AJAX error:", textStatus, errorThrown);
                            alert("Request failed: " + textStatus);
                            $("#confirmDeleteBtn").prop("disabled", false).html("Yes, Delete");
                        }
                    });
                }
            </script>

            <style>
                /* Dark Mode Styling for Modals */
                .dark-version .modal-content {
                    background-color: #2d2d2d !important;
                    color: #ffffff !important;
                    border-color: #444444 !important;
                }

                .dark-version .modal-header {
                    background-color: #2d2d2d !important;
                    border-bottom-color: #444444 !important;
                    color: #ffffff !important;
                }

                .dark-version .modal-header .btn-close {
                    filter: invert(1);
                }

                .dark-version .modal-footer {
                    background-color: #2d2d2d !important;
                    border-top-color: #444444 !important;
                }

                .dark-version .modal-body {
                    background-color: #2d2d2d !important;
                    color: #ffffff !important;
                }

                .dark-version #bailDetailModal .modal-content,
                .dark-version #editBailModal .modal-content,
                .dark-version #deleteConfirmModal .modal-content,
                .dark-version #editImagesModal .modal-content {
                    background-color: #2d2d2d !important;
                }

                /* Form elements in dark mode */
                .dark-version .form-control,
                .dark-version .form-select {
                    background-color: #3a3a3a !important;
                    color: #ffffff !important;
                    border-color: #555555 !important;
                }

                .dark-version .form-control:focus,
                .dark-version .form-select:focus {
                    background-color: #3a3a3a !important;
                    color: #ffffff !important;
                    border-color: #6c63ff !important;
                    box-shadow: 0 0 0 0.2rem rgba(108, 99, 255, 0.25);
                }

                .dark-version .form-control::placeholder {
                    color: #999999 !important;
                }

                .dark-version .form-label {
                    color: #ffffff !important;
                }

                /* Text in modals */
                .dark-version .modal-body label,
                .dark-version .modal-body p,
                .dark-version .modal-body h5,
                .dark-version .modal-body h6 {
                    color: #ffffff !important;
                }

                /* Buttons styling */
                .dark-version .modal-footer .btn-primary {
                    background-color: #6c63ff !important;
                    border-color: #6c63ff !important;
                }

                .dark-version .modal-footer .btn-primary:hover {
                    background-color: #5551cc !important;
                    border-color: #5551cc !important;
                }

                .dark-version .modal-footer .btn-secondary {
                    background-color: #555555 !important;
                    border-color: #555555 !important;
                    color: #ffffff !important;
                }

                .dark-version .modal-footer .btn-secondary:hover {
                    background-color: #666666 !important;
                    border-color: #666666 !important;
                }

                .dark-version .modal-footer .btn-danger {
                    background-color: #dc3545 !important;
                    border-color: #dc3545 !important;
                }

                .dark-version .modal-footer .btn-danger:hover {
                    background-color: #bd2130 !important;
                    border-color: #bd2130 !important;
                }

                /* Table styling in modals */
                .dark-version .table {
                    color: #ffffff !important;
                    border-color: #444444 !important;
                }

                .dark-version .table thead th {
                    background-color: #3a3a3a !important;
                    color: #ffffff !important;
                    border-color: #444444 !important;
                }

                .dark-version .table tbody tr {
                    border-color: #444444 !important;
                }

                .dark-version .table tbody tr:hover {
                    background-color: #3a3a3a !important;
                }

                /* Thumbnail gallery styling */
                .dark-version .thumbnail-gallery {
                    background-color: #3a3a3a !important;
                    border-color: #444444 !important;
                }

                .dark-version .thumbnail-gallery img {
                    border-color: #444444 !important;
                }

                .dark-version .thumbnail-gallery img:hover,
                .dark-version .thumbnail-gallery img.active {
                    border-color: #6c63ff !important;
                }

                /* Alert and badge styling */
                .dark-version .alert-info {
                    background-color: #1a3a4a !important;
                    color: #b3d9e6 !important;
                    border-color: #2a5a6a !important;
                }

                .dark-version .badge {
                    background-color: #6c63ff !important;
                }

                /* Link styling */
                .dark-version .modal-body a {
                    color: #6c63ff !important;
                }

                .dark-version .modal-body a:hover {
                    color: #8781ff !important;
                }
            </style>

            <?php
            require_once "partials/footer.php";
            ?>