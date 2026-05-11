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

-- Demo vehicle records used by the search page.
INSERT INTO cars (seller_id, color, model, year, location, price, image, description)
VALUES
(1, 'Blue', 'Tesla Model 3', 2024, 'Beijing', 239900, 'Tesla_Model3.png', 'Clean condition and good electric range for city driving. The cabin is simple, quiet and easy to use, making it suitable for daily commuting and weekend travel.'),
(1, 'Black', 'BYD Han', 2023, 'Shanghai', 189800, 'BYD_HanL EV.png', 'Comfortable new energy sedan with low running cost. The car offers a spacious cabin, smooth acceleration and a practical choice for family use.'),
(1, 'White', 'NIO ET5', 2024, 'Guangzhou', 289800, 'NIO_ET5.png', 'Modern electric vehicle with a clean interior design and smart driving features. It is suitable for buyers looking for technology and comfort.'),
(1, 'Green', 'Audi A4 40 TFSI', 2022, 'Beijing', 215000, 'audi_a4_40tfsi.jpg', 'A premium sedan with a calm exterior design and a refined interior. It is a good choice for buyers who want a balanced car for business use and daily driving.'),
(1, 'Blue', 'BMW 3 Series 320i', 2021, 'Shanghai', 228000, 'bmw_3series_320i.jpg', 'A sporty sedan with responsive handling and a comfortable cabin. It fits buyers who care about driving feeling but still need a practical family car.'),
(1, 'White', 'Honda Civic Type R', 2020, 'Guangzhou', 298000, 'honda_civic.jpg', 'A performance focused Civic with an aggressive look and strong road presence. It is more suitable for drivers who enjoy a dynamic and energetic style.'),
(1, 'Silver', 'Mercedes-Benz C 200', 2021, 'Shenzhen', 236000, 'mercedes_c200.jpg', 'A stylish luxury sedan with a smooth driving experience and elegant interior atmosphere. It is suitable for city driving and business occasions.'),
(1, 'Red', 'Tesla Model 3', 2023, 'Hangzhou', 229000, 'tesla_model3.jpg', 'A clean and efficient electric sedan with quick acceleration and low daily running cost. The red exterior gives it a more energetic and modern appearance.'),
(1, 'Black', 'Toyota Camry', 2022, 'Chengdu', 168000, 'toyota_camry.jpg', 'A reliable midsize sedan with comfortable seats and stable driving quality. It is a practical option for families and long distance daily use.');
