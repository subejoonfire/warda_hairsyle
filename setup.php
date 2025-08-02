<?php

// Setup script untuk menjalankan migration dan seeder
require_once 'vendor/autoload.php';

// Load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Initialize CodeIgniter
$pathsPath = realpath(FCPATH . '../app/Config/Paths.php');
$paths = new Config\Paths();

// Set up database
$db = \Config\Database::connect();

echo "🚀 Memulai setup database MySQL...\n";
echo "📋 Pastikan MySQL server sudah berjalan dan database sudah dibuat\n\n";

// Run migrations
echo "📦 Menjalankan migrations...\n";

$migration = \Config\Services::migrations();
$migration->setNamespace('App\Database\Migrations');

try {
    $migration->latest();
    echo "✅ Migrations berhasil dijalankan\n";
} catch (Exception $e) {
    echo "❌ Error menjalankan migrations: " . $e->getMessage() . "\n";
    exit(1);
}

// Run seeders
echo "🌱 Menjalankan seeders...\n";

$seeder = \Config\Services::seeder();
$seeder->setNamespace('App\Database\Seeds');

try {
    $seeder->call('InitialDataSeeder');
    echo "✅ Seeders berhasil dijalankan\n";
    echo "📋 Data quick messages telah ditambahkan\n";
} catch (Exception $e) {
    echo "❌ Error menjalankan seeders: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n🎉 Setup selesai! Database MySQL telah siap digunakan.\n";
echo "\n📋 Informasi login:\n";
echo "Admin WhatsApp: 6281234567890\n";
echo "Admin Password: admin123\n";
echo "\n🔧 Jangan lupa untuk mengatur konfigurasi Fonnte di file .env\n";
echo "   - fonnte.api_key = YOUR_FONNTE_API_KEY\n";
echo "   - fonnte.device_id = YOUR_DEVICE_ID\n";
echo "\n🌐 Jalankan server dengan: php spark serve\n";
echo "\n📊 Database yang digunakan: MySQL\n";
echo "📁 Database name: wardati_hairstyle_db\n";
echo "🎯 Quick messages sudah siap digunakan\n";