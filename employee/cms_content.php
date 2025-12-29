<?php
require_once 'partials/header.php';

// Check if user is logged in and is employee
if (!isset($_SESSION['userId']) || $_SESSION['userType'] != '2') {
    header('Location: ../signin.php');
    exit;
}

// Get all content sections
$hero = $db->query("SELECT * FROM hero_content WHERE is_active = 1 LIMIT 1")->fetchArray();
$about = $db->query("SELECT * FROM about_content WHERE is_active = 1 LIMIT 1")->fetchArray();
$about_features = $db->query("SELECT * FROM about_features WHERE is_active = 1 ORDER BY sort_order")->fetchAll();
$services = $db->query("SELECT * FROM services WHERE is_active = 1 ORDER BY sort_order")->fetchAll();
$stats = $db->query("SELECT * FROM stats WHERE is_active = 1 ORDER BY sort_order")->fetchAll();
$clients = $db->query("SELECT * FROM clients WHERE is_active = 1 ORDER BY sort_order")->fetchAll();
$contact_info = $db->query("SELECT * FROM contact_info WHERE is_active = 1 ORDER BY sort_order")->fetchAll();

$message = $_GET['success'] ?? '';
?>

<div class="container-fluid py-2">

    <!-- Hero Section Management -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-3">
                        <h6 class="text-white text-capitalize mb-0">Hero Section</h6>
                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#editHeroModal">
                            <i class="material-symbols-rounded text-sm me-1">edit</i>Edit Hero
                        </button>
                    </div>
                </div>
                <div class="card-body px-3 pb-2 pt-3">
                    <div class="row">
                        <div class="col-md-8">
                            <h5><?php echo htmlspecialchars($hero['title'] ?? 'The latest Threads & Fashion'); ?></h5>
                            <p class="text-sm"><?php echo htmlspecialchars($hero['subtitle'] ?? 'Only dress with the best.'); ?></p>
                            <p><strong>CTA Text:</strong> <?php echo htmlspecialchars($hero['cta_text'] ?? 'Shop Now'); ?></p>
                            <p><strong>CTA Link:</strong> <?php echo htmlspecialchars($hero['cta_link'] ?? '#about'); ?></p>
                        </div>
                        <div class="col-md-4">
                            <?php
                            $heroImagePath = $hero['hero_image'] ?? 'assets/img/hero-img.png';
                            // Ensure path works from /employee/ subdirectory by adding ../ prefix
                            $displayPath = strpos($heroImagePath, '../') === 0 ? $heroImagePath : '../' . $heroImagePath;
                            ?>
                            <img src="<?php echo $displayPath; ?>" class="img-fluid border-radius-lg" alt="Hero Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section Management -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-3">
                        <h6 class="text-white text-capitalize mb-0">About Section</h6>
                        <div>
                            <button type="button" class="btn btn-sm btn-light me-2" data-bs-toggle="modal" data-bs-target="#editAboutModal">
                                <i class="material-symbols-rounded text-sm me-1">edit</i>Edit About
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-light" data-bs-toggle="modal" data-bs-target="#manageFeaturesModal">
                                <i class="material-symbols-rounded text-sm me-1">list</i>Manage Features
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body px-3 pb-2 pt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                            $aboutImagePath = $about['image_path'] ?? 'assets/img/about.jpg';
                            // Ensure path works from /employee/ subdirectory by adding ../ prefix
                            $displayPath = strpos($aboutImagePath, '../') === 0 ? $aboutImagePath : '../' . $aboutImagePath;
                            ?>
                            <img src="<?php echo $displayPath; ?>" class="img-fluid border-radius-lg" alt="About Image">
                        </div>
                        <div class="col-md-6">
                            <h5><?php echo htmlspecialchars($about['title'] ?? 'About Us'); ?></h5>
                            <?php if (!empty($about['subtitle'])): ?>
                                <h6 class="text-info"><?php echo htmlspecialchars($about['subtitle']); ?></h6>
                            <?php endif; ?>
                            <p class="text-sm"><?php echo htmlspecialchars($about['description'] ?? 'Learn more about our company and mission.'); ?></p>

                            <h6 class="mt-4">Features:</h6>
                            <ul class="list-unstyled">
                                <?php foreach ($about_features as $feature): ?>
                                    <li class="mb-2">
                                        <i class="<?php echo htmlspecialchars($feature['icon_class']); ?> text-info me-2"></i>
                                        <strong><?php echo htmlspecialchars($feature['title']); ?>:</strong>
                                        <?php echo htmlspecialchars($feature['description']); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Section Management -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-3">
                        <h6 class="text-white text-capitalize mb-0">Services Section</h6>
                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#manageServicesModal">
                            <i class="material-symbols-rounded text-sm me-1">settings</i>Manage Services
                        </button>
                    </div>
                </div>
                <div class="card-body px-3 pb-2 pt-3">
                    <div class="row">
                        <?php foreach ($services as $service): ?>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="<?php echo htmlspecialchars($service['icon_class']); ?> text-lg me-3" style="color: <?php echo htmlspecialchars($service['icon_color']); ?>"></i>
                                    <div>
                                        <h6 class="mb-0"><?php echo htmlspecialchars($service['title']); ?></h6>
                                        <p class="text-sm mb-0"><?php echo htmlspecialchars($service['description']); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section Management -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-warning shadow-warning border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-3">
                        <h6 class="text-white text-capitalize mb-0">Stats Section</h6>
                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#manageStatsModal">
                            <i class="material-symbols-rounded text-sm me-1">bar_chart</i>Manage Stats
                        </button>
                    </div>
                </div>
                <div class="card-body px-3 pb-2 pt-3">
                    <div class="row">
                        <?php foreach ($stats as $stat): ?>
                            <div class="col-md-3 mb-3">
                                <div class="text-center">
                                    <h3 class="text-gradient text-warning"><?php echo $stat['value']; ?></h3>
                                    <p class="mb-0"><?php echo htmlspecialchars($stat['label']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Clients Section Management -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-secondary shadow-secondary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-3">
                        <h6 class="text-white text-capitalize mb-0">Clients Section</h6>
                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#manageClientsModal">
                            <i class="material-symbols-rounded text-sm me-1">business</i>Manage Clients
                        </button>
                    </div>
                </div>
                <div class="card-body px-3 pb-2 pt-3">
                    <div class="row">
                        <?php foreach ($clients as $client): ?>
                            <div class="col-md-3 mb-3">
                                <div class="text-center">
                                    <img src="<?php echo htmlspecialchars($client['logo_path']); ?>" class="img-fluid" style="max-height: 60px;" alt="<?php echo htmlspecialchars($client['name']); ?>">
                                    <p class="text-sm mt-2 mb-0"><?php echo htmlspecialchars($client['name']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section Management -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-3">
                        <h6 class="text-white text-capitalize mb-0">Contact Information</h6>
                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#manageContactModal">
                            <i class="material-symbols-rounded text-sm me-1">contact_mail</i>Manage Contact
                        </button>
                    </div>
                </div>
                <div class="card-body px-3 pb-2 pt-3">
                    <div class="row">
                        <?php foreach ($contact_info as $info): ?>
                            <?php if ($info['type'] != 'map'): ?>
                                <div class="col-md-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="<?php echo htmlspecialchars($info['icon_class']); ?> text-lg me-3"></i>
                                        <div>
                                            <h6 class="mb-0"><?php echo htmlspecialchars($info['label']); ?></h6>
                                            <p class="text-sm mb-0"><?php echo htmlspecialchars($info['value']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Hero Modal -->
<div class="modal fade" id="editHeroModal" tabindex="-1" aria-labelledby="editHeroModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editHeroModalLabel">Edit Hero Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="heroForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($hero['title'] ?? ''); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label">Subtitle</label>
                                <input type="text" class="form-control" name="subtitle" value="<?php echo htmlspecialchars($hero['subtitle'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label">CTA Text</label>
                                <input type="text" class="form-control" name="cta_text" value="<?php echo htmlspecialchars($hero['cta_text'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label">CTA Link</label>
                                <input type="text" class="form-control" name="cta_link" value="<?php echo htmlspecialchars($hero['cta_link'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Current Hero Image</label>
                                <div class="text-center">
                                    <img src="<?php echo '../' . ($hero['hero_image'] ?? 'assets/img/hero-img.png'); ?>" class="img-fluid border-radius-lg" style="max-height: 200px;" alt="Current Hero Image">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Upload New Hero Image</label>
                                <input type="file" class="form-control" id="heroImageUpload" accept="image/*">
                                <button type="button" class="btn btn-sm btn-info mt-2" onclick="uploadHeroImage()">Upload & Replace</button>
                                <small class="text-muted d-block mt-1">This will replace the current hero image</small>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="heroImagePath" name="hero_image" value="<?php echo htmlspecialchars($hero['hero_image'] ?? ''); ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn bg-gradient-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit About Modal -->
<div class="modal fade" id="editAboutModal" tabindex="-1" aria-labelledby="editAboutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAboutModalLabel">Edit About Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="aboutForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($about['title'] ?? ''); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label">Subtitle</label>
                                <input type="text" class="form-control" name="subtitle" value="<?php echo htmlspecialchars($about['subtitle'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="input-group input-group-outline mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="4"><?php echo htmlspecialchars($about['description'] ?? ''); ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Current About Image</label>
                                <div class="text-center">
                                    <img src="<?php echo '../' . ($about['image_path'] ?? 'assets/img/about.jpg'); ?>" class="img-fluid border-radius-lg" style="max-height: 200px;" alt="Current About Image">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Upload New About Image</label>
                                <input type="file" class="form-control" id="aboutImageUpload" accept="image/*">
                                <button type="button" class="btn btn-sm btn-info mt-2" onclick="uploadAboutImage()">Upload & Replace</button>
                                <small class="text-muted d-block mt-1">This will replace the current about image</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label">Video URL</label>
                                <input type="text" class="form-control" name="video_url" value="<?php echo htmlspecialchars($about['video_url'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="aboutImagePath" name="image_path" value="<?php echo htmlspecialchars($about['image_path'] ?? ''); ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn bg-gradient-info">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Manage Features Modal -->
<div class="modal fade" id="manageFeaturesModal" tabindex="-1" aria-labelledby="manageFeaturesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manageFeaturesModalLabel">Manage About Features</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Icon</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Order</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($about_features as $feature): ?>
                                <tr>
                                    <td><i class="<?php echo htmlspecialchars($feature['icon_class']); ?> text-info"></i></td>
                                    <td><?php echo htmlspecialchars($feature['title']); ?></td>
                                    <td><?php echo htmlspecialchars(substr($feature['description'], 0, 50)) . '...'; ?></td>
                                    <td><?php echo $feature['sort_order']; ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="editFeature(<?php echo $feature['id']; ?>, '<?php echo htmlspecialchars($feature['icon_class']); ?>', '<?php echo htmlspecialchars($feature['title']); ?>', '<?php echo htmlspecialchars($feature['description']); ?>', <?php echo $feature['sort_order']; ?>)">Edit</button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteFeature(<?php echo $feature['id']; ?>)">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="addFeature()">Add New Feature</button>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Feature Modal -->
<div class="modal fade" id="featureFormModal" tabindex="-1" aria-labelledby="featureFormModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="featureFormModalLabel">Add Feature</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="featureForm">
                <div class="modal-body">
                    <input type="hidden" id="featureId" name="feature_id" value="">
                    <input type="hidden" id="featureAction" name="action" value="add">

                    <div class="mb-3">
                        <label for="featureIcon" class="form-label">Icon Class</label>
                        <input type="text" class="form-control" id="featureIcon" name="icon_class" placeholder="e.g., bi bi-diagram-3" required>
                        <small class="text-muted">Use Bootstrap Icons classes</small>
                    </div>

                    <div class="mb-3">
                        <label for="featureTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="featureTitle" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="featureDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="featureDescription" name="description" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="featureOrder" class="form-label">Sort Order</label>
                        <input type="number" class="form-control" id="featureOrder" name="sort_order" value="1" min="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="featureSubmitBtn">Save Feature</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Manage Services Modal -->
<div class="modal fade" id="manageServicesModal" tabindex="-1" aria-labelledby="manageServicesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manageServicesModalLabel">Manage Services</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Icon</th>
                                <th>Color</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($services as $service): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($service['title']); ?></td>
                                    <td><?php echo htmlspecialchars(substr($service['description'], 0, 50)) . '...'; ?></td>
                                    <td><i class="<?php echo htmlspecialchars($service['icon_class']); ?>"></i></td>
                                    <td><span class="badge" style="background-color: <?php echo htmlspecialchars($service['icon_color']); ?>"><?php echo htmlspecialchars($service['icon_color']); ?></span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="editService(<?php echo $service['id']; ?>)">Edit</button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteService(<?php echo $service['id']; ?>)">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="addService()">Add New Service</button>
            </div>
        </div>
    </div>
</div>

<!-- Manage Stats Modal -->
<div class="modal fade" id="manageStatsModal" tabindex="-1" aria-labelledby="manageStatsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manageStatsModalLabel">Manage Statistics</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Label</th>
                                <th>Value</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($stats as $stat): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($stat['label']); ?></td>
                                    <td><?php echo $stat['value']; ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="editStat(<?php echo $stat['id']; ?>)">Edit</button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteStat(<?php echo $stat['id']; ?>)">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="addStat()">Add New Stat</button>
            </div>
        </div>
    </div>
</div>

<!-- Manage Clients Modal -->
<div class="modal fade" id="manageClientsModal" tabindex="-1" aria-labelledby="manageClientsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manageClientsModalLabel">Manage Clients</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Logo</th>
                                <th>Name</th>
                                <th>Website</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clients as $client): ?>
                                <tr>
                                    <td><img src="<?php echo htmlspecialchars($client['logo_path']); ?>" style="max-height: 30px;" alt="Logo"></td>
                                    <td><?php echo htmlspecialchars($client['name']); ?></td>
                                    <td><?php echo htmlspecialchars($client['website_url'] ?? 'N/A'); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="editClient(<?php echo $client['id']; ?>)">Edit</button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteClient(<?php echo $client['id']; ?>)">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="addClient()">Add New Client</button>
            </div>
        </div>
    </div>
</div>

<!-- Manage Contact Modal -->
<div class="modal fade" id="manageContactModal" tabindex="-1" aria-labelledby="manageContactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manageContactModalLabel">Manage Contact Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Label</th>
                                <th>Value</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contact_info as $info): ?>
                                <tr>
                                    <td><?php echo ucfirst($info['type']); ?></td>
                                    <td><?php echo htmlspecialchars($info['label']); ?></td>
                                    <td><?php echo htmlspecialchars(substr($info['value'], 0, 30)) . (strlen($info['value']) > 30 ? '...' : ''); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="editContact(<?php echo $info['id']; ?>)">Edit</button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteContact(<?php echo $info['id']; ?>)">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="addContact()">Add New Contact</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Placeholder functions for CRUD operations
    function editService(id) {
        alert('Edit Service ' + id + ' - Feature coming soon!');
    }

    function deleteService(id) {
        if (confirm('Delete this service?')) alert('Delete Service ' + id + ' - Feature coming soon!');
    }

    function addService() {
        alert('Add Service - Feature coming soon!');
    }

    function editStat(id) {
        alert('Edit Stat ' + id + ' - Feature coming soon!');
    }

    function deleteStat(id) {
        if (confirm('Delete this stat?')) alert('Delete Stat ' + id + ' - Feature coming soon!');
    }

    function addStat() {
        alert('Add Stat - Feature coming soon!');
    }

    function editClient(id) {
        alert('Edit Client ' + id + ' - Feature coming soon!');
    }

    function deleteClient(id) {
        if (confirm('Delete this client?')) alert('Delete Client ' + id + ' - Feature coming soon!');
    }

    function addClient() {
        alert('Add Client - Feature coming soon!');
    }

    function editContact(id) {
        alert('Edit Contact ' + id + ' - Feature coming soon!');
    }

    function deleteContact(id) {
        if (confirm('Delete this contact?')) alert('Delete Contact ' + id + ' - Feature coming soon!');
    }

    function addContact() {
        alert('Add Contact - Feature coming soon!');
    }

    // Image upload functions
    function uploadHeroImage() {
        const fileInput = document.getElementById('heroImageUpload');
        const file = fileInput.files[0];

        if (!file) {
            alert('Please select an image first');
            return;
        }

        const formData = new FormData();
        formData.append('image', file);
        formData.append('section', 'hero');

        $.ajax({
            url: '../model/uploadSectionImage.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('button[onclick="uploadHeroImage()"]').prop('disabled', true).text('Uploading...');
            },
            success: function(data) {
                const response = typeof data === 'string' ? JSON.parse(data) : data;
                if (response.success) {
                    document.getElementById('heroImagePath').value = response.path;
                    alert('Hero image uploaded and replaced successfully!');
                    fileInput.value = '';
                    // Reload page to show new image
                    window.location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Error uploading image');
            },
            complete: function() {
                $('button[onclick="uploadHeroImage()"]').prop('disabled', false).text('Upload & Replace');
            }
        });
    }

    function uploadAboutImage() {
        const fileInput = document.getElementById('aboutImageUpload');
        const file = fileInput.files[0];

        if (!file) {
            alert('Please select an image first');
            return;
        }

        const formData = new FormData();
        formData.append('image', file);
        formData.append('section', 'about');

        $.ajax({
            url: '../model/uploadSectionImage.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('button[onclick="uploadAboutImage()"]').prop('disabled', true).text('Uploading...');
            },
            success: function(data) {
                const response = typeof data === 'string' ? JSON.parse(data) : data;
                if (response.success) {
                    document.getElementById('aboutImagePath').value = response.path;
                    alert('About image uploaded and replaced successfully!');
                    fileInput.value = '';
                    // Reload page to show new image
                    window.location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Error uploading image');
            },
            complete: function() {
                $('button[onclick="uploadAboutImage()"]').prop('disabled', false).text('Upload & Replace');
            }
        });
    }

    // Features management functions
    function addFeature() {
        document.getElementById('featureFormModalLabel').textContent = 'Add Feature';
        document.getElementById('featureAction').value = 'add';
        document.getElementById('featureId').value = '';
        document.getElementById('featureForm').reset();

        const modal = new bootstrap.Modal(document.getElementById('featureFormModal'));
        modal.show();
    }

    function editFeature(id, iconClass, title, description, sortOrder) {
        document.getElementById('featureFormModalLabel').textContent = 'Edit Feature';
        document.getElementById('featureAction').value = 'edit';
        document.getElementById('featureId').value = id;
        document.getElementById('featureIcon').value = iconClass;
        document.getElementById('featureTitle').value = title;
        document.getElementById('featureDescription').value = description;
        document.getElementById('featureOrder').value = sortOrder;

        const modal = new bootstrap.Modal(document.getElementById('featureFormModal'));
        modal.show();
    }

    function deleteFeature(id) {
        if (confirm('Are you sure you want to delete this feature?')) {
            $.ajax({
                url: '../model/updateFeature.php',
                type: 'POST',
                data: {
                    action: 'delete',
                    feature_id: id
                },
                success: function(data) {
                    try {
                        const response = typeof data === 'string' ? JSON.parse(data) : data;
                        if (response.success) {
                            alert('Feature deleted successfully!');
                            window.location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    } catch (e) {
                        console.error('JSON parse error:', e);
                        alert('Error processing response');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('Error deleting feature');
                }
            });
        }
    }

    // Handle feature form submission
    $(document).ready(function() {
        $('#featureForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '../model/updateFeature.php',
                type: 'POST',
                data: $(this).serialize(),
                beforeSend: function() {
                    $('#featureSubmitBtn').prop('disabled', true).text('Saving...');
                },
                success: function(data) {
                    console.log('Raw response:', data);
                    try {
                        const response = typeof data === 'string' ? JSON.parse(data) : data;
                        if (response.success) {
                            const modal = bootstrap.Modal.getInstance(document.getElementById('featureFormModal'));
                            modal.hide();
                            alert('Feature saved successfully!');
                            window.location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    } catch (e) {
                        console.error('JSON parse error:', e);
                        alert('Error processing response');
                    }
                    $('#featureSubmitBtn').prop('disabled', false).text('Save Feature');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('Error saving feature');
                    $('#featureSubmitBtn').prop('disabled', false).text('Save Feature');
                }
            });
        });
    });
</script>

<style>
    /* Dark Mode Styling for Home/About Modals */
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

    .dark-version #editHeroModal .modal-content,
    .dark-version #editAboutModal .modal-content,
    .dark-version #manageFeaturesModal .modal-content,
    .dark-version #featureFormModal .modal-content,
    .dark-version #manageServicesModal .modal-content,
    .dark-version #manageStatsModal .modal-content,
    .dark-version #manageClientsModal .modal-content,
    .dark-version #manageContactModal .modal-content {
        background-color: #2d2d2d !important;
    }

    /* Form elements in dark mode */
    .dark-version .form-control,
    .dark-version .form-select,
    .dark-version .input-group input,
    .dark-version .input-group textarea {
        background-color: #3a3a3a !important;
        color: #ffffff !important;
        border-color: #555555 !important;
    }

    .dark-version .form-control:focus,
    .dark-version .form-select:focus,
    .dark-version .input-group input:focus,
    .dark-version .input-group textarea:focus {
        background-color: #3a3a3a !important;
        color: #ffffff !important;
        border-color: #6c63ff !important;
        box-shadow: 0 0 0 0.2rem rgba(108, 99, 255, 0.25);
    }

    .dark-version .form-control::placeholder,
    .dark-version .input-group input::placeholder,
    .dark-version .input-group textarea::placeholder {
        color: #999999 !important;
    }

    .dark-version .form-label,
    .dark-version .input-group-outline label {
        color: #ffffff !important;
    }

    /* Text in modals */
    .dark-version .modal-body label,
    .dark-version .modal-body p,
    .dark-version .modal-body h5,
    .dark-version .modal-body h6 {
        color: #ffffff !important;
    }

    .dark-version .modal-body small {
        color: #adb5bd !important;
    }

    /* Buttons styling */
    .dark-version .modal-footer .btn-primary,
    .dark-version .modal-footer .bg-gradient-primary {
        background-color: #6c63ff !important;
        border-color: #6c63ff !important;
    }

    .dark-version .modal-footer .btn-primary:hover,
    .dark-version .modal-footer .bg-gradient-primary:hover {
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

    .dark-version .modal-footer .btn-success {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
    }

    .dark-version .modal-footer .btn-success:hover {
        background-color: #218838 !important;
        border-color: #218838 !important;
    }

    .dark-version .modal-footer .btn-danger {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
    }

    .dark-version .modal-footer .btn-danger:hover {
        background-color: #bd2130 !important;
        border-color: #bd2130 !important;
    }

    .dark-version .btn-info {
        background-color: #0dcaf0 !important;
        border-color: #0dcaf0 !important;
        color: #000000 !important;
    }

    .dark-version .btn-info:hover {
        background-color: #0aa2c0 !important;
        border-color: #0aa2c0 !important;
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

    .dark-version .table td {
        color: #ffffff !important;
    }

    /* Input groups */
    .dark-version .input-group-outline {
        border-color: #555555 !important;
    }

    .dark-version .input-group-outline:hover {
        border-color: #666666 !important;
    }

    /* Text styles */
    .dark-version .text-muted {
        color: #adb5bd !important;
    }

    .dark-version .text-info {
        color: #0dcaf0 !important;
    }

    .dark-version .badge {
        background-color: #6c63ff !important;
        color: #ffffff !important;
    }

    /* Link styling */
    .dark-version .modal-body a {
        color: #0dcaf0 !important;
    }

    .dark-version .modal-body a:hover {
        color: #0aa2c0 !important;
    }

    /* Horizontal rule styling */
    .dark-version hr {
        border-color: #444444 !important;
    }

    /* Image containers */
    .dark-version .text-center img {
        border-color: #444444 !important;
    }
</style>

<?php require_once 'partials/footer.php'; ?>