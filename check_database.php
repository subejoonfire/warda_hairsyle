<?php
// Check Database Script
// Mengecek dan setup database jika diperlukan

$host = 'localhost';
$username = 'root';
$password = '123456';
$database = 'wardati_hairstyle';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database successfully!\n";
    
    // Check if categories table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'categories'");
    if ($stmt->rowCount() == 0) {
        echo "Categories table not found. Creating...\n";
        
        // Create categories table
        $sql = "CREATE TABLE IF NOT EXISTS `categories` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(100) NOT NULL,
            `description` text DEFAULT NULL,
            `is_active` tinyint(1) DEFAULT 1,
            `sort_order` int(11) DEFAULT 0,
            `created_at` datetime NOT NULL,
            `updated_at` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $pdo->exec($sql);
        echo "Categories table created successfully!\n";
        
        // Insert default categories
        $defaultCategories = [
            ['name' => 'Potong Rambut Pria', 'description' => 'Berbagai gaya potong rambut untuk pria', 'is_active' => 1, 'sort_order' => 1],
            ['name' => 'Potong Rambut Wanita', 'description' => 'Berbagai gaya potong rambut untuk wanita', 'is_active' => 1, 'sort_order' => 2],
            ['name' => 'Styling', 'description' => 'Layanan styling rambut', 'is_active' => 1, 'sort_order' => 3],
            ['name' => 'Perawatan Rambut', 'description' => 'Layanan perawatan dan treatment rambut', 'is_active' => 1, 'sort_order' => 4],
            ['name' => 'Makeup', 'description' => 'Layanan makeup dan riasan', 'is_active' => 1, 'sort_order' => 5],
            ['name' => 'Hair Coloring', 'description' => 'Layanan pewarnaan rambut', 'is_active' => 1, 'sort_order' => 6]
        ];
        
        $stmt = $pdo->prepare("INSERT INTO categories (name, description, is_active, sort_order, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
        
        foreach ($defaultCategories as $category) {
            $stmt->execute([$category['name'], $category['description'], $category['is_active'], $category['sort_order']]);
        }
        
        echo "Default categories inserted successfully!\n";
    } else {
        echo "Categories table already exists.\n";
    }
    
    // Check if hairstyles table has required columns
    $stmt = $pdo->query("SHOW COLUMNS FROM hairstyles LIKE 'category_id'");
    if ($stmt->rowCount() == 0) {
        echo "Adding category_id column to hairstyles table...\n";
        
        $sql = "ALTER TABLE `hairstyles` 
                ADD COLUMN `category_id` int(11) unsigned NULL AFTER `category`,
                ADD COLUMN `image_url` varchar(500) NULL AFTER `image`,
                ADD COLUMN `duration_minutes` int(11) NOT NULL DEFAULT 60 AFTER `price`,
                ADD COLUMN `difficulty_level` ENUM('easy', 'medium', 'hard') NOT NULL DEFAULT 'medium' AFTER `duration_minutes`,
                ADD COLUMN `tags` text NULL AFTER `difficulty_level`,
                ADD COLUMN `sort_order` int(11) NOT NULL DEFAULT 0 AFTER `is_active`";
        
        $pdo->exec($sql);
        echo "Columns added to hairstyles table successfully!\n";
        
        // Add foreign key constraint
        $sql = "ALTER TABLE `hairstyles` 
                ADD CONSTRAINT `hairstyles_category_id_foreign` 
                FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL ON UPDATE CASCADE";
        
        $pdo->exec($sql);
        echo "Foreign key constraint added successfully!\n";
    } else {
        echo "Hairstyles table already has required columns.\n";
    }
    
    // Count records
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM categories");
    $categoriesCount = $stmt->fetch()['count'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM hairstyles");
    $hairstylesCount = $stmt->fetch()['count'];
    
    echo "Database check completed!\n";
    echo "Categories: $categoriesCount\n";
    echo "Hairstyles: $hairstylesCount\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>