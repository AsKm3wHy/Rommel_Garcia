<?php
header('Content-Type: application/json');
require_once '../config.php';

// Initialize database connection
$db = Database::getInstance()->getConnection();

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

// Enhanced appointment creation function
function createAppointment($data) {
    global $db;
    
    try {
        // Handle different field name formats
        $fullName = $data['full_name'] ?? '';
        $email = $data['email'] ?? '';
        $phone = $data['phone'] ?? '';
        $appointmentDate = $data['appointment_date'] ?? $data['booking_date'] ?? '';
        $appointmentTime = $data['appointment_time'] ?? $data['booking_time'] ?? '';
        $package = $data['package'] ?? '';
        $notes = $data['notes'] ?? '';
        
        // Create notes with package info if provided
        if (!empty($package) && empty($notes)) {
            $notes = $package . " Package";
        } elseif (!empty($package) && !empty($notes)) {
            $notes = $package . " Package - " . $notes;
        }
        
        // Check for time slot conflicts
        $conflictCheck = $db->prepare("
            SELECT COUNT(*) FROM appointments 
            WHERE appointment_date = ? AND appointment_time = ? AND status_id IN (1, 2)
        ");
        $conflictCheck->execute([$appointmentDate, $appointmentTime]);
        
        if ($conflictCheck->fetchColumn() > 0) {
            return [
                'success' => false,
                'message' => 'Time slot is already booked. Please choose a different time.'
            ];
        }
        
        $stmt = $db->prepare("
            INSERT INTO appointments (
                full_name, email, phone, 
                appointment_date, appointment_time, 
                status_id, notes, created_at
            ) VALUES (?, ?, ?, ?, ?, 1, ?, NOW())
        ");

        $stmt->execute([
            $fullName,
            $email,
            $phone,
            $appointmentDate,
            $appointmentTime,
            $notes
        ]);

        $id = $db->lastInsertId();
        
        // Get the created appointment with status info
        $createdAppointment = getAppointmentById($id);
        
        return [
            'success' => true,
            'id' => $id,
            'full_name' => $fullName,
            'email' => $email,
            'phone' => $phone,
            'package' => $package,
            'appointment_date' => $appointmentDate,
            'appointment_time' => $appointmentTime,
            'status' => 'Pending',
            'message' => 'Appointment created successfully'
        ];
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => 'Failed to create appointment: ' . $e->getMessage()
        ];
    }
}

// Get appointment by ID with status info
function getAppointmentById($id) {
    global $db;
    
    $stmt = $db->prepare("
        SELECT a.*, 
               CASE 
                   WHEN a.status_id = 1 THEN 'Pending'
                   WHEN a.status_id = 2 THEN 'Confirmed'
                   WHEN a.status_id = 3 THEN 'Completed'
                   WHEN a.status_id = 4 THEN 'Cancelled'
                   WHEN a.status_id = 5 THEN 'No Show'
                   ELSE 'Unknown'
               END as status_name
        FROM appointments a 
        WHERE a.id = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Enhanced get appointments function with better filtering
function getAppointments($filters = []) {
    global $db;
    
    $sql = "
        SELECT a.*, 
               CASE 
                   WHEN a.status_id = 1 THEN 'Pending'
                   WHEN a.status_id = 2 THEN 'Confirmed'
                   WHEN a.status_id = 3 THEN 'Completed'
                   WHEN a.status_id = 4 THEN 'Cancelled'
                   WHEN a.status_id = 5 THEN 'No Show'
                   ELSE 'Unknown'
               END as status_name
        FROM appointments a 
        WHERE 1=1
    ";
    $params = [];

    if (!empty($filters['status_id'])) {
        $sql .= " AND a.status_id = ?";
        $params[] = $filters['status_id'];
    }

    if (!empty($filters['status'])) {
        $statusMap = [
            'pending' => 1,
            'confirmed' => 2,
            'completed' => 3,
            'cancelled' => 4,
            'no_show' => 5
        ];
        if (isset($statusMap[strtolower($filters['status'])])) {
            $sql .= " AND a.status_id = ?";
            $params[] = $statusMap[strtolower($filters['status'])];
        }
    }

    if (!empty($filters['date_from'])) {
        $sql .= " AND a.appointment_date >= ?";
        $params[] = $filters['date_from'];
    }

    if (!empty($filters['date_to'])) {
        $sql .= " AND a.appointment_date <= ?";
        $params[] = $filters['date_to'];
    }

    if (!empty($filters['date'])) {
        $sql .= " AND a.appointment_date = ?";
        $params[] = $filters['date'];
    }

    if (!empty($filters['package'])) {
        $sql .= " AND a.notes LIKE ?";
        $params[] = '%' . $filters['package'] . '%';
    }

    if (!empty($filters['search'])) {
        $search = '%' . $filters['search'] . '%';
        $sql .= " AND (a.full_name LIKE ? OR a.email LIKE ? OR a.phone LIKE ? OR a.notes LIKE ?)";
        $params[] = $search;
        $params[] = $search;
        $params[] = $search;
        $params[] = $search;
    }

    $sql .= " ORDER BY a.appointment_date DESC, a.appointment_time ASC";
    
    if (!empty($filters['limit'])) {
        $sql .= " LIMIT " . (int)$filters['limit'];
    }
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get dashboard statistics
function getDashboardStats() {
    global $db;
    
    try {
        $stats = [];
        
        // Total appointments
        $stmt = $db->query("SELECT COUNT(*) FROM appointments");
        $stats['total'] = $stmt->fetchColumn();
        
        // Today's appointments
        $stmt = $db->query("SELECT COUNT(*) FROM appointments WHERE DATE(appointment_date) = CURDATE()");
        $stats['today'] = $stmt->fetchColumn();
        
        // Pending appointments
        $stmt = $db->query("SELECT COUNT(*) FROM appointments WHERE status_id = 1");
        $stats['pending'] = $stmt->fetchColumn();
        
        // This week's appointments
        $stmt = $db->query("SELECT COUNT(*) FROM appointments WHERE appointment_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)");
        $stats['week'] = $stmt->fetchColumn();
        
        // Package breakdown
        $stmt = $db->query("
            SELECT 
                CASE 
                    WHEN notes LIKE '%UNO%' THEN 'UNO'
                    WHEN notes LIKE '%TRIO%' THEN 'TRIO'
                    WHEN notes LIKE '%TRES%' THEN 'TRES'
                    WHEN notes LIKE '%GRADUATE%' THEN 'Graduate'
                    WHEN notes LIKE '%DUO%' THEN 'DUO'
                    WHEN notes LIKE '%SOLO%' THEN 'SOLO'
                    WHEN notes LIKE '%QUAD%' THEN 'QUAD'
                    WHEN notes LIKE '%DELUXE%' THEN 'DELUXE'
                    WHEN notes LIKE '%GROUP%' THEN 'GROUP'
                    ELSE 'Other'
                END as package,
                COUNT(*) as count
            FROM appointments 
            GROUP BY package
            ORDER BY count DESC
        ");
        $stats['packages'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $stats;
    } catch (PDOException $e) {
        return [
            'total' => 0,
            'today' => 0,
            'pending' => 0,
            'week' => 0,
            'packages' => []
        ];
    }
}

// Get available time slots for a date
function getAvailableTimeSlots($date) {
    global $db;
    
    $allSlots = [
        '08:00:00', '09:00:00', '10:00:00', '11:00:00',
        '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00'
    ];
    
    $stmt = $db->prepare("
        SELECT appointment_time 
        FROM appointments 
        WHERE appointment_date = ? AND status_id IN (1, 2)
    ");
    $stmt->execute([$date]);
    
    $bookedSlots = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $availableSlots = array_diff($allSlots, $bookedSlots);
    
    return array_values($availableSlots);
}

// Route the request
switch ($method) {
    case 'GET':
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'dashboard':
                    $stats = getDashboardStats();
                    echo json_encode([
                        'success' => true,
                        'data' => $stats
                    ]);
                    break;
                    
                case 'today':
                    $appointments = getAppointments(['date' => date('Y-m-d')]);
                    echo json_encode([
                        'success' => true,
                        'data' => $appointments
                    ]);
                    break;
                    
                case 'available_slots':
                    if (isset($_GET['date'])) {
                        $slots = getAvailableTimeSlots($_GET['date']);
                        echo json_encode([
                            'success' => true,
                            'data' => $slots
                        ]);
                    } else {
                        echo json_encode([
                            'success' => false,
                            'message' => 'Date parameter required'
                        ]);
                    }
                    break;
                    
                case 'packages':
                    $packages = getAppointments(['package' => $_GET['package'] ?? '']);
                    echo json_encode([
                        'success' => true,
                        'data' => $packages
                    ]);
                    break;
                    
                default:
                    echo json_encode([
                        'success' => false,
                        'message' => 'Invalid action'
                    ]);
                    break;
            }
        } else {
            // Get all appointments with filters
            $filters = [];
            if (isset($_GET['status_id'])) $filters['status_id'] = $_GET['status_id'];
            if (isset($_GET['status'])) $filters['status'] = $_GET['status'];
            if (isset($_GET['date_from'])) $filters['date_from'] = $_GET['date_from'];
            if (isset($_GET['date_to'])) $filters['date_to'] = $_GET['date_to'];
            if (isset($_GET['date'])) $filters['date'] = $_GET['date'];
            if (isset($_GET['package'])) $filters['package'] = $_GET['package'];
            if (isset($_GET['search'])) $filters['search'] = $_GET['search'];
            if (isset($_GET['limit'])) $filters['limit'] = $_GET['limit'];
            
            $appointments = getAppointments($filters);
            echo json_encode([
                'success' => true,
                'data' => $appointments
            ]);
        }
        break;

    case 'POST':
        // Create new appointment
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            $data = $_POST;
        }
        
        // Validate required fields (handle both field name formats)
        $required = ['full_name', 'phone'];
        $missing = [];
        
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $missing[] = $field;
            }
        }
        
        // Check for either appointment_date or booking_date
        if (empty($data['appointment_date']) && empty($data['booking_date'])) {
            $missing[] = 'appointment_date/booking_date';
        }
        
        // Check for either appointment_time or booking_time
        if (empty($data['appointment_time']) && empty($data['booking_time'])) {
            $missing[] = 'appointment_time/booking_time';
        }
        
        if (!empty($missing)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Missing required fields: ' . implode(', ', $missing)
            ]);
            break;
        }
        
        $result = createAppointment($data);
        echo json_encode($result);
        break;

    case 'PUT':
        // Update appointment
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($_GET['id'])) {
            try {
                $updates = [];
                $params = [];

                $allowedFields = ['full_name', 'email', 'phone', 'appointment_date', 'appointment_time', 'status_id', 'notes'];
                
                foreach ($data as $key => $value) {
                    if (in_array($key, $allowedFields)) {
                        $updates[] = "$key = ?";
                        $params[] = $value;
                    }
                }

                if (empty($updates)) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'No valid fields to update'
                    ]);
                    break;
                }

                $params[] = $_GET['id'];
                $sql = "UPDATE appointments SET " . implode(', ', $updates) . " WHERE id = ?";
                
                $stmt = $db->prepare($sql);
                $stmt->execute($params);

                echo json_encode([
                    'success' => true,
                    'message' => 'Appointment updated successfully'
                ]);
            } catch (PDOException $e) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to update appointment: ' . $e->getMessage()
                ]);
            }
        } else {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Appointment ID is required'
            ]);
        }
        break;

    case 'DELETE':
        // Delete appointment
        if (isset($_GET['id'])) {
            try {
                $stmt = $db->prepare("DELETE FROM appointments WHERE id = ?");
                $stmt->execute([$_GET['id']]);

                echo json_encode([
                    'success' => true,
                    'message' => 'Appointment deleted successfully'
                ]);
            } catch (PDOException $e) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to delete appointment: ' . $e->getMessage()
                ]);
            }
        } else {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Appointment ID is required'
            ]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Method not allowed'
        ]);
        break;
} 