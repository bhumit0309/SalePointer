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
//------------------------------------------------------------------------------
$re=0;
$message="";
if(!isset($_POST["cid"])||!isset($_POST["rid"])){
    $re=-10;
    $message="No parameters were provided!!";
    $ret=new stdClass();
    $ret->state=$re;
    $ret->message=$message;
    toutf8($ret);
    echo json_encode($ret);
    exit(0);
}
$cid=$_POST["cid"];
$rid=$_POST["rid"];
try{
    
    $server='sql7.hostek.com';
    $database='BV_WBFCMS_PROTO';
    $sqluser='Liao';
    $sqlpwd='Liao123!';        
 
    $constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database";
    
    $sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
    if ($sqlconn){       
    	$query1 ="EXEC dbo.proc_deleteCustomer $cid,$rid";
        $execute=odbc_exec($sqlconn,$query1);
        if($execute){
            odbc_fetch_row($execute);
            $re= odbc_result($execute, 'State');
            $message="Customer: ".odbc_result($execute,'Message');
        }
        else{            
            $re= -10;
            $message=  'Customer ERROR: non-execution.';            
        }
        //----------------------------------------------------------------------
        if ($re <= 0){
            if ($sqlconn){
                odbc_close($sqlconn);
            }
            $ret=(object)array("state"=>$re,"message"=>$message);
            toutf8($ret);
            echo json_encode($ret);
            exit(0);
        }
        //----------------------------------------------------------------------
        $query2 ="EXEC dbo.proc_deleteOneRetailerAndItsLocations $rid";
        $execute2=odbc_exec($sqlconn,$query2);
        if($execute2){
            odbc_fetch_row($execute2);
            $re= odbc_result($execute2, 'State');
            $message=$message." \n Retailer: ".odbc_result($execute2,'Message');
        }
        else{
            $re= -10;
            $message=$message.' \n Retailer ERROR: non-execution.';
        }        
        odbc_close($sqlconn);       
    }
    else{
        $re= -10;
        $message=  'ERROR: non-connection.';
    }
}
catch(Exception $e){
     $re= -20;
     $message=$message." ERROR: ".$e->getMessage();
}
finally{
    if ($sqlconn){
         odbc_close($sqlconn);
    }
    $ret=(object)array("state"=>$re,"message"=>$message);
    toutf8($ret);
    echo json_encode($ret);
}


