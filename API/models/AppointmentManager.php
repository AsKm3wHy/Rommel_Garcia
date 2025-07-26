<?php
class AppointmentManager {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAppointment($id) {
        $stmt = $this->db->prepare("
            SELECT a.*, 
                   CASE 
                       WHEN a.status_id = 1 THEN 'Pending'
                       WHEN a.status_id = 2 THEN 'Confirmed'
                       WHEN a.status_id = 3 THEN 'Completed'
                       WHEN a.status_id = 4 THEN 'Cancelled'
                       WHEN a.status_id = 5 THEN 'No Show'
                       ELSE 'Unknown'
                   END as status_name,
                   CASE 
                       WHEN a.status_id = 1 THEN 'warning'
                       WHEN a.status_id = 2 THEN 'info'
                       WHEN a.status_id = 3 THEN 'success'
                       WHEN a.status_id = 4 THEN 'danger'
                       WHEN a.status_id = 5 THEN 'secondary'
                       ELSE 'light'
                   END as status_color
            FROM appointments a 
            WHERE a.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAppointments($filters = []) {
        $sql = "
            SELECT a.*, 
                   CASE 
                       WHEN a.status_id = 1 THEN 'Pending'
                       WHEN a.status_id = 2 THEN 'Confirmed'
                       WHEN a.status_id = 3 THEN 'Completed'
                       WHEN a.status_id = 4 THEN 'Cancelled'
                       WHEN a.status_id = 5 THEN 'No Show'
                       ELSE 'Unknown'
                   END as status_name,
                   CASE 
                       WHEN a.status_id = 1 THEN 'warning'
                       WHEN a.status_id = 2 THEN 'info'
                       WHEN a.status_id = 3 THEN 'success'
                       WHEN a.status_id = 4 THEN 'danger'
                       WHEN a.status_id = 5 THEN 'secondary'
                       ELSE 'light'
                   END as status_color
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
                'Pending' => 1,
                'Confirmed' => 2,
                'Completed' => 3,
                'Cancelled' => 4,
                'No Show' => 5
            ];
            if (isset($statusMap[$filters['status']])) {
                $sql .= " AND a.status_id = ?";
                $params[] = $statusMap[$filters['status']];
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

        if (!empty($filters['search'])) {
            $search = '%' . $filters['search'] . '%';
            $sql .= " AND (a.full_name LIKE ? OR a.email LIKE ? OR a.phone LIKE ?)";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }

        if (!empty($filters['limit'])) {
            $sql .= " LIMIT " . (int)$filters['limit'];
        }

        $sql .= " ORDER BY a.appointment_date DESC, a.appointment_time ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAppointmentsWithStatus($filters = []) {
        return $this->getAppointments($filters);
    }

    public function getAppointmentsForDate($date) {
        $stmt = $this->db->prepare("
            SELECT a.*, 
                   CASE 
                       WHEN a.status_id = 1 THEN 'Pending'
                       WHEN a.status_id = 2 THEN 'Confirmed'
                       WHEN a.status_id = 3 THEN 'Completed'
                       WHEN a.status_id = 4 THEN 'Cancelled'
                       WHEN a.status_id = 5 THEN 'No Show'
                       ELSE 'Unknown'
                   END as status_name,
                   CASE 
                       WHEN a.status_id = 1 THEN 'warning'
                       WHEN a.status_id = 2 THEN 'info'
                       WHEN a.status_id = 3 THEN 'success'
                       WHEN a.status_id = 4 THEN 'danger'
                       WHEN a.status_id = 5 THEN 'secondary'
                       ELSE 'light'
                   END as status_color
            FROM appointments a 
            WHERE a.appointment_date = ?
            ORDER BY a.appointment_time ASC
        ");
        $stmt->execute([$date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createAppointment($data) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO appointments (
                    full_name, email, phone, 
                    appointment_date, appointment_time, 
                    status_id, notes
                ) VALUES (?, ?, ?, ?, ?, 1, ?)
            ");

            $stmt->execute([
                $data['full_name'],
                $data['email'],
                $data['phone'],
                $data['appointment_date'],
                $data['appointment_time'],
                $data['notes'] ?? null
            ]);

            $id = $this->db->lastInsertId();
            return [
                'success' => true,
                'id' => $id,
                'message' => 'Appointment created successfully'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Failed to create appointment: ' . $e->getMessage()
            ];
        }
    }

    public function updateAppointment($id, $data) {
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
                return [
                    'success' => false,
                    'message' => 'No valid fields to update'
                ];
            }

            $params[] = $id;
            $sql = "UPDATE appointments SET " . implode(', ', $updates) . " WHERE id = ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);

            return [
                'success' => true,
                'message' => 'Appointment updated successfully'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Failed to update appointment: ' . $e->getMessage()
            ];
        }
    }

    public function updateAppointmentStatus($id, $status) {
        try {
            $stmt = $this->db->prepare("UPDATE appointments SET status_id = ? WHERE id = ?");
            $stmt->execute([$status, $id]);

            return [
                'success' => true,
                'message' => 'Appointment status updated successfully'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Failed to update appointment status: ' . $e->getMessage()
            ];
        }
    }

    public function updateAppointmentNotes($id, $notes) {
        try {
            $stmt = $this->db->prepare("UPDATE appointments SET notes = ? WHERE id = ?");
            $stmt->execute([$notes, $id]);

            return [
                'success' => true,
                'message' => 'Appointment notes updated successfully'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Failed to update appointment notes: ' . $e->getMessage()
            ];
        }
    }

    public function deleteAppointment($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM appointments WHERE id = ?");
            $stmt->execute([$id]);

            return [
                'success' => true,
                'message' => 'Appointment deleted successfully'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Failed to delete appointment: ' . $e->getMessage()
            ];
        }
    }

