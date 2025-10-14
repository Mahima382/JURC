<?php
if(isset($_POST['login'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $found = false;

    if(file_exists("users.txt")){
        $lines = file("users.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach($lines as $line){
            list($savedUser, $savedEmail, $savedHash, $savedRole, $savedPhoto) = explode(" | ", $line);
            if($username === $savedUser && password_verify($password,$savedHash)){
                $found = true;
                session_start();
                $_SESSION['username']=$savedUser;
                $_SESSION['role']=$savedRole;
                $_SESSION['photo']=$savedPhoto;
                echo "<script>alert('Login successful! Welcome, $savedUser ($savedRole) 🤖');
                      window.location.href='join_us.php';</script>";
                break;
            }
        }
    }
    if(!$found) echo "<script>alert('Incorrect username or password!');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Robotics Club - Login</title>
<link rel="stylesheet" href="css_files/styleforloginreg.css">
</head>
<body>
<div class="login-container">
<div class="login-card">
<h2>Welcome Back 🤖</h2>
<p class="subtitle">Login to your Robotics Club account</p>
<form method="POST" action="">
<input type="text" name="username" placeholder="Enter Username" required>
<input type="password" name="password" placeholder="Enter Password" required>
<button type="submit" name="login">Login</button>
</form>
<p>Don’t have an account? <a href="register.php">Register</a></p>
</div>
</div>
</body>
</html>
