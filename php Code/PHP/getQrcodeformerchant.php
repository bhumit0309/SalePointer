<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('functionsLib.php');


$email = $_GET["email"];

try{
    
    $server='sql7.hostek.com';
    $database='BV_WBFCMS_PROTO';
    $sqluser='Liao';
    $sqlpwd='Liao123!';        
    
    $constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database";
    
    $sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
    if ($sqlconn){
           
    	$query ="select QrCode from dbo.M01_MemberShipMaster where LowerEmail = '".$email."'";
    // echo $query;
       $result = odbc_exec($sqlconn,$query);
        $get_data = array();
         
          if(odbc_num_rows($result) > 0)
         {
         while (odbc_fetch_row($result)) {
      
            $get_data['SalePointer'][] = array(
                'QrCode' => odbc_result($result, "QrCode"));
                break;
            //$message=odbc_result($execute,'Message');
        }
         }
         else
         {
              $get_data['SalePointer'][] = array(
                'QrCode' => "");
         }
       
        odbc_close($sqlconn);       
    }
}
catch(Exception $e){
}
finally{
    if ($sqlconn){
         odbc_close($sqlconn);
    }
    //$ret=(object)array("QrCode"=>$qrcode);
  //  toutf8($get_data);
     echo json_encode($get_data);
}
    
    