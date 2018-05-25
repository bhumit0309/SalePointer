<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once ('functionsLib.php');
$re=0;
$message="";
try{
    $ucode = $_POST["ucode"];
    $oldpass = $_POST["oldpass"];
    $newpass = $_POST["newpass"];
    //--------------------------------------------------------------------------
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
    
    $sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
    if ($sqlconn){
        $query  ="EXEC dbo.proc_memberResetPass  '$ucode','$oldpass','$newpass'";
         $execute=odbc_exec($sqlconn,$query);
         if ($execute){
             if (odbc_fetch_row($execute)){
                $re= odbc_result($execute, 'State');
                $message .=odbc_result($execute,'Message');
             }
             else{
                 $re=-40;
                 $message="ERROR: error occurred during getting execution results!";
             }
         }
         else{
            $re= -20;
            $message .=  'ERROR: non-execution.';
         }
         odbc_close($sqlconn);  
    }
    else{
        $re= -10;
        $message .=  'ERROR: non-connection.';
    }
}
catch (Exception $e){
    $re= -30;
    $message .=  "ERROR; ".$e->getMessage();
}
finally{
    if ($sqlconn){
         odbc_close($sqlconn);
    }
    $ret=(object)array("state"=>$re,"message"=>$message);
    toutf8($ret);
    echo json_encode($ret);
}

