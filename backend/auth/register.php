<?php
require_once __DIR__ . '/../config/db_config.php';
$data = json_input();
$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';
$phone = trim($data['phone'] ?? '');
$role = in_array($data['role'] ?? 'farmer', ['farmer','owner'], true) ? $data['role'] : 'farmer';

if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
    http_response_code(422); echo json_encode(['error' => 'Name, valid email, and password of 6+ characters are required']); exit;
}
try {
    $stmt = $pdo->prepare('INSERT INTO users (name,email,phone,password,role) VALUES (?,?,?,?,?)');
    $stmt->execute([$name, $email, $phone, password_hash($password, PASSWORD_DEFAULT), $role]);
    echo json_encode(['message' => 'Registration successful', 'user_id' => $pdo->lastInsertId()]);
} catch (PDOException $e) {
    http_response_code(409); echo json_encode(['error' => 'Email is already registered']);
}
?>
