-- Setup Admin Management System
-- This script creates the admins table and inserts default data

-- Create admins table
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `role` enum('super_admin','admin','moderator') NOT NULL DEFAULT 'admin',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user
INSERT IGNORE INTO `admins` (`username`, `email`, `password`, `full_name`, `phone`, `role`, `is_active`, `created_at`, `updated_at`) VALUES
('admin', 'admin@wardati.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Super Administrator', '081234567890', 'super_admin', 1, NOW(), NOW());

-- Insert sample admin users for testing
INSERT IGNORE INTO `admins` (`username`, `email`, `password`, `full_name`, `phone`, `role`, `is_active`, `created_at`, `updated_at`) VALUES
('manager', 'manager@wardati.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Manager Wardati', '081234567891', 'admin', 1, NOW(), NOW()),
('staff', 'staff@wardati.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Staff Wardati', '081234567892', 'moderator', 1, NOW(), NOW());

-- Show the created table structure
DESCRIBE `admins`;

-- Show inserted data
SELECT `id`, `username`, `email`, `full_name`, `role`, `is_active`, `created_at` FROM `admins`;