<?php

if (!defined('SECURE_ACCESS')) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

if ($_ENV['APP_ENV'] === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

// // Security headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("Content-Security-Policy: default-src 'self' https://cdnjs.cloudflare.com; script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://www.googletagmanager.com https://static.cloudflareinsights.com; style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://unpkg.com; img-src 'self' data:;");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains");

class Database {
    private static $instance = null;
    private $conn;
    
    private function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8mb4",
                $_ENV['DB_USER'],
                $_ENV['DB_PASS'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
                ]
            );
        } catch(PDOException $e) {
            error_log("Connection failed: " . $e->getMessage());
            throw new Exception("Database connection failed");
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    // Prevent cloning of the instance
    private function __clone() {}
}

class AppointmentManager {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    private function generateBookingReference() {
        return strtoupper(bin2hex(random_bytes(8)));
    }

    private function sanitizeInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }

    public function createAppointment($data) {
        try {
            // Sanitize all inputs
            $fullName = $this->sanitizeInput($data['name']);
            $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
            $phone = $this->sanitizeInput($data['phone']);
            
            // Validate appointment type
            $validTypes = ['solo', 'duo', 'trio', 'quad', 'deluxe', 'graduate', 'group'];
            if (!in_array($data['appointment_type'], $validTypes)) {
                throw new Exception("Invalid appointment type");
            }

            $bookingReference = $this->generateBookingReference();
            
            $stmt = $this->db->prepare("
                INSERT INTO appointments (
                    full_name, email, phone, appointment_type, 
                    photobooth_type, appointment_date, appointment_time,
                    price, booking_reference
                ) VALUES (
                    :full_name, :email, :phone, :appointment_type,
                    :photobooth_type, :appointment_date, :appointment_time,
                    :price, :booking_reference
                )
            ");

            $success = $stmt->execute([
                'full_name' => $fullName,
                'email' => $email,
                'phone' => $phone,
                'appointment_type' => $data['appointment_type'],
                'photobooth_type' => $data['photobooth_type'],
                'appointment_date' => $data['date'],
                'appointment_time' => $data['time'],
                'price' => $data['price'],
                'booking_reference' => $bookingReference
            ]);

            if ($success) {
                // Send confirmation email
                $this->sendConfirmationEmail($email, $bookingReference);
                return $bookingReference;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            throw new Exception("Failed to create appointment");
        }
    }

    public function getAppointment($bookingReference) {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM appointments 
                WHERE booking_reference = :booking_reference
            ");
            $stmt->execute(['booking_reference' => $bookingReference]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            throw new Exception("Failed to retrieve appointment");
        }
    }

    public function updateAppointment($bookingReference, $data) {
        try {
            $updateFields = [];
            $params = ['booking_reference' => $bookingReference];

            foreach ($data as $key => $value) {
                if ($value !== null && $key !== 'booking_reference') {
                    $updateFields[] = "$key = :$key";
                    $params[$key] = $this->sanitizeInput($value);
                }
            }

            if (empty($updateFields)) {
                return false;
            }

            $sql = "UPDATE appointments SET " . implode(', ', $updateFields) . 
                   " WHERE booking_reference = :booking_reference";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            throw new Exception("Failed to update appointment");
        }
    }

    public function deleteAppointment($bookingReference) {
        try {
            $stmt = $this->db->prepare("
                DELETE FROM appointments 
                WHERE booking_reference = :booking_reference
            ");
            return $stmt->execute(['booking_reference' => $bookingReference]);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            throw new Exception("Failed to delete appointment");
        }
    }

    private function sendConfirmationEmail($email, $bookingReference) {
        // Implementation for sending confirmation email
        // Use PHPMailer or similar library
    }
}

// Initialize session with secure settings
session_start([
    'cookie_httponly' => true,
    'cookie_secure' => true,
    'cookie_samesite' => 'Strict',
    'use_strict_mode' => true
]);

// Create global instance of AppointmentManager
$appointmentManager = new AppointmentManager();
?>