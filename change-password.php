<?php
require_once 'partials/header.php';

// Check if user is logged in
if (!$isLoggedIn || $userType != '3') {
    header('Location: signin.php');
    exit;
}

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>

<main class="main">
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Change Password</h4>
                        </div>
                        <div class="card-body">
                            <?php if ($success): ?>
                                <div class="alert alert-success">Password changed successfully!</div>
                            <?php endif; ?>
                            
                            <?php if ($error == 'current'): ?>
                                <div class="alert alert-danger">Current password is incorrect!</div>
                            <?php elseif ($error == 'match'): ?>
                                <div class="alert alert-danger">New passwords do not match!</div>
                            <?php elseif ($error == 'length'): ?>
                                <div class="alert alert-danger">Password must be at least 6 characters!</div>
                            <?php endif; ?>
                            
                            <form id="customerPasswordForm">
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Current Password:</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password:</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirm New Password:</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                                
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success">Update Password</button>
                                    <a href="profile.php" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="assets/js/forms.js"></script>
<?php require_once 'partials/footer.php'; ?>