<?php
// Database configuration for different environments

// Detect environment (you can also use $_SERVER variables)
$isLocal = (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || 
           strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false ||
           strpos($_SERVER['HTTP_HOST'], '.local') !== false);

if ($isLocal) {
    // Local development settings
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '085213');
    define('DB_NAME', 'trendy_threads');
} else {
    // Production settings - UPDATE THESE WITH YOUR HOSTING PROVIDER'S DETAILS
    define('DB_HOST', 'localhost'); // Usually localhost for shared hosting
    define('DB_USER', 'your_db_username'); // Your hosting database username
    define('DB_PASS', 'your_db_password'); // Your hosting database password
    define('DB_NAME', 'your_db_name'); // Your hosting database name
}

// Set environment variables for Database class
$_ENV['DB_HOST'] = DB_HOST;
$_ENV['DB_USER'] = DB_USER;
$_ENV['DB_PASS'] = DB_PASS;
$_ENV['DB_NAME'] = DB_NAME;
?>