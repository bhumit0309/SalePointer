<?php

class My_Controller extends CI_Controller{
    
    public function index(){
        $this->load->view('main_page');
        //$this->load->model('Db_model');
    }
    public function Name(){
        $this-> load-> model('my_model');
        $firstName = $this -> my_model -> firstName();
        echo'FirstName -> ', $firstName;
    }
    public function deals() {
        $this->load->view('main_page');
        $this->load->view('deals');
    }
}
