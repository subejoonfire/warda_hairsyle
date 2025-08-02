<?php

/**
 * Script untuk migrasi dari SQLite ke MySQL
 * Jalankan script ini jika Anda sebelumnya menggunakan SQLite
 */

require_once 'vendor/autoload.php';

// Load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "🔄 Memulai migrasi dari SQLite ke MySQL...\n\n";

// Check if SQLite database exists
$sqliteFile = __DIR__ . '/app/Database/wardati_hairstyle.db';
if (file_exists($sqliteFile)) {
    echo "📁 File SQLite ditemukan: {$sqliteFile}\n";
    echo "⚠️  File ini akan dihapus setelah migrasi selesai\n\n";
} else {
    echo "ℹ️  File SQLite tidak ditemukan, melanjutkan setup MySQL...\n\n";
}

// Test MySQL connection
echo "🔍 Testing koneksi MySQL...\n";
try {
    $db = \Config\Database::connect();
    echo "✅ Koneksi MySQL berhasil\n\n";
} catch (Exception $e) {
    echo "❌ Error koneksi MySQL: " . $e->getMessage() . "\n";
    echo "📋 Pastikan:\n";
    echo "   - MySQL server berjalan\n";
    echo "   - Database 'wardati_hairstyle_db' sudah dibuat\n";
    echo "   - Kredensial di file .env sudah benar\n\n";
    exit(1);
}

// Run migrations
echo "📦 Menjalankan migrations...\n";
$migration = \Config\Services::migrations();
$migration->setNamespace('App\Database\Migrations');

try {
    $migration->latest();
    echo "✅ Migrations berhasil dijalankan\n\n";
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
    echo "✅ Seeders berhasil dijalankan\n\n";
} catch (Exception $e) {
    echo "❌ Error menjalankan seeders: " . $e->getMessage() . "\n";
    exit(1);
}

// Remove SQLite file if exists
if (file_exists($sqliteFile)) {
    if (unlink($sqliteFile)) {
        echo "🗑️  File SQLite berhasil dihapus\n\n";
    } else {
        echo "⚠️  Gagal menghapus file SQLite, hapus manual: {$sqliteFile}\n\n";
    }
}

echo "🎉 Migrasi ke MySQL selesai!\n\n";
echo "📊 Database yang digunakan: MySQL\n";
echo "📁 Database name: wardati_hairstyle_db\n";
echo "🔧 Konfigurasi: app/Config/Database.php\n\n";
echo "📋 Informasi login:\n";
echo "Admin WhatsApp: 6281234567890\n";
echo "Admin Password: admin123\n\n";
echo "🌐 Jalankan server dengan: php spark serve\n";
echo "📚 Dokumentasi lengkap: MYSQL_SETUP.md\n";