<?php
$page_title = "Sales - Trendy Threads";
require_once 'partials/header.php';
?>
<div class="container-fluid py-2">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-3">
                        <h6 class="text-white text-capitalize mb-0">Sales</h6>
                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#recordSaleModal"><i class="fa fa-plus me-2"></i>Record a Sale</button>
                    </div>
                </div>
                <div class="card-body px-3 pb-2 pt-3">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Search...</label>
                                <input type="text" class="form-control" id="searchInput" placeholder="Search by name or email">
                            </div>
                        </div>
                        <div class="col-md-6">
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
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Bail Item</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantity</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Unit Price</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Total Amount</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr onclick="showSaleDetail(1, 'John Michael', 'john@creative-tim.com', 'Asana Bail', 5, 50.00, 250.00, 'completed', 'cash', '2024-10-15')" style="cursor: pointer;">
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="assets/img/team-2.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">John Michael</h6>
                                                <p class="text-xs text-secondary mb-0">john@creative-tim.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">Asana Bail</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">5</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">$50.00</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-success">$250.00</span>
                                    </td>
                                    <td>
                                        <span class="text-xs font-weight-bold">completed</span>
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-link text-secondary mb-0" onclick="event.stopPropagation();">
                                            <i class="fa fa-ellipsis-v text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr onclick="showSaleDetail(2, 'Alexa Liras', 'alexa@creative-tim.com', 'Github Merchandise', 3, 75.00, 225.00, 'pending', 'card', '2024-10-14')" style="cursor: pointer;">
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="assets/img/team-3.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user2">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Alexa Liras</h6>
                                                <p class="text-xs text-secondary mb-0">alexa@creative-tim.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">Github Merchandise</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">3</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">$75.00</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-warning">$225.00</span>
                                    </td>
                                    <td>
                                        <span class="text-xs font-weight-bold">pending</span>
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-link text-secondary mb-0" onclick="event.stopPropagation();">
                                            <i class="fa fa-ellipsis-v text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr onclick="showSaleDetail(3, 'Laurent Perrier', 'laurent@creative-tim.com', 'Atlassian Tools', 2, 100.00, 200.00, 'completed', 'cash', '2024-10-13')" style="cursor: pointer;">
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="assets/img/team-4.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user3">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Laurent Perrier</h6>
                                                <p class="text-xs text-secondary mb-0">laurent@creative-tim.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">Atlassian Tools</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">2</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">$100.00</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-success">$200.00</span>
                                    </td>
                                    <td>
                                        <span class="text-xs font-weight-bold">completed</span>
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-link text-secondary mb-0" onclick="event.stopPropagation();">
                                            <i class="fa fa-ellipsis-v text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr onclick="showSaleDetail(4, 'Michael Levi', 'michael@creative-tim.com', 'Bootstrap Components', 8, 45.00, 360.00, 'cancelled', 'check', '2024-10-12')" style="cursor: pointer;">
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="assets/img/team-3.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user4">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Michael Levi</h6>
                                                <p class="text-xs text-secondary mb-0">michael@creative-tim.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">Bootstrap Components</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">8</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">$45.00</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-danger">$360.00</span>
                                    </td>
                                    <td>
                                        <span class="text-xs font-weight-bold">cancelled</span>
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-link text-secondary mb-0" onclick="event.stopPropagation();">
                                            <i class="fa fa-ellipsis-v text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr onclick="showSaleDetail(5, 'Richard Gran', 'richard@creative-tim.com', 'Slack Merchandise', 4, 60.00, 240.00, 'refunded', 'card', '2024-10-11')" style="cursor: pointer;">
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="assets/img/team-2.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user5">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Richard Gran</h6>
                                                <p class="text-xs text-secondary mb-0">richard@creative-tim.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">Slack Merchandise</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">4</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">$60.00</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-warning">$240.00</span>
                                    </td>
                                    <td>
                                        <span class="text-xs font-weight-bold">refunded</span>
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-link text-secondary mb-0" onclick="event.stopPropagation();">
                                            <i class="fa fa-ellipsis-v text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr onclick="showSaleDetail(6, 'Miriam Eric', 'miriam@creative-tim.com', 'Dev.to Items', 6, 55.00, 330.00, 'completed', 'cash', '2024-10-10')" style="cursor: pointer;">
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="assets/img/team-4.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user6">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Miriam Eric</h6>
                                                <p class="text-xs text-secondary mb-0">miriam@creative-tim.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">Dev.to Items</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">6</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">$55.00</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-success">$330.00</span>
                                    </td>
                                    <td>
                                        <span class="text-xs font-weight-bold">completed</span>
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-link text-secondary mb-0" onclick="event.stopPropagation();">
                                            <i class="fa fa-ellipsis-v text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
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
                <form id="recordSaleForm" method="POST" action="#">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="saleCustomerId" class="form-label">Customer *</label>
                                <input type="text" class="form-control" id="saleCustomerId" name="p_customer_id" placeholder="Select customer" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="saleBailId" class="form-label">Bail Item *</label>
                                <input type="text" class="form-control" id="saleBailId" name="p_bail_id" placeholder="Select bail" required>
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
                                <label for="saleUnitPrice" class="form-label">Unit Price *</label>
                                <input type="number" class="form-control" id="saleUnitPrice" name="p_unit_price" placeholder="Enter unit price" step="0.01" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="saleStatus" class="form-label">Status</label>
                                <select class="form-control" id="saleStatus" name="p_status">
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="refunded">Refunded</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="salePaymentMethod" class="form-label">Payment Method</label>
                                <input type="text" class="form-control" id="salePaymentMethod" name="p_payment_method" placeholder="e.g., cash, card" value="cash">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="salePurchaseDate" class="form-label">Purchase Date</label>
                        <input type="date" class="form-control" id="salePurchaseDate" name="p_purchase_date">
                    </div>

                    <div class="form-group">
                        <label for="saleNotes" class="form-label">Notes</label>
                        <textarea class="form-control" id="saleNotes" name="p_notes" placeholder="Enter sale notes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveRecordedSale()">Record Sale</button>
            </div>
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
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-dark mb-2">Payment Method</h6>
                        <p class="text-muted" id="detailSalePaymentMethod">-</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h6 class="text-dark mb-2">Purchase Date</h6>
                        <p class="text-muted" id="detailSalePurchaseDate">-</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showSaleDetail(id, customer, email, bail, quantity, unitPrice, totalAmount, status, paymentMethod, purchaseDate) {
        document.getElementById('detailSaleCustomer').textContent = customer;
        document.getElementById('detailSaleEmail').textContent = email;
        document.getElementById('detailSaleBail').textContent = bail;
        document.getElementById('detailSaleQuantity').textContent = quantity;
        document.getElementById('detailSaleUnitPrice').textContent = '$' + parseFloat(unitPrice).toFixed(2);
        document.getElementById('detailSaleTotalAmount').textContent = '$' + parseFloat(totalAmount).toFixed(2);
        document.getElementById('detailSaleStatus').textContent = status.charAt(0).toUpperCase() + status.slice(1);
        document.getElementById('detailSalePaymentMethod').textContent = paymentMethod.charAt(0).toUpperCase() + paymentMethod.slice(1);
        document.getElementById('detailSalePurchaseDate').textContent = purchaseDate;

        const modal = new bootstrap.Modal(document.getElementById('saleDetailModal'));
        modal.show();
    }

    function saveRecordedSale() {
        const form = document.getElementById('recordSaleForm');
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            form.classList.add('was-validated');
        } else {
            const formData = new FormData(form);
            fetch('#', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('recordSaleModal'));
                        modal.hide();
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }
</script>

<?php
require_once "partials/footer.php";
?>