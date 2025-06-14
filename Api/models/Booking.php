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
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all bookings
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get single booking
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->package = $row['package'];
            $this->full_name = $row['full_name'];
            $this->email = $row['email'];
            $this->phone = $row['phone'];
            $this->booking_date = $row['booking_date'];
            $this->booking_time = $row['booking_time'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }
        return false;
    }

    // Create booking
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET package=:package, full_name=:full_name, email=:email, 
                      phone=:phone, booking_date=:booking_date, booking_time=:booking_time";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize
        $this->package = htmlspecialchars(strip_tags($this->package));
        $this->full_name = htmlspecialchars(strip_tags($this->full_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->booking_date = htmlspecialchars(strip_tags($this->booking_date));
        $this->booking_time = htmlspecialchars(strip_tags($this->booking_time));
        
        // Bind values
        $stmt->bindParam(":package", $this->package);
        $stmt->bindParam(":full_name", $this->full_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":booking_date", $this->booking_date);
        $stmt->bindParam(":booking_time", $this->booking_time);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update booking
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET package=:package, full_name=:full_name, email=:email, 
                      phone=:phone, booking_date=:booking_date, booking_time=:booking_time,
                      updated_at=CURRENT_TIMESTAMP
                  WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize
        $this->package = htmlspecialchars(strip_tags($this->package));
        $this->full_name = htmlspecialchars(strip_tags($this->full_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->booking_date = htmlspecialchars(strip_tags($this->booking_date));
        $this->booking_time = htmlspecialchars(strip_tags($this->booking_time));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Bind values
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

    // Delete booking
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

    // Search bookings
    public function search($keywords) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE full_name LIKE ? OR email LIKE ? OR package LIKE ? OR phone LIKE ?
                  ORDER BY created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        
        $keywords = htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
        
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);
        $stmt->bindParam(4, $keywords);
        
        $stmt->execute();
        return $stmt;
    }

    // Get bookings by package
    public function getByPackage($package) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE package = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $package);
        $stmt->execute();
        return $stmt;
    }

    // Get bookings by date range
    public function getByDateRange($start_date, $end_date) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE booking_date BETWEEN ? AND ? 
                  ORDER BY booking_date ASC, booking_time ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $start_date);
        $stmt->bindParam(2, $end_date);
        $stmt->execute();
        return $stmt;
    }

    // Validate package
    public function isValidPackage($package) {
        $valid_packages = [
            'SOLO', 'DUO', 'TRIO', 'QUAD', 'DELUXE', 'GROUP', 'GRADUATE',
            'GRADUATE Package 1', 'GRADUATE Package 2', 'GRADUATE Package 3', 'GRADUATE Package 4',
            'UNO', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS'
        ];
        return in_array($package, $valid_packages);
    }

    // Validate email
    public function isValidEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    // Validate date
    public function isValidDate($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

    // Validate time
    public function isValidTime($time) {
        $t = DateTime::createFromFormat('H:i', $time);
        return $t && $t->format('H:i') === $time;
    }
}