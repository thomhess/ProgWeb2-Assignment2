<?php
require_once('app/dbinfo.php');
require_once('app/dbconn.php');

class setup {

    // Creates database
    public function createDB(){
        global $dbconn;
        $query = 'CREATE DATABASE IF NOT EXISTS ' . DB_DATABASE . '';
        if ($dbconn->conn->exec($query)===false)
          die('Query failed:' . $dbconn->conn->errorInfo()[2]);
    }
    
    // create the user and grant creditentials
    public function userDB(){
    global $dbconn;
    $query = "GRANT ALL ON " . DB_DATABASE . ".* TO '" . DB_USER . "'@'" . DB_HOST . "' IDENTIFIED BY '" . DB_PASS . "'";
    if ($dbconn->conn->exec($query)===false)
    die('Query failed:' . $dbconn->conn->errorInfo()[2]);
    }
        
    // Uses database
    public function useDB(){
    global $dbconn;
        if ($dbconn->conn->exec("USE " . DB_DATABASE . "")===false)
          die('Can not select db:' . $dbconn->conn->errorInfo()[2]);
    }
    
    // Closes database connection
    public function close_connection(){
        global $dbconn;
        $dbconn->conn = null;
    }//close_connection
    
    // Creates all the tables
    public function createTables(){
        global $dbconn;
        // Creates user table
        $query = 'CREATE TABLE IF NOT EXISTS users (
            user_id INT PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(15),
            password CHAR(250),
            first_name VARCHAR(30),
            surname VARCHAR(30),
            email VARCHAR(64),
            usertype int(1))';
        if ($dbconn->conn->exec($query)===false)
          die("CREATE USER FAIL" . $dbconn->conn->errorInfo()[2]);

        // Creates categories table
        $query = 'CREATE TABLE IF NOT EXISTS categories (
            category VARCHAR(10) PRIMARY KEY)';
        if ($dbconn->conn->exec($query)===false)
          die("CREATE categories FAIL" . $dbconn->conn->errorInfo()[2]);
        
        // Creates articles table
        $query = 'CREATE TABLE IF NOT EXISTS articles (
            id INT PRIMARY KEY AUTO_INCREMENT,
            datetime int(11),
            heading VARCHAR(50),
            text TEXT(1000),
            category VARCHAR(10),
            rating int(11),
            publisher VARCHAR(15),
            
            FOREIGN KEY (category) REFERENCES categories(category) on delete cascade)';
        if ($dbconn->conn->exec($query)===false)
          die("CREATE articles FAIL" . $dbconn->conn->errorInfo()[2]);
    }
    
    
    /* Inserting default data into tables created */
    public function insertDefaultData(){
        global $dbconn;
        
        // Insert data into users
        $query = "INSERT INTO users(username, password, first_name, surname, email, usertype) VALUES
        ('admin', '" . hash('sha256', '123') . "', 'Admin', 'Bruker', 'admin@nettavis.no', '1'),
        ('thomhess', '" . hash('sha256', '123') . "', 'Thomas', 'Hesselberg', 'thomhes@stud.ntnu.no', '1'),
        ('kolloen', '" . hash('sha256', '123') . "', 'Øivind', 'Kolloen', 'oeivind.kolloen@ntnu.no', '2'),
        ('testuser', '" . hash('sha256', '123') . "', 'Test', 'Bruker', 'testbruker@test.no', '2')";
        if ($dbconn->conn->exec($query)===false)
            die("INSERT USER FAIL" . $dbconn->conn->errorInfo()[2]);
        
        // Insert data into categories
        $query = "INSERT INTO categories(category) VALUES('Sport'),('News'),('Other')";
        if ($dbconn->conn->exec($query)===false)
            die("INSERT USER FAIL" . $dbconn->conn->errorInfo()[2]);
        
                // Insert data into articles
        $query = "INSERT INTO articles(datetime, heading, text, category, rating, publisher) VALUES
        ('1492009049', 'Hello world!', 'This is the very first article, isnt that awesome?', 'News', '0', 'Admin'),
        ('1492009200', 'Fake News', 'This is a really fake news article, inspired by the 45th president of the United States.', 'News', '0', 'testuser')";
        if ($dbconn->conn->exec($query)===false)
            die("INSERT article FAIL" . $dbconn->conn->errorInfo()[2]);
    }//insertDefaultData

}//class
$setup =  new setup();
