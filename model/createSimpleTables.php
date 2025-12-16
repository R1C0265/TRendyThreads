<?php
include(dirname(__DIR__) . "/config/main.php");

// Create cart table without foreign keys
$createCart = "CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Create orders table without foreign keys
$createOrders = "CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    payment_status ENUM('pending', 'paid', 'failed') DEFAULT 'pending',
    payment_method VARCHAR(50),
    shipping_address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Create order_items table without foreign keys
$createOrderItems = "CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL
)";

try {
    $db->query($createCart);
    echo "Cart table created successfully\n";
    
    $db->query($createOrders);
    echo "Orders table created successfully\n";
    
    $db->query($createOrderItems);
    echo "Order items table created successfully\n";
    
    // Insert sample products using existing table structure
    $sampleProducts = [
        ["Trendy T-Shirt", "Comfortable cotton t-shirt with modern design", "29.99", "Clothing", "29.99", "assets/img/products/tshirt1.jpg", "Trendy T-Shirt"],
        ["Designer Jeans", "Premium denim jeans with perfect fit", "89.99", "Clothing", "89.99", "assets/img/products/jeans1.jpg", "Designer Jeans"],
        ["Summer Dress", "Elegant summer dress for all occasions", "59.99", "Clothing", "59.99", "assets/img/products/dress1.jpg", "Summer Dress"],
        ["Casual Sneakers", "Comfortable sneakers for everyday wear", "79.99", "Footwear", "79.99", "assets/img/products/shoes1.jpg", "Casual Sneakers"],
        ["Fashion Jacket", "Stylish jacket for cool weather", "129.99", "Clothing", "129.99", "assets/img/products/jacket1.jpg", "Fashion Jacket"],
        ["Accessories Set", "Complete accessories set with bag and jewelry", "49.99", "Accessories", "49.99", "assets/img/products/accessories1.jpg", "Accessories Set"]
    ];
    
    foreach ($sampleProducts as $product) {
        $db->query("INSERT INTO products (product_name, product_description, product_amount, product_category, product_price, product_image_location, product_image_alt) VALUES (?, ?, ?, ?, ?, ?, ?)", $product[0], $product[1], $product[2], $product[3], $product[4], $product[5], $product[6]);
    }
    echo "Sample products inserted successfully\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>