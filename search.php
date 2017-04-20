<?php

// Fetching the application
require_once('app/app.php');
require_once('app/init.php');

$count = 0;

// Fetching upvote-thing and changing value
if(isset($_GET['upvote'])){
    $database->updateRating($_GET['upvote'], $app->articles[$_GET['upvote']]->get_rating());
    
    // Returning to the same search result as before
    header("Location: " . $_SERVER['PHP_SELF'] . '?search=' . $_GET['search']);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php include_once "nav.php";?>   

<div class="container newslist"> 
<?php
// Fetching all search results and making them into articles
if (!empty($_GET['search'])){
    if ($app->search($_GET['search'])) { 
        foreach($app->search($_GET['search']) as $article){
            echo '<div class="well well-lg newsitem">';
            echo '<h3>' . $article['heading'] . '</h3>';
            echo $article['text'];
            echo '<br>';
            echo 'Category: ' . $article['category'];
            echo '<br>';
            echo 'Published by: ' . $article['publisher'];
            echo '<br>';
            echo 'Rating: ' . $article['rating'];
            echo '<br>';
            echo "<a class='btn btn-primary' href='" . $_SERVER['PHP_SELF'] . '?search=' . $_GET['search'] .  '&upvote=' . $article['id'] . "'>Upvote</a>";
            echo '</div>';
        }
    } else {
        echo "<h1>No results found</h1>";
    }
}

?>
</div>
<?php include_once "footer.php";?>
</body>
</html>