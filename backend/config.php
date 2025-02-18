<?php
// Prevent direct access to this file
if (!defined('AUTHORIZED')) {
    http_response_code(403);
    exit('Access Denied');
}   

// General Configuration
define('DEBUG_MODE', true);  // Set to true for development, false for production

// Configure error reporting based on environment
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Security: Set secure PHP options
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    ini_set('session.cookie_secure', 1);
}

// Database configuration

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();


define('DB_HOST', $_ENV['DB_HOST']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);
define('DB_NAME', $_ENV['DB_NAME']);
define('APP_ENV', $_ENV['APP_ENV']);

// Database connection class with PDO for security
class Database {
    private static $instance = null;
    private $conn;
    
    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            ];
            
            $this->conn = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            if (DEBUG_MODE) {
                die("Connection failed: " . $e->getMessage());
            } else {
                die("Database connection error. Please try again later.");
            }
        }
    }
    
    // Singleton pattern to ensure only one database connection
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->conn;
    }
    
    // Prevent cloning and unserialization
    private function __clone() {}
    // private function __wakeup() {}
}

// CRUD Operations class
class AppointmentManager {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Function to sanitize inputs
    private function sanitizeInput($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->sanitizeInput($value);
            }
        } else {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        }
        return $data;
    }
    
    // Create appointment
    public function createAppointment($data) {
        try {
            $data = $this->sanitizeInput($data);
            
            // Generate a unique reference number
            $referenceNumber = $this->generateReferenceNumber();
            
            $sql = "INSERT INTO appointments (
                reference_number, 
                name, 
                phone, 
                email, 
                appointment_type, 
                price, 
                photobooth_type, 
                appointment_date, 
                appointment_time, 
                status, 
                created_at
            ) VALUES (
                :reference_number, 
                :name, 
                :phone, 
                :email, 
                :appointment_type, 
                :price, 
                :photobooth_type, 
                :appointment_date, 
                :appointment_time, 
                :status, 
                NOW()
            )";
            
            $stmt = $this->db->prepare($sql);
            
            // Remove currency symbol and convert to float for price
            $price = str_replace(['₱', ' '], '', $data['price']);
            
            $stmt->bindParam(':reference_number', $referenceNumber);
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':appointment_type', $data['appointment_type']);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':photobooth_type', $data['photobooth_type']);
            $stmt->bindParam(':appointment_date', $data['appointment_date']);
            $stmt->bindParam(':appointment_time', $data['appointment_time']);
            
            $status = 'pending'; // Default status
            $stmt->bindParam(':status', $status);
            
            $stmt->execute();
            
            return [
                'success' => true,
                'reference_number' => $referenceNumber,
                'message' => 'Appointment created successfully'
            ];
            
        } catch (PDOException $e) {
            $errorMsg = DEBUG_MODE ? $e->getMessage() : "Error creating appointment. Please try again.";
            return ['success' => false, 'message' => $errorMsg];
        }
    }
    
    // Generate a unique reference number
    private function generateReferenceNumber() {
        $prefix = 'RM';
        $timestamp = time();
        $random = rand(1000, 9999);
        $referenceNumber = $prefix . $timestamp . $random;
        
        // Make sure it's unique
        while ($this->referenceNumberExists($referenceNumber)) {
            $random = rand(1000, 9999);
            $referenceNumber = $prefix . $timestamp . $random;
        }
        
        return $referenceNumber;
    }
    
    // Check if reference number already exists
    private function referenceNumberExists($referenceNumber) {
        $sql = "SELECT COUNT(*) FROM appointments WHERE reference_number = :reference_number";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':reference_number', $referenceNumber);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }
    
    // Read appointment(s) with flexible filtering options
    public function getAppointments($filters = [], $orderBy = 'appointment_date', $order = 'ASC', $limit = null, $offset = 0) {
        try {
            $filterSQL = '';
            $params = [];
            
            // Build the WHERE clause based on filters
            if (!empty($filters)) {
                $filterConditions = [];
                
                foreach ($filters as $field => $value) {
                    if ($field === 'date_range') {
                        if (isset($value['start']) && isset($value['end'])) {
                            $filterConditions[] = "appointment_date BETWEEN :date_start AND :date_end";
                            $params[':date_start'] = $value['start'];
                            $params[':date_end'] = $value['end'];
                        }
                    } elseif ($field === 'appointment_date' && is_array($value)) {
                        // For array of dates
                        $dateParams = [];
                        foreach ($value as $index => $date) {
                            $paramName = ":date_$index";
                            $dateParams[] = $paramName;
                            $params[$paramName] = $date;
                        }
                        $filterConditions[] = "appointment_date IN (" . implode(', ', $dateParams) . ")";
                    } elseif ($field === 'search') {
                        // For general search across name, email, phone, reference number
                        $filterConditions[] = "(name LIKE :search OR email LIKE :search OR phone LIKE :search OR reference_number LIKE :search)";
                        $params[':search'] = '%' . $value . '%';
                    } else {
                        // For exact matches
                        $filterConditions[] = "$field = :$field";
                        $params[":$field"] = $value;
                    }
                }
                
                if (!empty($filterConditions)) {
                    $filterSQL = "WHERE " . implode(' AND ', $filterConditions);
                }
            }
            
            // Build the ORDER BY clause
            $orderClause = "ORDER BY $orderBy $order";
            
            // Build the LIMIT clause
            $limitClause = '';
            if ($limit !== null) {
                $limitClause = "LIMIT :offset, :limit";
                $params[':offset'] = (int) $offset;
                $params[':limit'] = (int) $limit;
            }
            
            $sql = "SELECT * FROM appointments $filterSQL $orderClause $limitClause";
            $stmt = $this->db->prepare($sql);
            
            // Bind parameters
            foreach ($params as $param => $value) {
                if ($param === ':offset' || $param === ':limit') {
                    $stmt->bindValue($param, $value, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue($param, $value);
                }
            }
            
            $stmt->execute();
            $results = $stmt->fetchAll();
            
            // Get total count without limits for pagination
            $countSql = "SELECT COUNT(*) FROM appointments $filterSQL";
            $countStmt = $this->db->prepare($countSql);
            
            // Bind parameters for count query (excluding offset and limit)
            foreach ($params as $param => $value) {
                if ($param !== ':offset' && $param !== ':limit') {
                    $countStmt->bindValue($param, $value);
                }
            }
            
            $countStmt->execute();
            $totalCount = $countStmt->fetchColumn();
            
            return [
                'success' => true,
                'data' => $results,
                'total_count' => $totalCount,
                'filtered_count' => count($results)
            ];
            
        } catch (PDOException $e) {
            $errorMsg = DEBUG_MODE ? $e->getMessage() : "Error retrieving appointments. Please try again.";
            return ['success' => false, 'message' => $errorMsg];
        }
    }
    
    // Get a single appointment by ID or reference number
    public function getAppointment($identifier, $idType = 'id') {
        try {
            $field = ($idType === 'reference') ? 'reference_number' : 'id';
            
            $sql = "SELECT * FROM appointments WHERE $field = :identifier";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':identifier', $identifier);
            $stmt->execute();
            
            $result = $stmt->fetch();
            
            if ($result) {
                return ['success' => true, 'data' => $result];
            } else {
                return ['success' => false, 'message' => 'Appointment not found'];
            }
            
        } catch (PDOException $e) {
            $errorMsg = DEBUG_MODE ? $e->getMessage() : "Error retrieving appointment. Please try again.";
            return ['success' => false, 'message' => $errorMsg];
        }
    }
    
    // Update appointment
    public function updateAppointment($id, $data, $idType = 'id') {
        try {
            $data = $this->sanitizeInput($data);
            
            // Prepare the SET part of the query
            $updates = [];
            $params = [];
            
            foreach ($data as $key => $value) {
                // Skip the id field itself
                if ($key !== 'id' && $key !== 'reference_number') {
                    // Special handling for price field
                    if ($key === 'price' && is_string($value) && strpos($value, '₱') !== false) {
                        $value = str_replace(['₱', ' '], '', $value);
                    }
                    
                    $updates[] = "$key = :$key";
                    $params[":$key"] = $value;
                }
            }
            
            // If no fields to update, return
            if (empty($updates)) {
                return ['success' => false, 'message' => 'No fields to update'];
            }
            
            // Add the identifier
            $field = ($idType === 'reference') ? 'reference_number' : 'id';
            $params[':identifier'] = $id;
            
            $sql = "UPDATE appointments SET " . implode(', ', $updates) . " WHERE $field = :identifier";
            $stmt = $this->db->prepare($sql);
            
            // Bind all parameters
            foreach ($params as $param => $value) {
                $stmt->bindValue($param, $value);
            }
            
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Appointment updated successfully'];
            } else {
                return ['success' => false, 'message' => 'No changes made or appointment not found'];
            }
            
        } catch (PDOException $e) {
            $errorMsg = DEBUG_MODE ? $e->getMessage() : "Error updating appointment. Please try again.";
            return ['success' => false, 'message' => $errorMsg];
        }
    }
    
    // Delete appointment
    public function deleteAppointment($id, $idType = 'id') {
        try {
            $field = ($idType === 'reference') ? 'reference_number' : 'id';
            
            $sql = "DELETE FROM appointments WHERE $field = :identifier";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':identifier', $id);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Appointment deleted successfully'];
            } else {
                return ['success' => false, 'message' => 'Appointment not found'];
            }
            
        } catch (PDOException $e) {
            $errorMsg = DEBUG_MODE ? $e->getMessage() : "Error deleting appointment. Please try again.";
            return ['success' => false, 'message' => $errorMsg];
        }
    }
    
    // Dashboard Statistics
    public function getDashboardStats() {
        try {
            $stats = [];
            
            // Today's appointments
            $todayDate = date('Y-m-d');
            $sql = "SELECT COUNT(*) FROM appointments WHERE appointment_date = :today_date";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':today_date', $todayDate);
            $stmt->execute();
            $stats['today_appointments'] = $stmt->fetchColumn();
            
            // New appointments (last 7 days)
            $sevenDaysAgo = date('Y-m-d', strtotime('-7 days'));
            $sql = "SELECT COUNT(*) FROM appointments WHERE created_at >= :seven_days_ago";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':seven_days_ago', $sevenDaysAgo);
            $stmt->execute();
            $stats['new_appointments'] = $stmt->fetchColumn();
            
            // Upcoming appointments (next 7 days)
            $nextSevenDays = date('Y-m-d', strtotime('+7 days'));
            $sql = "SELECT COUNT(*) FROM appointments WHERE appointment_date > :today_date AND appointment_date <= :next_seven_days";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':today_date', $todayDate);
            $stmt->bindParam(':next_seven_days', $nextSevenDays);
            $stmt->execute();
            $stats['upcoming_appointments'] = $stmt->fetchColumn();
            
            // Total appointments
            $sql = "SELECT COUNT(*) FROM appointments";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $stats['total_appointments'] = $stmt->fetchColumn();
            
            // Appointments by status
            $sql = "SELECT status, COUNT(*) as count FROM appointments GROUP BY status";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $stats['status_breakdown'] = $stmt->fetchAll();
            
            // Appointments by month (for chart)
            $sql = "SELECT DATE_FORMAT(appointment_date, '%Y-%m') as month, COUNT(*) as count 
                    FROM appointments 
                    WHERE appointment_date >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
                    GROUP BY DATE_FORMAT(appointment_date, '%Y-%m')
                    ORDER BY month";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $stats['monthly_breakdown'] = $stmt->fetchAll();
            
            return ['success' => true, 'data' => $stats];
            
        } catch (PDOException $e) {
            $errorMsg = DEBUG_MODE ? $e->getMessage() : "Error retrieving dashboard statistics. Please try again.";
            return ['success' => false, 'message' => $errorMsg];
        }
    }
    
    // Get appointments for specific date (for calendar view)
    public function getAppointmentsForDate($date) {
        try {
            $sql = "SELECT * FROM appointments WHERE appointment_date = :date ORDER BY appointment_time";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':date', $date);
            $stmt->execute();
            
            $results = $stmt->fetchAll();
            
            return ['success' => true, 'data' => $results];
            
        } catch (PDOException $e) {
            $errorMsg = DEBUG_MODE ? $e->getMessage() : "Error retrieving appointments for date. Please try again.";
            return ['success' => false, 'message' => $errorMsg];
        }
    }
    
    // Get available time slots for a specific date
    public function getAvailableTimeSlots($date) {
        try {
            // Define all possible time slots
            $allTimeSlots = [
                '8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', 
                '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM', '5:00 PM'
            ];
            
            // Get booked time slots
            $sql = "SELECT appointment_time FROM appointments WHERE appointment_date = :date AND status != 'cancelled'";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':date', $date);
            $stmt->execute();
            
            $bookedSlots = [];
            while ($row = $stmt->fetch()) {
                $bookedSlots[] = $row['appointment_time'];
            }
            
            // Calculate available slots
            $availableSlots = array_diff($allTimeSlots, $bookedSlots);
            
            return ['success' => true, 'data' => array_values($availableSlots)];
            
        } catch (PDOException $e) {
            $errorMsg = DEBUG_MODE ? $e->getMessage() : "Error retrieving available time slots. Please try again.";
            return ['success' => false, 'message' => $errorMsg];
        }
    }
}

