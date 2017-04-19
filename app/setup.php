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
          die("CREATE articles FAIL" . $this->conn->errorInfo()[2]);
        
        // create the categories table
        $query = 'CREATE TABLE IF NOT EXISTS categories (
            id INT PRIMARY KEY AUTO_INCREMENT,
            category VARCHAR(10))';
        if ($this->conn->exec($query)===false)
          die("CREATE categories FAIL" . $this->conn->errorInfo()[2]);

    }
    
    public function insertDefaultData(){
        // Insert data into articles
        $query = "INSERT INTO articles(datetime, heading, text, category, rating, publisher) VALUES('1492009049', 'Hei verden', 'Her skal det stå en lang eller kort tekst, denne gangen blir den kort', 'sport', '4.5', 'thomhess')";
        if ($this->conn->exec($query)===false)
            die("INSERT article FAIL" . $this->conn->errorInfo()[2]);
        
        // Insert data into users
        $query = "INSERT INTO users(username, password, first_name, surname, email, usertype) VALUES('thomhess', '123', 'fornavn', 'etternavn', 'e@mail', '1')";
        if ($this->conn->exec($query)===false)
            die("INSERT USER FAIL" . $this->conn->errorInfo()[2]);
        
        // Insert data into categories
        $query = "INSERT INTO categories(category) VALUES('Sport')";
        if ($this->conn->exec($query)===false)
            die("INSERT USER FAIL" . $this->conn->errorInfo()[2]);
    }//insertDefaultData
    
    public function insertNewUser($username, $password, $first_name, $surname, $email, $usertype){
        
        $sql = "INSERT INTO users ( username, password, first_name, surname, email, usertype) VALUES ( :username, :password, :first_name, :surname, :email, :usertype )";
        $query = $this->conn->prepare( $sql );
        $result = $query->execute( array( ':username'=>$username, ':password'=>hash('sha256', $password), ':first_name'=>$first_name, ':surname'=>$surname, ':email'=>$email, ':usertype'=>$usertype ) );
    }
    
    public function insertNewsArticle($heading, $text, $category, $publisher) {
        $currentTime = time();
        $defaultRating = '3';
        $sql = "INSERT INTO articles(datetime, heading, text, category, rating, publisher) VALUES(:datetime, :heading, :text, :category, :rating, :publisher)";
        $query = $this->conn->prepare( $sql );
        $result = $query->execute( array( ':datetime'=>$currentTime, ':heading'=>$heading, ':text'=>$text, ':category'=>$category, ':rating'=>$defaultRating, ':publisher'=>$publisher ) );
    }
    
    public function insertCategory($category){
        
        $sql = "INSERT INTO categories ( category ) VALUES ( :category )";
        $query = $this->conn->prepare( $sql );
        $result = $query->execute( array( ':category'=>$category ) );
    }
    
    public function deleteNewsArticle($id){
        $sql = "DELETE FROM articles WHERE id = :id";
        $query = $this->conn->prepare( $sql );
        $result = $query->execute( array( ':id'=>$id ) );
    }
    
    public function deleteCategory($id){
        $sql = "DELETE FROM categories WHERE id = :id";
        $query = $this->conn->prepare( $sql );
        $result = $query->execute( array( ':id'=>$id ) );
    }
    
    public function updateNewsArticle($id, $heading, $text, $category){
        $sql = "UPDATE articles SET heading=:heading, text=:text, category=:category WHERE id=:id";
        $query = $this->conn->prepare( $sql );
        $result = $query->execute( array( ':id'=>$id, ':heading'=>$heading, ':text'=>$text, ':category'=>$category ) );
    }
    
    public function categoryCount($category){
        $sql = "SELECT id FROM articles WHERE category = :category";
        $query = $this->conn->prepare( $sql );
        $result = $query->execute( array( ':category'=>$category ) );
        return $query->rowCount();
    }

}//class
$database =  new DB();
