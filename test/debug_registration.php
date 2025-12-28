<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Registration Debug - Exact Error Capture</h2>";

// Test the exact data you provided
$test_data = [
    'u_name' => 'John Pagaja',
    'u_email' => 'jp@email.com', 
    'u_phone' => '0997835428',
    'u_address' => 'Soche East House No 27',
    'u_password' => '00000000',
    'u_type' => '3'
];

echo "<h3>Testing with your exact data:</h3>";
foreach ($test_data as $key => $value) {
    echo "<p><strong>$key:</strong> $value</p>";
}

// Simulate the addUser.php process step by step
try {
    require_once 'config/main.php';
    echo "<p>✅ Config loaded</p>";
    
    require_once 'model/notificationHelper.php';
    echo "<p>✅ Notification helper loaded</p>";
    
    // Check if email exists
    $existing = $db->query("SELECT u_id FROM users WHERE u_email = ?", $test_data['u_email'])->fetchArray();
    if ($existing) {
        echo "<p>❌ Email already exists in database</p>";
        exit;
    } else {
        echo "<p>✅ Email is unique</p>";
    }
    
    // Hash password
    $hashed_password = password_hash($test_data['u_password'], PASSWORD_DEFAULT);
    echo "<p>✅ Password hashed: " . substr($hashed_password, 0, 20) . "...</p>";
    
    // Try the insert
    echo "<h3>Attempting database insert...</h3>";
    $save = $db->query(
        "INSERT INTO users (u_name, u_email, u_phone, u_password, u_type, u_address) VALUES (?, ?, ?, ?, ?, ?)",
        $test_data['u_name'], 
        $test_data['u_email'], 
        $test_data['u_phone'], 
        $hashed_password, 
        $test_data['u_type'], 
        $test_data['u_address']
    );
    
    if ($save) {
        $user_id = $db->lastInsertID();
        echo "<p>✅ User inserted successfully with ID: $user_id</p>";
        
        // Test notification
        try {
            notifyUserRegistered($test_data['u_name'], $user_id);
            echo "<p>✅ Notification created</p>";
        } catch (Exception $e) {
            echo "<p>⚠️ Notification failed: " . $e->getMessage() . "</p>";
        }
        
        echo "<p><strong>✅ REGISTRATION SHOULD WORK - Response: 1</strong></p>";
        
        // Clean up test user
        $db->query("DELETE FROM users WHERE u_id = ?", $user_id);
        echo "<p>🧹 Test user cleaned up</p>";
        
    } else {
        echo "<p>❌ Database insert failed</p>";
        echo "<p><strong>❌ REGISTRATION FAILED - Response: 2</strong></p>";
    }
    
} catch (Exception $e) {
    echo "<p>❌ <strong>ERROR:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
}

echo "<hr>";
echo "<h3>Direct addUser.php Test</h3>";
echo "<p>Now test the actual addUser.php file:</p>";
?>

<form method="POST" action="model/addUser.php" target="_blank">
    <input type="hidden" name="u_name" value="John Pagaja Test">
    <input type="hidden" name="u_email" value="jptest<?php echo time(); ?>@email.com">
    <input type="hidden" name="u_phone" value="0997835428">
    <input type="hidden" name="u_address" value="Soche East House No 27">
    <input type="hidden" name="u_password" value="00000000">
    <input type="hidden" name="u_type" value="3">
    <button type="submit">Test addUser.php Directly</button>
</form>