<?php
if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    if ($username && $email && $password && $role) {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Handle photo upload
        $photoName = "images/default.jpg";
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $photoName = "images/" . uniqid() . "." . $ext;
            move_uploaded_file($_FILES['photo']['tmp_name'], $photoName);
        }

        // Save user info
        $data = "$username | $email | $hashedPassword | $role | $photoName\n";
        file_put_contents("users.txt", $data, FILE_APPEND);

        // Success message + redirect back to registration.php
        echo "<script>
                alert('Registration successful as $role!');
                window.location.href='registration.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Please fill all fields!');
                window.location.href='registration.php';
              </script>";
        exit;
    }
} else {
    header("Location: registration.php");
    exit;
}
?>
