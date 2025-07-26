<?php
class Booking {
    private $conn;
    private $table_name = "bookings";

    public $id;
    public $package;
    public $full_name;
    public $email;
    public $phone;
    public $booking_date;
    public $booking_time;
    public $status;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        try {
            $query = "SELECT b.*, bs.name as status_name, bs.color as status_color 
                     FROM bookings b 
                     LEFT JOIN booking_statuses bs ON b.status_id = bs.id 
                     ORDER BY b.booking_date DESC, b.booking_time ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // If the status_id column doesn't exist, fall back to basic query
            $query = "SELECT * FROM bookings ORDER BY booking_date DESC, booking_time ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function readOne() {
        try {
            $query = "SELECT b.*, bs.name as status_name, bs.color as status_color 
                     FROM bookings b 
                     LEFT JOIN booking_statuses bs ON b.status_id = bs.id 
                     WHERE b.id = :id LIMIT 0,1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // If the status_id column doesn't exist, fall back to basic query
            $query = "SELECT * FROM bookings WHERE id = :id LIMIT 0,1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function create() {
        try {
            $query = "INSERT INTO bookings 
                    (package, full_name, email, phone, booking_date, booking_time, status_id, created_at, updated_at) 
                    VALUES 
                    (:package, :full_name, :email, :phone, :booking_date, :booking_time, 1, NOW(), NOW())";
            
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":package", $this->package);
            $stmt->bindParam(":full_name", $this->full_name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":booking_date", $this->booking_date);
            $stmt->bindParam(":booking_time", $this->booking_time);

            if($stmt->execute()) {
                $this->id = $this->conn->lastInsertId();
                return true;
            }
            return false;
        } catch (PDOException $e) {
            // If the status_id column doesn't exist, fall back to basic query
            $query = "INSERT INTO bookings 
                    (package, full_name, email, phone, booking_date, booking_time, created_at, updated_at) 
                    VALUES 
                    (:package, :full_name, :email, :phone, :booking_date, :booking_time, NOW(), NOW())";
            
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":package", $this->package);
            $stmt->bindParam(":full_name", $this->full_name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":booking_date", $this->booking_date);
            $stmt->bindParam(":booking_time", $this->booking_time);

            if($stmt->execute()) {
                $this->id = $this->conn->lastInsertId();
                return true;
            }
            return false;
        }
    }

    public function update() {
        try {
            $query = "UPDATE bookings 
                    SET package = :package,
                        full_name = :full_name,
                        email = :email,
                        phone = :phone,
                        booking_date = :booking_date,
                        booking_time = :booking_time,
                        updated_at = NOW()
                    WHERE id = :id";
        } catch (PDOException $e) {
            // If the status_id column doesn't exist, fall back to basic query
            $query = "UPDATE bookings 
                    SET package = :package,
                        full_name = :full_name,
                        email = :email,
                        phone = :phone,
                        booking_date = :booking_date,
                        booking_time = :booking_time,
                        updated_at = NOW()
                    WHERE id = :id";
        }

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":package", $this->package);
        $stmt->bindParam(":full_name", $this->full_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":booking_date", $this->booking_date);
        $stmt->bindParam(":booking_time", $this->booking_time);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function searchByDate($date) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE booking_date = ? ORDER BY booking_time ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $date);
        $stmt->execute();
        return $stmt;
    }

    public function searchByName($search_term) {
        try {
            $query = "SELECT b.*, bs.name as status_name, bs.color as status_color 
                     FROM bookings b 
                     LEFT JOIN booking_statuses bs ON b.status_id = bs.id 
                     WHERE b.full_name LIKE :search_term 
                     ORDER BY b.booking_date DESC, b.booking_time ASC";
            $stmt = $this->conn->prepare($query);
            $search_term = "%{$search_term}%";
            $stmt->bindParam(":search_term", $search_term);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // If the status_id column doesn't exist, fall back to basic query
            $query = "SELECT * FROM bookings WHERE full_name LIKE :search_term ORDER BY booking_date DESC, booking_time ASC";
            $stmt = $this->conn->prepare($query);
            $search_term = "%{$search_term}%";
            $stmt->bindParam(":search_term", $search_term);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function updateStatus() {
        try {
            // First try with status_id
            $query = "UPDATE bookings SET status_id = :status_id, updated_at = NOW() WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            
            // Map status names to IDs
            $status_map = [
                'pending' => 1,
                'confirmed' => 2,
                'completed' => 3,
                'cancelled' => 4
            ];
            
            $status_id = $status_map[$this->status] ?? 1; // Default to pending if status not found
            $stmt->bindParam(":status_id", $status_id);
            $stmt->bindParam(":id", $this->id);
            
            if($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            // If the status_id column doesn't exist, try with status column
            try {
                $query = "UPDATE bookings SET status = :status, updated_at = NOW() WHERE id = :id";
                $stmt = $this->conn->prepare($query);
                
                $stmt->bindParam(":status", $this->status);
                $stmt->bindParam(":id", $this->id);
                
                if($stmt->execute()) {
                    return true;
                }
                return false;
            } catch (PDOException $e) {
                return false;
            }
        }
    }
}
?> 