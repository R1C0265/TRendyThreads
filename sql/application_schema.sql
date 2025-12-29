-- ============================================
-- Trendy Threads Application Database Schema
-- ============================================

-- Drop existing tables if they exist (for clean reinstall)
DROP TABLE IF EXISTS notifications;
DROP TABLE IF EXISTS purchases;
DROP TABLE IF EXISTS bails;
DROP TABLE IF EXISTS customers;

-- ============================================
-- CUSTOMERS TABLE
-- ============================================
CREATE TABLE customers (
    c_id INT AUTO_INCREMENT PRIMARY KEY,
    c_name VARCHAR(100) NOT NULL,
    c_email VARCHAR(100) UNIQUE NOT NULL,
    c_phone VARCHAR(15),
    c_address VARCHAR(255),
    c_city VARCHAR(50),
    c_state VARCHAR(50),
    c_zip VARCHAR(10),
    c_country VARCHAR(50) DEFAULT 'USA',
    c_joined_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    c_status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    c_notes TEXT,
    CREATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UPDATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (c_email),
    INDEX idx_status (c_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- BAILS TABLE
-- ============================================
CREATE TABLE bails (
    b_id INT AUTO_INCREMENT PRIMARY KEY,
    b_name VARCHAR(150) NOT NULL,
    b_items_count INT NOT NULL DEFAULT 1,
    b_avg_price_per_item DECIMAL(10, 2) NOT NULL,
    b_total_value DECIMAL(12, 2) GENERATED ALWAYS AS (b_items_count * b_avg_price_per_item) STORED,
    b_purchase_date DATE NOT NULL,
    b_description TEXT,
    b_status ENUM('unopened', 'available', 'sold') DEFAULT 'unopened',
    b_stock_quantity INT DEFAULT 1,
    b_created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    b_updated_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CREATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UPDATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (b_status),
    INDEX idx_purchase_date (b_purchase_date),
    INDEX idx_name (b_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- PURCHASES TABLE
-- Combines Bails and Customers
-- ============================================
CREATE TABLE purchases (
    p_id INT AUTO_INCREMENT PRIMARY KEY,
    p_customer_id INT NOT NULL,
    p_bail_id INT NOT NULL,
    p_quantity INT NOT NULL DEFAULT 1,
    p_unit_price DECIMAL(10, 2) NOT NULL,
    p_total_amount DECIMAL(12, 2) GENERATED ALWAYS AS (p_quantity * p_unit_price) STORED,
    p_purchase_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    p_status ENUM('pending', 'completed', 'cancelled', 'refunded') DEFAULT 'pending',
    p_payment_method VARCHAR(50) DEFAULT 'cash',
    p_notes TEXT,
    CREATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UPDATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (p_customer_id) REFERENCES customers(c_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (p_bail_id) REFERENCES bails(b_id) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX idx_customer (p_customer_id),
    INDEX idx_bail (p_bail_id),
    INDEX idx_status (p_status),
    INDEX idx_purchase_date (p_purchase_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- NOTIFICATIONS TABLE
-- For system activities and events
-- ============================================
CREATE TABLE notifications (
    n_id INT AUTO_INCREMENT PRIMARY KEY,
    n_type VARCHAR(50) NOT NULL,
    n_title VARCHAR(150) NOT NULL,
    n_message TEXT NOT NULL,
    n_related_entity VARCHAR(50),
    n_related_id INT,
    n_customer_id INT,
    n_is_read BOOLEAN DEFAULT FALSE,
    n_read_date TIMESTAMP NULL,
    n_priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    n_created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CREATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_type (n_type),
    INDEX idx_customer (n_customer_id),
    INDEX idx_read (n_is_read),
    INDEX idx_priority (n_priority),
    INDEX idx_created_date (n_created_date),
    FOREIGN KEY (n_customer_id) REFERENCES customers(c_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- SAMPLE DATA (Optional - for testing)
-- ============================================

-- Insert Sample Customers
INSERT INTO customers (c_name, c_email, c_phone, c_address, c_city, c_state, c_zip, c_country, c_status) VALUES
('John Smith', 'john@example.com', '555-0101', '123 Main St', 'New York', 'NY', '10001', 'USA', 'active'),
('Sarah Johnson', 'sarah@example.com', '555-0102', '456 Oak Ave', 'Los Angeles', 'CA', '90001', 'USA', 'active'),
('Michael Brown', 'michael@example.com', '555-0103', '789 Pine Rd', 'Chicago', 'IL', '60601', 'USA', 'active'),
('Emily Davis', 'emily@example.com', '555-0104', '321 Elm St', 'Houston', 'TX', '77001', 'USA', 'active'),
('David Wilson', 'david@example.com', '555-0105', '654 Maple Dr', 'Phoenix', 'AZ', '85001', 'USA', 'inactive');

-- Insert Sample Bails
INSERT INTO bails (b_name, b_items_count, b_avg_price_per_item, b_purchase_date, b_description, b_status, b_stock_quantity) VALUES
('Summer Collection Bundle', 50, 25.99, '2025-11-01', 'Assorted summer dresses and tops', 'available', 15),
('Winter Jacket Pack', 30, 45.50, '2025-10-15', 'Premium winter jackets', 'available', 8),
('Denim Essentials', 75, 18.75, '2025-11-05', 'Various denim pants and jeans', 'available', 20),
('Casual Wear Bundle', 60, 22.00, '2025-10-20', 'T-shirts and casual wear', 'unopened', 25),
('Formal Wear Collection', 25, 65.00, '2025-09-30', 'Suits and formal attire', 'sold', 0);

-- Insert Sample Purchases
INSERT INTO purchases (p_customer_id, p_bail_id, p_quantity, p_unit_price, p_status, p_payment_method) VALUES
(1, 1, 2, 25.99, 'completed', 'credit_card'),
(2, 2, 1, 45.50, 'completed', 'cash'),
(3, 3, 3, 18.75, 'completed', 'debit_card'),
(4, 4, 1, 22.00, 'pending', 'check'),
(5, 1, 1, 25.99, 'cancelled', 'cash');

-- Insert Sample Notifications
INSERT INTO notifications (n_type, n_title, n_message, n_related_entity, n_related_id, n_customer_id, n_priority) VALUES
('new_bail', 'New Bail Available', 'Summer Collection Bundle is now available for purchase!', 'bail', 1, NULL, 'high'),
('purchase_completed', 'Purchase Confirmed', 'Your order for Winter Jacket Pack has been completed.', 'purchase', 1, 1, 'medium'),
('new_customer', 'Welcome!', 'Welcome to Trendy Threads, Sarah!', 'customer', 2, 2, 'medium'),
('low_stock', 'Low Stock Alert', 'Summer Collection Bundle is running low on stock.', 'bail', 1, NULL, 'high'),
('purchase_pending', 'Payment Pending', 'Your order for Casual Wear Bundle is awaiting payment.', 'purchase', 4, 4, 'medium');

-- ============================================
-- DISPLAY TABLE INFORMATION
-- ============================================
SHOW TABLES;
SHOW CREATE TABLE customers;
SHOW CREATE TABLE bails;
SHOW CREATE TABLE purchases;
SHOW CREATE TABLE notifications;
