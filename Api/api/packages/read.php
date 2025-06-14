<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../models/Package.php';

$database = new Database();
$db = $database->getConnection();

$package = new Package($db);

$stmt = $package->read();
$num = $stmt->rowCount();

if($num > 0) {
    $packages_arr = array();
    $packages_arr["records"] = array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        
        $package_item = array(
            "id" => $id,
            "name" => $name,
            "description" => $description,
            "price" => $price,
            "duration" => $duration,
            "max_participants" => $max_participants
        );
        
        array_push($packages_arr["records"], $package_item);
    }
    
    http_response_code(200);
    echo json_encode($packages_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No packages found."));
}
?>