<?php

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'wardati_hairstyle';

try {
    // Create connection
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to MySQL successfully\n";
    
    // Test quick message responses
    echo "\n=== Testing Quick Message Responses ===\n";
    
    $stmt = $pdo->query("SELECT qm.keyword, qmr.response_text FROM quick_messages qm 
                         LEFT JOIN quick_message_responses qmr ON qm.id = qmr.quick_message_id 
                         WHERE qmr.is_active = 1 ORDER BY qm.id");
    
    $responses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($responses)) {
        echo "No quick message responses found!\n";
        echo "Please run: php setup_database.php\n";
    } else {
        echo "Found " . count($responses) . " quick message responses:\n\n";
        
        foreach ($responses as $response) {
            echo "Keyword: " . $response['keyword'] . "\n";
            echo "Response: " . substr($response['response_text'], 0, 100) . "...\n";
            echo "---\n";
        }
    }
    
    // Test specific quick message
    echo "\n=== Testing Specific Quick Message ===\n";
    $quickMessageId = 3; // jam buka
    
    $stmt = $pdo->prepare("SELECT qm.keyword, qmr.response_text FROM quick_messages qm 
                           LEFT JOIN quick_message_responses qmr ON qm.id = qmr.quick_message_id 
                           WHERE qm.id = ? AND qmr.is_active = 1");
    $stmt->execute([$quickMessageId]);
    $response = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($response) {
        echo "Quick Message ID: $quickMessageId\n";
        echo "Keyword: " . $response['keyword'] . "\n";
        echo "Response: " . $response['response_text'] . "\n";
    } else {
        echo "No response found for quick message ID: $quickMessageId\n";
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}