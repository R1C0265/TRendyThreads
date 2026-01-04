<?php
// Debug script to check what's causing the 500 error
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>PHP Debug Information</h2>";
echo "<p><strong>PHP Version:</strong> " . PHP_VERSION . "</p>";
echo "<p><strong>Server:</strong> " . $_SERVER['HTTP_HOST'] . "</p>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";

echo "<h3>Extensions Check</h3>";
echo "<p>mysqli: " . (extension_loaded('mysqli') ? 'YES' : 'NO') . "</p>";
echo "<p>session: " . (extension_loaded('session') ? 'YES' : 'NO') . "</p>";

echo "<h3>File Permissions Check</h3>";
$files_to_check = [
    'config/main.php',
    'config/database.php',
    'controller/Database.php',
    'partials/header.php',
    'index.php'
];

foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        echo "<p>$file: EXISTS (readable: " . (is_readable($file) ? 'YES' : 'NO') . ")</p>";
    } else {
        echo "<p>$file: <strong>MISSING</strong></p>";
    }
}

echo "<h3>Database Connection Test</h3>";
try {
    require_once 'config/database.php';
    echo "<p>Database config loaded successfully</p>";
    echo "<p>DB_HOST: " . DB_HOST . "</p>";
    echo "<p>DB_USER: " . DB_USER . "</p>";
    echo "<p>DB_NAME: " . DB_NAME . "</p>";
    
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($connection->connect_error) {
        echo "<p><strong>Database Connection FAILED:</strong> " . $connection->connect_error . "</p>";
    } else {
        echo "<p><strong>Database Connection SUCCESS</strong></p>";
        $connection->close();
    }
} catch (Exception $e) {
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
}

echo "<h3>Session Test</h3>";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
echo "<p>Session Status: " . session_status() . "</p>";
?>