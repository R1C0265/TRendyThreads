<?php
require_once 'config/main.php';

echo "<h2>Fix Users Table - Add u_phone Column</h2>";

try {
    // Check current table structure
    echo "<h3>Current users table structure:</h3>";
    $ structure = $db->query("DESCRIBE users")->fetchAll();
    echo "<table border='1'><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>";
    foreach ($structure as $row) {
        echo "<tr><td>{$row['Field']}</td><td>{$row['Type']}</td><td>{$row['Null']}</td><td>{$row['Key']}</td></tr>";
    }
    echo "</table>";
    
    // Check if u_phone column exists
    $hasPhone = false;
    foreach ($structure as $row) {
        if ($row['Field'] === 'u_phone') {
            $hasPhone = true;
            break;
        }
    }
    
    if (!$hasPhone) {
        echo "<p>❌ u_phone column missing. Adding it now...</p>";
        
        // Add u_phone column
        $addColumn = $db->query("ALTER TABLE users ADD COLUMN u_phone VARCHAR(15) NULL AFTER u_email");
        
        if ($addColumn) {
            echo "<p>✅ u_phone column added successfully!</p>";
        } else {
            echo "<p>❌ Failed to add u_phone column</p>";
        }
    } else {
        echo "<p>✅ u_phone column already exists</p>";
    }
    
    // Show updated structure
    echo "<h3>Updated users table structure:</h3>";
    $newStructure = $db->query("DESCRIBE users")->fetchAll();
    echo "<table border='1'><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>";
    foreach ($newStructure as $row) {
        echo "<tr><td>{$row['Field']}</td><td>{$row['Type']}</td><td>{$row['Null']}</td><td>{$row['Key']}</td></tr>";
    }
    echo "</table>";
    
    echo "<p><strong>✅ Users table is now ready for registration!</strong></p>";
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
}
?>