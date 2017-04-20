<?php
// Fetching the application
require_once('app/app.php');

// Start Session
session_start();

// Defined variable for error message
$register_error_message = '';

// Form validation for registered user
if (!empty($_POST['btnRegister'])) { 
            if ($_POST['username'] == "") {
                $register_error_message = 'Username field is required!';
            } else if ($_POST['password'] == "") {
                $register_error_message = 'Password field is required!';
            } else if ($_POST['email'] == "") {
                $register_error_message = 'Email field is required!';
            } else if ($_POST['first_name'] == "") {
                $register_error_message = 'First name field is required!';
            } else if ($_POST['surname'] == "") {
                $register_error_message = 'Surname field is required!';
            /*} else if ($app->isUsername($_POST['username'])) {
                $register_error_message = 'Username is already in use!';
            } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $register_error_message = 'Invalid email address!';
            } else if ($app->isEmail($_POST['email'])) {
                $register_error_message = 'Email is already in use!'; */
            } else {
                $user_id = $database->insertNewUser($_POST['username'], $_POST['password'], $_POST['first_name'], $_POST['surname'], $_POST['email'], 2);
                // set session and redirect user to the profile page
                $_SESSION['user_id'] = $user_id; // Set Session
                header("Location: profile.php"); // Redirect user to the profile.php
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php include_once "nav.php";?>
<div class="container">
    <div class="row col-lg-6 col-lg-offset-3">
    <h1>Registration</h1>
    <div class="well">
    <?php
    if ($register_error_message != "") {
        echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $register_error_message . '</div>';
    }
    ?>
    <form action="register.php" method="post">
        <div class="form-group">
            <label for="">Username</label>
            <input type="text" name="username" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="">Password</label>
            <input type="password" name="password" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="">Email</label>
            <input type="email" name="email" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="">First name</label>
            <input type="text" name="first_name" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="">Surname</label>
            <input type="text" name="surname" class="form-control"/>
        </div>
        <div class="form-group">
            <input type="submit" name="btnRegister" class="btn btn-primary" value="Register"/>
        </div>
    </form>
     </div>
     </div>
</div>
</body>
</html>