<?php
// Fetching other php-files to be used
require_once('app/setup.php');

$setup->createDB();
$setup->userDB();
$setup->useDB();
$setup->createTables(); 
$setup->insertDefaultData();