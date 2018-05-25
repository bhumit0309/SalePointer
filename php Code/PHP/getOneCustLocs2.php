<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function toutf8(&$input) {
    if (is_string($input)) {
       
        //$input=mb_convert_encoding($input, "UTF-8", "ASCII");
        //$input = utf8_encode($input);
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

/*
$server='localhost\SQLEXPRESS';
$database='BV_WBFCMS_PROTO_1';
$sqluser='sa';
$sqlpwd='l760112p';
*/

$constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database";

$result = array();

$sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
if ($sqlconn){
    $customerId = $_GET["cid"];
    $iscurrent = $_GET["iscurrent"];
    //$query="exec dbo.proc_getDeals_4 '$catCode','$retailers',$latitude,$longitude,$range,$discount,'$sortBy'";
    //$query ="SELECT DISTINCT RetailerId,RetailerName,RImgName,RImgPath FROM dbo.vw_AllCustomers";
    $query ="SELECT * FROM dbo.vw_AllCustomers Where IsCurrent=$iscurrent AND CustomerId=$customerId";
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