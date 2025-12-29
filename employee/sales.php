<?php
$page_title = "Sales - Trendy Threads";
require_once 'partials/header.php';

// Get filter parameters
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';
$dateFrom = $_GET['date_from'] ?? '';
$dateTo = $_GET['date_to'] ?? '';
?>
<div class="container-fluid py-2">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-3">
                        <h6 class="text-white text-capitalize mb-0">Sales</h6>
                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#recordSaleModal">
                            <i class="fa fa-plus me-2"></i>Record a Sale
                        </button>
                    </div>
                </div>
                <div class="card-body px-3 pb-2 pt-3">
                    <form method="GET" id="salesFilterForm">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search customer, email, or bail name">
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" name="status">
                                    <option value="">All Status</option>
                                    <option value="pending" <?php echo $status === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="completed" <?php echo $status === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                    <option value="cancelled" <?php echo $status === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                    <option value="refunded" <?php echo $status === 'refunded' ? 'selected' : ''; ?>>Refunded</option>
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
                                <a href="sales.php" class="btn btn-secondary btn-sm">Clear</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Bail Item</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantity</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Unit Price</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Total Amount</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                // Build query with filters
                                $whereClause = "WHERE 1=1";
                                $params = [];

                                if ($search) {
                                    $whereClause .= " AND (COALESCE(c.c_name, 'Unknown Customer') LIKE ? OR COALESCE(c.c_email, 'N/A') LIKE ? OR b.b_name LIKE ?)";
                                    $params[] = "%$search%";
                                    $params[] = "%$search%";
                                    $params[] = "%$search%";
                                }

                                if ($status) {
                                    $whereClause .= " AND p.p_status = ?";
                                    $params[] = $status;
                                }

                                if ($dateFrom) {
                                    $whereClause .= " AND DATE(p.p_purchase_date) >= ?";
                                    $params[] = $dateFrom;
                                }

                                if ($dateTo) {
                                    $whereClause .= " AND DATE(p.p_purchase_date) <= ?";
                                    $params[] = $dateTo;
                                }

                                $sql = "SELECT p.*, 
                                        CASE WHEN p.p_customer_id IS NULL THEN 'Unknown Customer' ELSE c.c_name END as c_name,
                                        CASE WHEN p.p_customer_id IS NULL THEN 'N/A' ELSE c.c_email END as c_email,
                                        b.b_name
                                        FROM purchases p
                                        LEFT JOIN customers c ON p.p_customer_id = c.c_id
                                        INNER JOIN bails b ON p.p_bail_id = b.b_id
                                        $whereClause
                                        ORDER BY p.p_purchase_date DESC";

                                if (empty($params)) {
                                    $sales = $db->query($sql)->fetchAll();
                                } else {
                                    $sales = $db->query($sql, ...$params)->fetchAll();
                                }

                                foreach ($sales as $sale) {
                                    // Determine badge color based on status
                                    $badgeColor = 'bg-gradient-secondary';
                                    switch ($sale['p_status']) {
                                        case 'completed':
                                            $badgeColor = 'bg-gradient-success';
                                            break;
                                        case 'pending':
                                            $badgeColor = 'bg-gradient-warning';
                                            break;
                                        case 'cancelled':
                                            $badgeColor = 'bg-gradient-danger';
                                            break;
                                        case 'refunded':
                                            $badgeColor = 'bg-gradient-info';
                                            break;
                                    }
                                ?>
                                    <tr onclick="showSaleDetail(
            <?php echo $sale['p_id']; ?>, 
            '<?php echo htmlspecialchars($sale['c_name']); ?>', 
            '<?php echo htmlspecialchars($sale['c_email']); ?>', 
            '<?php echo htmlspecialchars($sale['b_name']); ?>', 
            <?php echo $sale['p_quantity']; ?>, 
            <?php echo $sale['p_unit_price']; ?>, 
            <?php echo $sale['p_total_amount']; ?>, 
            '<?php echo $sale['p_status']; ?>', 
            '<?php echo htmlspecialchars($sale['p_payment_method']); ?>', 
            '<?php echo date('Y-m-d', strtotime($sale['p_purchase_date'])); ?>',
            '<?php echo htmlspecialchars($sale['p_notes'] ?? ''); ?>'
        )" style="cursor: pointer;">
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="assets/img/team-2.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($sale['c_name']); ?></h6>
                                                    <p class="text-xs text-secondary mb-0"><?php echo htmlspecialchars($sale['c_email']); ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?php echo htmlspecialchars($sale['b_name']); ?></p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?php echo $sale['p_quantity']; ?></p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">MWK <?php echo number_format($sale['p_unit_price'], 2); ?></p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm <?php echo $badgeColor; ?>">MWK <?php echo number_format($sale['p_total_amount'], 2); ?></span>
                                        </td>
                                        <td>
                                            <span class="text-xs font-weight-bold"><?php echo ucfirst($sale['p_status']); ?></span>
                                        </td>
                                        <td>
                                            <span class="text-xs font-weight-bold"><?php echo date('M d, Y', strtotime($sale['p_purchase_date'])); ?></span>
                                        </td>
                                        <td class="align-middle">
                                            <button class="btn btn-link text-secondary mb-0" onclick="event.stopPropagation();">
                                                <i class="fa fa-ellipsis-v text-xs"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php
                                }

                                // Show message if no sales found
                                if (empty($sales)) {
                                    echo '<tr><td colspan="8" class="text-center">No sales found</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Record Sale Modal -->
<div class="modal fade" id="recordSaleModal" tabindex="-1" aria-labelledby="recordSaleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-dark">
                <h5 class="modal-title text-white" id="recordSaleModalLabel">Record a Sale</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="recordSaleForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="saleCustomerId" class="form-label">Customer *</label>
                                <select class="form-control" id="saleCustomerId" name="p_customer_id" required>
                                    <option value="">Select customer</option>
                                    <option value="0">Unknown/New Customer</option>
                                    <?php
                                    $customers = $db->query("SELECT c_id, c_name, c_email FROM customers WHERE c_status = 'active' ORDER BY c_name")->fetchAll();
                                    foreach ($customers as $customer) {
                                        echo "<option value='{$customer['c_id']}'>{$customer['c_name']} ({$customer['c_email']})</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="saleBailId" class="form-label">Bail Item *</label>
                                <select class="form-control" id="saleBailId" name="p_bail_id" required>
                                    <option value="">Select bail</option>
                                    <?php
                                    $bails = $db->query("SELECT b_id, b_name, b_avg_price_per_item FROM bails WHERE b_status = 'available' AND b_avg_price_per_item > 0 ORDER BY b_name")->fetchAll();
                                    foreach ($bails as $bail) {
                                        echo "<option value='{$bail['b_id']}' data-price='{$bail['b_avg_price_per_item']}'>{$bail['b_name']} (MWK {$bail['b_avg_price_per_item']})</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="saleQuantity" class="form-label">Quantity *</label>
                                <input type="number" class="form-control" id="saleQuantity" name="p_quantity" placeholder="Enter quantity" value="1" required min="1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="saleUnitPrice" class="form-label">Unit Price (MWK)</label>
                                <input type="number" class="form-control" id="saleUnitPrice" name="p_unit_price" placeholder="Leave empty to use bail price" step="0.01">
                                <small class="text-muted">Optional - Will use bail price if left empty. Can be adjusted for haggling.</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="salePaymentMethod" class="form-label">Payment Method *</label>
                                <select class="form-control" id="salePaymentMethod" name="p_payment_method" required>
                                    <option value="cash">Cash</option>
                                    <option value="credit">Credit</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="salePurchaseDate" class="form-label">Sale Date</label>
                                <input type="date" class="form-control" id="salePurchaseDate" name="p_purchase_date" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="saleNotes" class="form-label">Notes</label>
                        <textarea class="form-control" id="saleNotes" name="p_notes" placeholder="Enter sale notes" rows="3"></textarea>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="btnSaveSale" form="recordSaleForm">Record Sale</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Sale Detail Modal -->
<div class="modal fade" id="saleDetailModal" tabindex="-1" aria-labelledby="saleDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-dark">
                <h5 class="modal-title text-white" id="saleDetailModalLabel">Sale Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="currentSaleId" value="">

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-dark mb-2">Customer</h6>
                        <p class="text-muted" id="detailSaleCustomer">-</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-dark mb-2">Email</h6>
                        <p class="text-muted" id="detailSaleEmail">-</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-dark mb-2">Bail Item</h6>
                        <p class="text-muted" id="detailSaleBail">-</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-dark mb-2">Quantity</h6>
                        <p class="text-muted" id="detailSaleQuantity">-</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-dark mb-2">Unit Price</h6>
                        <p class="text-muted" id="detailSaleUnitPrice">-</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-dark mb-2">Total Amount</h6>
                        <p class="text-muted font-weight-bold" id="detailSaleTotalAmount">-</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-dark mb-2">Status</h6>
                        <p class="text-muted" id="detailSaleStatus">-</p>
                        <select class="form-control" id="editSaleStatus" style="display: none;">
                            <option value="completed">Completed</option>
                            <option value="pending">Pending</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-dark mb-2">Payment Method</h6>
                        <p class="text-muted" id="detailSalePaymentMethod">-</p>
                        <select class="form-control" id="editSalePaymentMethod" style="display: none;">
                            <option value="cash">Cash</option>
                            <option value="credit">Credit</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-dark mb-2">Purchase Date</h6>
                        <p class="text-muted" id="detailSalePurchaseDate">-</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h6 class="text-dark mb-2">Notes</h6>
                        <p class="text-muted" id="detailSaleNotes">-</p>
                        <textarea class="form-control" id="editSaleNotes" rows="3" style="display: none;"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editSaleBtn" style="display: none;" onclick="enableEditMode()">Edit Credit Sale</button>
                <button type="button" class="btn btn-success" id="saveSaleBtn" style="display: none;" onclick="saveSaleChanges()">Save Changes</button>
                <div class="text-muted small" id="readOnlyText">Cash sales are read-only for audit purposes</div>
            </div>
        </div>
    </div>
</div>



<script>
    // Notification function
    function showNotification(type, title, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';

        const notification = `
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">
                <i class="fa ${iconClass} me-2"></i>
                <strong>${title}</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        $('body').append(notification);

        // Auto-remove after 3 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 3000);
    }

    // Auto-fill unit price when bail is selected
    $('#saleBailId').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var price = selectedOption.data('price');
        if (price) {
            $('#saleUnitPrice').val(price);
        }
    });

    // Handle form submission
    $("#recordSaleForm").submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: "../model/addSale.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $("#btnSaveSale").prop("disabled", true).html("Processing...");
            },
            success: function(data) {
                console.log(data);
                var response = typeof data === 'string' ? JSON.parse(data) : data;

                if (response.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('recordSaleModal'));
                    modal.hide();

                    // Show success notification
                    showNotification('success', 'Sale Recorded!', 'Sale has been recorded successfully.');
                    $("#recordSaleForm")[0].reset();

                    // Reload page after short delay to show notification
                    setTimeout(function() {
                        window.location.reload();
                    }, 1500);
                } else {
                    showNotification('error', 'Error!', response.message);
                }

                $("#btnSaveSale").prop("disabled", false).html("Record Sale");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:", textStatus, errorThrown, "response:", jqXHR.responseText);
                showNotification('error', 'Request Failed!', 'Please check console for details.');
                $("#btnSaveSale").prop("disabled", false).html("Record Sale");
            }
        });
    });

    function showSaleDetail(id, customer, email, bail, quantity, unitPrice, totalAmount, status, paymentMethod, purchaseDate, notes) {
        document.getElementById('currentSaleId').value = id;
        document.getElementById('detailSaleCustomer').textContent = customer;
        document.getElementById('detailSaleEmail').textContent = email;
        document.getElementById('detailSaleBail').textContent = bail;
        document.getElementById('detailSaleQuantity').textContent = quantity;
        document.getElementById('detailSaleUnitPrice').textContent = 'MWK ' + parseFloat(unitPrice).toFixed(2);
        document.getElementById('detailSaleTotalAmount').textContent = 'MWK ' + parseFloat(totalAmount).toFixed(2);
        document.getElementById('detailSaleStatus').textContent = status.charAt(0).toUpperCase() + status.slice(1);
        document.getElementById('detailSalePaymentMethod').textContent = paymentMethod.charAt(0).toUpperCase() + paymentMethod.slice(1);
        document.getElementById('detailSalePurchaseDate').textContent = purchaseDate;
        document.getElementById('detailSaleNotes').textContent = notes || 'No notes';

        // Show edit button only for credit transactions
        const editBtn = document.getElementById('editSaleBtn');
        const readOnlyText = document.getElementById('readOnlyText');

        if (paymentMethod.toLowerCase() === 'credit') {
            editBtn.style.display = 'inline-block';
            readOnlyText.textContent = 'Credit sales can be edited for reconciliation';
        } else {
            editBtn.style.display = 'none';
            readOnlyText.textContent = 'Cash sales are read-only for audit purposes';
        }

        // Reset edit mode
        document.getElementById('saveSaleBtn').style.display = 'none';
        disableEditMode();

        const modal = new bootstrap.Modal(document.getElementById('saleDetailModal'));
        modal.show();
    }

    function enableEditMode() {
        // Hide display elements, show edit elements
        document.getElementById('detailSaleStatus').style.display = 'none';
        document.getElementById('editSaleStatus').style.display = 'block';
        document.getElementById('editSaleStatus').value = document.getElementById('detailSaleStatus').textContent.toLowerCase();

        document.getElementById('detailSalePaymentMethod').style.display = 'none';
        document.getElementById('editSalePaymentMethod').style.display = 'block';
        document.getElementById('editSalePaymentMethod').value = document.getElementById('detailSalePaymentMethod').textContent.toLowerCase();

        document.getElementById('detailSaleNotes').style.display = 'none';
        document.getElementById('editSaleNotes').style.display = 'block';
        document.getElementById('editSaleNotes').value = document.getElementById('detailSaleNotes').textContent === 'No notes' ? '' : document.getElementById('detailSaleNotes').textContent;

        // Toggle buttons
        document.getElementById('editSaleBtn').style.display = 'none';
        document.getElementById('saveSaleBtn').style.display = 'inline-block';
    }

    function disableEditMode() {
        // Show display elements, hide edit elements
        document.getElementById('detailSaleStatus').style.display = 'block';
        document.getElementById('editSaleStatus').style.display = 'none';

        document.getElementById('detailSalePaymentMethod').style.display = 'block';
        document.getElementById('editSalePaymentMethod').style.display = 'none';

        document.getElementById('detailSaleNotes').style.display = 'block';
        document.getElementById('editSaleNotes').style.display = 'none';
    }

    function saveSaleChanges() {
        const saleId = document.getElementById('currentSaleId').value;
        const status = document.getElementById('editSaleStatus').value;
        const paymentMethod = document.getElementById('editSalePaymentMethod').value;
        const notes = document.getElementById('editSaleNotes').value;

        $.ajax({
            url: '../model/updateSale.php',
            type: 'POST',
            data: {
                sale_id: saleId,
                status: status,
                payment_method: paymentMethod,
                notes: notes
            },
            success: function(response) {
                const result = typeof response === 'string' ? JSON.parse(response) : response;

                if (result.success) {
                    showNotification('success', 'Updated!', 'Credit sale updated successfully.');

                    // Update display values
                    document.getElementById('detailSaleStatus').textContent = status.charAt(0).toUpperCase() + status.slice(1);
                    document.getElementById('detailSalePaymentMethod').textContent = paymentMethod.charAt(0).toUpperCase() + paymentMethod.slice(1);
                    document.getElementById('detailSaleNotes').textContent = notes || 'No notes';

                    // Exit edit mode
                    disableEditMode();
                    document.getElementById('editSaleBtn').style.display = 'inline-block';
                    document.getElementById('saveSaleBtn').style.display = 'none';

                    // Reload page after delay to show updated data
                    setTimeout(function() {
                        window.location.reload();
                    }, 1500);
                } else {
                    showNotification('error', 'Error!', result.message);
                }
            },
            error: function() {
                showNotification('error', 'Error!', 'Failed to update sale.');
            }
        });
    }
</script>

<style>
    /* Dark Mode Styling for Sales Modals */
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

    .dark-version #saleDetailModal .modal-content,
    .dark-version #recordSaleModal .modal-content,
    .dark-version #editSaleModal .modal-content {
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

    /* Row styling in detail sections */
    .dark-version .detail-row {
        background-color: #3a3a3a !important;
        color: #ffffff !important;
    }

    .dark-version .detail-row strong {
        color: #ffffff !important;
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

    /* Horizontal rule styling */
    .dark-version hr {
        border-color: #444444 !important;
    }
</style>

<?php
require_once "partials/footer.php";
?>