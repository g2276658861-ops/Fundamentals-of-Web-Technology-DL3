CREATE DATABASE IF NOT EXISTS car_database
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;

USE car_database;

DROP TABLE IF EXISTS verification_codes;
DROP TABLE IF EXISTS cars;
DROP TABLE IF EXISTS sellers;

CREATE TABLE sellers (
    seller_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) NOT NULL,
    address VARCHAR(160) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    username VARCHAR(60) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cars (
    car_id INT AUTO_INCREMENT PRIMARY KEY,
    seller_id INT NOT NULL,
    color VARCHAR(40) NOT NULL,
    model VARCHAR(100) NOT NULL,
    year INT NOT NULL,
    location VARCHAR(100) NOT NULL,
    price DECIMAL(12, 2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_cars_seller
        FOREIGN KEY (seller_id) REFERENCES sellers(seller_id)
        ON DELETE CASCADE
);

CREATE TABLE verification_codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    target VARCHAR(100) NOT NULL,
    type ENUM('email', 'phone') NOT NULL,
    code VARCHAR(10) NOT NULL,
    expires_at DATETIME NOT NULL,
    is_used TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Demo seller account:
-- username: demo_seller
-- password: demo123
INSERT INTO sellers (name, address, phone, email, username, password_hash)
VALUES
('Demo Seller', 'Beijing Chaoyang', '13800138000', 'demo@example.com', 'demo_seller', '$2y$12$WjGnGfc.rs41IoXrstYW..i.WdSRS3LHLscWuXj0tUDMF3myb7YT6');

INSERT INTO cars (seller_id, color, model, year, location, price, image, description)
VALUES
(1, 'Blue', 'Tesla Model 3', 2024, 'Beijing', 239900, 'Tesla_Model3.png', 'Clean condition and good range for city driving.'),
(1, 'Black', 'BYD Han', 2023, 'Shanghai', 189800, 'BYD_HanL EV.png', 'Comfortable sedan with low running cost.'),
(1, 'White', 'NIO ET5', 2024, 'Guangzhou', 289800, 'NIO_ET5.png', 'New energy vehicle with modern interior.');
