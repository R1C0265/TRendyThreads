<?php
$page_title = "Notifications - Trendy Threads";
require_once 'partials/header.php';

// Get notifications
$sql = "SELECT * FROM notifications ORDER BY n_created_date DESC LIMIT 50";
$notifications = $db->query($sql)->fetchAll();
?>
<div class="container-fluid py-2">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Notifications</h6>
                    </div>
                </div>
                <div class="card-body px-3 pb-2 pt-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-0">System Activity</h6>
                            <p class="text-sm text-muted mb-0">Stay updated with recent changes</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-info" onclick="location.reload()"><i class="fa fa-refresh me-1"></i>Refresh</button>
                            <button class="btn btn-sm btn-gradient-primary" onclick="markAllRead()"><i class="fa fa-check me-1"></i>Mark All Read</button>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <?php if (empty($notifications)): ?>
                        <div class="text-center py-5">
                            <div class="bg-gradient-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="fa fa-bell-slash fa-2x text-secondary"></i>
                            </div>
                            <h6 class="text-muted mb-2">All caught up!</h6>
                            <p class="text-sm text-muted mb-0">No new notifications at the moment</p>
                        </div>
                    <?php else: ?>
                        <div class="px-3">
                            <?php foreach ($notifications as $notification): 
                                $iconClass = '';
                                $iconBg = '';
                                $cardClass = $notification['n_is_read'] ? 'border-light' : 'border-primary border-2';
                                $bgClass = $notification['n_is_read'] ? '' : 'bg-gradient-light';
                                
                                switch ($notification['n_type']) {
                                    case 'bail_added':
                                        $iconClass = 'fa-plus-circle';
                                        $iconBg = 'bg-gradient-success';
                                        break;
                                    case 'sale_completed':
                                        $iconClass = 'fa-shopping-cart';
                                        $iconBg = 'bg-gradient-primary';
                                        break;
                                    case 'customer_registered':
                                        $iconClass = 'fa-user-plus';
                                        $iconBg = 'bg-gradient-info';
                                        break;
                                    case 'item_deleted':
                                        $iconClass = 'fa-trash';
                                        $iconBg = 'bg-gradient-danger';
                                        break;
                                }
                            ?>
                                <div class="card mb-3 <?php echo $cardClass; ?> <?php echo $bgClass; ?> shadow-sm notification-card" 
                                     onclick="markAsRead(<?php echo $notification['n_id']; ?>)" style="cursor: pointer; transition: all 0.3s ease;">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="me-3">
                                                <div class="avatar avatar-sm <?php echo $iconBg; ?> rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="fa <?php echo $iconClass; ?> text-white text-sm"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start mb-1">
                                                    <h6 class="mb-0 text-sm font-weight-bold text-dark"><?php echo htmlspecialchars($notification['n_title']); ?></h6>
                                                    <div class="d-flex align-items-center">
                                                        <?php if (!$notification['n_is_read']): ?>
                                                            <span class="badge bg-gradient-primary badge-sm me-2">New</span>
                                                        <?php endif; ?>
                                                        <small class="text-muted"><?php echo date('M d, H:i', strtotime($notification['n_created_date'])); ?></small>
                                                    </div>
                                                </div>
                                                <p class="mb-0 text-sm text-muted"><?php echo htmlspecialchars($notification['n_message']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
.notification-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
}

.avatar {
    width: 40px;
    height: 40px;
}

.notification-card {
    border-radius: 12px;
}

.bg-gradient-light {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}
</style>

<script>
function markAsRead(notificationId) {
    $.ajax({
        url: '../model/markNotificationRead.php',
        type: 'POST',
        data: { id: notificationId },
        success: function(response) {
            // Add smooth fade effect before reload
            $(`[onclick*="${notificationId}"]`).fadeOut(300, function() {
                location.reload();
            });
        }
    });
}

function markAllRead() {
    if (confirm('Mark all notifications as read?')) {
        $.ajax({
            url: '../model/markAllNotificationsRead.php',
            type: 'POST',
            success: function(response) {
                $('.notification-card').fadeOut(300, function() {
                    location.reload();
                });
            }
        });
    }
}

// Add smooth animations on page load
$(document).ready(function() {
    $('.notification-card').each(function(index) {
        $(this).css('opacity', '0').delay(index * 100).animate({opacity: 1}, 300);
    });
});
</script>

<?php
require_once "partials/footer.php";
?>