    public function bulkDeleteAppointments($ids) {
        try {
            $placeholders = str_repeat('?,', count($ids) - 1) . '?';
            $stmt = $this->db->prepare("DELETE FROM appointments WHERE id IN ($placeholders)");
            $stmt->execute($ids);

            return [
                'success' => true,
                'message' => count($ids) . ' appointments deleted successfully'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Failed to delete appointments: ' . $e->getMessage()
            ];
        }
    }

    public function bulkUpdateAppointments($data) {
        try {
            if (!isset($data['ids']) || !isset($data['updates'])) {
                return [
                    'success' => false,
                    'message' => 'IDs and updates required'
                ];
            }

            $updates = [];
            $params = [];

            $allowedFields = ['status_id', 'notes'];
            
            foreach ($data['updates'] as $key => $value) {
                if (in_array($key, $allowedFields)) {
                    $updates[] = "$key = ?";
                    $params[] = $value;
                }
            }

            if (empty($updates)) {
                return [
                    'success' => false,
                    'message' => 'No valid fields to update'
                ];
            }

            $placeholders = str_repeat('?,', count($data['ids']) - 1) . '?';
            $params = array_merge($params, $data['ids']);
            
            $sql = "UPDATE appointments SET " . implode(', ', $updates) . " WHERE id IN ($placeholders)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);

            return [
                'success' => true,
                'message' => count($data['ids']) . ' appointments updated successfully'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Failed to update appointments: ' . $e->getMessage()
            ];
        }
    }

    public function getDashboardStats() {
        try {
            // Total appointments
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM appointments");
            $stmt->execute();
            $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

            // New appointments (today)
            $stmt = $this->db->prepare("SELECT COUNT(*) as new FROM appointments WHERE DATE(created_at) = CURDATE()");
            $stmt->execute();
            $new = $stmt->fetch(PDO::FETCH_ASSOC)['new'];

            // Today's appointments
            $stmt = $this->db->prepare("SELECT COUNT(*) as today FROM appointments WHERE appointment_date = CURDATE()");
            $stmt->execute();
            $today = $stmt->fetch(PDO::FETCH_ASSOC)['today'];

            // Upcoming appointments (next 7 days)
            $stmt = $this->db->prepare("SELECT COUNT(*) as upcoming FROM appointments WHERE appointment_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)");
            $stmt->execute();
            $upcoming = $stmt->fetch(PDO::FETCH_ASSOC)['upcoming'];

            return [
                'total' => $total,
                'new' => $new,
                'today' => $today,
                'upcoming' => $upcoming
            ];
        } catch (PDOException $e) {
            return [
                'total' => 0,
                'new' => 0,
                'today' => 0,
                'upcoming' => 0
            ];
        }
    }

