<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function toutf8(&$input) {
     //echo "toutf8";
     //echo "<br/>";
    if (is_string($input)) {
       
        //$input=mb_convert_encoding($input, "UTF-8", "ASCII");
         //if (mb_detect_encoding($input,"UTF-8") !== "UTF-8"){
         if (!json_encode($input)){
            $input = utf8_encode($input);
            //echo $input;
            //echo "<br/>";
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
    $query="exec dbo.proc_getDeals_11 '$catCode','$retailers',$latitude,$longitude,$range,$discount";
    $execute=odbc_exec($sqlconn,$query);
    
    while ($r = odbc_fetch_object($execute))
    {
        toutf8($r);	
        /*
         $vars = array_keys(get_object_vars($r));
        foreach ($vars as $var) {
            //toutf8($r->$var);
            $m=$r->$var;
            echo $m;
            echo "<br/>";
            echo mb_detect_encoding($m,"UTF-8");
            echo "<br/>";
        }
        */
        //$n=$r->ItemName;
        //echo $n;
        //echo "<br/>";
        //echo mb_detect_encoding($n,"UTF-8");
        //echo "<br/>";
        //echo json_encode($r,JSON_UNESCAPED_UNICODE );
        /*
        if (json_encode($r)){
            echo "ok";
        }else{
            echo "fail error is ";
            //echo json_last_error();
            switch (json_last_error()) {
        case JSON_ERROR_NONE:
            echo ' - No errors';
        break;
        case JSON_ERROR_DEPTH:
            echo ' - Maximum stack depth exceeded';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Underflow or the modes mismatch';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Unexpected control character found';
        break;
        case JSON_ERROR_SYNTAX:
            echo ' - Syntax error, malformed JSON';
        break;
        case JSON_ERROR_UTF8:
            echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
        break;
        default:
            echo ' - Unknown error';
        break;
    }
        }*/
        //echo "<br/>";
        $result[] = $r;
    }
    
    echo json_encode($result);
    odbc_close($sqlconn);
}
else{
    echo json_encode($result);
}
?>
