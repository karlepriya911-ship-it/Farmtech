<?php
require_once __DIR__ . '/../config/db_config.php';
$data = json_input();
$days = max(1, (strtotime($data['end_date'] ?? '') - strtotime($data['start_date'] ?? '')) / 86400 + 1);
if (!$data['farmer_id'] || !$data['equipment_id'] || !$data['start_date'] || !$data['end_date']) { http_response_code(422); echo json_encode(['error'=>'Required booking fields are missing']); exit; }
$stmt = $pdo->prepare('SELECT price_per_day FROM equipment WHERE id=? AND status="approved" AND availability=1');
$stmt->execute([$data['equipment_id']]); $equipment = $stmt->fetch();
if (!$equipment) { http_response_code(404); echo json_encode(['error'=>'Equipment unavailable']); exit; }
$total = $days * $equipment['price_per_day'];
$stmt = $pdo->prepare('INSERT INTO bookings (farmer_id,equipment_id,start_date,end_date,total_amount) VALUES (?,?,?,?,?)');
$stmt->execute([$data['farmer_id'],$data['equipment_id'],$data['start_date'],$data['end_date'],$total]);
echo json_encode(['message'=>'Booking request submitted','booking_id'=>$pdo->lastInsertId(),'total_amount'=>$total]);
?>
