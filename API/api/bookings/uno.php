<?php
define('AUTHORIZED', true);
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Function to send JSON response
function sendJsonResponse($success, $message, $data = null) {
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    sendJsonResponse(false, 'Method not allowed');
}

try {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        throw new Exception('Invalid input data');
    }

    // Validate required fields
    $requiredFields = ['fullName', 'email', 'phone', 'date', 'time'];
    foreach ($requiredFields as $field) {
        if (empty($input[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    // Validate email
    if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email format');
    }

    // Validate phone number (basic validation)
    if (!preg_match('/^[0-9]{10,15}$/', $input['phone'])) {
        throw new Exception('Invalid phone number format');
    }

    // Validate date format
    $date = DateTime::createFromFormat('Y-m-d', $input['date']);
    if (!$date || $date->format('Y-m-d') !== $input['date']) {
        throw new Exception('Invalid date format');
    }

    // Validate time format
    if (!preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $input['time'])) {
        throw new Exception('Invalid time format');
    }

    // Prepare appointment data
    $appointmentData = [
        'name' => $input['fullName'],
        'email' => $input['email'],
        'phone' => $input['phone'],
        'appointment_type' => 'UNO',
        'price' => '199.00',
        'photobooth_type' => 'UNO',
        'appointment_date' => $input['date'],
        'appointment_time' => $input['time']
    ];

    // Create appointment
    $appointmentManager = new AppointmentManager();
    $result = $appointmentManager->createAppointment($appointmentData);

    if ($result['success']) {
        sendJsonResponse(true, 'Appointment booked successfully', [
            'reference_number' => $result['reference_number'],
            'appointment' => $appointmentData
        ]);
    } else {
        throw new Exception($result['message']);
    }

} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    http_response_code(500);
    sendJsonResponse(false, 'Database error occurred. Please try again later.');
} catch (Exception $e) {
    http_response_code(400);
    sendJsonResponse(false, $e->getMessage());
} 