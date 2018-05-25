<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('functionsLib.php');
require_once ('db_credential.php');
//$user = $_POST["user"];
$email= $_POST["email"];
$pass = $_POST["pass"];

$r=null;
$message="";

/*
$server='localhost\SQLEXPRESS';
$database='BV_WBFCMS_PROTO_1';
$sqluser='sa';
$sqlpwd='l760112p';
*/

//$constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database";
try {
    //$sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
    if ($sqlconn){

        //$query ="exec dbo.proc_authentication1 '$user','$pass'";
        $query ="exec dbo.proc_authentication2 '$email','$pass'";
        $execute=odbc_exec($sqlconn,$query);

        if (! $r = odbc_fetch_object($execute))
        {
            $message="ERROR: error occurred during sql execution.";
            $r=(object) array("state"=>-20,"uniquecode"=>null,"message"=>$message);

        }
        odbc_close($sqlconn);
    }
    else{
        $message="ERROR: no database server connection.";
        $r=(object) array("state"=>-10,"uniquecode"=>null,"message"=>$message);
    }
}
catch (Exception $e){
    $message="ERROR; ".$e->getMessage();
    $r=(object) array("state"=>-30,"uniquecode"=>null,"message"=>$message);
}
 finally {
    if ($sqlconn){
         odbc_close($sqlconn);
    }
    toutf8($r);
    echo json_encode($r);
}

