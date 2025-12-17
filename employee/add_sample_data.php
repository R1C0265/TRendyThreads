<?php
require_once '../config/main.php';

// Clear existing sample data first
$db->query("DELETE FROM orders WHERE user_id = 1");

// Add sample orders for demonstration
$sampleOrders = [
    // This week's data (current dates)
    [date('Y-m-d'), 15000, 'demo'],
    [date('Y-m-d', strtotime('-1 day')), 25000, 'stripe'],
    [date('Y-m-d', strtotime('-2 days')), 18000, 'paypal'],
    [date('Y-m-d', strtotime('-3 days')), 32000, 'demo'],
    [date('Y-m-d', strtotime('-4 days')), 12000, 'stripe'],
    [date('Y-m-d', strtotime('-5 days')), 28000, 'demo'],
    [date('Y-m-d', strtotime('-6 days')), 22000, 'paypal'],
    
    // Previous months this year
    [date('Y') . '-11-15', 45000, 'stripe'],
    [date('Y') . '-11-10', 35000, 'demo'],
    [date('Y') . '-10-20', 55000, 'paypal'],
    [date('Y') . '-10-05', 40000, 'stripe'],
    [date('Y') . '-09-25', 30000, 'demo'],
    [date('Y') . '-08-15', 65000, 'stripe'],
    [date('Y') . '-07-10', 50000, 'paypal'],
    [date('Y') . '-06-20', 38000, 'demo'],
    [date('Y') . '-05-15', 42000, 'stripe'],
    [date('Y') . '-04-10', 33000, 'paypal'],
    [date('Y') . '-03-25', 48000, 'demo'],
    [date('Y') . '-02-15', 28000, 'stripe'],
    [date('Y') . '-01-20', 35000, 'paypal']
];

foreach ($sampleOrders as $order) {
    $db->query(
        "INSERT INTO orders (user_id, total_amount, payment_method, status, created_at) VALUES (?, ?, ?, 'delivered', ?)",
        1, $order[1], $order[2], $order[0]
    );
}

echo "Sample data added successfully! Go back to dashboard to see the charts with data.";
?>