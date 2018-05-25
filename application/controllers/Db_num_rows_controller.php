<?php
class Db_num_rows_controller extends CI_Controller{
    
    function index(){
        $this->load->model('Db_num_deals_model');
        $res['a']= $this->Db_num_deals_model->return_deals();
        $this->load->view('db_num_rows_view', $res);
        
//        if($res){
//            //$data['result'] =$res;
//            $this->load->view('user_view',$res);
//        }
//        else{
//            echo "Fail!";
//        }
    }
}
