<?php
header('Content-Type: application/json');
require_once '../config.php';

// Initialize database connection
$db = Database::getInstance()->getConnection();
$appointmentManager = new AppointmentManager();

// Get request method
$method = $_SERVER['REQUEST_METHOD'];

// Handle CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Route the request
switch ($method) {
    case 'GET':
        // Get all appointments or specific appointment
        if (isset($_GET['id'])) {
            $appointment = $appointmentManager->getAppointment($_GET['id']);
            echo json_encode($appointment);
        } else {
            $filters = [];
            if (isset($_GET['status'])) $filters['status'] = $_GET['status'];
            if (isset($_GET['date'])) {
                // Use getAppointmentsForDate instead of passing date filter
                $result = $appointmentManager->getAppointmentsForDate($_GET['date']);
                echo json_encode($result);
                exit();
            }
            
            $appointments = $appointmentManager->getAppointments($filters);
            echo json_encode($appointments);
        }
        break;

    case 'POST':
        // Create new appointment
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            $data = $_POST;
        }
        
        $result = $appointmentManager->createAppointment($data);
        echo json_encode($result);
        break;

    case 'PUT':
        // Update appointment
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($_GET['id'])) {
            $result = $appointmentManager->updateAppointment($_GET['id'], $data);
            echo json_encode($result);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Appointment ID is required']);
        }
        break;

    case 'DELETE':
        // Delete appointment
        if (isset($_GET['id'])) {
            $result = $appointmentManager->deleteAppointment($_GET['id']);
            echo json_encode($result);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Appointment ID is required']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
} 