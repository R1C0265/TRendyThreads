<?php
require_once dirname(__DIR__) . '/config/main.php';

// Create bail_images table
$createBailImages = "CREATE TABLE IF NOT EXISTS bail_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bail_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_primary TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bail_id) REFERENCES bails(b_id) ON DELETE CASCADE
)";

try {
    $db->query($createBailImages);
    echo "Bail images table created successfully!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>