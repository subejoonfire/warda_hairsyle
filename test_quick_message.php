<?php

// Test quick message
require_once 'vendor/autoload.php';

// Load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Initialize CodeIgniter
$pathsPath = realpath(FCPATH . '../app/Config/Paths.php');
$paths = new Config\Paths();

// Set up database
$db = \Config\Database::connect();

echo "🧪 Test Quick Message System\n\n";

// Check quick messages
echo "📋 Data Quick Messages:\n";
$quickMessages = $db->table('quick_messages')->get()->getResultArray();
if (empty($quickMessages)) {
    echo "❌ Tidak ada data quick messages\n";
} else {
    foreach ($quickMessages as $qm) {
        echo "• ID {$qm['id']}: {$qm['keyword']} - {$qm['description']}\n";
    }
}

echo "\n📋 Data Hairstyles:\n";
$hairstyles = $db->table('hairstyles')->get()->getResultArray();
if (empty($hairstyles)) {
    echo "❌ Tidak ada data hairstyles\n";
} else {
    foreach ($hairstyles as $hairstyle) {
        echo "• {$hairstyle['name']} - Rp " . number_format($hairstyle['price'], 0, ',', '.') . "\n";
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

echo "\n🔍 Test Response Generation:\n";

// Test response generation
$controller = new \App\Controllers\Home();

// Test case 3 (jam buka)
echo "Testing jam buka (ID: 3):\n";
$response = $controller->getOpeningHours();
echo "Response: " . $response . "\n\n";

// Test case 1 (list hairstyle)
echo "Testing list hairstyle (ID: 1):\n";
$response = $controller->getHairstyleListFromDatabase();
echo "Response: " . $response . "\n\n";

echo "🎉 Test selesai!\n";
echo "📊 Cek log file untuk debug info\n";