<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//header('Content-type: text/plain; charset=utf-16');

function toutf8(&$input) {
    if (is_string($input)) {
       
        //$input=mb_convert_encoding($input, "UTF-8", "ASCII");
        if (!json_encode($input)){
        $input = utf8_encode($input);
        }
             
    } else if (is_array($input)) {
        foreach ($input as &$value) {
            toutf8($value);
           
        }

        unset($value);
    } else if (is_object($input)) {
        $vars = array_keys(get_object_vars($input));
       

        foreach ($vars as $var) {
            toutf8($input->$var);
        }

    }
   
}

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
    $discount = $_GET['dis'];
    //$sortBy = $_GET['sort'];

    //$query="exec dbo.proc_getDeals_5 '$catCode','$retailers',$latitude,$longitude,$range,$discount";
    //$query="exec dbo.proc_getDeals_9 '$catCode','$retailers',$latitude,$longitude,$range,$discount";
    //$query="exec dbo.proc_getDeals_11 '$catCode','$retailers',$latitude,$longitude,$range,$discount";
    $query="exec dbo.proc_getExclusiveDeals '$catCode','$retailers',$latitude,$longitude,$range,$discount";
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
?>
