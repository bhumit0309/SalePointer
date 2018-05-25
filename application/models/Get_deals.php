<?php

class Get_deals extends CI_Model {
    function getDeals(){
        $this->load->database();
        $query = $this->db->query("Select ItemName, OriginalPrice, DiscountPrice, Percentage, IconImage from dbo.D01_DealMaster where Exclusive = 'False' and DealType='P'");    //to get deals
        //$count = $query -> num_rows();
        //echo "Regular Deals = ".$count; 
        $result = $query->result_array();
        return $result;
    }
    
    function getnum(){
        $this->load->database();
        $query = $this->db->query("Select ItemName, OriginalPrice, DiscountPrice, Percentage, IconImage from dbo.D01_DealMaster where Exclusive = 'False' and DealType='P'");    //to get deals
        $count = $query -> num_rows();
        return $count;
    }
}