<?php
require_once 'partials/header.php';

// Check if user is logged in and is employee
if (!isset($_SESSION['userId']) || $_SESSION['userType'] != '2') {
    header('Location: ../signin.php');
    exit;
}

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>

<div class="container-fluid px-2 px-md-4">
    <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
        <span class="mask bg-gradient-dark opacity-6"></span>
    </div>
    <div class="card card-body mx-2 mx-md-2 mt-n6">
        <div class="row gx-4 mb-4">
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1">Change Password</h5>
                    <p class="mb-0 font-weight-normal text-sm">Update your account password</p>
                </div>
            </div>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Password changed successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if ($error == 'current'): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Current password is incorrect!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($error == 'match'): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                New passwords do not match!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($error == 'length'): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Password must be at least 6 characters!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-12 col-xl-6 mx-auto">
                <div class="card card-plain">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Password Settings</h6>
                    </div>
                    <div class="card-body p-3">
                        <form action="../model/updatePassword.php" method="POST">
                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" class="form-control" name="current_password" required>
                            </div>
                            
                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control" name="new_password" required>
                            </div>
                            
                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" name="confirm_password" required>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <a href="profile.php" class="btn btn-light me-2">Cancel</a>
                                <button type="submit" class="btn bg-gradient-dark">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>