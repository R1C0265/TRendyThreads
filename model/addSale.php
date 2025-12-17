<?php
require_once '../config/main.php';
require_once 'notificationHelper.php';
header('Content-Type: application/json');

// Get POST data
$p_customer_id = $_POST['p_customer_id'] ?? 0;
$p_customer_id = ($p_customer_id == 0) ? null : intval($p_customer_id); // Convert 0 to NULL for unknown customers
$p_bail_id = intval($_POST['p_bail_id'] ?? 0);
$p_quantity = intval($_POST['p_quantity'] ?? 1);
$p_unit_price = floatval($_POST['p_unit_price'] ?? 0);
$p_purchase_date = $_POST['p_purchase_date'] ?? date('Y-m-d');
$p_notes = trim($_POST['p_notes'] ?? '');

if ($p_bail_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Bail item is required']);
    exit;
}

if ($p_quantity <= 0) {
    echo json_encode(['success' => false, 'message' => 'Valid quantity is required']);
    exit;
}

if ($p_unit_price <= 0) {
    echo json_encode(['success' => false, 'message' => 'Valid price is required']);
    exit;
}

// All sales are completed when recorded
$p_status = 'completed';
$p_payment_method = 'cash'; // Default payment method

try {
    // Calculate total amount
    $total_amount = $p_quantity * $p_unit_price;
    
    // Insert the purchase using Database class (p_total_amount is auto-calculated)
    $save = $db->query(
        "INSERT INTO purchases (p_customer_id, p_bail_id, p_quantity, p_unit_price, p_status, p_payment_method, p_purchase_date, p_notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
        $p_customer_id, $p_bail_id, $p_quantity, $p_unit_price, $p_status, $p_payment_method, $p_purchase_date, $p_notes
    );
    
    if ($save) {
        $new_sale_id = $db->lastInsertID();
        
        // Get customer and bail names for notification
        if ($p_customer_id === null) {
            $customer_name = 'Unknown Customer';
        } else {
            $customer = $db->query("SELECT c_name FROM customers WHERE c_id = ?", $p_customer_id)->fetchArray();
            $customer_name = $customer['c_name'] ?? 'Unknown Customer';
        }
        $bail = $db->query("SELECT b_name FROM bails WHERE b_id = ?", $p_bail_id)->fetchArray();
        
        // Add notification
        notifySaleCompleted($customer_name, $bail['b_name'], $total_amount, $new_sale_id);
        
        echo json_encode([
            'success' => true, 
            'message' => 'Sale recorded successfully',
            'sale_id' => $new_sale_id
        ]);
    } else {
        throw new Exception('Failed to record sale');
    }
    
} catch (Exception $e) {
    error_log('Sale creation error: ' . $e->getMessage());
    
    echo json_encode([
        'success' => false, 
        'message' => 'An error occurred while recording the sale. Please try again.'
    ]);
} 