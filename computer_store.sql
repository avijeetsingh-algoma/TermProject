-- Create Database
CREATE DATABASE IF NOT EXISTS computer_store;
USE computer_store;

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT 0
);

-- Products Table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image_url VARCHAR(255),
    category VARCHAR(50),
    stock INT DEFAULT 0
);

-- Cart Table
CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    quantity INT DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Orders Table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_price DECIMAL(10,2),
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Order Items Table
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT,
    price DECIMAL(10,2),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Reviews Table (Optional/Bonus)
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    rating INT,
    comment TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Dummy Users
INSERT INTO users (name, email, password, is_admin)
VALUES 
('Admin User', 'admin@store.com', 
    '$2a$12$YQh9IYCQ0tMCNp2Y0aDUsulMRP/HqLB0RtEyBS7kYphHWg2rlMnP.', 1), -- password: admin123
('Avijeet Generic', 'avijeet@generic.com', 
    '$2a$12$hXUzyoFyV8/vtIHd7JpYMOOm.JCED4VnUpXFh5sZgzeJuYpz7LByu', 0); -- password: password

-- Dummy Products
INSERT INTO products (name, description, price, image_url, category, stock) VALUES
('Lenovo ThinkPad X1', 'High-performance business laptop with Intel i7 and 16GB RAM.', 1299.00, 'thinkpad.jpg', 'Laptop', 10),
('Dell XPS 13', 'Compact ultrabook with stunning display and Intel Evo certification.', 1199.00, 'dell_xps13.jpg', 'Laptop', 12),
('MacBook Air M2', 'Apple M2-powered ultraportable with all-day battery life.', 1399.00, 'macbook_air.jpg', 'Laptop', 8);

INSERT INTO products (name, description, price, image_url, category, stock) VALUES
('Custom Gaming PC', 'Powered by Ryzen 7 and RTX 4070 — built to dominate.', 2499.00, 'custom_desktop.jpg', 'Desktop', 5),
('HP Envy Desktop', 'All-purpose desktop with Intel i5 and 16GB RAM.', 899.00, 'hp_envy.jpg', 'Desktop', 6),
('Alienware Aurora R15', 'High-end gaming desktop with Intel i9 and RTX 4080.', 3199.00, 'alienware.jpg', 'Desktop', 4);

INSERT INTO products (name, description, price, image_url, category, stock) VALUES
('Logitech MX Master 3', 'Ergonomic wireless mouse for productivity.', 99.00, 'mouse_logi.jpg', 'Accessory', 20),
('Corsair K95 RGB Keyboard', 'Mechanical keyboard with per-key RGB and macro keys.', 179.00, 'corsair_k95.jpg', 'Accessory', 15),
('Samsung T7 SSD 1TB', 'Portable USB-C SSD with blazing-fast read/write speeds.', 129.00, 'samsung_t7.jpg', 'Accessory', 25);


