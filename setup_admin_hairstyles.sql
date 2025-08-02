-- Setup Admin Hairstyle Management System
-- Wardati Hairstyle

-- Create categories table
CREATE TABLE IF NOT EXISTS `categories` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL,
    `description` text DEFAULT NULL,
    `is_active` tinyint(1) DEFAULT 1,
    `sort_order` int(11) DEFAULT 0,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default categories
INSERT IGNORE INTO `categories` (`id`, `name`, `description`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Potong Rambut Pria', 'Berbagai gaya potong rambut untuk pria', 1, 1, NOW(), NOW()),
(2, 'Potong Rambut Wanita', 'Berbagai gaya potong rambut untuk wanita', 1, 2, NOW(), NOW()),
(3, 'Styling', 'Layanan styling rambut', 1, 3, NOW(), NOW()),
(4, 'Perawatan Rambut', 'Layanan perawatan dan treatment rambut', 1, 4, NOW(), NOW()),
(5, 'Makeup', 'Layanan makeup dan riasan', 1, 5, NOW(), NOW()),
(6, 'Hair Coloring', 'Layanan pewarnaan rambut', 1, 6, NOW(), NOW());

-- Update hairstyles table with new columns
ALTER TABLE `hairstyles` 
ADD COLUMN `category_id` int(11) unsigned NULL AFTER `category`,
ADD COLUMN `image_url` varchar(500) NULL AFTER `image`,
ADD COLUMN `duration_minutes` int(11) NOT NULL DEFAULT 60 AFTER `price`,
ADD COLUMN `difficulty_level` ENUM('easy', 'medium', 'hard') NOT NULL DEFAULT 'medium' AFTER `duration_minutes`,
ADD COLUMN `tags` text NULL AFTER `difficulty_level`,
ADD COLUMN `sort_order` int(11) NOT NULL DEFAULT 0 AFTER `is_active`;

-- Add foreign key constraint
ALTER TABLE `hairstyles` 
ADD CONSTRAINT `hairstyles_category_id_foreign` 
FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- Update existing hairstyles with default values
UPDATE `hairstyles` SET 
    `sort_order` = `id`,
    `duration_minutes` = 60,
    `difficulty_level` = 'medium'
WHERE `sort_order` IS NULL;

-- Insert sample hairstyles if table is empty
INSERT IGNORE INTO `hairstyles` (`name`, `description`, `price`, `category_id`, `image_url`, `is_active`, `duration_minutes`, `difficulty_level`, `tags`, `sort_order`, `created_at`, `updated_at`) VALUES
('Pompadour Classic', 'Gaya pompadour klasik yang elegan', 75000, 1, 'https://example.com/pompadour.jpg', 1, 90, 'medium', 'pria, klasik, elegan', 1, NOW(), NOW()),
('Undercut Modern', 'Undercut dengan gaya modern', 65000, 1, 'https://example.com/undercut.jpg', 1, 75, 'easy', 'pria, modern, pendek', 2, NOW(), NOW()),
('Fade Style', 'Fade dengan transisi halus', 70000, 1, 'https://example.com/fade.jpg', 1, 80, 'medium', 'pria, fade, modern', 3, NOW(), NOW()),
('Bob Cut', 'Bob cut untuk wanita', 85000, 2, 'https://example.com/bob.jpg', 1, 90, 'medium', 'wanita, bob, pendek', 4, NOW(), NOW()),
('Layered Cut', 'Potongan berlapis untuk wanita', 95000, 2, 'https://example.com/layered.jpg', 1, 100, 'hard', 'wanita, berlapis, panjang', 5, NOW(), NOW()),
('Quiff Style', 'Quiff dengan volume tinggi', 80000, 1, 'https://example.com/quiff.jpg', 1, 85, 'hard', 'pria, quiff, volume', 6, NOW(), NOW()),
('Buzz Cut', 'Buzz cut pendek dan praktis', 45000, 1, 'https://example.com/buzz.jpg', 1, 45, 'easy', 'pria, buzz, pendek', 7, NOW(), NOW()),
('Side Part', 'Side part klasik', 60000, 1, 'https://example.com/sidepart.jpg', 1, 70, 'easy', 'pria, side part, klasik', 8, NOW(), NOW()),
('Hair Treatment', 'Perawatan rambut lengkap', 120000, 4, 'https://example.com/treatment.jpg', 1, 120, 'medium', 'treatment, perawatan', 9, NOW(), NOW()),
('Hair Coloring', 'Pewarnaan rambut', 150000, 6, 'https://example.com/coloring.jpg', 1, 150, 'hard', 'coloring, warna', 10, NOW(), NOW()),
('Styling Wedding', 'Styling untuk acara pernikahan', 200000, 3, 'https://example.com/wedding.jpg', 1, 180, 'hard', 'wedding, styling, acara', 11, NOW(), NOW()),
('Makeup Natural', 'Makeup natural untuk sehari-hari', 100000, 5, 'https://example.com/makeup-natural.jpg', 1, 90, 'medium', 'makeup, natural', 12, NOW(), NOW());

-- Verify setup
SELECT 'Admin Hairstyle Management System Setup Complete!' as status;
SELECT COUNT(*) as total_categories FROM categories;
SELECT COUNT(*) as total_hairstyles FROM hairstyles;
SELECT 'Categories:' as info;
SELECT id, name, description, is_active, sort_order FROM categories ORDER BY sort_order;
SELECT 'Hairstyles:' as info;
SELECT id, name, price, category_id, duration_minutes, difficulty_level, is_active, sort_order FROM hairstyles ORDER BY sort_order;