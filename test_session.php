<?php

// Test session and login functionality
session_start();

echo "Session ID: " . session_id() . "\n";
echo "Session data:\n";
print_r($_SESSION);

echo "\nChecking if user is logged in:\n";
if (isset($_SESSION['user_id'])) {
    echo "User ID: " . $_SESSION['user_id'] . "\n";
    echo "User Name: " . $_SESSION['user_name'] . "\n";
    echo "User Role: " . $_SESSION['user_role'] . "\n";
    echo "User WhatsApp: " . $_SESSION['user_whatsapp'] . "\n";
} else {
    echo "No user logged in\n";
}

echo "\nSession files:\n";
$sessionFiles = glob('/tmp/sess_*');
foreach ($sessionFiles as $file) {
    echo $file . "\n";
}