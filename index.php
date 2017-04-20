<?php
// Fetching the application
require_once('app/app.php');

// Start Session
session_start();

if(isset($_GET['sort'])){
    $app->sorting($app->articles, $_GET['sort']);
    setcookie('preferred_rating', $_GET['sort'], time() + (86400 * 30), "/");
}

if(isset($_COOKIE['preferred_rating'])) {
    if(!isset($_GET['sort'])){
        header("Location: index.php?sort=" . $_COOKIE['preferred_rating']);
    }
}

if(isset($_GET['upvote'])){
    $database->updateRating($_GET['upvote'], $app->articles[$_GET['upvote']]->get_rating());
    header("Location: index.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Index</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
<?php include_once "nav.php";?>
<div class="container">
    <h5 class="text-right">SORT BY</h5>
    <div class="btn-group pull-right" role="group" aria-label="...">
        <?php
            echo '<a class="btn btn-default" href="' . $_SERVER['PHP_SELF'] . '?sort=published">Published</a>';
            echo '<a class="btn btn-default" href="' . $_SERVER['PHP_SELF'] . '?sort=rating">Rating</a>'; 
        ?>
    </div>
</div>
<div class="container newslist"> 
    <?php
            //print_r($app->articles);
        foreach($app->articles as $article){    
            echo '<div class="well well-lg newsitem">';
            echo '<h3>' . $article->get_heading() . '</h3>';
            echo $article->get_text();
            echo "<br>";
            echo 'Category: ' . $article->get_category();
            echo "<br>";
            echo 'Published by: ' . $article->get_publisher();
            echo "<br>";
            echo 'Rating: ' . $article->get_rating();
            echo "<br>";
            echo "<a class='btn btn-primary' href='" . $_SERVER['PHP_SELF'] . '?upvote=' . $article->get_id() . "'>Upvote</a>";
            echo '</div>';  
            }
    ?>
</div>
<?php include_once "footer.php";?>
</body>
</html>