<?php
require_once '../config/main.php';

try {
    $sql = "CREATE TABLE IF NOT EXISTS notifications (
        n_id INT AUTO_INCREMENT PRIMARY KEY,
        n_type ENUM('bail_added', 'sale_completed', 'customer_registered', 'item_deleted') NOT NULL,
        n_title VARCHAR(255) NOT NULL,
        n_message TEXT NOT NULL,
        n_related_id INT,
        n_is_read BOOLEAN DEFAULT FALSE,
        n_created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_created_date (n_created_date)
    )";
    
    $db->query($sql);
    echo "Notifications table created successfully!";
} catch (Exception $e) {
    echo "Error creating notifications table: " . $e->getMessage();
}
?>