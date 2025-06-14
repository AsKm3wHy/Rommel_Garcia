<?php

class Package {
    private $conn;
    private $table_name = "packages";

    public $id;
    public $name;
    public $description;
    public $price;
    public $duration;
    public $max_participants;
    public $is_active;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all packages
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE is_active = 1 ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get single package
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->name = $row['name'];
            $this->description = $row['description'];
            $this->price = $row['price'];
            $this->duration = $row['duration'];
            $this->max_participants = $row['max_participants'];
            $this->is_active = $row['is_active'];
            return true;
        }
        return false;
    }
}