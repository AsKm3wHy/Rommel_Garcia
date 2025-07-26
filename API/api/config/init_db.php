<?php
// Database connection parameters
$host = 'localhost';
$dbname = 'rommelgarciaappointments';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Create booking_statuses table first (since it's referenced by bookings)
    $sql = "CREATE TABLE IF NOT EXISTS booking_statuses (
        id INT(11) NOT NULL AUTO_INCREMENT,
        name VARCHAR(50) NOT NULL,
        description TEXT DEFAULT NULL,
        color VARCHAR(20) NOT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
    $pdo->exec($sql);
    
    // Create bookings table
    $sql = "CREATE TABLE IF NOT EXISTS bookings (
        id INT(11) NOT NULL AUTO_INCREMENT,
        package VARCHAR(50) NOT NULL,
        full_name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        booking_date DATE NOT NULL,
        booking_time TIME NOT NULL,
        status ENUM('pending','confirmed','completed','cancelled') NOT NULL DEFAULT 'pending',
        status_id INT(11) DEFAULT 1,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY idx_package (package),
        KEY idx_email (email),
        KEY idx_booking_date (booking_date),
        KEY idx_status (status),
        KEY idx_status_id (status_id),
        CONSTRAINT fk_booking_status FOREIGN KEY (status_id) REFERENCES booking_statuses (id) ON DELETE SET NULL ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
    $pdo->exec($sql);
    
    // Create admin_users table
    $sql = "CREATE TABLE IF NOT EXISTS admin_users (
        id INT(11) NOT NULL AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY username (username)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
    $pdo->exec($sql);
    
    // Insert default admin user if not exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM admin_users WHERE username = 'admin'");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $password_hash = password_hash('admin123', PASSWORD_DEFAULT);
        $sql = "INSERT INTO admin_users (username, password) VALUES ('admin', :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':password', $password_hash);
        $stmt->execute();
    }
    
    // Insert default booking statuses if not exist
    $statuses = [
        ['pending', 'Booking is pending confirmation', '#f39c12'],
        ['confirmed', 'Booking has been confirmed', '#3498db'],
        ['completed', 'Booking has been completed', '#2ecc71'],
        ['cancelled', 'Booking has been cancelled', '#e74c3c']
    ];
    
    foreach ($statuses as $status) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM booking_statuses WHERE name = :name");
        $stmt->bindParam(':name', $status[0]);
        $stmt->execute();
        
        if ($stmt->fetchColumn() == 0) {
            $sql = "INSERT INTO booking_statuses (name, description, color) VALUES (:name, :description, :color)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $status[0]);
            $stmt->bindParam(':description', $status[1]);
            $stmt->bindParam(':color', $status[2]);
            $stmt->execute();
        }
    }
    
} catch(PDOException $e) {
    // Log error but don't output it
    error_log("Database initialization error: " . $e->getMessage());
}
?> 