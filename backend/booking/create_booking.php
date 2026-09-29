<?php
require_once __DIR__ . '/../config/db_config.php';

$data = json_input();

$farmer_id = $data['farmer_id'] ?? null;
$equipment_id = $data['equipment_id'] ?? null;
$start_date = $data['start_date'] ?? null;
$end_date = $data['end_date'] ?? null;

if (!$farmer_id || !$equipment_id || !$start_date || !$end_date) {
    json_response(['error' => 'All booking fields are required'], 422);
}

try {
    // Check equipment availability
    $equipStmt = $pdo->prepare(
        'SELECT price_per_day FROM equipment WHERE id = ? AND status = "approved" AND availability = 1'
    );
    $equipStmt->execute([$equipment_id]);
    $equipment = $equipStmt->fetch();
    
    if (!$equipment) {
        json_response(['error' => 'Equipment unavailable'], 404);
    }
    
    // Calculate total amount
    $start = new DateTime($start_date);
    $end = new DateTime($end_date);
    $days = $end->diff($start)->days + 1;
    $total_amount = $days * $equipment['price_per_day'];
    
    // Create booking
    $stmt = $pdo->prepare(
        'INSERT INTO bookings (farmer_id, equipment_id, start_date, end_date, total_amount) 
         VALUES (?, ?, ?, ?, ?)'
    );
    
    $stmt->execute([
        $farmer_id,
        $equipment_id,
        $start_date,
        $end_date,
        $total_amount
    ]);
    
    json_response([
        'message' => 'Booking request submitted successfully',
        'booking_id' => $pdo->lastInsertId(),
        'total_amount' => $total_amount,
        'days' => $days
    ], 201);
    
} catch (PDOException $e) {
    json_response(['error' => 'Database error'], 500);
}
?>