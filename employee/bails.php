<?php
$page_title = "Bails - Trendy Threads";
require_once 'partials/header.php';
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
                                <tr onclick="showBailDetail(1, 'Asana', 50, '2024-10-15', 'available', 60, 'High-quality clothing items')" style="cursor: pointer;">
                                    <td>
                                        <div class="d-flex px-2">
                                            <div>
                                                <img src="assets/img/small-logos/logo-asana.svg" class="avatar avatar-sm rounded-circle me-2" alt="asana">
                                            </div>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">Asana</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">50</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">2024-10-15</p>
                                    </td>
                                    <td>
                                        <span class="text-xs font-weight-bold">working</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <span class="me-2 text-xs font-weight-bold">60%</span>
                                            <div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
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
                                <tr onclick="showBailDetail(2, 'Github', 75, '2024-09-20', 'sold', 100, 'Tech merchandise and apparel')" style="cursor: pointer;">
                                    <td>
                                        <div class="d-flex px-2">
                                            <div>
                                                <img src="assets/img/small-logos/github.svg" class="avatar avatar-sm rounded-circle me-2" alt="github">
                                            </div>
                                            <div class="my-auto">
                                                <h6 class="mb-0 text-sm">Github</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">75</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">2024-09-20</p>
                                    </td>
                                    <td>
                                        <span class="text-xs font-weight-bold">done</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <span class="me-2 text-xs font-weight-bold">100%</span>
                                            <div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-link text-secondary mb-0" onclick="event.stopPropagation();" aria-haspopup="true" aria-expanded="false">
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

<!-- Add Bail Modal -->
<div class="modal fade" id="addBailModal" tabindex="-1" aria-labelledby="addBailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-dark">
                <h5 class="modal-title text-white" id="addBailModalLabel">Add New Bail</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addBailForm" method="POST" action="#">
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveBail()">Save Bail</button>
            </div>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showBailDetail(id, name, items, purchaseDate, status, stockLevel, description) {
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

    function saveBail() {
        const form = document.getElementById('addBailForm');
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            form.classList.add('was-validated');
        } else {
            // Submit the form
            const formData = new FormData(form);
            fetch('../model/addBail.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addBailModal'));
                        modal.hide();
                        // Optionally reload the page or add the new bail to the table
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