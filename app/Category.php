<?php

class Category {
    
    public $id, $category;
    
    public function __construct($id, $category){
        $this->id = $id;
        $this->category = $category;
    }
    
    // Getters
    public function get_id(){
        return $this->id;
    }
    
    public function get_category(){
        return $this->category;
    }
}