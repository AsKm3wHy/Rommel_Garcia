<?php
header('Content-Type: application/json');
$mysqli = new mysqli("localhost", "root", "", "rommelgarciaappointments");
if ($mysqli->connect_errno) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to connect to MySQL']);
    exit;
}
$res = $mysqli->query("SELECT * FROM gallery ORDER BY uploaded_at DESC");
$images = [];
while ($row = $res->fetch_assoc()) {
    $images[] = $row;
}
$mysqli->close();
echo json_encode($images); 