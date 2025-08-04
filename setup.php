<?php

/**
 * Setup Script for Warda Hairstyle Dynamic Content
 * 
 * This script will:
 * 1. Run database migrations
 * 2. Run seeders for home content and footer content
 * 3. Create necessary directories
 */

// Include CodeIgniter bootstrap
require_once 'app/Config/Paths.php';

$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';

// Get database instance
$db = \Config\Database::connect();

echo "=== Warda Hairstyle Setup Script ===\n\n";

// 1. Create home_content table
echo "1. Creating home_content table...\n";
try {
    $db->query("
        CREATE TABLE IF NOT EXISTS home_content (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            section VARCHAR(50) NOT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            icon VARCHAR(100),
            order_position INTEGER DEFAULT 1,
            is_active TINYINT(1) DEFAULT 1,
            created_at DATETIME,
            updated_at DATETIME
        )
    ");
    echo "✓ home_content table created successfully\n";
} catch (Exception $e) {
    echo "✗ Error creating home_content table: " . $e->getMessage() . "\n";
}

// 2. Create footer_content table
echo "\n2. Creating footer_content table...\n";
try {
    $db->query("
        CREATE TABLE IF NOT EXISTS footer_content (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            section VARCHAR(50) NOT NULL,
            title VARCHAR(255),
            content TEXT NOT NULL,
            icon VARCHAR(100),
            order_position INTEGER DEFAULT 1,
            is_active TINYINT(1) DEFAULT 1,
            created_at DATETIME,
            updated_at DATETIME
        )
    ");
    echo "✓ footer_content table created successfully\n";
} catch (Exception $e) {
    echo "✗ Error creating footer_content table: " . $e->getMessage() . "\n";
}

// 3. Add new columns to bookings table
echo "\n3. Adding new columns to bookings table...\n";
try {
    // Check if columns already exist
    $fields = $db->getFieldData('bookings');
    $existingFields = array_column($fields, 'name');
    
    if (!in_array('customer_photo', $existingFields)) {
        $db->query("ALTER TABLE bookings ADD COLUMN customer_photo VARCHAR(255)");
        echo "✓ customer_photo column added\n";
    } else {
        echo "✓ customer_photo column already exists\n";
    }
    
    if (!in_array('price_confirmed', $existingFields)) {
        $db->query("ALTER TABLE bookings ADD COLUMN price_confirmed DECIMAL(10,2)");
        echo "✓ price_confirmed column added\n";
    } else {
        echo "✓ price_confirmed column already exists\n";
    }
    
    if (!in_array('price_status', $existingFields)) {
        $db->query("ALTER TABLE bookings ADD COLUMN price_status VARCHAR(20) DEFAULT 'pending'");
        echo "✓ price_status column added\n";
    } else {
        echo "✓ price_status column already exists\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error adding columns to bookings table: " . $e->getMessage() . "\n";
}

// 4. Insert home content data
echo "\n4. Inserting home content data...\n";
try {
    // Check if data already exists
    $existingCount = $db->table('home_content')->countAllResults();
    
    if ($existingCount == 0) {
        $homeContentData = [
            [
                'section' => 'why_choose_us',
                'title' => 'Kualitas Terbaik',
                'description' => 'Menggunakan alat dan teknik terbaik untuk hasil maksimal',
                'icon' => 'fas fa-star',
                'order_position' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'why_choose_us',
                'title' => 'Tepat Waktu',
                'description' => 'Layanan cepat dan tepat waktu sesuai janji',
                'icon' => 'fas fa-clock',
                'order_position' => 2,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'why_choose_us',
                'title' => 'Barber Profesional',
                'description' => 'Tim barber berpengalaman dan terlatih',
                'icon' => 'fas fa-user-tie',
                'order_position' => 3,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'why_choose_us',
                'title' => 'Kepuasan Customer',
                'description' => 'Prioritas utama adalah kepuasan customer',
                'icon' => 'fas fa-heart',
                'order_position' => 4,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'services',
                'title' => 'Cornrow',
                'description' => 'Layanan cukur rambut dengan berbagai style modern dan klasik',
                'icon' => 'fas fa-cut',
                'order_position' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'services',
                'title' => 'Home Service',
                'description' => 'Layanan cukur rambut di rumah Anda dengan kenyamanan maksimal',
                'icon' => 'fas fa-home',
                'order_position' => 2,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'services',
                'title' => 'Boxbraid',
                'description' => 'Konsultasi style rambut sesuai dengan bentuk wajah Anda',
                'icon' => 'fas fa-cut',
                'order_position' => 3,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        
        $db->table('home_content')->insertBatch($homeContentData);
        echo "✓ Home content data inserted successfully (" . count($homeContentData) . " records)\n";
    } else {
        echo "✓ Home content data already exists ($existingCount records)\n";
    }
} catch (Exception $e) {
    echo "✗ Error inserting home content data: " . $e->getMessage() . "\n";
}

// 5. Insert footer content data
echo "\n5. Inserting footer content data...\n";
try {
    // Check if data already exists
    $existingCount = $db->table('footer_content')->countAllResults();
    
    if ($existingCount == 0) {
        $footerContentData = [
            [
                'section' => 'about',
                'title' => 'Warda_hairstyle',
                'content' => 'Layanan cukur rambut terbaik dengan kualitas profesional dan harga terjangkau.',
                'icon' => null,
                'order_position' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'services',
                'title' => 'Layanan',
                'content' => '',
                'icon' => null,
                'order_position' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'services',
                'title' => null,
                'content' => 'Cukur Rambut',
                'icon' => 'fas fa-cut',
                'order_position' => 2,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'services',
                'title' => null,
                'content' => 'Home Service',
                'icon' => 'fas fa-home',
                'order_position' => 3,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'services',
                'title' => null,
                'content' => 'Konsultasi Style',
                'icon' => 'fas fa-comments',
                'order_position' => 4,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'contact',
                'title' => 'Kontak',
                'content' => '',
                'icon' => null,
                'order_position' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'contact',
                'title' => null,
                'content' => '+62 812-3456-7890',
                'icon' => 'fab fa-whatsapp',
                'order_position' => 2,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'contact',
                'title' => null,
                'content' => 'Jl. Contoh No. 123',
                'icon' => 'fas fa-map-marker-alt',
                'order_position' => 3,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section' => 'contact',
                'title' => null,
                'content' => '08:00 - 20:00',
                'icon' => 'fas fa-clock',
                'order_position' => 4,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        
        $db->table('footer_content')->insertBatch($footerContentData);
        echo "✓ Footer content data inserted successfully (" . count($footerContentData) . " records)\n";
    } else {
        echo "✓ Footer content data already exists ($existingCount records)\n";
    }
} catch (Exception $e) {
    echo "✗ Error inserting footer content data: " . $e->getMessage() . "\n";
}

// 6. Create upload directories
echo "\n6. Creating upload directories...\n";
try {
    $uploadPath = WRITEPATH . 'uploads/customer_photos/';
    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0755, true);
        echo "✓ Customer photos directory created: $uploadPath\n";
    } else {
        echo "✓ Customer photos directory already exists: $uploadPath\n";
    }
    
    // Create .htaccess file to allow access to uploaded images
    $htaccessPath = $uploadPath . '.htaccess';
    if (!file_exists($htaccessPath)) {
        file_put_contents($htaccessPath, "Allow from all\n");
        echo "✓ .htaccess file created for uploads directory\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error creating upload directories: " . $e->getMessage() . "\n";
}

echo "\n=== Setup Complete! ===\n";
echo "\nFeatures installed:\n";
echo "✓ Dynamic home page content (Why Choose Us & Services sections)\n";
echo "✓ Dynamic footer content\n";
echo "✓ Photo upload for Boxbraid & Cornrow services\n";
echo "✓ Dynamic pricing with admin confirmation\n";
echo "✓ Admin panel for content management\n";
echo "\nAdmin menu locations:\n";
echo "- Home Content: /admin/home-content\n";
echo "- Footer Content: /admin/footer-content\n";
echo "- Price Confirmation: /admin/price-confirmation\n";
echo "\nSetup completed successfully! 🎉\n";