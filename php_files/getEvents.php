<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "jurc_events");

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "DB connection failed"]);
    exit;
}

$sql = "SELECT * FROM events";
$result = $conn->query($sql);

$events = array();
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

echo json_encode($events);
$conn->close();
?>
