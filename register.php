<?php
// Fetching the application
require_once('app/app.php');

// Start Session
session_start();

$register_error_message = '';

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
                $user_id = $database->insertNewUser($_POST['username'], $_POST['password'], $_POST['first_name'], $_POST['surname'], $_POST['email'], 1);
                // set session and redirect user to the profile page
                $_SESSION['user_id'] = $user_id;
                header("Location: profile.php");
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h1>Registration</h1>
    
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
     
     <!--form name="registration" action="register.php" method="POST">
      <label for='username'>Username: </label>
      <input type="text" name="username"/>
      <label for='password'>Password: </label>
      <input type="password" name="password"/>
      <label for='first_name'>First name: </label>
      <input type="text" name="first_name"/>
      <label for='surname'>Surname: </label>
      <input type="text" name="surname"/>
      <label for='email'>Email: </label>
      <input type="text" name="email"/>
      <br/>
      <button type="submit">Submit</button>
     </form-->
     
    <?php
       
        
        /*
        global $database;
    
        $form = $_POST;
        $username = $form[ 'username' ];
        $password = $form[ 'password' ];
        $first_name = $form[ 'first_name' ];
        $surname = $form[ 'surname' ];
        $email = $form[ 'email' ];
        $usertype = 1;
        
        

        $sql = "INSERT INTO users ( username, password, first_name, surname, email, usertype) VALUES ( :username, :password, :first_name, :surname, :email, :usertype )";
        $query = $database->conn->prepare( $sql );
        $result = $query->execute( array( ':username'=>$username, ':password'=>$password, ':first_name'=>$first_name, ':surname'=>$surname, ':email'=>$email, ':usertype'=>$usertype ) );
        if ( $result ){
          echo "<p>Bruker opprettet!</p>";
        } else {
          echo "<p>Sorry, there has been a problem inserting your details. Please contact admin.</p>";
        }
        
        */
    ?>
</body>
</html>