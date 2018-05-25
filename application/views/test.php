
<?php

class Test extends CI_Controller{
    
    public function index(){
        $this->load->view('test');
    }
    public function Name(){
        $this-> load-> model('My_Model');
        $firstName -> $this -> My_Model -> firstName();
        echo'FirstName ->',$firstName;
    }
}
