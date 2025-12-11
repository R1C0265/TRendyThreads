<?php
require_once 'partials/header.php';

// Check if user is logged in
if (!$isLoggedIn || $userType != '3') {
    header('Location: signin.php');
    exit;
}

// Get user data from users table (correct approach)
$user = $db->query("SELECT * FROM users WHERE u_id = '{$_SESSION['userId']}'")->fetchArray();

// Check for success message
$message = $_GET['success'] ?? '';
?>

<main class="main">
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>My Profile</h4>
                        </div>
                        <div class="card-body">
                            <?php if ($message): ?>
                                <div class="alert alert-success">Profile updated successfully!</div>
                            <?php endif; ?>
                            
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Name:</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext"><?php echo htmlspecialchars($user['u_name']); ?></p>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Email:</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext"><?php echo htmlspecialchars($user['u_email']); ?></p>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Phone:</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext"><?php echo htmlspecialchars($user['u_phone'] ?? 'Not provided'); ?></p>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Address:</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext"><?php echo htmlspecialchars($user['u_address'] ?? 'Not provided'); ?></p>
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <a href="edit-profile.php" class="btn btn-primary">Edit Profile</a>
                                <a href="change-password.php" class="btn btn-warning ms-2">Change Password</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once 'partials/footer.php'; ?>