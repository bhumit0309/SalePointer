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
    $catCode = $_GET['cat'];
    $retailers = $_GET['rets'];
    $latitude = $_GET['lat'];
    $longitude = $_GET['lng'];
    $range = $_GET['rng'];
    $days = $_GET['days'];
    

    //$query="exec dbo.proc_getDeals_5 '$catCode','$retailers',$latitude,$longitude,$range,$discount";
    $query="exec dbo.proc_getLastChanceDeals '$catCode','$retailers',$latitude,$longitude,$range,$days";
    //$query="exec dbo.proc_getLastChanceDeals2 '$catCode','$retailers',$latitude,$longitude,$range,$days";
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


