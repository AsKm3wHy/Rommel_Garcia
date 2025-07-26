<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../models/BookingStatus.php';

$database = new Database();
$db = $database->getConnection();

$status = new BookingStatus($db);
$stmt = $status->read();
$num = $stmt->rowCount();

if($num > 0) {
    $statuses_arr = array();
    $statuses_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $status_item = array(
            "id" => $id,
            "name" => $name,
            "description" => $description,
            "color" => $color,
            "created_at" => $created_at,
            "updated_at" => $updated_at
        );
        array_push($statuses_arr["records"], $status_item);
    }

    http_response_code(200);
    echo json_encode($statuses_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No booking statuses found."));
} 