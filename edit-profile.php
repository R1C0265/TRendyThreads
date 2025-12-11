<?php
require_once 'partials/header.php';

// Check if user is logged in
if (!$isLoggedIn || $userType != '3') {
    header('Location: signin.php');
    exit;
}

// Get user data
$user = $db->query("SELECT * FROM users WHERE u_id = '{$_SESSION['userId']}'")->fetchArray();
?>

<main class="main">
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Profile</h4>
                        </div>
                        <div class="card-body">
                            <form action="model/updateProfile.php" method="POST">
                                <div class="row mb-3">
                                    <label for="name" class="col-sm-3 col-form-label">Name:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="<?php echo htmlspecialchars($user['u_name']); ?>" required>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <label for="email" class="col-sm-3 col-form-label">Email:</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="email" name="email" 
                                               value="<?php echo htmlspecialchars($user['u_email']); ?>" required>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <label for="phone" class="col-sm-3 col-form-label">Phone:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="phone" name="phone" 
                                               value="<?php echo htmlspecialchars($user['u_phone'] ?? ''); ?>">
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <label for="address" class="col-sm-3 col-form-label">Address:</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="address" name="address" rows="3"><?php echo htmlspecialchars($user['u_address'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success">Save Changes</button>
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

<?php require_once 'partials/footer.php'; ?>