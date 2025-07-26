<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../models/Booking.php';

$database = new Database();
$db = $database->getConnection();

$booking = new Booking($db);

// Get search parameter
$search_date = isset($_GET['s']) ? $_GET['s'] : '';

if(empty($search_date)) {
    http_response_code(400);
    echo json_encode(array("message" => "Search date is required."));
    exit();
}

// Search bookings
$stmt = $booking->searchByDate($search_date);
$num = $stmt->rowCount();

if($num > 0) {
    $bookings_arr = array();
    $bookings_arr["records"] = array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        
        $booking_item = array(
            "id" => $id,
            "package" => $package,
            "full_name" => $full_name,
            "email" => $email,
            "phone" => $phone,
            "booking_date" => $booking_date,
            "booking_time" => $booking_time,
            "created_at" => $created_at,
            "updated_at" => $updated_at
        );
        
        array_push($bookings_arr["records"], $booking_item);
    }
    
    http_response_code(200);
    echo json_encode($bookings_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No bookings found for the specified date."));
}
?>