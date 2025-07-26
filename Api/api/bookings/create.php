<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../config.php';

$db = Database::getInstance()->getConnection();

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    $data = $_POST;
}

// Handle different field name formats
$fullName = $data['full_name'] ?? '';
$email = $data['email'] ?? '';
$phone = $data['phone'] ?? '';
$package = $data['package'] ?? '';
$bookingDate = $data['booking_date'] ?? $data['appointment_date'] ?? '';
$bookingTime = $data['booking_time'] ?? $data['appointment_time'] ?? '';

// Validate required fields
$missing = [];
if (empty($fullName)) $missing[] = 'full_name';
if (empty($phone)) $missing[] = 'phone';
if (empty($bookingDate)) $missing[] = 'booking_date/appointment_date';
if (empty($bookingTime)) $missing[] = 'booking_time/appointment_time';

if (!empty($missing)) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Missing required fields: " . implode(', ', $missing)
    ]);
    exit();
}

try {
    // Create notes with package info
    $notes = '';
    if (!empty($package)) {
        $notes = $package . " Package";
    }
    
    $stmt = $db->prepare("
        INSERT INTO appointments (
            full_name, email, phone, 
            appointment_date, appointment_time, 
            status_id, notes
        ) VALUES (?, ?, ?, ?, ?, 1, ?)
    ");

    $stmt->execute([
        $fullName,
        $email,
        $phone,
        $bookingDate,
        $bookingTime,
        $notes
    ]);

    $id = $db->lastInsertId();

    http_response_code(201);
    echo json_encode([
        "success" => true,
        "message" => "Appointment was created successfully.",
        "id" => $id,
        "full_name" => $fullName,
        "email" => $email,
        "phone" => $phone,
        "package" => $package,
        "booking_date" => $bookingDate,
        "booking_time" => $bookingTime
    ]);
} catch (PDOException $e) {
    http_response_code(503);
    echo json_encode([
        "success" => false,
        "message" => "Unable to create appointment: " . $e->getMessage()
    ]);
}
?>