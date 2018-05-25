<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('functionsLib.php');
function insertUser($user,$pwd,$email){
    $re=0;
    $message="";
    if (empty($user) or empty($pwd) or empty($email)){
                //return -1;
        $re=-1;
        $message="The information is not complete !";
        return (object)array("state"=>$re,"message"=>$message);
    }
    if (!validateEmail($email)){
        $re=-5;
        $message="Email is not valid!";
        return (object)array("state"=>$re,"message"=>$message);  
}
    try{
        $server='sql7.hostek.com';
        $database='BV_WBFCMS_PROTO';
        $sqluser='Liao';
        $sqlpwd='Liao123!';        
        $constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database";
        $sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
        if ($sqlconn){
            $query="exec proc_insertUser '$user','$pwd','$email'";
            $result=odbc_exec($sqlconn,$query);
            if($result) {
                         
                odbc_fetch_row($result);
                $re=odbc_result($result,1); 
                odbc_close($sqlconn);
                //return   $re; //returns 1 if the new user was inserted, or returns 0 if the username or email already exists.
                switch($re){
                    case 1:
                        $message="The user is successfully added.";
                        break;
                    case 0:
                        $message="The user name or email already exists!";
                        break;
                }
            }
            else{ 
                odbc_close($sqlconn);
                //return -3;
                $re=-3;
                $message="Error occured during query execution!";
            }
        }
        else{
            $re=-2;
            $message="Can not connect to the server!";
        }
    }
    catch(Exception $e){
        $re= -4;
        $message .=  "ERROR; ".$e->getMessage();
    }
    finally {
        if ($sqlconn){
            odbc_close($sqlconn);
        }
        return (object)array("state"=>$re,"message"=>$message);
    }             
}
        
$email = $_POST['email'];
$password = $_POST['pass'];
if (isset($_POST['user']) && !empty($_POST['user'])){
    $user = $_POST['user'];
}else{
    $user=$email;
}

//echo insertUser($user,$password,$email);
$ret=insertUser($user,$password,$email);
toutf8($ret);
echo json_encode($ret);



