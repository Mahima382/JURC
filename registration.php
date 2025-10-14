<?php
$preselectedRole = isset($_GET['role']) ? $_GET['role'] : '';
$roles = ["Supporter", "Mentor", "Leader", "Member", "President", "Vice-President"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Robotics Club - Register</title>
<link rel="stylesheet" href="css_files/styleforloginreg.css">
</head>
<body>

<div class="container" id="registerForm" style="display:block; max-width:400px; margin:50px auto;">
<h2>Register as <?= htmlspecialchars($preselectedRole ? $preselectedRole : "Member") ?></h2>

<form method="POST" action="members.php" enctype="multipart/form-data">
    <input type="text" name="username" placeholder="Enter Username" required>
    <input type="email" name="email" placeholder="Enter Email" required>
    <input type="password" name="password" placeholder="Enter Password" required>

    <label>Select Role:</label>
    <select name="role" id="role" required>
        <option value="">Select Role</option>
        <?php foreach($roles as $role): ?>
            <option value="<?= $role ?>" <?= $preselectedRole == $role ? 'selected' : '' ?>><?= $role ?></option>
        <?php endforeach; ?>
    </select>

    <label>Upload Photo:</label>
    <input type="file" name="photo" accept="image/*" required>

    <button type="submit" name="register">Register</button>
    <p>Already have an account? <a href="login.php">Login</a></p>
</form>
</div>

</body>
</html>
