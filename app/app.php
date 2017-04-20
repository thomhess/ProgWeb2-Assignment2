<?php

// Fetching other php-files to be used
require_once('init.php');

class App{

    public $articles = [];
    public $categories = [];
    public $users = [];
    //public $database;

    // Default sorting

    function __construct(){
        $this->populateArticles();
        $this->populateCategories();
        $this->populateUsers();
    }

    // Creating articles from database-content
    private function populateArticles(){
        $articles = $this->fetchArticles();

        foreach($articles as $key => $row){//something wrong here as customers doesnt get created properly -> fixed
          $this->articles[$row['id']] = new Article($row['id'], $row['datetime'], $row['heading'], $row['text'], $row['category'], $row['rating'], $row['publisher']);
        }//foreach
    }
    
    // Creating categories from database-content
    private function populateCategories(){
        $categories = $this->fetchCategories();

        foreach($categories as $key => $row){
          $this->categories[$row['id']] = new Category($row['id'], $row['category']);
        }//foreach
    }
    
    // Creating users from database-content
    private function populateUsers(){
        $users = $this->fetchUsers();

        foreach($users as $key => $row){
          $this->users[$row['user_id']] = new User($row['user_id'], $row['username'], $row['first_name'], $row['surname'], $row['email']);
        }//foreach
    }

    public function fetchArticles(){
        global $database;
        // fetch all the articles
        $query = "SELECT * FROM articles ORDER BY id ASC";
        $result = $database->conn->query($query)->fetchAll();
        if (!$result)
            die('Query failed:' . $database->conn->errorInfo()[2]);
            return $result;
    }
    
    public function fetchCategories(){
        global $database;
        // fetch all the categories
        $query = "SELECT * FROM categories";
        $result = $database->conn->query($query)->fetchAll();
        if (!$result)
            die('Query failed:' . $database->conn->errorInfo()[2]);
            return $result;
    }
    
    public function fetchUsers(){
        global $database;
        // fetch all the categories
        $query = "SELECT * FROM users";
        $result = $database->conn->query($query)->fetchAll();
        if (!$result)
            die('Query failed:' . $database->conn->errorInfo()[2]);
            return $result;
    }
    
    public function Login($username, $password){
        global $database;
        try {
            $query = $database->conn->prepare("SELECT user_id FROM users WHERE username=:username AND password=:password");
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $enc_password = hash('sha256', $password);
            $query->bindParam("password", $enc_password, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetch(PDO::FETCH_OBJ);
                return $result->user_id;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    
    public function UserDetails($user_id){
        global $database;
        try {
            $query = $database->conn->prepare("SELECT user_id, username, first_name, surname, email, usertype FROM users WHERE user_id=:user_id");
            $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_OBJ);
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    
    public function search($search){
        global $database;
        $sql = "SELECT id, heading, text FROM articles WHERE heading LIKE '%" . $search . "%' OR text LIKE '%" . $search ."%'";
        $query = $database->conn->prepare( $sql );
        $result = $query->execute( array( $search ) );
        
        if ($query->rowCount() > 0) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
   



    // Sorting withdrawals and deposits based on asc/desc and type
    public function sorting(&$array, $by){

        switch($by) {
            case 'published' :
                usort($array, "app::ranking_published");
                break;
            case 'rating' :
                usort($array, "app::ranking_rating");
                break;
            }
    }

    // Functions for the usort to use in sorting
    public function ranking_published($a, $b){
        return $b->datetime - $a->datetime;
    }

    public function ranking_rating($a, $b) {
        return $b->rating - $a->rating;
    }

}
$app = new App();
