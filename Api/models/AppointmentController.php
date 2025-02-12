<?php
namespace Api\Models;

class AppointmentModel extends \Api\Core\Model {
    protected $table = 'appointments';

    public function create(array $data) {
        $bookingRef = strtoupper(bin2hex(random_bytes(8)));
        
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (
                full_name, email, phone, appointment_type, 
                appointment_date, appointment_time, booking_reference
            ) VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['appointment_type'],
            $data['date'],
            $data['time'],
            $bookingRef
        ]);

        return $bookingRef;
    }

    public function read($ref) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE booking_reference = ?");
        $stmt->execute([$ref]);
        return $stmt->fetch();
    }

    public function update($ref, array $data) {
        $fields = [];
        $values = [];
        
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }
        
        $values[] = $ref;
        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . 
               " WHERE booking_reference = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    public function delete($ref) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE booking_reference = ?");
        return $stmt->execute([$ref]);
    }
}