<?php
require_once __DIR__ . '/../config/db_config.php';

$search = '%' . trim($_GET['search'] ?? '') . '%';

try {
    $stmt = $pdo->prepare("
        SELECT id, name, category, description, price_per_day, location, image 
        FROM equipment 
        WHERE status = 'approved' 
        AND availability = 1 
        AND (name LIKE ? OR category LIKE ? OR location LIKE ?)
        ORDER BY created_at DESC
    ");
    
    $stmt->execute([$search, $search, $search]);
    $equipment = $stmt->fetchAll();
    
    json_response($equipment, 200);
    
} catch (PDOException $e) {
    json_response(['error' => 'Database error'], 500);
}
?>