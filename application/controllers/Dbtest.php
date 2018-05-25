<?php
class DbTest extends CI_Controller {
    
    public function index($username = "Demo", $password = "Fake") {
        
        
        $this->load->helper('url');
        //$profile = array("username" => $username, "password" => $password);
        $this->load->model('db_model');
        
        $profile = $this->db_model->getData($username, $password);
        print_r($profile);
        //print_r($profile);
        //$this->load->view('header');
        $data["profile"] = $profile;
        
        //$this->load->view('dbtest', $data);
    }
    
    public function hello() {
        echo "This is hello function!";
    }
}