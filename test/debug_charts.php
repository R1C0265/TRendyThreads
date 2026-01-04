<?php
require_once '../config/main.php';

echo "<h3>Debug Chart Data</h3>";

// Check if orders table exists and show structure
echo "<h4>Orders Table Structure:</h4>";
try {
    $result = $db->query("DESCRIBE orders")->fetchAll();
    echo "<pre>";
    print_r($result);
    echo "</pre>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}

// Check orders data
echo "<h4>Orders Data:</h4>";
try {
    $orders = $db->query("SELECT * FROM orders LIMIT 5")->fetchAll();
    echo "<pre>";
    print_r($orders);
    echo "</pre>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}

// Test the exact queries from dashboard
echo "<h4>Today's Sales Query:</h4>";
try {
    $todaySales = $db->query("SELECT COALESCE(SUM(total_amount), 0) as total FROM orders WHERE DATE(created_at) = CURDATE()")->fetchArray();
    echo "<pre>";
    print_r($todaySales);
    echo "</pre>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}

echo "<h4>Weekly Sales Query:</h4>";
try {
    $weeklySales = $db->query("
        SELECT DATE(created_at) as sale_date, COALESCE(SUM(total_amount), 0) as daily_total
        FROM orders 
        WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        GROUP BY DATE(created_at)
        ORDER BY sale_date
    ")->fetchAll();
    echo "<pre>";
    print_r($weeklySales);
    echo "</pre>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}
?>