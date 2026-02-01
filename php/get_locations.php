<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    $stmt = $pdo->query("SELECT id, user_id, lat, lng, description, created_at FROM locations ORDER BY created_at DESC");
    $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($locations);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to load locations: ' . $e->getMessage()]);
}
?>