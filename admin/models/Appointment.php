<?php
class Appointment {
    private $conn;
    private $table_name = "appointments";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get total appointments count
    public function getTotalAppointments() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['total'];
    }

    // Get new appointments count (appointments created today)
    public function getNewAppointments() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " 
                  WHERE DATE(created_at) = CURDATE()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['total'];
    }

    // Get today's sessions count
    public function getTodaySessions() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " 
                  WHERE appointment_date = CURDATE()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['total'];
    }

    // Get upcoming sessions count (next 7 days)
    public function getUpcomingSessions() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " 
                  WHERE appointment_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
                  AND appointment_date > CURDATE()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['total'];
    }

    // Get today's appointments
    public function getTodayAppointments() {
        $query = "SELECT id, full_name, notes as category, appointment_time 
                  FROM " . $this->table_name . " 
                  WHERE appointment_date = CURDATE() 
                  ORDER BY appointment_time ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get upcoming appointments for next week
    public function getUpcomingAppointments() {
        $query = "SELECT notes as category, full_name, appointment_date, appointment_time 
                  FROM " . $this->table_name . " 
                  WHERE appointment_date BETWEEN DATE_ADD(CURDATE(), INTERVAL 1 DAY) 
                  AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
                  ORDER BY appointment_date ASC, appointment_time ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Search appointments by client name
    public function searchAppointments($search_term) {
        $query = "SELECT id, full_name, notes as category, appointment_time 
                  FROM " . $this->table_name . " 
                  WHERE appointment_date = CURDATE() 
                  AND full_name LIKE :search_term
                  ORDER BY appointment_time ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':search_term', '%' . $search_term . '%');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Search upcoming appointments by client name
    public function searchUpcomingAppointments($search_term) {
        $query = "SELECT notes as category, full_name, appointment_date, appointment_time 
                  FROM " . $this->table_name . " 
                  WHERE appointment_date BETWEEN DATE_ADD(CURDATE(), INTERVAL 1 DAY) 
                  AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
                  AND full_name LIKE :search_term
                  ORDER BY appointment_date ASC, appointment_time ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':search_term', '%' . $search_term . '%');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Fetch all appointments
    public function getAllAppointments() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY appointment_date DESC, appointment_time ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Fetch appointment by ID
    public function getAppointmentById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Insert a new appointment
    public function addAppointment($data) {
        $query = "INSERT INTO " . $this->table_name . " (full_name, email, phone, appointment_date, appointment_time, status_id, notes) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['full_name'],
            $data['email'],
            $data['phone'],
            $data['appointment_date'],
            $data['appointment_time'],
            $data['status_id'],
            $data['notes']
        ]);
    }

    // Update an appointment
    public function updateAppointment($id, $data) {
        $query = "UPDATE " . $this->table_name . " SET full_name=?, email=?, phone=?, appointment_date=?, appointment_time=?, notes=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['full_name'],
            $data['email'],
            $data['phone'],
            $data['appointment_date'],
            $data['appointment_time'],
            $data['notes'],
            $id
        ]);
    }

    // Mark appointment as done (completed)
    public function markAsDone($id) {
        $query = "UPDATE " . $this->table_name . " SET status_id=3 WHERE id=?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    // Cancel appointment
    public function cancelAppointment($id) {
        $query = "UPDATE " . $this->table_name . " SET status_id=4 WHERE id=?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    // Set appointment as confirmed
    public function confirmAppointment($id) {
        $query = "UPDATE " . $this->table_name . " SET status_id=2 WHERE id=?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    // Set appointment as pending
    public function setPending($id) {
        $query = "UPDATE " . $this->table_name . " SET status_id=1 WHERE id=?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?> 