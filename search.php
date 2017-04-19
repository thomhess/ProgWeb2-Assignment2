<?php

// Fetching the application
require_once('app/app.php');
require_once('app/init.php');

$count = 0;

if (!empty($_GET['search'])){
    if ($app->search($_GET['search'])) { 
        foreach($app->search($_GET['search']) as $article){
            echo $article['heading'];
            echo '<br>';
            echo $article['text'];
            echo '<br>';
        }
    } else {
        echo "No mathascas";
    }
}