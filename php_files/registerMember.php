<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jurc_events"; // use the same DB as other endpoints

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode(["success" => false, "message" => "DB connection failed"]));
}

// Basic validation
$required = ['username','Name','email','password','category'];
foreach ($required as $r) {
    if (empty($_POST[$r])) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Missing field: $r"]);
        $conn->close();
        exit;
    }
}

$username_input = trim($_POST['username']);
$name_input = trim($_POST['Name']);
$email_input = trim($_POST['email']);
$password_input = $_POST['password'];
$category_input = trim($_POST['category']);

// Handle uploaded file
$target_dir = __DIR__ . "/../uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
}

$image_url = "images/default.png"; // default
if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
    $image_name = basename($_FILES["image"]["name"]);
    $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','gif'];
    if (in_array($ext, $allowed)) {
        $safe_name = time() . '_' . preg_replace('/[^a-z0-9._-]/i', '_', $image_name);
        $target_file = $target_dir . $safe_name;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // expose relative path from web root (assuming project root is served)
            $image_url = 'uploads/' . $safe_name;
        }
    }
}

// Hash password
$password_hash = password_hash($password_input, PASSWORD_DEFAULT);

// Insert new member
$stmt = $conn->prepare("INSERT INTO members (username, Name, email, password, category, image_url) VALUES (?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
    $conn->close();
    exit;
}

$stmt->bind_param("ssssss", $username_input, $name_input, $email_input, $password_hash, $category_input, $image_url);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
