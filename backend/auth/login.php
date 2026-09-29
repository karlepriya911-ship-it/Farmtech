<?php
require_once __DIR__ . '/../config/db_config.php';

$data = json_input();

$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';

if (!$email || !$password) {
    json_response(['error' => 'Email and password are required'], 422);
}

try {
    $stmt = $pdo->prepare('SELECT id, name, email, password, role FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if (!$user || !password_verify($password, $user['password'])) {
        json_response(['error' => 'Invalid email or password'], 401);
    }
    
    unset($user['password']);
    
    json_response([
        'message' => 'Login successful',
        'user' => $user
    ], 200);
    
} catch (PDOException $e) {
    json_response(['error' => 'Database error'], 500);
}
?>