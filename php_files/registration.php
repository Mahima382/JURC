<?php
// registration.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jurc_events";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, username, Name as full_name, category, image_url FROM members ORDER BY FIELD(category,'Supporter','Mentor','Leader','Member'), Name";
$result = $conn->query($sql);

$members = array();
while($row = $result->fetch_assoc()) {
    $members[] = $row;
}

header('Content-Type: application/json');
echo json_encode($members);
$conn->close();
?>
