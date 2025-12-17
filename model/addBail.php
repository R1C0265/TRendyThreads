<?php
require_once("../config/main.php");
require_once('notificationHelper.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $b_name = $_POST['b_name'] ?? null;
    $b_items_count = $_POST['b_items_count'] ?? 1;
    $b_avg_price_per_item = $_POST['b_avg_price_per_item'] ?? null;
    $b_purchase_date = $_POST['b_purchase_date'] ?? null;
    $b_description = $_POST['b_description'] ?? null;
    $b_status = $_POST['b_status'] ?? 'available';
    $b_stock_quantity = $_POST['b_stock_quantity'] ?? 1;

    // Insert bail
    $save = $db->query(
        "INSERT INTO bails (b_name, b_items_count, b_avg_price_per_item, b_purchase_date, b_description, b_status, b_stock_quantity) VALUES (?, ?, ?, ?, ?, ?, ?)",
        $b_name, $b_items_count, $b_avg_price_per_item, $b_purchase_date, $b_description, $b_status, $b_stock_quantity
    );
    
    if ($save) {
        $bail_id = $db->lastInsertID();
        
        // Handle image uploads
        if (isset($_FILES['bail_images']) && !empty($_FILES['bail_images']['name'][0])) {
            $upload_dir = '../assets/img/bails/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $files = $_FILES['bail_images'];
            $file_count = count($files['name']);
            
            for ($i = 0; $i < min($file_count, 4); $i++) {
                if ($files['error'][$i] === UPLOAD_ERR_OK) {
                    $file_name = $files['name'][$i];
                    $file_tmp = $files['tmp_name'][$i];
                    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                    
                    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                    if (in_array($file_ext, $allowed_types)) {
                        $new_filename = 'bail_' . $bail_id . '_' . time() . '_' . $i . '.' . $file_ext;
                        $upload_path = $upload_dir . $new_filename;
                        
                        if (move_uploaded_file($file_tmp, $upload_path)) {
                            $image_path = 'assets/img/bails/' . $new_filename;
                            $is_primary = ($i == 0) ? 1 : 0;
                            
                            $db->query(
                                "INSERT INTO bail_images (bail_id, image_path, is_primary) VALUES (?, ?, ?)",
                                $bail_id, $image_path, $is_primary
                            );
                        }
                    }
                }
            }
        }
        
        // Add notification
        notifyBailAdded($b_name, $bail_id);
        
        echo 1;
    } else {
        echo 2;
    }
}
?>
