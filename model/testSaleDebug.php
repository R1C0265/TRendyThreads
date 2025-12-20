<?php
require_once '../config/main.php';

// Test data - simulating form submission
$_POST = [
    'p_customer_id' => '0', // Unknown customer
    'p_bail_id' => '1', // Assuming bail ID 1 exists
    'p_quantity' => '1',
    'p_unit_price' => '', // Empty to test auto-fill
    'p_payment_method' => 'cash',
    'p_purchase_date' => date('Y-m-d'),
    'p_notes' => 'Debug test sale'
];

echo "Testing sale creation...\n";
echo "POST data: " . print_r($_POST, true) . "\n";

// Check if bail exists and has price
$bail = $db->query("SELECT b_id, b_name, b_avg_price_per_item FROM bails WHERE b_id = ? AND b_status = 'available'", 1)->fetchArray();
echo "Bail data: " . print_r($bail, true) . "\n";

// Include addSale.php to test
ob_start();
include 'addSale.php';
$output = ob_get_clean();

echo "Output: " . $output . "\n";
?>