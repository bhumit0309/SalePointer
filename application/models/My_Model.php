<?php

class My_Model extends CI_Model{
    
    public function firstName(){
        $lastName = $this -> lastName();
        return "Harsh $lastName";
       
    }
    
    private function lastName(){
        return "Ankit";
    }
}