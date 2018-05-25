

<?php 
class Sp_controller extends CI_Controller{
    
    function index(){
//load helper url
        $this->load->helper('url');
        $this->load->view('main_page');
    }
    function signin(){
        $this->load->helper('url');
        $this->load->view('signin');
    }
            
    function hello(){
        echo "Hello";
    }
}

