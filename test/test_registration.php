<?php
// Test user registration functionality
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>User Registration Debug Test</h2>";

// Test 1: Check if files exist
echo "<h3>1. File Existence Check</h3>";
$files = [
    'config/main.php',
    'model/addUser.php', 
    'model/notificationHelper.php',
    'controller/Database.php'
];

foreach ($files as $file) {
    echo "<p>$file: " . (file_exists($file) ? "✓ EXISTS" : "✗ MISSING") . "</p>";
}

// Test 2: Database connection
echo "<h3>2. Database Connection Test</h3>";
try {
    require_once 'config/main.php';
    echo "<p>✓ Config loaded successfully</p>";
    echo "<p>✓ Database connection established</p>";
} catch (Exception $e) {
    echo "<p>✗ Error: " . $e->getMessage() . "</p>";
}

// Test 3: Check users table structure
echo "<h3>3. Users Table Structure</h3>";
try {
    $result = $db->query("DESCRIBE users")->fetchAll();
    if ($result) {
        echo "<table border='1'><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>";
        foreach ($result as $row) {
            echo "<tr><td>{$row['Field']}</td><td>{$row['Type']}</td><td>{$row['Null']}</td><td>{$row['Key']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>✗ Users table not found</p>";
    }
} catch (Exception $e) {
    echo "<p>✗ Error checking table: " . $e->getMessage() . "</p>";
}

// Test 4: Test user insertion directly
echo "<h3>4. Direct User Insertion Test</h3>";
try {
    $test_name = "Test User " . time();
    $test_email = "test" . time() . "@example.com";
    $test_password = password_hash("testpass123", PASSWORD_DEFAULT);
    
    $result = $db->query(
        "INSERT INTO users (u_name, u_email, u_password, u_type) VALUES (?, ?, ?, ?)",
        $test_name, $test_email, $test_password, '3'
    );
    
    if ($result) {
        $user_id = $db->lastInsertID();
        echo "<p>✓ User inserted successfully with ID: $user_id</p>";
        
        // Clean up test user
        $db->query("DELETE FROM users WHERE u_id = ?", $user_id);
        echo "<p>✓ Test user cleaned up</p>";
    } else {
        echo "<p>✗ Failed to insert user</p>";
    }
} catch (Exception $e) {
    echo "<p>✗ Error inserting user: " . $e->getMessage() . "</p>";
}

// Test 5: Test addUser.php directly
echo "<h3>5. Test addUser.php Response</h3>";
echo "<form method='POST' action='model/addUser.php' target='_blank'>";
echo "<input type='hidden' name='u_name' value='Debug Test User'>";
echo "<input type='hidden' name='u_email' value='debug" . time() . "@test.com'>";
echo "<input type='hidden' name='u_password' value='testpass123'>";
echo "<input type='hidden' name='u_type' value='3'>";
echo "<button type='submit'>Test addUser.php directly</button>";
echo "</form>";

echo "<h3>6. Registration Form Test</h3>";
echo "<p>Try the registration form below:</p>";
?>

<form id="testRegisterForm">
    <p><input type="text" name="u_name" placeholder="Full Name" required></p>
    <p><input type="email" name="u_email" placeholder="Email" required></p>
    <p><input type="tel" name="u_phone" placeholder="Phone"></p>
    <p><textarea name="u_address" placeholder="Address"></textarea></p>
    <p><input type="password" name="u_password" placeholder="Password" required></p>
    <p><button type="submit">Test Register</button></p>
</form>

<div id="testResult"></div>

<script src="assets/js/jquery-3.7.1.min.js"></script>
<script>
$('#testRegisterForm').on('submit', function(e) {
    e.preventDefault();
    
    $.ajax({
        url: 'model/addUser.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            $('#testResult').html('<p><strong>Response:</strong> ' + response + '</p>');
            console.log('Response:', response);
        },
        error: function(xhr, status, error) {
            $('#testResult').html('<p><strong>Error:</strong> ' + error + '</p>');
            console.log('Error:', xhr.responseText);
        }
    });
});
</script>