<?php

class Db_num_deals_model extends CI_Model{
    
    function return_deals(){
        $this->load->database(); //It will load the database
        $q2 = $this->db->query("Select DISTINCT(DealType) from dbo.D01_DealMaster"); //To get distinct values
//        $q = $this->db -> query("Select DealId, ItemName, Description from dbo.D01_DealMaster where DealType = 'D'");//returns
    
        return $q2 ->result_array();
//        print_r($result);
//        return $result;
        }
}