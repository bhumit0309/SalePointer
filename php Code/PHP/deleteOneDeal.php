<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('functionsLib.php');

if (!isset ($_POST["did"])){
    $re=-10;
    $message="Deal Id was not provided !!";
    $ret=(object)array("state"=>$re,"message"=>$message);
    toutf8($ret);
    echo json_encode($ret);
    exit(0);
}

$did =$_POST["did"];
$path="";
try{
    
    $server='sql7.hostek.com';
    $database='BV_WBFCMS_PROTO';
    $sqluser='Liao';
    $sqlpwd='Liao123!';        
 
    $constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database";
    
    $sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
    if ($sqlconn){
        
    	//$query ="EXEC dbo.proc_deleteOneDeal $did";
        $query ="EXEC dbo.proc_deleteOneDeal2 $did";
     
        $execute=odbc_exec($sqlconn,$query);
        if($execute){
            odbc_fetch_row($execute);
            $re= odbc_result($execute, 'State');
            $message=odbc_result($execute,'Message');
            if ($re >0){
                $path=$message;
                if (deletefile($path)){
                    $message="successfully delete the deal and its image !!";
                }else {
                    $message="successfully delete the deal but failed to delete its image !!";
                }
            }
        }
        else{
            $re= -10;
            $message=  'ERROR: non-execution.';
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
     $message=  "ERROR; ".$e->getMessage();
}
finally{
    if ($sqlconn){
         odbc_close($sqlconn);
    }
    $ret=(object)array("state"=>$re,"message"=>$message);
    toutf8($ret);
    echo json_encode($ret);
}

