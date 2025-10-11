<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "robotics_club";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "DB connection failed"]));
}

// Handle uploaded file
$target_dir = "uploads/";
$image_name = basename($_FILES["image"]["name"]);
$target_file = $target_dir . time() . "_" . $image_name;
if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    $image_url = $target_file;
} else {
    $image_url = "images/default.png";
}

// Insert new member
$stmt = $conn->prepare("INSERT INTO members (username, Name, email, password, category, image_url) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $_POST['username'], $_POST['Name'], $_POST['email'], $_POST['password'], $_POST['category'], $image_url);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
