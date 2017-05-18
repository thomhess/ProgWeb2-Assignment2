<?php

class Category {

    public $category;
    
    public function __construct($category){
        $this->category = $category;
    }
    
    // Getters
    
    public function get_category(){
        return $this->category;
    }
}