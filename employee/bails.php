<?php
$page_title = "Bails - Trendy Threads";
require_once 'partials/header.php';

// 2. Define the Query
$sql = "SELECT 
            b_id, 
            b_name, 
            b_items_count, 
            b_purchase_date, 
            b_status, 
            b_stock_quantity
        FROM bails WHERE b_status != 'sold' 
        ORDER BY b_created_date DESC";

$bails = $db->query($sql)->fetchAll();



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
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Search...</label>
                                <input type="text" class="form-control" id="searchInput" placeholder="Search by bail name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control" id="bailStatus">
                                <option value="">All Status</option>
                                <option value="finished">Finished</option>
                                <option value="opened">Opened</option>
                                <option value="unopened">Unopened</option>
                                <option value="selling">Selling</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-outline">
                                        <label class="form-label">From</label>
                                        <input type="date" class="form-control" id="dateFrom">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-outline">
                                        <label class="form-label">To</label>
                                        <input type="date" class="form-control" id="dateTo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                <label for="bailItemsCount" class="form-label">Items Count *</label>
                                <input type="number" class="form-control" id="bailItemsCount" name="b_items_count" placeholder="Enter items count" value="1" required min="1">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bailAvgPrice" class="form-label">Avg Price Per Item *</label>
                                <input type="number" class="form-control" id="bailAvgPrice" name="b_avg_price_per_item" placeholder="Enter average price" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bailStockQuantity" class="form-label">Stock Quantity</label>
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
                                    <option value="available">Available</option>
                                    <option value="sold">Sold</option>
                                    <option value="discontinued">Discontinued</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bailDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="bailDescription" name="b_description" placeholder="Enter bail description" rows="3"></textarea>
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
<div class="modal fade" id="bailDetailModal" tabindex="-1" aria-labelledby="bailDetailModalLabel" aria-hidden="true">
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

                <div class="row">
                    <div class="col-12">
                        <h6 class="text-dark mb-2">Description</h6>
                        <p class="text-muted" id="detailBailDescription">-</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="showDeleteConfirmation()">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Edit</button>
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
                                

            <script src="../assets/js/jquery-3.7.1.min.js"></script>
            <script>
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
                                alert("hazaa!")
                            } else {
                                // show server response for debugging
                                alert("Error in insertion. Server returned: " + data);
                            }
                            $("#btnSub").removeClass("disabled");
                            $("#btnSub").html("Adding Bail");
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
                            $("#btnSub").prop("disabled", false).text("LOGIN");
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

    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('bailDetailModal'));
    modal.show();
}

function showDeleteConfirmation() {
    // Hide detail modal
    const detailModal = bootstrap.Modal.getInstance(document.getElementById('bailDetailModal'));
    detailModal.hide();
    
    // Show confirmation modal
    const confirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
    confirmModal.show();
}

function deleteBail() {
    const bailId = document.getElementById('currentBailId').value;
    
    $.ajax({
        url: "../model/delBail.php",
        type: "POST",
        data: { bail_id: bailId },
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



            <?php
            require_once "partials/footer.php";
            ?>