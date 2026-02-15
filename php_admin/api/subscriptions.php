<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../include/db.php';

if (!$mysqli) {
    echo json_encode(['ok' => false, 'error' => 'Database connection failed']);
    exit;
}

// Fetch active subscriptions
$query = "SELECT id, title, duration_months, price, discount_percentage, discount_end_date, description, is_active 
          FROM subscriptions 
          WHERE is_active = 1 
          ORDER BY duration_months ASC";

$result = $mysqli->query($query);

if (!$result) {
    echo json_encode(['ok' => false, 'error' => 'Query failed']);
    exit;
}

$subscriptions = [];
while ($row = $result->fetch_assoc()) {
    $subscriptions[] = $row;
}

echo json_encode([
    'ok' => true,
    'subscriptions' => $subscriptions
]);
