<?php
// Categories
$categories = ["Mentor","President","Vice-President","Leader","Supporter","Member"];
$categoryNames = [
    "Mentor"=>"Mentor",
    "President"=>"President",
    "Vice-President"=>"Vice-President",
    "Leader"=>"Team Leader",
    "Supporter"=>"Supporter",
    "Member"=>"Club Member"
];

// Initialize team array
$team = [];
foreach($categories as $cat){
    $team[$cat] = [];
}

// Fetch registered users from users.txt
if(file_exists("users.txt")){
    $lines = file("users.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach($lines as $line){
        $parts = explode(" | ", $line);
        $username = $parts[0] ?? '';
        $role = $parts[3] ?? '';
        $photo = $parts[4] ?? 'images/default.jpg';

        if(empty($photo) || !file_exists($photo)) $photo = "images/default.jpg";

        // Include all 6 categories
        if(in_array($role, $categories)){
            $team[$role][] = ["name"=>$username,"photo"=>$photo];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Join Us - JURC</title>
<link rel="stylesheet" href="/JURC/css_files/joinusstyle.css">
</head>
<body>
<h2 style="text-align:center; margin-bottom:40px;">Join Us - Meet Our Club</h2>

<div class="category-cards">
<?php
foreach($categories as $cat){
    echo '<div class="category-card '.$cat.'">';
    echo '<h3>'.$categoryNames[$cat].'</h3>';

    // List members if registered
    echo '<div class="members-list">';
    if(!empty($team[$cat])){
        foreach($team[$cat] as $m){
            echo '<div class="member-card">';
            echo '<img src="'.$m['photo'].'" alt="'.$m['name'].'">';
            echo '<div class="member-info">';
            echo '<p><strong>'.$m['name'].'</strong></p>';
            echo '</div></div>';
        }
    } else {
        echo '<p>No one registered yet.</p>';
    }
    echo '</div>';

    // Join Us button linked to registration.php with role preselected
    echo '<button onclick="location.href=\'registration.php?role='.$cat.'\'">Join Us</button>';
    echo '</div>';
}
?>
</div>
</body>
</html>