    public function getAppointmentHistory($filters = []) {
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
            WHERE a.appointment_date < CURDATE()
        ";
        $params = [];

        if (!empty($filters['status'])) {
            $statusMap = [
                'Pending' => 1,
                'Confirmed' => 2,
                'Completed' => 3,
                'Cancelled' => 4,
                'No Show' => 5
            ];
            if (isset($statusMap[$filters['status']])) {
                $sql .= " AND a.status_id = ?";
                $params[] = $statusMap[$filters['status']];
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

        if (!empty($filters['search'])) {
            $search = '%' . $filters['search'] . '%';
            $sql .= " AND (a.full_name LIKE ? OR a.email LIKE ? OR a.phone LIKE ?)";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }

        $sql .= " ORDER BY a.appointment_date DESC, a.appointment_time ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCalendarEvents() {
        $stmt = $this->db->prepare("
            SELECT 
                id,
                full_name as title,
                appointment_date as start,
                CONCAT(appointment_date, ' ', appointment_time) as start_datetime,
                notes,
                CASE 
                    WHEN status_id = 1 THEN '#ffc107'
                    WHEN status_id = 2 THEN '#17a2b8'
                    WHEN status_id = 3 THEN '#28a745'
                    WHEN status_id = 4 THEN '#dc3545'
                    WHEN status_id = 5 THEN '#6c757d'
                    ELSE '#6c757d'
                END as backgroundColor
            FROM appointments 
            WHERE appointment_date >= CURDATE() - INTERVAL 30 DAY
            ORDER BY appointment_date ASC, appointment_time ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAppointmentsForDateRange($startDate, $endDate) {
        $stmt = $this->db->prepare("
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
            WHERE a.appointment_date BETWEEN ? AND ?
            ORDER BY a.appointment_date ASC, a.appointment_time ASC
        ");
        $stmt->execute([$startDate, $endDate]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function exportAppointments($filters = []) {
        $appointments = $this->getAppointments($filters);
        
        if (empty($appointments)) {
            return [
                'success' => false,
                'message' => 'No appointments found to export'
            ];
        }

        $filename = 'appointments_' . date('Y-m-d_H-i-s') . '.csv';
        $filepath = sys_get_temp_dir() . '/' . $filename;
        
        $file = fopen($filepath, 'w');
        
        // Write headers
        fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'Date', 'Time', 'Status', 'Notes', 'Created']);
        
        // Write data
        foreach ($appointments as $appointment) {
            fputcsv($file, [
                $appointment['id'],
                $appointment['full_name'],
                $appointment['email'],
                $appointment['phone'],
                $appointment['appointment_date'],
                $appointment['appointment_time'],
                $appointment['status_name'],
                $appointment['notes'],
                $appointment['created_at']
            ]);
        }
        
        fclose($file);
        
        return [
            'success' => true,
            'file' => $filepath,
            'filename' => $filename,
            'count' => count($appointments)
        ];
    }

    public function getAppointmentStatuses() {
        return [
            ['id' => 1, 'name' => 'Pending', 'description' => 'Appointment is pending confirmation', 'color' => 'warning'],
            ['id' => 2, 'name' => 'Confirmed', 'description' => 'Appointment has been confirmed', 'color' => 'info'],
            ['id' => 3, 'name' => 'Completed', 'description' => 'Appointment has been completed', 'color' => 'success'],
            ['id' => 4, 'name' => 'Cancelled', 'description' => 'Appointment has been cancelled', 'color' => 'danger'],
            ['id' => 5, 'name' => 'No Show', 'description' => 'Client did not show up', 'color' => 'secondary']
        ];
    }

    public function getTodaysAppointments() {
        $stmt = $this->db->prepare("
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
            WHERE a.appointment_date = CURDATE()
            ORDER BY a.appointment_time ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUpcomingAppointments($days = 7) {
        $stmt = $this->db->prepare("
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
            WHERE a.appointment_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL ? DAY)
            ORDER BY a.appointment_date ASC, a.appointment_time ASC
        ");
        $stmt->execute([$days]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchAppointments($searchTerm) {
        $search = '%' . $searchTerm . '%';
        $stmt = $this->db->prepare("
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
            WHERE a.full_name LIKE ? OR a.email LIKE ? OR a.phone LIKE ? OR a.notes LIKE ?
            ORDER BY a.appointment_date DESC, a.appointment_time ASC
        ");
        $stmt->execute([$search, $search, $search, $search]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 