<?php
require_once 'partials/header.php';

// Check if user is logged in and is employee
if (!isset($_SESSION['userId']) || $_SESSION['userType'] != '2') {
    header('Location: ../signin.php');
    exit;
}

// Get user data
$user = $db->query("SELECT * FROM users WHERE u_id = '{$_SESSION['userId']}'")->fetchArray();

$error = $_GET['error'] ?? '';
?>

<div class="container-fluid px-2 px-md-4">
    <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
        <span class="mask bg-gradient-dark opacity-6"></span>
    </div>
    <div class="card card-body mx-2 mx-md-2 mt-n6">
        <div class="row gx-4 mb-4">
            <div class="col-auto">
                <div class="avatar avatar-xl position-relative">
                    <img src="<?php echo $user['u_img'] ?? 'assets/img/bruce-mars.jpg'; ?>" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1">Edit Profile</h5>
                    <p class="mb-0 font-weight-normal text-sm">Update your profile information</p>
                </div>
            </div>
        </div>

        <?php if ($error == 'required'): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Name and email are required fields!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($error == 'email'): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Please enter a valid email address!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($error == 'update'): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Failed to update profile. Please try again!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-12 col-xl-8 mx-auto">
                <div class="card card-plain">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Profile Information</h6>
                    </div>
                    <div class="card-body p-3">
                        <form action="../model/updateProfile.php" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-outline mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($user['u_name']); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-outline mb-3">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['u_email']); ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-outline mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($user['u_phone'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-outline mb-3">
                                        <label class="form-label">Employee ID</label>
                                        <input type="text" class="form-control" value="EMP-<?php echo str_pad($user['u_id'], 4, '0', STR_PAD_LEFT); ?>" disabled>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group input-group-outline mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control" name="address" rows="3"><?php echo htmlspecialchars($user['u_address'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end">
                                        <a href="profile.php" class="btn btn-light me-2">Cancel</a>
                                        <button type="submit" class="btn bg-gradient-dark">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>