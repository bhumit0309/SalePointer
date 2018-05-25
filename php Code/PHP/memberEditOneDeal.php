<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('functionsLib.php');
$path="";
$re=-1;
$message="";

$server='sql7.hostek.com';
$database='BV_WBFCMS_PROTO';
$sqluser='Liao';
$sqlpwd='Liao123!';   
 
$constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database";

try{
    
    $ucode = $_POST["ucode"];
    $did =$_POST["did"];
    $catCode=$_POST["cat"];
    $item=$_POST["item"];
    $description=$_POST["des"];
    $oprice=$_POST["oprice"];
    $dprice=$_POST["dprice"];
    $units=$_POST["units"];
    //$effdate=$_POST["effdate"];
    $expdate=$_POST["expdate"];
    
    $query ="EXEC dbo.proc_editOneDeal @UCODE='$ucode',@DealId='$did',@CatCode='$catCode',@ItemName='$item',@Description='$description',@OriginalPrice=$oprice,@DiscountPrice=$dprice,@Units='$units',@ExpiryDate='$expdate'";
    
    $sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
    if ($sqlconn){
        $execute = odbc_exec($sqlconn, $query);
        if ($execute){
            odbc_fetch_row($execute);
            $re= odbc_result($execute, 'State');
            $message=odbc_result($execute,'Message');
            if ($re>0){
                if (isset($_POST["base64Img"]) && !empty($_POST["base64Img"])){
                    $encoded_base64 = $_POST["base64Img"];
                    $path=$message;
                    if (resetImage($path, $encoded_base64)) {
                        $message="Successfully update the deal and the image ! ";
                    }else{
                        $message="Successfully update the deal but failed to update the image! ";
                    }
                }
                else{
                    $message="Successfully update the deal! ";
                }
            }
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

