<?php

// Simple script to run seeder
require_once 'vendor/autoload.php';

// Load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Initialize CodeIgniter
$pathsPath = realpath(FCPATH . '../app/Config/Paths.php');
$paths = new Config\Paths();

// Set up database
$db = \Config\Database::connect();

echo "🌱 Menjalankan seeder...\n";

// Run seeders
$seeder = \Config\Services::seeder();
$seeder->setNamespace('App\Database\Seeds');

try {
    $seeder->call('InitialDataSeeder');
    echo "✅ Seeder berhasil dijalankan\n";
    echo "📋 Data hairstyles dan quick messages telah ditambahkan\n";
} catch (Exception $e) {
    echo "❌ Error menjalankan seeder: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n🎉 Seeder selesai!\n";