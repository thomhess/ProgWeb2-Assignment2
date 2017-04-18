<?php

class Article {
    
    public $id, $datetime, $heading, $text, $category, $rating, $publisher;
    
    public function __construct($id, $datetime, $heading, $text, $category, $rating, $publisher){
        $this->id = $id;
        $this->datetime = $datetime;
        $this->heading = $heading;
        $this->text = $text;
        $this->category = $category;
        $this->rating = $rating;
        $this->publisher = $publisher;
    }
    
    // Getters
    public function get_id(){
        return $this->id;
    }
    
    public function get_datetime(){
        return $this->datetime;
    }
    
    public function get_heading(){
        return $this->heading;
    }
    
    public function get_text(){
        return $this->text;
    }
    
    public function get_category(){
        return $this->category;
    }
    
    public function get_rating(){
        return $this->rating;
    }
    
    public function get_publisher(){
        return $this->publisher;
    }
    
    // Setter for rating
    public function set_rating(){
        $this->rating = $rating;
    }
}