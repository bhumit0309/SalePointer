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
        //$input =  mb_convert_encoding($input, "UTF-8", "UTF-16"); 
        //$input =  mb_convert_encoding($input, "UTF-8", "UCS-2LE");
        //$input =  mb_convert_encoding($input, "UTF-8", "UCS-2");
        
             
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
$constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database";//Client_CSet=UTF-8";

$result = array();

$sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
if ($sqlconn){
   
    //$query="exec dbo.proc_getDeals_4 '$catCode','$retailers',$latitude,$longitude,$range,$discount,'$sortBy'";
    //$query ="SELECT DISTINCT RetailerId,RetailerName,RImgName,RImgPath FROM dbo.vw_AllCustomers";
    //$query ="SELECT CustomerId, RetailerId,RetailerName,RImgPath,RImgName,MAX(ActivateDate) AS ActivateDate FROM dbo.vw_AllCustomers GROUP BY CustomerId, RetailerId,RetailerName,RImgPath,RImgName";
    $query ="EXEC dbo.proc_getAllCustromer";
    $execute=odbc_exec($sqlconn,$query);
    
    while ($r = odbc_fetch_object($execute))
    {
        //toutf8($r);	
        $n=$r->RetailerName;
        echo $n;
        echo "<br/>";
        if (mb_detect_encoding($n,"UTF-8")=="UTF-8"){
            echo "ok" ;
        }else{
            echo "failed";
        }
        echo "<br/>";
        $result[] = $r;
    }
    
    echo json_encode($result);
    //echo json_encode($result,JSON_UNESCAPED_UNICODE);
    odbc_close($sqlconn);
}
else{
    echo json_encode($result);
    //echo json_encode($result,JSON_UNESCAPED_UNICODE);
}
?>
