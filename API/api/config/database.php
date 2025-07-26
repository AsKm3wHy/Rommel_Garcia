<?php
class Database {
    private $host = "localhost";
    private $db_name = "rommelgarciaappointments";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            // Include initialization script
            require_once __DIR__ . '/init_db.php';
            
            // Create connection
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->exec("set names utf8");
            return $this->conn;
        } catch(PDOException $e) {
            // Log error but don't output it
            error_log("Database connection error: " . $e->getMessage());
            return null;
        }
    }
}
?> 