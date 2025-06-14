<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/Booking.php';

$database = new Database();
$db = $database->getConnection();

$booking = new Booking($db);

$data = json_decode(file_get_contents("php://input"));

$booking->id = $data->id;

if(!empty($data->package) && !empty($data->full_name) && !empty($data->email) && 
   !empty($data->phone) && !empty($data->booking_date) && !empty($data->booking_time)) {
    
    // Validate package
    if(!$booking->isValidPackage($data->package)) {
        http_response_code(400);
        echo json_encode(array("message" => "Invalid package selected."));
        exit();
    }
    
    // Validate email
    if(!$booking->isValidEmail($data->email)) {
        http_response_code(400);
        echo json_encode(array("message" => "Invalid email format."));
        exit();
    }
    
    // Validate date
    if(!$booking->isValidDate($data->booking_date)) {
        http_response_code(400);
        echo json_encode(array("message" => "Invalid date format. Use YYYY-MM-DD."));
        exit();
    }
    
    // Validate time
    if(!$booking->isValidTime($data->booking_time)) {
        http_response_code(400);
        echo json_encode(array("message" => "Invalid time format. Use HH:MM."));
        exit();
    }
    
    $booking->package = $data->package;
    $booking->full_name = $data->full_name;
    $booking->email = $data->email;
    $booking->phone = $data->phone;
    $booking->booking_date = $data->booking_date;
    $booking->booking_time = $data->booking_time;
    
    if($booking->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Booking was updated successfully."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update booking."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to update booking. Data is incomplete."));
}
?>