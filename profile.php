<?php

require_once('app/init.php');

// Start Session
session_start();
 
// check user login
if(empty($_SESSION['user_id']))
{
    header("Location: index.php");
}
 
$user = $app->UserDetails($_SESSION['user_id']); // get user details
 
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="well">
            <h2>
                Profile
            </h2>
            <h3>Hello <?php echo $user->name ?>,</h3>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur deserunt dolore fuga labore magni maxime, quaerat reiciendis tenetur? Accusantium blanditiis doloribus earum error inventore laudantium nesciunt quis reprehenderit ullam vel?
            </p>
            <a href="logout.php" class="btn btn-primary">Logout</a>
        </div>
    </div>
</body>
</html>