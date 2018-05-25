<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('functionsLib.php');

$email = $_POST['email'];
$pwd = $_POST['pass'];
if (isset($_POST['user']) && !empty($_POST['user'])){
    $user = $_POST['user'];
}else{
    $user=$email;
}

$re=0;
$message="";
if (empty($user) or empty($pwd) or empty($email)){
    //return -1;
    //$re=-1;
    $message="The information is not complete !";
    $r=(object) array("state"=>-1,"uniquecode"=>null,"message"=>$message);
    toutf8($r);
    echo json_encode($r);
    exit(0);
}
if (!validateEmail($email)){
    //$re=-5;
    $message="Email is not valid!";
    $r=(object) array("state"=>-5,"uniquecode"=>null,"message"=>$message);
    toutf8($r);
    echo json_encode($r);
    exit(0);
}

$server='sql7.hostek.com';
$database='BV_WBFCMS_PROTO';
$sqluser='Liao';
$sqlpwd='Liao123!';        
$constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database";
 
try {
    $sqlconn=  odbc_connect($constr, $sqluser, $sqlpwd);
    if ($sqlconn){
        $query="exec proc_insertUser3 '$user','$pwd','$email'";
        $result=odbc_exec($sqlconn,$query);
        if (!$r=odbc_fetch_object($result)){
            $message="ERROR: error occurred during query execution.";
            $r=(object) array("state"=>-3,"uniquecode"=>null,"message"=>$message);
        }
        odbc_close($sqlconn);
    }else{
        $message="Can not connect to the server!";
        $r=(object) array("state"=>-2,"uniquecode"=>null,"message"=>$message);
    }
}
catch (Exception $e){
    $message="ERROR; ".$e->getMessage();
    $r=(object) array("state"=>-4,"uniquecode"=>null,"message"=>$message);
}
finally {
    if ($sqlconn){
         odbc_close($sqlconn);
    }
    toutf8($r);
    echo json_encode($r);
}

