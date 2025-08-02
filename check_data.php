<?php

// Script to check database data
require_once 'vendor/autoload.php';

// Load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Initialize CodeIgniter
$pathsPath = realpath(FCPATH . '../app/Config/Paths.php');
$paths = new Config\Paths();

// Set up database
$db = \Config\Database::connect();

echo "🔍 Mengecek data di database...\n\n";

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
        echo "• {$qm['keyword']} - {$qm['description']}\n";
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

echo "\n🎉 Pengecekan selesai!\n";