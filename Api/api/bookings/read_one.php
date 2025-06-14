<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../models/Booking.php';

$database = new Database();
$db = $database->getConnection();

$booking = new Booking($db);

$booking->id = isset($_GET['id']) ? $_GET['id'] : die();

if($booking->readOne()) {
    $booking_arr = array(
        "id" => $booking->id,
        "package" => $booking->package,
        "full_name" => $booking->full_name,
        "email" => $booking->email,
        "phone" => $booking->phone,
        "booking_date" => $booking->booking_date,
        "booking_time" => $booking->booking_time,
        "created_at" => $booking->created_at,
        "updated_at" => $booking->updated_at
    );
    
    http_response_code(200);
    echo json_encode($booking_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Booking does not exist."));
}
?>