<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../config.php';

$db = Database::getInstance()->getConnection();

try {
    $stmt = $db->prepare("
        SELECT a.*, s.name as status_name, s.color as status_color 
        FROM appointments a 
        LEFT JOIN appointment_statuses s ON a.status_id = s.id 
        ORDER BY a.appointment_date DESC, a.appointment_time ASC
    ");
    $stmt->execute();
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($appointments) > 0) {
        $appointments_arr = array();
        $appointments_arr["records"] = array();

        foreach ($appointments as $appointment) {
            $appointment_item = array(
                "id" => $appointment["id"],
                "full_name" => $appointment["full_name"],
                "email" => $appointment["email"],
                "phone" => $appointment["phone"],
                "booking_date" => $appointment["appointment_date"],
                "booking_time" => $appointment["appointment_time"],
                "status" => $appointment["status_name"],
                "status_color" => $appointment["status_color"],
                "package" => str_replace(" Package", "", $appointment["notes"])
            );

            array_push($appointments_arr["records"], $appointment_item);
        }

        http_response_code(200);
        echo json_encode($appointments_arr);
    } else {
        http_response_code(200);
        echo json_encode(array("message" => "No appointments found."));
    }
} catch (PDOException $e) {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to read appointments: " . $e->getMessage()));
}
?>