// Anti-CSRF Protection
class CSRFProtection {
    public static function generateToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    public static function verifyToken($token) {
        if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            return false;
        }
        return true;
    }
}

// Initialize database tables if not already created
function initializeDatabaseTables() {
    try {
        $db = Database::getInstance()->getConnection();
        
        // Check if appointments table exists
        $result = $db->query("SHOW TABLES LIKE 'appointments'");
        
        if ($result->rowCount() == 0) {
            // Create appointments table
            $sql = "CREATE TABLE appointments (
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                reference_number VARCHAR(20) NOT NULL UNIQUE,
                name VARCHAR(255) NOT NULL,
                phone VARCHAR(20) NOT NULL,
                email VARCHAR(255) NOT NULL,
                appointment_type VARCHAR(50) NOT NULL,
                price DECIMAL(10,2) NOT NULL,
                photobooth_type VARCHAR(50) NOT NULL,
                appointment_date DATE NOT NULL,
                appointment_time VARCHAR(20) NOT NULL,
                status ENUM('pending', 'confirmed', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
                notes TEXT,
                created_at DATETIME NOT NULL,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                KEY idx_appointment_date (appointment_date),
                KEY idx_status (status),
                KEY idx_created_at (created_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            
            $db->exec($sql);
        }
        
    } catch (PDOException $e) {
        if (DEBUG_MODE) {
            die("Database initialization error: " . $e->getMessage());
        } else {
            die("An error occurred during system initialization. Please contact support.");
        }
    }
}

// Run database initialization
initializeDatabaseTables();

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Function to securely log sensitive actions
function logActivity($action, $details, $userId = 'System') {
    $logFile = dirname(__FILE__) . '/logs/activity_' . date('Y-m-d') . '.log';
    $logDir = dirname($logFile);
    
    // Create log directory if it doesn't exist
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    
    $logMessage = sprintf(
        "[%s] %s | IP: %s | User Agent: %s | Action: %s | Details: %s\n",
        $timestamp,
        $userId,
        $ip,
        $userAgent,
        $action,
        $details
    );
    
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

// Helper function to sanitize output
function sanitizeOutput($data) {
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = sanitizeOutput($value);
        }
    } else {
        // Convert special characters to HTML entities
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
    return $data;
}

// Initialize appointments manager
$appointmentManager = new AppointmentManager();