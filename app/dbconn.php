<?php

class dbconn {
    
    public $conn; //Defines variable for database connection
    
    public function __construct(){
        // Connects to database
        try{
          $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE . ";charset=utf8", DB_USER, DB_PASS);
        } catch(PDOException  $e) {
            try{
              $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=;charset=utf8", DB_USER, DB_PASS);
            } catch(PDOException  $e) {
              die ("Error: ".$e->getMessage());
            }
        }


    }//construct()
}

$dbconn = new dbconn();