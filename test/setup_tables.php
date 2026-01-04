<?php
require_once 'config/main.php';

echo "<h2>Create Missing Tables</h2>";

try {
    // Create users table if it doesn't exist
    $createUsers = "CREATE TABLE IF NOT EXISTS users (
        u_id INT AUTO_INCREMENT PRIMARY KEY,
        u_name VARCHAR(100) NOT NULL,
        u_email VARCHAR(100) UNIQUE NOT NULL,
        u_phone VARCHAR(15),
        u_password VARCHAR(255) NOT NULL,
        u_type ENUM('1', '2', '3') DEFAULT '3' COMMENT '1=Admin, 2=Employee, 3=Customer',
        u_address TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_email (u_email),
        INDEX idx_type (u_type)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $db->query($createUsers);
    echo "<p>✅ Users table created/verified</p>";
    
    // Create notifications table if it doesn't exist (updated structure)
    $createNotifications = "CREATE TABLE IF NOT EXISTS notifications (
        n_id INT AUTO_INCREMENT PRIMARY KEY,
        n_type VARCHAR(50) NOT NULL,
        n_title VARCHAR(150) NOT NULL,
        n_message TEXT NOT NULL,
        n_related_id INT,
        n_user_id INT,
        n_is_read BOOLEAN DEFAULT FALSE,
        n_read_date TIMESTAMP NULL,
        n_priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
        n_created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_type (n_type),
        INDEX idx_user (n_user_id),
        INDEX idx_read (n_is_read),
        INDEX idx_created_date (n_created_date)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $db->query($createNotifications);
    echo "<p>✅ Notifications table created/verified</p>";
    
    // Insert default admin user if no users exist
    $userCount = $db->query("SELECT COUNT(*) as count FROM users")->fetchArray();
    if ($userCount['count'] == 0) {
        $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $db->query(
            "INSERT INTO users (u_name, u_email, u_password, u_type) VALUES (?, ?, ?, ?)",
            'Administrator', 'admin@trendythreads.com', $adminPassword, '1'
        );
        echo "<p>✅ Default admin user created (admin@trendythreads.com / admin123)</p>";
    }
    
    echo "<h3>✅ All tables ready! You can now test registration.</h3>";
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
}
?>