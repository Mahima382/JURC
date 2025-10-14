<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "jurc_events");
if($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "DB connection failed"]);
    exit;
}

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$event_id = isset($_POST['event_id']) ? intval($_POST['event_id']) : 0;

// Basic validation
if ($event_id <= 0 || empty($name) || empty($email)) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Missing or invalid fields"]);
    $conn->close();
    exit;
}

// Insert participant
$stmt = $conn->prepare("INSERT INTO participants (event_id, name, email, phone) VALUES (?, ?, ?, ?)");
if (!$stmt) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
    $conn->close();
    exit;
}

$stmt->bind_param("isss", $event_id, $name, $email, $phone);
if($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Registered successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Registration failed: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
