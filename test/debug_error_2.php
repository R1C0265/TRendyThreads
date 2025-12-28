<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Detailed Registration Error Debug</h2>";

// Test with exact registration data
$_POST = [
    'u_name' => 'John Pagaja',
    'u_email' => 'jp@email.com',
    'u_phone' => '0997835428', 
    'u_address' => 'Soche East House No 27',
    'u_password' => '00000000',
    'u_type' => '3'
];

echo "<h3>Simulating addUser.php with exact POST data:</h3>";

try {
    require_once 'config/main.php';
    echo "<p>✅ Config loaded</p>";
    
    // Check if users table exists and has correct structure
    echo "<h3>Checking users table structure:</h3>";
    $structure = $db->query("DESCRIBE users")->fetchAll();
    echo "<table border='1'><tr><th>Field</th><th>Type</th><th>Null</th></tr>";
    foreach ($structure as $row) {
        echo "<tr><td>{$row['Field']}</td><td>{$row['Type']}</td><td>{$row['Null']}</td></tr>";
    }
    echo "</table>";
    
    // Test each step of addUser.php
    $u_name = $_POST['u_name'] ?? null;
    $u_email = $_POST['u_email'] ?? null;
    $u_phone = $_POST['u_phone'] ?? null;
    $u_password = $_POST['u_password'] ?? null;
    $u_type = $_POST['u_type'] ?? '3';
    $u_address = $_POST['u_address'] ?? null;

    echo "<p>✅ POST data extracted</p>";

    // Validate required fields
    if (empty($u_name) || empty($u_email) || empty($u_password)) {
        echo "<p>❌ Missing required fields</p>";
        exit;
    }
    echo "<p>✅ Required fields validated</p>";

    // Hash password
    $hashed_password = password_hash($u_password, PASSWORD_DEFAULT);
    echo "<p>✅ Password hashed</p>";

    // Check if email exists
    $existing = $db->query("SELECT u_id FROM users WHERE u_email = ?", $u_email)->fetchArray();
    if ($existing) {
        echo "<p>❌ Email already exists: " . $u_email . "</p>";
        exit;
    }
    echo "<p>✅ Email is unique</p>";

    // Try the exact insert query
    echo "<h3>Testing database insert:</h3>";
    echo "<p><strong>Query:</strong> INSERT INTO users (u_name, u_email, u_phone, u_password, u_type, u_address) VALUES (?, ?, ?, ?, ?, ?)</p>";
    echo "<p><strong>Values:</strong> '$u_name', '$u_email', '$u_phone', '[hashed]', '$u_type', '$u_address'</p>";
    
    $save = $db->query(
        "INSERT INTO users (u_name, u_email, u_phone, u_password, u_type, u_address) VALUES (?, ?, ?, ?, ?, ?)",
        $u_name, $u_email, $u_phone, $hashed_password, $u_type, $u_address
    );
    
    if ($save) {
        $user_id = $db->lastInsertID();
        echo "<p>✅ User inserted successfully with ID: $user_id</p>";
        echo "<p><strong>✅ REGISTRATION WORKS - Should return: 1</strong></p>";
        
        // Clean up
        $db->query("DELETE FROM users WHERE u_id = ?", $user_id);
        echo "<p>🧹 Test user cleaned up</p>";
    } else {
        echo "<p>❌ Database insert failed</p>";
        echo "<p><strong>❌ This is why you get response: 2</strong></p>";
    }

} catch (Exception $e) {
    echo "<p>❌ <strong>EXCEPTION:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
    echo "<p><strong>This is why you get response: 2</strong></p>";
}

echo "<hr>";
echo "<h3>Check Error Logs</h3>";
echo "<p>Also check your server error logs for more details.</p>";
?>