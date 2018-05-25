<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'functionsLib.php';

$server='sql7.hostek.com';
$database='BV_WBFCMS_PROTO';
$sqluser='Liao';
$sqlpwd='Liao123!';        

$constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database";

$result = array();

$sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
if ($sqlconn){
    
    $lat=$_GET['lat'];
    $lng=$_GET['lng'];
   
    //$query="exec dbo.proc_getDeals_4 '$catCode','$retailers',$latitude,$longitude,$range,$discount,'$sortBy'";
    //$query ="SELECT DISTINCT RetailerId,RetailerName,RImgName,RImgPath FROM dbo.vw_AllCustomers";
    $query ="exec dbo.proc_getAllCustromerLocation3 $lat,$lng ";
    $execute=odbc_exec($sqlconn,$query);
    
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

