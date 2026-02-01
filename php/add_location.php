<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON input');
    }

    if (!$data || !isset($data['lat']) || !isset($data['lng'])) {
        throw new Exception('Missing required fields: lat and lng');
    }

    $lat = floatval($data['lat']);
    $lng = floatval($data['lng']);
    $description = isset($data['description']) ? trim($data['description']) : '';

    // Validate coordinates
    if ($lat < -90 || $lat > 90) {
        throw new Exception('Invalid latitude');
    }
    if ($lng < -180 || $lng > 180) {
        throw new Exception('Invalid longitude');
    }

    $stmt = $pdo->prepare("INSERT INTO locations (user_id, lat, lng, description) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $lat, $lng, $description]);

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>