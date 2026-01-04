<?php
require_once __DIR__ . '/../config/main.php';

function addNotification($type, $title, $message, $relatedId = null, $userId = null) {
    global $db;
    
    try {
        $sql = "INSERT INTO notifications (n_type, n_title, n_message, n_related_id) 
                VALUES (?, ?, ?, ?)";
        $db->query($sql, $type, $title, $message, $relatedId);
        return true;
    } catch (Exception $e) {
        error_log("Notification error: " . $e->getMessage());
        return false;
    }
}

// Specific notification functions
function notifyBailAdded($bailName, $bailId) {
    return addNotification(
        'bail_added',
        'New Bail Added',
        "A new bail '$bailName' has been added to inventory",
        $bailId
    );
}

function notifySaleCompleted($customerName, $bailName, $amount, $saleId) {
    return addNotification(
        'sale_completed',
        'Sale Completed',
        "Sale to $customerName for '$bailName' - MWK " . number_format($amount, 2),
        $saleId
    );
}

function notifyCustomerRegistered($customerName, $customerId) {
    return addNotification(
        'customer_registered',
        'New Customer Registered',
        "New customer '$customerName' has registered",
        $customerId
    );
}

function notifyUserRegistered($userName, $userId) {
    return addNotification(
        'user_registered',
        'New User Registered',
        "New user '$userName' has registered",
        $userId
    );
}

function notifyImageUploaded($section, $imagePath) {
    return addNotification(
        'image_uploaded',
        ucfirst($section) . ' Image Updated',
        "The $section section image has been updated to: $imagePath",
        null
    );
}

function notifyItemDeleted($itemType, $itemName, $itemId) {
    return addNotification(
        'item_deleted',
        ucfirst($itemType) . ' Deleted',
        "$itemType '$itemName' has been deleted from the system",
        $itemId
    );
}
?>