<?php
// Fetching the application
require_once('app/app.php');



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Index</title>
</head>
<body>
   <?php
        echo $app->UserDetails(1);
    
       /* echo "<pre>";
            //print_r($app->articles);
        foreach($app->articles as $article){    
            echo $article->get_heading();
            echo "<br>";
            echo $article->get_text();
            echo "<br>";
            }
        echo "</pre>"; */
    ?>
</body>
</html>
