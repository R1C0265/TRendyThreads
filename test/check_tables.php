<?php
require_once 'config/main.php';

echo "<h2>Database Tables Check</h2>";

// Check what tables exist
try {
    $tables = $db->query("SHOW TABLES")->fetchAll();
    echo "<h3>Existing Tables:</h3><ul>";
    foreach ($tables as $table) {
        $tableName = array_values($table)[0];
        echo "<li>$tableName</li>";
    }
    echo "</ul>";
    
    // Check if users table exists
    $userTableExists = false;
    foreach ($tables as $table) {
        if (array_values($table)[0] === 'users') {
            $userTableExists = true;
            break;
        }
    }
    
    if (!$userTableExists) {
        echo "<p><strong>❌ ISSUE FOUND: 'users' table does not exist!</strong></p>";
        echo "<p>Creating users table...</p>";
        
        $createUsers = "CREATE TABLE users (
            u_id INT AUTO_INCREMENT PRIMARY KEY,
            u_name VARCHAR(100) NOT NULL,
            u_email VARCHAR(100) UNIQUE NOT NULL,
            u_phone VARCHAR(15),
            u_password VARCHAR(255) NOT NULL,
            u_type ENUM('1', '2', '3') DEFAULT '3',
            u_address TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        $result = $db->query($createUsers);
        if ($result) {
            echo "<p>✅ Users table created successfully!</p>";
        } else {
            echo "<p>❌ Failed to create users table</p>";
        }
    } else {
        echo "<p>✅ Users table exists</p>";
        
        // Show users table structure
        $structure = $db->query("DESCRIBE users")->fetchAll();
        echo "<h3>Users Table Structure:</h3>";
        echo "<table border='1'><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>";
        foreach ($structure as $row) {
            echo "<tr><td>{$row['Field']}</td><td>{$row['Type']}</td><td>{$row['Null']}</td><td>{$row['Key']}</td></tr>";
        }
        echo "</table>";
    }
    
} catch (Exception $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>