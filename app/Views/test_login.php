<!DOCTYPE html>
<html>
<head>
    <title>Test Login</title>
</head>
<body>
    <h1>Test Login Form</h1>
    
    <form method="POST" action="/auth/login">
        <input type="hidden" name="csrf_test_name" value="<?= csrf_hash() ?>">
        
        <div>
            <label>WhatsApp:</label>
            <input type="text" name="whatsapp" value="6281234567890" required>
        </div>
        
        <div>
            <label>Password:</label>
            <input type="password" name="password" value="admin123" required>
        </div>
        
        <button type="submit">Login</button>
    </form>
    
    <hr>
    
    <h2>Debug Info:</h2>
    <p>CSRF Token: <?= csrf_hash() ?></p>
    <p>Session ID: <?= session_id() ?></p>
    <p>Current User: <?= session()->get('user_id') ? 'Logged in (ID: ' . session()->get('user_id') . ')' : 'Not logged in' ?></p>
</body>
</html>