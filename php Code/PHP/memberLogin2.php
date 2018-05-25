<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('functionsLib.php');

$email = $_POST["email"];
$pass = $_POST["pass"];

$r=null;
$message="";

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
$result = new stdClass();
$status = new stdClass();
$retailer = new stdClass();
$locations = array();
try {
    $sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
    if ($sqlconn){

        $query ="exec proc_memberLogin2 '$email','$pass'";
        $execute=odbc_exec($sqlconn,$query);

        if ($status = odbc_fetch_object($execute)){
            
            if (odbc_next_result($execute)){
                If (!$retailer = odbc_fetch_object($execute)){
                    $retailer=(object)null;
                }
                if (odbc_next_result($execute)){
                    while($l=  odbc_fetch_object($execute)){
                        $locations[]=$l;
                    }
                }else{
                    $message="ERROR: error occurred during sql execution.";
                    $status=(object) array("state"=>-20,"message"=>$message);
                    $retailer=(object)null;
                }
            }else{
                $message="ERROR: error occurred during sql execution.";
                $status=(object) array("state"=>-20,"message"=>$message);
            }
             
            
        }
        else
        {
            //toutf8($r);	
            $message="ERROR: error occurred during sql execution.";
            $status=(object) array("state"=>-20,"message"=>$message);

        }

        odbc_close($sqlconn);
        //toutf8($r);
        //echo json_encode($r);
    }
    else{

        $message="ERROR: no database server connection.";
        $status=(object) array("state"=>-10,"message"=>$message);
        //toutf8($r);
        //echo json_encode($r);
    }
}
catch (Exception $e){
    $message="ERROR; ".$e->getMessage();
    $status=(object) array("state"=>-30,"message"=>$message);
    $retailer=(object)null;
    $locations=array();
}
 finally {
    if ($sqlconn){
         odbc_close($sqlconn);
    }
    $result->status=$status;
    $result->retailer=$retailer;
    $result->locations=$locations;
    toutf8($result);
    echo json_encode($result);
}

