<?php
include(dirname(__DIR__) . "/config/main.php");

// Create products table
$createProducts = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image_path VARCHAR(255),
    category VARCHAR(100),
    stock_quantity INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

// Create cart table
$createCart = "CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
)";

// Create orders table
$createOrders = "CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    payment_status ENUM('pending', 'paid', 'failed') DEFAULT 'pending',
    payment_method VARCHAR(50),
    shipping_address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

// Create order_items table
$createOrderItems = "CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
)";

try {
    $db->query($createProducts);
    echo "Products table created successfully\n";
    
    $db->query($createCart);
    echo "Cart table created successfully\n";
    
    $db->query($createOrders);
    echo "Orders table created successfully\n";
    
    $db->query($createOrderItems);
    echo "Order items table created successfully\n";
    
    // Insert sample products
    $sampleProducts = [
        ["Trendy T-Shirt", "Comfortable cotton t-shirt with modern design", 29.99, "assets/img/products/tshirt1.jpg", "Clothing", 50],
        ["Designer Jeans", "Premium denim jeans with perfect fit", 89.99, "assets/img/products/jeans1.jpg", "Clothing", 30],
        ["Summer Dress", "Elegant summer dress for all occasions", 59.99, "assets/img/products/dress1.jpg", "Clothing", 25],
        ["Casual Sneakers", "Comfortable sneakers for everyday wear", 79.99, "assets/img/products/shoes1.jpg", "Footwear", 40],
        ["Fashion Jacket", "Stylish jacket for cool weather", 129.99, "assets/img/products/jacket1.jpg", "Clothing", 20],
        ["Accessories Set", "Complete accessories set with bag and jewelry", 49.99, "assets/img/products/accessories1.jpg", "Accessories", 35]
    ];
    
    foreach ($sampleProducts as $product) {
        $db->query("INSERT INTO products (name, description, price, image_path, category, stock_quantity) VALUES (?, ?, ?, ?, ?, ?)", $product);
    }
    echo "Sample products inserted successfully\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>