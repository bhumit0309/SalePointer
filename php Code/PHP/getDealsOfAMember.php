<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('functionsLib.php');
$server='sql7.hostek.com';
$database='BV_WBFCMS_PROTO';
$sqluser='Liao';
$sqlpwd='Liao123!';        
$constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database";

$result = array();

$sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
if ($sqlconn){
    $ucode = $_POST["ucode"];
    $catCode = $_POST['cat'];
    $latitude = $_POST['lat'];
    $longitude = $_POST['lng'];
    $range = $_POST['rng'];
    //$discount = $_GET['dis'];

    $query="proc_getDealsOfCustomer '$ucode','$catCode',$latitude,$longitude,$range";
    $execute= odbc_exec($sqlconn,$query);
    
  
          while ($r = odbc_fetch_object($execute))
         {
               toutf8($r);	
                $result[] = $r;
         }
    
      
    
    echo json_encode($result);
    odbc_close($sqlconn);
}
else{
    echo json_encode($result);
}