<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../config.php';

$db = Database::getInstance()->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    try {
        $stmt = $db->prepare("DELETE FROM appointments WHERE id = ?");
        $stmt->execute([$data->id]);

        if ($stmt->rowCount() > 0) {
            http_response_code(200);
            echo json_encode([
                "success" => true,
                "message" => "Appointment was deleted successfully."
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                "success" => false,
                "message" => "Appointment not found."
            ]);
        }
    } catch (PDOException $e) {
        http_response_code(503);
        echo json_encode([
            "success" => false,
            "message" => "Unable to delete appointment: " . $e->getMessage()
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Unable to delete appointment. ID is required."
    ]);
}
?>