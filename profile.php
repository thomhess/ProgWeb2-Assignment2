<?php
// Fetching the application
require_once('app/app.php');
require_once('app/init.php');

// Start Session
session_start();
 
// check user login
if(empty($_SESSION['user_id']))
{
    header("Location: index.php");
}

if(isset($_GET['deleteArticle'])){
    $database->deleteNewsArticle($_GET['deleteArticle']);
    header("Location: profile.php");
    }

if(isset($_GET['deleteCategory'])){
    $database->deleteCategory($_GET['deleteCategory']);
    header("Location: profile.php");
    }

if(isset($_GET['deleteUser'])){
    $database->deleteUser($_GET['deleteUser']);
    header("Location: profile.php");
    }

if(isset($_GET['editArticle'])){
    //header("Location: edit.php");
    }

$user = $app->UserDetails($_SESSION['user_id']); // get user details
 
$article_error_message = '';
$editprofile_error_message = '';


if (!empty($_POST['btnArticle'])) { 
            if ($_POST['heading'] == "") {
                $article_error_message = 'Heading field is required!';
            } else if ($_POST['text'] == "") {
                $article_error_message = 'Text field is required!';
            } else if (!isset($_POST['category'])) {
                $article_error_message = 'Category field is required!';
            } else {
                $user_id = $database->insertNewsArticle($_POST['heading'], $_POST['text'], $_POST['category'], $user->username);
                header("Location: profile.php"); //?upload=true
        }
    }

if (!empty($_POST['btnEditProfile'])) { 
            if ($_POST['username'] == "") {
                $editprofile_error_message = 'Username field is required!';
            } else if ($_POST['password'] == "") {
                $editprofile_error_message = 'Password field is required!';
            } else if ($_POST['email'] == "") {
                $editprofile_error_message = 'Email field is required!';
            } else if ($_POST['first_name'] == "") {
                $editprofile_error_message = 'First name field is required!';
            } else if ($_POST['surname'] == "") {
                $editprofile_error_message = 'Surname field is required!';
            /*} else if ($app->isUsername($_POST['username'])) {
                $register_error_message = 'Username is already in use!';
            } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $register_error_message = 'Invalid email address!';
            } else if ($app->isEmail($_POST['email'])) {
                $register_error_message = 'Email is already in use!'; */
            } else {
                $user_id = $database->editUser($_SESSION['user_id'], $_POST['username'], $_POST['password'], $_POST['first_name'], $_POST['surname'], $_POST['email']);
                header("Location: profile.php"); // Redirect user to the profile.php
        }
    }

if (!empty($_POST['btnCategory'])) { 
    $database->insertCategory($_POST['category']);
    header("Location: profile.php");
}



?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
<?php include_once "nav.php";?>
    <div class="container">
        <div class="well">
            <h2>
                Profile
            </h2>
            <h3>Hello <?php echo $user->first_name . ' ' . $user->surname ?></h3>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur deserunt dolore fuga labore magni maxime, quaerat reiciendis tenetur? Accusantium blanditiis doloribus earum error inventore laudantium nesciunt quis reprehenderit ullam vel?
            </p>
            <a href="logout.php" class="btn btn-primary">Logout</a>
        </div>
        <div class="well">
            <h2>New article</h2>
            
            <form action="profile.php" method="post">
                <?php
                    if ($article_error_message != "") {
                        echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $article_error_message . '</div>';
                }
                ?>
                <div class="form-group">
                    <label for="">Heading</label>
                    <input type="text" name="heading" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="">Text</label>
                    <textarea type="text" name="text" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Category</label>
                    <?php 
                    
                    foreach($app->categories as $category){  
                        echo '<br><input type="radio" name="category" value="' . $category->get_category() .'"><span> ' . $category->get_category() .'</span>';
                    }
                    
                    ?>
                    
                    
                </div>
                <div class="form-group">
                    <input type="submit" name="btnArticle" class="btn btn-primary" value="Publish"/>
                </div>
            </form>
        </div>
        <div class="well">
            <h2>My articles</h2>
            <?php
            
            foreach($app->articles as $article){    
                if ($article->get_publisher() == $user->username){
                    echo "<h3>" . $article->get_heading() . "</h3>";
                    echo $article->get_text();
                    echo "<br>";
                    echo "<a class='btn btn-danger' href='" . $_SERVER['PHP_SELF'] . "?deleteArticle=" . $article->get_id() . "'>Delete</a>";
                    echo "<a class='btn btn-link' href='edit.php?editArticle=" . $article->get_id() . "'>Edit</a>";
                    // data-toggle='modal' data-target='#myModal' <-- Modal stuff
                    echo "<br>";
                    
                }
            }
            
            ?>
            <!-- Modal -->
              <!--div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Modal Header</h4>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div-->
        </div>
        
    
        <?php
        if ($editprofile_error_message != "") {
            echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $editprofile_error_message . '</div>';
        }
        ?>
        <div class="well">
           <h2>Edit Profile</h2>
            <form  method="post">
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo $user->username ?>"/>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $user->email ?>"/>
                </div>
                <div class="form-group">
                    <label for="">First name</label>
                    <input type="text" name="first_name" class="form-control" value="<?php echo $user->first_name ?>"/>
                </div>
                <div class="form-group">
                    <label for="">Surname</label>
                    <input type="text" name="surname" class="form-control" value="<?php echo $user->surname ?>"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="btnEditProfile" class="btn btn-primary" value="Update profile"/>
                </div>
            </form>
        </div>
        <?php if($user->usertype == 1) {
            
            echo "<h1>Admin panel</h1>";
    
            echo '<div class="well">';
            echo '<h2>All articles</h2>';
            
            foreach($app->articles as $article){    
                    echo "<h3>" . $article->get_heading() . "</h3>";
                    echo $article->get_text();
                    echo "<br>";
                    echo "<a class='btn btn-danger' href='" . $_SERVER['PHP_SELF'] . "?deleteArticle=" . $article->get_id() . "'>Delete</a>";
                    echo "<br>";
            }
            
            echo '</div>';
            echo '<div class="well">';
            echo '<h2>Categories</h2>';
    
            foreach($app->categories as $category){    
                    echo "<h3>" . $category->get_category() . "</h3>";
                    $newsInCat = $database->categoryCount($category->get_category());
                    echo $newsInCat . ' news article(s) published in this category';
                    echo "<br>";
                    echo "<a class='btn btn-danger' href='" . $_SERVER['PHP_SELF'] . "?deleteCategory=" . $category->get_category() . "'>Delete</a>";
                    echo "<br>";
            }
    
            echo '<h2>New category</h2>';
            
            echo '<form action="profile.php" method="post">';
                echo '<div class="form-group">';
                    echo '<label for="">Category name</label>';
                    echo '<input type="text" name="category" class="form-control"/>';
                echo '</div>';
                echo '<div class="form-group">';
                    echo '<input type="submit" name="btnCategory" class="btn btn-primary" value="Submit"/>';
                echo '</div>';
            echo '</form>';
            echo '</div>';
        
            echo '<div class="well">';
            echo '<h2>Delete users</h2>';
    
            foreach($app->users as $user){    
                if ($user->get_id() != $_SESSION['user_id']){
                    echo "<h3>" . $user->get_username() . "</h3>";
                    echo "<a class='btn btn-danger' href='" . $_SERVER['PHP_SELF'] . "?deleteUser=" . $user->get_id() . "'>Delete</a>";
                    echo "<br>";
                    }
            }
            
            echo '</div>';
            }
            
            
        
        ?>
    </div>
    
</body>
</html>