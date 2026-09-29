<?php
require_once __DIR__ . '/../config/db_config.php';

$data = json_input();

$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';
$phone = trim($data['phone'] ?? '');
$role = in_array($data['role'] ?? 'farmer', ['farmer', 'owner'], true) ? $data['role'] : 'farmer';

// Validation
if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
    json_response(
        ['error' => 'Name, valid email, and password (6+ characters) are required'],
        422
    );
}

try {
    // Check if email already exists
    $checkStmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $checkStmt->execute([$email]);
    
    if ($checkStmt->fetch()) {
        json_response(['error' => 'Email is already registered'], 409);
    }
    
    // Insert new user
    $stmt = $pdo->prepare(
        'INSERT INTO users (name, email, phone, password, role) VALUES (?, ?, ?, ?, ?)'
    );
    
    $stmt->execute([
        $name,
        $email,
        $phone,
        password_hash($password, PASSWORD_DEFAULT),
        $role
    ]);
    
    $userId = $pdo->lastInsertId();
    
    json_response([
        'message' => 'Registration successful',
        'user_id' => $userId,
        'role' => $role
    ], 201);
    
} catch (PDOException $e) {
    json_response(['error' => 'Database error: ' . $e->getMessage()], 500);
}
?>