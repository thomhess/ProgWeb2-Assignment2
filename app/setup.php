<?php
require_once('app/dbinfo.php');

class DB {

    public $conn;

    public function __construct(){
        try{
          $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE . ";charset=utf8", DB_USER, DB_PASS);
        } catch(PDOException  $e) {
          die ("Error: ".$e->getMessage());
        }

        self::createDB();
        self::useDB();
        self::createTables();
        //self::insertDefaultData();

    }//construct()







    public function createDB(){
        $query = 'CREATE DATABASE IF NOT EXISTS imt3851_db';
        if ($this->conn->exec($query)===false)
          die('Query failed:' . $this->conn->errorInfo()[2]);
    }

    public function useDB(){
        if ($this->conn->exec("USE " . DB_DATABASE)===false)
          die('Can not select db:' . $this->conn->errorInfo()[2]);
    }

    public function close_connection(){
        $this->conn = null;
    }//close_connection

    public function createTables(){
        $query = 'CREATE TABLE IF NOT EXISTS users (
            user_id INT PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(15),
            password CHAR(250),
            first_name VARCHAR(30),
            surname VARCHAR(30),
            email VARCHAR(64),
            usertype int(1))';
        if ($this->conn->exec($query)===false)
          die("CREATE USER FAIL" . $this->conn->errorInfo()[2]);

        // create the articles table
        $query = 'CREATE TABLE IF NOT EXISTS articles (
            id INT PRIMARY KEY AUTO_INCREMENT,
            datetime int(11),
            heading VARCHAR(50),
            text TEXT(1000),
            category VARCHAR(10),
            rating FLOAT(2,1),
            publisher VARCHAR(15))';
        if ($this->conn->exec($query)===false)
          die("CREATE artivles FAIL" . $this->conn->errorInfo()[2]);

    }
    
    public function insertDefaultData(){
        // Insert data into articles
        $query = "INSERT INTO articles(datetime, heading, text, category, rating, publisher) VALUES('1492009049', 'Hei verden', 'Her skal det stå en lang eller kort tekst, denne gangen blir den kort', 'sport', '4.5', 'thomhess')";
        if ($this->conn->exec($query)===false)
            die("INSERT article FAIL" . $this->conn->errorInfo()[2]);
        
        // Insert data into users
        $query = "INSERT INTO users(username, password, first_name, surname, email, usertype) VALUES('thomhess', 'passord', 'oørstenavn', 'etternavn', 'e@mail', '1')";
        if ($this->conn->exec($query)===false)
            die("INSERT USER FAIL" . $this->conn->errorInfo()[2]);
    }//insertDefaultData
    
    public function insertNewUser($username, $password, $first_name, $surname, $email, $usertype){
        
        $sql = "INSERT INTO users ( username, password, first_name, surname, email, usertype) VALUES ( :username, :password, :first_name, :surname, :email, :usertype )";
        $query = $this->conn->prepare( $sql );
        $result = $query->execute( array( ':username'=>$username, ':password'=>$password, ':first_name'=>$first_name, ':surname'=>$surname, ':email'=>$email, ':usertype'=>$usertype ) );
//        if ( $result ){
//          echo "<p>Bruker opprettet!</p>";
//        } else {
//          echo "<p>Sorry, there has been a problem inserting your details. Please contact admin.</p>";
//        }
        
    }

}//class
$database =  new DB();
