<?php
require_once 'partials/header.php';

// Check if user is logged in and is employee
if (!isset($_SESSION['userId']) || $_SESSION['userType'] != '2') {
    header('Location: ../signin.php');
    exit;
}

// Get user data
$user = $db->query("SELECT * FROM users WHERE u_id = '{$_SESSION['userId']}'")->fetchArray();

// Check for success message
$message = $_GET['success'] ?? '';
?>

<div class="container-fluid px-2 px-md-4">
    <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
        <span class="mask bg-gradient-dark opacity-6"></span>
    </div>
    <div class="card card-body mx-2 mx-md-2 mt-n6">
        <div class="row gx-4 mb-2">
            <div class="col-auto">
                <div class="avatar avatar-xl position-relative">
                    <img src="<?php echo $user['u_img'] ?? 'assets/img/bruce-mars.jpg'; ?>" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1"><?php echo htmlspecialchars($user['u_name']); ?></h5>
                    <p class="mb-0 font-weight-normal text-sm">Employee</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                <div class="nav-wrapper position-relative end-0">
                    <ul class="nav nav-pills nav-fill p-1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#profile-tab" role="tab" aria-selected="true">
                                <i class="material-symbols-rounded text-lg position-relative">person</i>
                                <span class="ms-1">Profile</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#settings-tab" role="tab" aria-selected="false">
                                <i class="material-symbols-rounded text-lg position-relative">settings</i>
                                <span class="ms-1">Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Profile updated successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="tab-content">
            <!-- Profile Tab -->
            <div class="tab-pane fade show active" id="profile-tab" role="tabpanel">
                <div class="row">
                    <div class="col-12 col-xl-6">
                        <div class="card card-plain h-100">
                            <div class="card-header pb-0 p-3">
                                <div class="row">
                                    <div class="col-md-8 d-flex align-items-center">
                                        <h6 class="mb-0">Profile Information</h6>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <a href="edit-profile.php">
                                            <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Profile"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <p class="text-sm">
                                    Employee at Trendy Threads. Dedicated to providing excellent service and managing operations efficiently.
                                </p>
                                <hr class="horizontal gray-light my-4">
                                <ul class="list-group">
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                                        <strong class="text-dark">Full Name:</strong> &nbsp; <?php echo htmlspecialchars($user['u_name']); ?>
                                    </li>
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <strong class="text-dark">Email:</strong> &nbsp; <?php echo htmlspecialchars($user['u_email']); ?>
                                    </li>
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <strong class="text-dark">Phone:</strong> &nbsp; <?php echo htmlspecialchars($user['u_phone'] ?? 'Not provided'); ?>
                                    </li>
                                    <li class="list-group-item border-0 ps-0 text-sm">
                                        <strong class="text-dark">Address:</strong> &nbsp; <?php echo htmlspecialchars($user['u_address'] ?? 'Not provided'); ?>
                                    </li>
                                    <li class="list-group-item border-0 ps-0 pb-0">
                                        <strong class="text-dark text-sm">Employee ID:</strong> &nbsp; EMP-<?php echo str_pad($user['u_id'], 4, '0', STR_PAD_LEFT); ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-xl-6">
                        <div class="card card-plain h-100">
                            <div class="card-header pb-0 p-3">
                                <h6 class="mb-0">Account Settings</h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="d-grid gap-2">
                                    <a href="edit-profile.php" class="btn btn-outline-primary btn-sm">
                                        <i class="material-symbols-rounded text-sm me-2">edit</i>
                                        Edit Profile Information
                                    </a>
                                    <a href="change-password.php" class="btn btn-outline-warning btn-sm">
                                        <i class="material-symbols-rounded text-sm me-2">lock</i>
                                        Change Password
                                    </a>
                                    <a href="../../logout.php" class="btn btn-outline-danger btn-sm">
                                        <i class="material-symbols-rounded text-sm me-2">logout</i>
                                        Sign Out
                                    </a>
                                </div>
                                
                                <hr class="horizontal gray-light my-4">
                                
                                <h6 class="text-uppercase text-body text-xs font-weight-bolder">Account Status</h6>
                                <ul class="list-group">
                                    <li class="list-group-item border-0 px-0">
                                        <div class="form-check form-switch ps-0">
                                            <input class="form-check-input ms-auto" type="checkbox" checked disabled>
                                            <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0">Account Active</label>
                                        </div>
                                    </li>
                                    <li class="list-group-item border-0 px-0">
                                        <div class="form-check form-switch ps-0">
                                            <input class="form-check-input ms-auto" type="checkbox" checked>
                                            <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0">Email Notifications</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Tab -->
            <div class="tab-pane fade" id="settings-tab" role="tabpanel">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-plain">
                            <div class="card-header pb-0 p-3">
                                <h6 class="mb-0">Platform Settings</h6>
                            </div>
                            <div class="card-body p-3">
                                <h6 class="text-uppercase text-body text-xs font-weight-bolder">Account</h6>
                                <ul class="list-group">
                                    <li class="list-group-item border-0 px-0">
                                        <div class="form-check form-switch ps-0">
                                            <input class="form-check-input ms-auto" type="checkbox" id="emailNotifications" checked>
                                            <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="emailNotifications">Email me about system updates</label>
                                        </div>
                                    </li>
                                    <li class="list-group-item border-0 px-0">
                                        <div class="form-check form-switch ps-0">
                                            <input class="form-check-input ms-auto" type="checkbox" id="salesNotifications">
                                            <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="salesNotifications">Notify me about new sales</label>
                                        </div>
                                    </li>
                                    <li class="list-group-item border-0 px-0">
                                        <div class="form-check form-switch ps-0">
                                            <input class="form-check-input ms-auto" type="checkbox" id="inventoryNotifications" checked>
                                            <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="inventoryNotifications">Alert me about low inventory</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>