<?php
// Fetching the application
require_once('app/app.php');



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
    
       echo "<pre>";
            //print_r($app->articles);
        foreach($app->articles as $article){    
            echo $article->get_heading();
            echo "<br>";
            echo $article->get_text();
            echo "<br>";
            }
        echo "</pre>";
    ?>
</body>
</html>
