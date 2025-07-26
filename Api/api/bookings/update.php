<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../config.php';

$db = Database::getInstance()->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    try {
        $updates = [];
        $params = [];

        $allowedFields = [
            'full_name' => 'full_name',
            'email' => 'email',
            'phone' => 'phone',
            'booking_date' => 'appointment_date',
            'booking_time' => 'appointment_time',
            'status_id' => 'status_id',
            'package' => 'notes'
        ];

        foreach ($data as $key => $value) {
            if (isset($allowedFields[$key])) {
                $field = $allowedFields[$key];
                if ($key === 'package') {
                    $value = $value . " Package";
                }
                $updates[] = "$field = ?";
                $params[] = $value;
            }
        }

        if (empty($updates)) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "No valid fields to update."
            ]);
            exit();
        }

        $params[] = $data->id;
        $sql = "UPDATE appointments SET " . implode(', ', $updates) . " WHERE id = ?";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);

        http_response_code(200);
        echo json_encode([
            "success" => true,
            "message" => "Appointment was updated successfully."
        ]);
    } catch (PDOException $e) {
        http_response_code(503);
        echo json_encode([
            "success" => false,
            "message" => "Unable to update appointment: " . $e->getMessage()
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Unable to update appointment. ID is required."
    ]);
}
?>