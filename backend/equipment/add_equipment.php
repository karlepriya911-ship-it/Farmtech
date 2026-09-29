<?php
require_once __DIR__ . '/../config/db_config.php';

$data = json_input();

$owner_id = $data['owner_id'] ?? null;
$name = trim($data['name'] ?? '');
$category = trim($data['category'] ?? '');
$description = trim($data['description'] ?? '');
$price_per_day = floatval($data['price_per_day'] ?? 0);
$location = trim($data['location'] ?? '');

if (!$owner_id || !$name || !$category || $price_per_day <= 0 || !$location) {
    json_response(['error' => 'All fields are required'], 422);
}

try {
    $stmt = $pdo->prepare(
        'INSERT INTO equipment (owner_id, name, category, description, price_per_day, location) 
         VALUES (?, ?, ?, ?, ?, ?)'
    );
    
    $stmt->execute([
        $owner_id,
        $name,
        $category,
        $description,
        $price_per_day,
        $location
    ]);
    
    json_response([
        'message' => 'Equipment added successfully. Awaiting admin approval.',
        'equipment_id' => $pdo->lastInsertId()
    ], 201);
    
} catch (PDOException $e) {
    json_response(['error' => 'Database error'], 500);
}
?>