<?php
require_once '../config/main.php';
header('Content-Type: application/json');

// Get POST data
$p_customer_id = intval($_POST['p_customer_id'] ?? 0);
$p_bail_id = intval($_POST['p_bail_id'] ?? 0);
$p_quantity = intval($_POST['p_quantity'] ?? 1);
$p_unit_price = floatval($_POST['p_unit_price'] ?? 0);
$p_status = $_POST['p_status'] ?? 'pending';
$p_payment_method = trim($_POST['p_payment_method'] ?? 'cash');
$p_purchase_date = $_POST['p_purchase_date'] ?? date('Y-m-d');
$p_notes = trim($_POST['p_notes'] ?? '');

// Validate required fields
if ($p_customer_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Customer is required']);
    exit;
}

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

// Validate allowed status values
$allowed_statuses = ['pending', 'completed', 'cancelled', 'refunded'];
if (!in_array($p_status, $allowed_statuses)) {
    $p_status = 'pending';
}

try {
    // Insert the purchase
    $query = "INSERT INTO purchases (
        p_customer_id,
        p_bail_id,
        p_quantity,
        p_unit_price,
        p_status,
        p_payment_method,
        p_purchase_date,
        p_notes
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $db->connection->prepare($query);
    
    if (!$stmt) {
        throw new Exception('Database prepare failed: ' . $db->connection->error);
    }
    
    $stmt->bind_param(
        "iiidssss",
        $p_customer_id,
        $p_bail_id,
        $p_quantity,
        $p_unit_price,
        $p_status,
        $p_payment_method,
        $p_purchase_date,
        $p_notes
    );
    
    if ($stmt->execute()) {
        $new_sale_id = $stmt->insert_id;
        
        echo json_encode([
            'success' => true, 
            'message' => 'Sale recorded successfully',
            'sale_id' => $new_sale_id
        ]);
    } else {
        throw new Exception('Failed to record sale: ' . $stmt->error);
    }
    
    $stmt->close();
    
} catch (Exception $e) {
    error_log('Sale creation error: ' . $e->getMessage());
    
    echo json_encode([
        'success' => false, 
        'message' => 'An error occurred while recording the sale. Please try again.'
    ]);
} 