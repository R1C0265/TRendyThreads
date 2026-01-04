<?php
require_once dirname(__DIR__) . '/config/main.php';

try {
    // Create payment_transactions table
    $createPaymentTransactions = "
        CREATE TABLE IF NOT EXISTS payment_transactions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            order_id INT NOT NULL,
            transaction_id VARCHAR(255) UNIQUE NOT NULL,
            payment_method VARCHAR(50) NOT NULL,
            amount DECIMAL(10,2) NOT NULL,
            status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
        )
    ";
    
    $db->query($createPaymentTransactions);
    echo "Payment transactions table created successfully.\n";
    
    // Add payment_status column to orders table if it doesn't exist
    // Check if column exists first
    $columnExists = $db->query("SHOW COLUMNS FROM orders LIKE 'payment_status'")->fetchArray();
    
    if (!$columnExists) {
        $addPaymentStatus = "
            ALTER TABLE orders 
            ADD COLUMN payment_status ENUM('pending', 'paid', 'failed') DEFAULT 'pending'
        ";
        $db->query($addPaymentStatus);
        echo "Payment status column added to orders table.\n";
    } else {
        echo "Payment status column already exists in orders table.\n";
    }

    
    echo "PayChangu integration database setup completed successfully!";
    
} catch (Exception $e) {
    echo "Error creating payment tables: " . $e->getMessage();
}
?>