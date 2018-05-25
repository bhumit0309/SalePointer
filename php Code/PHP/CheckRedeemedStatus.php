<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('functionsLib.php');


$DealId = $_GET["DealId"];
$UserId = $_GET["UserId"];

try{
    
    $server='sql7.hostek.com';
    $database='BV_WBFCMS_PROTO';
    $sqluser='Liao';
    $sqlpwd='Liao123!';        
    
    $constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database";
    
    $sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
    if ($sqlconn){
           
    	$query ="select * from dbo.R02_RedeemMaster where DealId ='$DealId' and UserId='$UserId'";
       // echo $query;
        $execute=odbc_exec($sqlconn,$query);
       
        $get_data = array();
            if(odbc_num_rows($execute) > 0)
            {
                  $get_data['salepointer'][] = array(
				'status' => 'true');
            }else{
                    $get_data['salepointer'][] = array(
				'status' => 'false');
            }
        }
        else{
        }
}
catch(Exception $e){
   
}
finally{
    if ($sqlconn){
         odbc_close($sqlconn);
    }
  //  $ret=(object)array("status"=>$status);
//    toutf8($ret);
   echo json_encode($get_data);
}
    
    