<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function toutf8(&$input) {
    if (is_string($input)) {
       
        //$input=mb_convert_encoding($input, "UTF-8", "ASCII");
        $input = utf8_encode($input);
        //$input = iconv("ISO-8859-1", "utf-8", $input);
        //$input = iconv("UCS-2LE", "utf-8", $input);
        // does not work $input = iconv("CP850", "UTF-8//TRANSLIT", $input);
        //$input = iconv("CP1252", "UTF-8", $input);
        // does not work $input = iconv("CP1252", "ISO-8859-1", $input);
        
             
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
//header ('Content-type: application/json; charset=utf-8');
$server='sql7.hostek.com';
$database='BV_WBFCMS_PROTO';
$sqluser='Liao';
$sqlpwd='Liao123!';        
$constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database;Client_CSet=UTF-8";

$result = array();

$sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
if ($sqlconn){
    $catCode = $_GET['cat'];
    $locationId = $_GET['lid'];    
    $discount = $_GET['dis'];
    $sortBy = $_GET['sort'];

    $query="exec dbo.proc_getDealsOfOneLocation '$catCode',$locationId,$discount,'$sortBy'";
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


