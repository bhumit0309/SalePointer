<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'functionsLib.php';

//echo uniqid('IMG_',false).'.jpg';
$re=0;
$message="";
$path="";

$server='sql7.hostek.com';
$database='BV_WBFCMS_PROTO';
$sqluser='Liao';
$sqlpwd='Liao123!';   
 
$constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database";
try{
    
    $ucode = $_POST["ucode"];
    $store =$_POST["store"];
    $first=$_POST["first"];
    $last=$_POST["last"];
    $phone=$_POST["phone"];
    $des=$_POST["des"];
    $cat=$_POST["cat"];
    
    $query ="EXEC proc_memberUpdateProfile @UCODE='$ucode',@StoreName='$store',@FirstName='$first',@LastName='$last',@Phone='$phone',@Description='$des',@CatCode='$cat'";
    $sqlconn=  odbc_connect($constr, $sqluser, $sqlpwd);
    if ($sqlconn){
        $result = odbc_exec($sqlconn, $query);
        if ($result){
            $r= odbc_fetch_object($result);
            if ($r){
                $re=$r->state;
                $message=$r->message;
                if ($re>0){
                     if (isset($_POST["base64Img"]) && !empty($_POST["base64Img"])){
                        $encoded_base64 = $_POST["base64Img"];
                        $path=$r->path; //echo $path;
                        $messagef = "";
                        if ($path==null ||empty($path)){
                            $fileName=uniqid('IMG_',false).'.jpg';
                            $path="/upload/StoreImgs/";
                            $fullpath="..".$path.$fileName;
                            $messagef=" But failed to add the image! ";
                            if (saveImage($fullpath, $encoded_base64)){
                                $filePath="http://".$_SERVER['HTTP_HOST'].$path;
                                $query2 ="EXEC proc_memberAddLogo @UCODE='$ucode',@ImagePath='$filePath',@ImageName='$fileName'";
                                $result2=  odbc_exec($sqlconn, $query2);
                                if ($result2){
                                    $r2= odbc_fetch_object($result2);
                                    if ($r2){
                                        $messagef=" And ".$r2->message;
                                    }
                                }
                            }                    
                        }else{
                            if (resetImage($path, $encoded_base64)) {
                                $messagef=" And successfully update the image ! ";
                            }else{
                                $messagef=" But failed to update the image! ";
                            }
                        }
                        $message=$message.$messagef;
                    }                
                }        
            }else{
                $re= -20;
                $message=  'ERROR: no response from the database!.';
            }
        }else{
            $re=-40;
            $message=  'ERROR: non-execution.';
        }
        odbc_close($sqlconn);
    }else{
        $re= -10;
        $message=  'ERROR: non-connection.';
    }
}
catch(Exception $e){
     $re= -30;
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
    
   
