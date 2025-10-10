<?php
$conn = new mysqli("localhost", "root", "", "jurc_events");
if($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$event_id = $_POST['event_id'];

// Insert participant
$stmt = $conn->prepare("INSERT INTO participants (event_id, name, email, phone) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $event_id, $name, $email, $phone);
if($stmt->execute()) {
    echo "Registered successfully!";
} else {
    echo "Registration failed!";
}

$stmt->close();
$conn->close();
?>
