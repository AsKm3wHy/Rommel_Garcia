<?php
namespace Api\Models;

class AppointmentModel {
    private $db;
    private $priceList = [
        'solo' => 500,
        'duo' => 800,
        'trio' => 900,
        'quad' => 1000,
        'deluxe' => 2500,
        'group' => 1500,
        'graduate' => 800
    ];

    public function __construct() {
        $this->db = \Api\Config\Database::getInstance()->getConnection();
    }

    public function create(array $data) {
        $price = $this->calculatePrice($data['appointment_type']);
        
        $stmt = $this->db->prepare("
            INSERT INTO appointments (
                full_name, email, phone, appointment_type, 
                photobooth_type, appointment_date, appointment_time,
                price, status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')
        ");

        $stmt->execute([
            $data['full_name'],
            $data['email'],
            $data['phone'],
            $data['appointment_type'],
            $data['photobooth_type'],
            $data['appointment_date'],
            $data['appointment_time'],
            $price
        ]);

        return $this->db->lastInsertId();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM appointments WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function update($id, array $data) {
        $allowedFields = ['status', 'appointment_date', 'appointment_time'];
        $updates = array_intersect_key($data, array_flip($allowedFields));
        
        if (empty($updates)) return false;

        $sql = "UPDATE appointments SET " . 
               implode('=?, ', array_keys($updates)) . "=? " .
               "WHERE id = ?";
        
        return $this->db->prepare($sql)->execute([...array_values($updates), $id]);
    }

    public function checkAvailability($date, $time) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM appointments 
            WHERE appointment_date = ? 
            AND appointment_time = ? 
            AND status != 'cancelled'
        ");
        $stmt->execute([$date, $time]);
        return $stmt->fetchColumn() === 0;
    }

    private function calculatePrice($type) {
        return $this->priceList[$type] ?? 500;
    }

    public function validateAppointment($data) {
        if (empty($data['full_name']) || empty($data['email']) || 
            empty($data['phone']) || empty($data['appointment_type']) || 
            empty($data['photobooth_type']) || empty($data['appointment_date']) || 
            empty($data['appointment_time'])) {
            throw new \Exception("Missing required fields");
        }

        if (!in_array($data['appointment_type'], array_keys($this->priceList))) {
            throw new \Exception("Invalid appointment type");
        }

        if (!in_array($data['photobooth_type'], ['360 Video', 'Self Mirror', 'Self-Portrait'])) {
            throw new \Exception("Invalid photobooth type");
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("Invalid email format");
        }
    }
}