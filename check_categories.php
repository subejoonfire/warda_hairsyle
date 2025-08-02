<?php
// Check Categories Script
// Mengecek apakah tabel categories ada dan terisi

require_once 'app/Config/Database.php';
require_once 'app/Models/CategoryModel.php';

use App\Models\CategoryModel;

try {
    $categoryModel = new CategoryModel();
    
    // Check if categories table exists
    $db = \Config\Database::connect();
    $result = $db->query("SHOW TABLES LIKE 'categories'");
    
    if ($result->getNumRows() == 0) {
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
        
        $db->query($sql);
        echo "Categories table created successfully!\n";
        
        // Insert default categories
        $categoryModel->insertDefaultCategories();
        echo "Default categories inserted successfully!\n";
    } else {
        echo "Categories table exists.\n";
    }
    
    // Get all categories
    $categories = $categoryModel->getAllCategories();
    echo "Total categories: " . count($categories) . "\n";
    
    if (empty($categories)) {
        echo "No categories found. Inserting default categories...\n";
        $categoryModel->insertDefaultCategories();
        $categories = $categoryModel->getAllCategories();
        echo "Default categories inserted. Total categories: " . count($categories) . "\n";
    }
    
    foreach ($categories as $category) {
        echo "- " . $category['name'] . " (ID: " . $category['id'] . ")\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>