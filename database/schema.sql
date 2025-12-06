-- SQL Schema for Catalogue Database
-- Database: catalogue_db

-- Categories Table
CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `description` TEXT,
  `parent_id` INT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_slug` (`slug`),
  KEY `idx_parent` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Products Table
CREATE TABLE IF NOT EXISTS `products` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `category_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `short_description` VARCHAR(512),
  `description` TEXT,
  `price` DECIMAL(10,2) NOT NULL,
  `sku` VARCHAR(100) UNIQUE,
  `status` VARCHAR(50) DEFAULT 'active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_category` (`category_id`),
  KEY `idx_slug` (`slug`),
  KEY `idx_status` (`status`),
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Product Images Table
CREATE TABLE IF NOT EXISTS `product_images` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `product_id` INT NOT NULL,
  `image_url` VARCHAR(1024) NOT NULL,
  `alt_text` VARCHAR(255),
  `is_primary` TINYINT(1) DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_product` (`product_id`),
  KEY `idx_primary` (`is_primary`),
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Contacts Table
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `subject` VARCHAR(255),
  `message` TEXT NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `status` VARCHAR(50) DEFAULT 'new',
  `ip_address` VARCHAR(45),
  `user_agent` VARCHAR(255),
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample Categories
INSERT INTO `categories` (`name`, `slug`, `description`) VALUES
('Electronics', 'electronics', 'Electronic devices and gadgets'),
('Fashion', 'fashion', 'Clothing and fashion accessories'),
('Home', 'home', 'Home furniture and decor'),
('Accessories', 'accessories', 'Various accessories');

-- Sample Products
INSERT INTO `products` (`category_id`, `name`, `slug`, `short_description`, `description`, `price`, `sku`, `status`) VALUES
(1, 'Wireless Headphones Pro', 'wireless-headphones-pro', 'Premium wireless headphones with noise cancellation', 'High-quality wireless headphones featuring active noise cancellation, 30-hour battery life, and premium sound quality.', 1499000.00, 'WH-PRO-001', 'active'),
(4, 'Minimalist Watch', 'minimalist-watch', 'Elegant minimalist design watch', 'Sleek and stylish minimalist watch with premium leather strap and Japanese movement.', 2199000.00, 'MW-001', 'active'),
(2, 'Premium Backpack', 'premium-backpack', 'Stylish and functional backpack', 'Durable backpack with multiple compartments, laptop sleeve, and water-resistant material.', 899000.00, 'BP-001', 'active'),
(1, 'Smart Speaker', 'smart-speaker', 'Voice-controlled smart speaker', 'AI-powered smart speaker with premium audio and smart home integration.', 1299000.00, 'SS-001', 'active'),
(3, 'Leather Sofa', 'leather-sofa', 'Modern leather sofa for living room', 'Comfortable 3-seater leather sofa with contemporary design and premium materials.', 8999000.00, 'LS-001', 'active'),
(4, 'Leather Wallet', 'leather-wallet', 'Genuine leather wallet with card slots', 'Handcrafted genuine leather wallet with RFID protection and multiple card slots.', 599000.00, 'LW-001', 'active');

-- Sample Product Images
INSERT INTO `product_images` (`product_id`, `image_url`, `alt_text`, `is_primary`) VALUES
(1, 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=300&fit=crop', 'Wireless Headphones Pro', 1),
(2, 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop', 'Minimalist Watch', 1),
(3, 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&h=300&fit=crop', 'Premium Backpack', 1),
(4, 'https://images.unsplash.com/photo-1543512214-318c7553f230?w=400&h=300&fit=crop', 'Smart Speaker', 1),
(5, 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=400&h=300&fit=crop', 'Leather Sofa', 1),
(6, 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=400&h=300&fit=crop', 'Leather Wallet', 1);
