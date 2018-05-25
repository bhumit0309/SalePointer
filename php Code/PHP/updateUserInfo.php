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

try{
    
    $ucode = $_POST["ucode"];
    $email=$_POST['email'];
    /*
    $first=$_POST['first'];
    $last=$_POST['last'];

    $loc1=$_POST['loc1'];
    $lat1=$_POST['lat1'];
    $lng1=$_POST['lng1'];
    $add1=$_POST['add1'];

    $loc2=$_POST['loc2'];
    $lat2=$_POST['lat2'];
    $lng2=$_POST['lng2'];
    $add2=$_POST['add2'];
    */
    if (isset($_POST['first']) && !empty($_POST['first'])){
        $first="'".urldecode($_POST['first'])."'";
    }else{
        $first="NULL";
    }
    if (isset($_POST['last']) && !empty($_POST['last'])){
        $last="'".urldecode($_POST['last'])."'";
    }else{
        $last="NULL";
    }

    if(isset($_POST['loc1']) && !empty($_POST['loc1'])){
        $loc1="'".urldecode($_POST['loc1'])."'";
    }else{
        $loc1="NULL";
    }
    if(isset($_POST['loc2']) && !empty($_POST['loc2'])){
        $loc2="'".urldecode($_POST['loc2'])."'";
    }else{
        $loc2="NULL";
    }
    if(isset($_POST['lat1']) && !empty($_POST['lat1'])){
        $lat1=$_POST['lat1'];
    }else{
        $lat1="NULL";
    }
    if(isset($_POST['lng1']) && !empty($_POST['lng1'])){
        $lng1=$_POST['lng1'];
    }else{
        $lng1="NULL";
    }
    if(isset($_POST['lat2']) && !empty($_POST['lat2'])){
        $lat2=$_POST['lat2'];
    }else{
        $lat2="NULL";
    }
    if(isset($_POST['lng2']) && !empty($_POST['lng2'])){
        $lng2=$_POST['lng2'];
    }else{
        $lng2="NULL";
    }
    if(isset($_POST['add1']) && !empty($_POST['add1'])){
        $add1="'".$_POST['add1']."'";
    }else{
        $add1="NULL";
    }
    if(isset($_POST['add2']) && !empty($_POST['add2'])){
        $add2="'".$_POST['add2']."'";
    }else{
        $add2="NULL";
    }
    
    //$query ="EXEC dbo.proc_updateUserInfo '$ucode','$email','$first','$last','$loc1','$loc2',$lat1,$lng1,$lat2,$lng2,'$add1','$add2'";
    $query ="EXEC dbo.proc_updateUserInfo '$ucode','$email',$first,$last,$loc1,$loc2,$lat1,$lng1,$lat2,$lng2,$add1,$add2";
    //echo $query;
    $sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
    if ($sqlconn){
        $execute = odbc_exec($sqlconn, $query);
        if ($execute){
            odbc_fetch_row($execute);
            $re= odbc_result($execute, 'State');
            $message=odbc_result($execute,'Message');
        }else{
            $re= -20;
            $message=  'ERROR: non-execution.';
        }
        odbc_close($sqlconn); 
    }else {
        $re= -10;
        $message=  'ERROR: non-connection.';
    }
}
catch(Exception $e){
    $re= -30;
    $message=  "ERROR; ".$e->getMessage();
}
finally {
    if ($sqlconn){
        odbc_close($sqlconn);
    }
    $ret=(object)array("state"=>$re,"message"=>$message);
    toutf8($ret);
    echo json_encode($ret);
}

