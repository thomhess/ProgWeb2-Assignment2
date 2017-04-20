<?php
// Fetching the application
require_once('app/app.php');

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
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> 

</head>
<body>
    <form action="search.php" method="get">
        <input type="text" name="search" placeholder="Search.." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <input type="submit" value="Søk">
    </form>
    <?php
        //echo $app->Login('thomhess', '123');
        echo '<a href="' . $_SERVER['PHP_SELF'] . '?sort=published">Published</a>';
        echo '<a href="' . $_SERVER['PHP_SELF'] . '?sort=rating">Rating</a>';
       echo '<div class="container">';
            //print_r($app->articles);
        foreach($app->articles as $article){    
            echo '<div class="well">';
            echo $article->get_heading();
            echo "<br>";
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
        echo '</div>';
    ?>
</body>
</html>


