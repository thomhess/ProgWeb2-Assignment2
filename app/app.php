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
          $this->categories[$row['category']] = new Category($row['category']);
        }//foreach
    }
    
    // Creating users from database-content
    private function populateUsers(){
        $users = $this->fetchUsers();

        foreach($users as $key => $row){
          $this->users[$row['user_id']] = new User($row['user_id'], $row['username'], $row['first_name'], $row['surname'], $row['email']);
        }//foreach
    }
    
    // Fetching articles from database to use in populate
    public function fetchArticles(){
        global $dbconn;
        // fetch all the articles
        $query = "SELECT * FROM articles ORDER BY id ASC";
        $result = $dbconn->conn->query($query)->fetchAll();
        if (!$result)
            die('Query failed:' . $dbconn->conn->errorInfo()[2]);
            return $result;
    }
    
    // Fetching categories from database to use in populate
    public function fetchCategories(){
        global $dbconn;
        // fetch all the categories
        $query = "SELECT * FROM categories";
        $result = $dbconn->conn->query($query)->fetchAll();
        if (!$result)
            die('Query failed:' . $dbconn->conn->errorInfo()[2]);
            return $result;
    }
    
    // Fetching users from database to use in populate
    public function fetchUsers(){
        global $dbconn;
        // fetch all the categories
        $query = "SELECT * FROM users";
        $result = $dbconn->conn->query($query)->fetchAll();
        if (!$result)
            die('Query failed:' . $dbconn->conn->errorInfo()[2]);
            return $result;
    }
    
    // Method to check if user exists and return user id
    public function Login($username, $password){
        global $dbconn;
        try {
            $query = $dbconn->conn->prepare("SELECT user_id FROM users WHERE username=:username AND password=:password");
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
    
    // Method for returning user information
    public function UserDetails($user_id){
        global $dbconn;
        try {
            $query = $dbconn->conn->prepare("SELECT user_id, username, first_name, surname, email, usertype FROM users WHERE user_id=:user_id");
            $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_OBJ);
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    
    // Search method
    public function search($search){
        global $dbconn;
        $sql = "SELECT id, heading, text, category, publisher, rating FROM articles WHERE heading LIKE '%" . $search . "%' OR text LIKE '%" . $search ."%'";
        $query = $dbconn->conn->prepare( $sql );
        $result = $query->execute( array( $search ) );
        
        if ($query->rowCount() > 0) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
    
    // Method for inserting new user in database
    public function insertNewUser($username, $password, $first_name, $surname, $email, $usertype){
        global $dbconn;
        $sql = "INSERT INTO users ( username, password, first_name, surname, email, usertype) VALUES ( :username, :password, :first_name, :surname, :email, :usertype )";
        $query = $dbconn->conn->prepare( $sql );
        $result = $query->execute( array( ':username'=>$username, ':password'=>hash('sha256', $password), ':first_name'=>$first_name, ':surname'=>$surname, ':email'=>$email, ':usertype'=>$usertype ) );
    }
    
    // Method for editing existing user
    public function editUser($id, $username, $password, $first_name, $surname, $email){
        global $dbconn;
        $sql = "UPDATE users SET username=:username, password=:password, first_name=:first_name, surname=:surname, email=:email WHERE user_id=:id";
        $query = $dbconn->conn->prepare( $sql );
        $result = $query->execute( array( ':id'=>$id, ':username'=>$username, ':password'=>hash('sha256', $password), ':first_name'=>$first_name, ':surname'=>$surname, ':email'=>$email ) );
    }
    
    // Method for inserting new article into database
    public function insertNewsArticle($heading, $text, $category, $publisher) {
        global $dbconn;
        $currentTime = time();
        $defaultRating = '3';
        $sql = "INSERT INTO articles(datetime, heading, text, category, rating, publisher) VALUES(:datetime, :heading, :text, :category, :rating, :publisher)";
        $query = $dbconn->conn->prepare( $sql );
        $result = $query->execute( array( ':datetime'=>$currentTime, ':heading'=>$heading, ':text'=>$text, ':category'=>$category, ':rating'=>$defaultRating, ':publisher'=>$publisher ) );
    }
    
    // Method for inserting new category
    public function insertCategory($category){
        global $dbconn;
        $sql = "INSERT INTO categories ( category ) VALUES ( :category )";
        $query = $dbconn->conn->prepare( $sql );
        $result = $query->execute( array( ':category'=>$category ) );
    }
    
    // Method for deleting article
    public function deleteNewsArticle($id){
        global $dbconn;
        $sql = "DELETE FROM articles WHERE id = :id";
        $query = $dbconn->conn->prepare( $sql );
        $result = $query->execute( array( ':id'=>$id ) );
    }
    
    // Method for deleting category
    public function deleteCategory($cat){
        global $dbconn;
        $sql = "DELETE FROM categories WHERE category = :cat";
        $query = $dbconn->conn->prepare( $sql );
        $result = $query->execute( array( ':cat'=>$cat ) );
    }
    
    // Method for deleting user
    public function deleteUser($id){
        global $dbconn;
        $sql = "DELETE FROM users WHERE user_id = :id";
        $query = $dbconn->conn->prepare( $sql );
        $result = $query->execute( array( ':id'=>$id ) );
    }
    
    // Method for updating news article
    public function updateNewsArticle($id, $heading, $text, $category){
        global $dbconn;
        $sql = "UPDATE articles SET heading=:heading, text=:text, category=:category WHERE id=:id";
        $query = $dbconn->conn->prepare( $sql );
        $result = $query->execute( array( ':id'=>$id, ':heading'=>$heading, ':text'=>$text, ':category'=>$category ) );
    }
    
    // Method for counting the number of articles whithin category
    public function categoryCount($category){
        global $dbconn;
        $sql = "SELECT id FROM articles WHERE category = :category";
        $query = $dbconn->conn->prepare( $sql );
        $result = $query->execute( array( ':category'=>$category ) );
        return $query->rowCount();
    }
    
    // Method for updating the rating in database
    public function updateRating($id, $rating){
        global $dbconn;
        $newrating = $rating + 1;
        $sql = "UPDATE articles SET rating=:newrating WHERE id=:id";
        $query = $dbconn->conn->prepare( $sql );
        $result = $query->execute( array( ':id'=>$id, ':newrating'=>$newrating ) );
    }
   

    // Sorting articles based on type
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
