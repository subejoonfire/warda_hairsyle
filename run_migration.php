<?php

// Simple script to run migration and seeder
require_once 'vendor/autoload.php';

// Load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Initialize CodeIgniter
$pathsPath = realpath(FCPATH . '../app/Config/Paths.php');
$paths = new Config\Paths();

// Set up database
$db = \Config\Database::connect();

echo "🚀 Menjalankan migration dan seeder...\n\n";

// Run migrations
echo "📦 Menjalankan migrations...\n";
$migration = \Config\Services::migrations();
$migration->setNamespace('App\Database\Migrations');

try {
    $migration->latest();
    echo "✅ Migrations berhasil\n";
} catch (Exception $e) {
    echo "❌ Error migrations: " . $e->getMessage() . "\n";
}

// Run seeders
echo "🌱 Menjalankan seeders...\n";
$seeder = \Config\Services::seeder();
$seeder->setNamespace('App\Database\Seeds');

try {
    $seeder->call('InitialDataSeeder');
    echo "✅ Seeders berhasil\n";
} catch (Exception $e) {
    echo "❌ Error seeders: " . $e->getMessage() . "\n";
}

echo "\n🔍 Mengecek data...\n";

// Check hairstyles
echo "📋 Data Hairstyles:\n";
$hairstyles = $db->table('hairstyles')->get()->getResultArray();
if (empty($hairstyles)) {
    echo "❌ Tidak ada data hairstyles\n";
} else {
    foreach ($hairstyles as $hairstyle) {
        echo "• {$hairstyle['name']} - Rp " . number_format($hairstyle['price'], 0, ',', '.') . "\n";
    }
}

echo "\n📋 Data Quick Messages:\n";
$quickMessages = $db->table('quick_messages')->get()->getResultArray();
if (empty($quickMessages)) {
    echo "❌ Tidak ada data quick messages\n";
} else {
    foreach ($quickMessages as $qm) {
        echo "• ID {$qm['id']}: {$qm['keyword']} - {$qm['description']}\n";
    }
}

echo "\n📋 Data Users:\n";
$users = $db->table('users')->get()->getResultArray();
if (empty($users)) {
    echo "❌ Tidak ada data users\n";
} else {
    foreach ($users as $user) {
        echo "• {$user['name']} - {$user['role']}\n";
    }
}

echo "\n🎉 Setup selesai!\n";
echo "🔧 Sekarang bisa test quick messages di chat\n";
echo "📊 Quick messages akan mengambil data dari database\n";