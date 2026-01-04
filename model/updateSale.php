<?php
require_once '../config/main.php';
require_once 'notificationHelper.php';
header('Content-Type: application/json');

// Get POST data
$sale_id = intval($_POST['sale_id'] ?? 0);
$status = $_POST['status'] ?? '';
$payment_method = $_POST['payment_method'] ?? '';
$notes = trim($_POST['notes'] ?? '');

if ($sale_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid sale ID']);
    exit;
}

// Validate status
$allowed_statuses = ['pending', 'completed', 'cancelled'];
if (!in_array($status, $allowed_statuses)) {
    echo json_encode(['success' => false, 'message' => 'Invalid status']);
    exit;
}

// Validate payment method
$allowed_methods = ['cash', 'credit'];
if (!in_array($payment_method, $allowed_methods)) {
    echo json_encode(['success' => false, 'message' => 'Invalid payment method']);
    exit;
}

try {
    // Check if sale exists and is credit transaction
    $sale = $db->query("SELECT p_payment_method, p_status FROM purchases WHERE p_id = ?", $sale_id)->fetchArray();
    
    if (!$sale) {
        echo json_encode(['success' => false, 'message' => 'Sale not found']);
        exit;
    }
    
    // Only allow editing of credit transactions
    if ($sale['p_payment_method'] !== 'credit') {
        echo json_encode(['success' => false, 'message' => 'Only credit transactions can be edited']);
        exit;
    }
    
    // Update the sale
    $update = $db->query(
        "UPDATE purchases SET p_status = ?, p_payment_method = ?, p_notes = ? WHERE p_id = ?",
        $status, $payment_method, $notes, $sale_id
    );
    
    if ($update) {
        // Add notification for status change if changed
        if ($sale['p_status'] !== $status) {
            addNotification(
                'sale_completed',
                'Credit Sale Updated',
                "Sale #$sale_id status changed from {$sale['p_status']} to $status",
                $sale_id
            );
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Sale updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update sale');
    }
    
} catch (Exception $e) {
    error_log('Sale update error: ' . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred while updating the sale'
    ]);
}
?>