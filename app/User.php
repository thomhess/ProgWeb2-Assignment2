<?php

class User {
    
    public $id, $username, $first_name, $surname, $email;
    
    public function __construct($id, $username, $first_name, $surname, $email){
        $this->id = $id;
        $this->username = $username;
        $this->first_name = $first_name;
        $this->surname = $surname;
        $this->email = $email;
    }
    
    // Getters
    public function get_id(){
        return $this->id;
    }
    
    public function get_username(){
        return $this->username;
    }
    
    public function get_first_name(){
        return $this->first_name;
    }
    
    public function get_surname(){
        return $this->surname;
    }
    
    public function get_email(){
        return $this->email;
    }

}