<?php

// Test login functionality
require_once 'vendor/autoload.php';

// Load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Initialize CodeIgniter
$app = Config\Services::codeigniter();
$app->initialize();

// Test database connection
$db = \Config\Database::connect();
echo "Database connected: " . ($db->connect(false) ? "YES" : "NO") . "\n";

// Test user model
$userModel = new \App\Models\UserModel();
$user = $userModel->findByWhatsApp('6281234567890');

if ($user) {
    echo "Admin user found: " . $user['name'] . "\n";
    echo "Password hash: " . substr($user['password'], 0, 20) . "...\n";
    
    // Test password verification
    $password = 'admin123';
    $isValid = password_verify($password, $user['password']);
    echo "Password verification: " . ($isValid ? "SUCCESS" : "FAILED") . "\n";
    
    // Test session
    $session = \Config\Services::session();
    $session->start();
    echo "Session started: " . ($session->isStarted() ? "YES" : "NO") . "\n";
    
} else {
    echo "Admin user not found!\n";
}

echo "Test completed.\n";