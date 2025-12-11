<?php
require_once 'partials/header.php';

// Check if user is logged in and is employee
if (!isset($_SESSION['userId']) || $_SESSION['userType'] != '2') {
    header('Location: ../signin.php');
    exit;
}

// Get hero and about content
$hero = $db->query("SELECT * FROM hero_content WHERE is_active = 1 LIMIT 1")->fetchArray();
$about = $db->query("SELECT * FROM about_content WHERE is_active = 1 LIMIT 1")->fetchArray();
$about_features = $db->query("SELECT * FROM about_features WHERE is_active = 1 ORDER BY sort_order")->fetchAll();

$message = $_GET['success'] ?? '';
?>

<div class="container-fluid py-2">
    <?php if ($message): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Content updated successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

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
                            <img src="<?php echo $hero['hero_image'] ?? '../assets/ig/hero-img.png'; ?>" class="img-fluid border-radius-lg" alt="Hero Image">
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
                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#editAboutModal">
                            <i class="material-symbols-rounded text-sm me-1">edit</i>Edit About
                        </button>
                    </div>
                </div>
                <div class="card-body px-3 pb-2 pt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="<?php echo $about['image_path'] ?? '../assets/img/about.jpg'; ?>" class="img-fluid border-radius-lg" alt="About Image">
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
</div>

<!-- Edit Hero Modal -->
<div class="modal fade" id="editHeroModal" tabindex="-1" aria-labelledby="editHeroModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editHeroModalLabel">Edit Hero Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../model/updateHero.php" method="POST">
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
                    <div class="input-group input-group-outline mb-3">
                        <label class="form-label">Hero Image Path</label>
                        <input type="text" class="form-control" name="hero_image" value="<?php echo htmlspecialchars($hero['hero_image'] ?? ''); ?>">
                    </div>
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
            <form action="../model/updateAbout.php" method="POST">
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
                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label">Image Path</label>
                                <input type="text" class="form-control" name="image_path" value="<?php echo htmlspecialchars($about['image_path'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label">Video URL</label>
                                <input type="text" class="form-control" name="video_url" value="<?php echo htmlspecialchars($about['video_url'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn bg-gradient-info">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>