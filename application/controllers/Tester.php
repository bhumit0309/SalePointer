<?php

class Tester extends CI_Controller{
    
    function deals(){
        $this->load->model('Get_deals');
        $result['data'] = $this->Get_deals->getDeals();
        $result['num'] = $this->Get_deals->getnum();
        $this->load->view('deals',$result);
    }
    
    function reg_deal()
    {
        $this->load->view('reg_deal');
    }
    
    function ex_deal()
    {
        $this->load->view('exclusive_deal');
    }
    
    function coupon()
    {
        $this->load->view('coupon');
    }
    
    function view_deal()
    {
        $this->load->view('view_deal');
    }
}
