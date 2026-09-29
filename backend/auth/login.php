<?php
require_once __DIR__ . '/../config/db_config.php';
$data = json_input();
$stmt = $pdo->prepare('SELECT id,name,email,password,role FROM users WHERE email = ? LIMIT 1');
$stmt->execute([trim($data['email'] ?? '')]);
$user = $stmt->fetch();
if (!$user || !password_verify($data['password'] ?? '', $user['password'])) {
    http_response_code(401); echo json_encode(['error' => 'Invalid email or password']); exit;
}
unset($user['password']);
echo json_encode(['message' => 'Login successful', 'user' => $user]);
?>
