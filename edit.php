<?php 
// Fetching the application
require_once('app/app.php');
require_once('app/init.php');

// Start Session
session_start();

$heading;
$text;
$category;
$updatearticle_error_message = '';
$articlenumber;
$publisher;

if(isset($_GET['editArticle'])){
        $articlenumber = $_GET['editArticle'];
    } else {
        die('Invalid article');
    }

foreach($app->articles as $article){
    if ($article->get_id() == $articlenumber){
        $heading = $article->get_heading();
        $text = $article->get_text();
        $category = $article->get_category();
        $publisher = $article->get_publisher();
    }
}


// Redirects if not logged in or wrong user
if(empty($_SESSION['user_id'])){
    header("Location: index.php");
} else {
    $user = $app->UserDetails($_SESSION['user_id']); // get user details

    if ($publisher != $user->username){
            header("Location: profile.php");
        }
}



if (!empty($_POST['btnArticleEdit'])) { 
            if ($_POST['heading'] == "") {
                $updatearticle_error_message = 'Heading field is required!';
            } else if ($_POST['text'] == "") {
                $updatearticle_error_message = 'Text field is required!';
            } else if (!isset($_POST['category'])) {
                $updatearticle_error_message = 'Category field is required!';
            } else {
                $user_id = $app->updateNewsArticle($articlenumber, $_POST['heading'], $_POST['text'], $_POST['category']);
                header("Location: profile.php"); //?upload=true
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php include_once "nav.php";?>
<div class="container">
<div class="row col-lg-8 col-lg-offset-2">
<h1>Edit article</h1>
<div class="well">
    <form  method="post">
        <?php
            if ($updatearticle_error_message != "") {
                echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $updatearticle_error_message . '</div>';
        }
        ?>
        <div class="form-group">
            <label for="">Heading</label>
            <input type="text" name="heading" class="form-control" value="<?php echo $heading ?>"/>
        </div>
        <div class="form-group">
            <label for="">Text</label>
            <textarea type="text" name="text" class="form-control"><?php echo $text ?></textarea>
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
            <input type="submit" name="btnArticleEdit" class="btn btn-primary" value="Publish"/>
        </div>
    </form>
</div>
</div>
</div> 
</body>
</html>