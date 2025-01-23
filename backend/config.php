<?php
// config.php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'photography_appointments');

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
if ($conn->query($sql) === FALSE) {
    die("Error creating database: " . $conn->error);
}

$conn->select_db(DB_NAME);

$sql = "CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    appointment_type ENUM('solo', 'duo', 'trio', 'quad', 'deluxe', 'graduate', 'group') NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    booking_datetime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    captcha_verified BOOLEAN DEFAULT FALSE
)";

if ($conn->query($sql) === FALSE) {
    die("Error creating table: " . $conn->error);
}

$sql = "CREATE TABLE IF NOT EXISTS time_slots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slot_time TIME NOT NULL,
    is_available BOOLEAN DEFAULT TRUE,
    UNIQUE KEY unique_slot (slot_time)
)";

if ($conn->query($sql) === FALSE) {
    die("Error creating time slots table: " . $conn->error);
}

$default_slots = ['08:00:00', '10:00:00', '12:00:00', '14:00:00', '16:00:00'];
$stmt = $conn->prepare("INSERT IGNORE INTO time_slots (slot_time) VALUES (?)");

foreach ($default_slots as $slot) {
    $stmt->bind_param("s", $slot);
    $stmt->execute();
}

$sql = "CREATE TABLE IF NOT EXISTS pricing (
    package_type ENUM('solo', 'duo', 'trio', 'quad', 'deluxe', 'graduate', 'group') PRIMARY KEY,
    price DECIMAL(10,2) NOT NULL
)";

if ($conn->query($sql) === FALSE) {
    die("Error creating pricing table: " . $conn->error);
}

$default_pricing = [
    ['solo', 500],
    ['duo', 800],
    ['trio', 900],
    ['quad', 1000],
    ['deluxe', 2500],
    ['graduate', 800],
    ['group', 1500]
];

$stmt = $conn->prepare("INSERT IGNORE INTO pricing (package_type, price) VALUES (?, ?)");

foreach ($default_pricing as $price) {
    $stmt->bind_param("sd", $price[0], $price[1]);
    $stmt->execute();
}

function isTimeSlotAvailable($date, $time) {
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM appointments WHERE appointment_date = ? AND appointment_time = ?");
    $stmt->bind_param("ss", $date, $time);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_row()[0];
    return $count === 0;
}

function bookAppointment($name, $phone, $email, $type, $date, $time, $price) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO appointments (full_name, phone, email, appointment_type, appointment_date, appointment_time, price) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssd", $name, $phone, $email, $type, $date, $time, $price);
    return $stmt->execute();
}

// Close the statement
if (isset($stmt)) {
    $stmt->close();
}