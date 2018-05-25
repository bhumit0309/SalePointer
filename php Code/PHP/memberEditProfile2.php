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

$retailer = new stdClass();
$l= new stdClass();
$locations = array();
$ret1 = new stdClass();

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
                        $path=trim($path); //---
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
                    $query3 ="EXEC proc_memberGetMemInfo @UCODE='$ucode'";
                    $result3=odbc_exec($sqlconn,$query3);
                    if($result3){
                        if(!$retailer=odbc_fetch_object($result3)){
                            $message .=" Please re Log in!";
                            $retailer=(object)null;
                        }else{
                            if (odbc_next_result($result3)){
                                while($l=  odbc_fetch_object($result3)){
                                    $locations[]=$l;
                                }
                            }else{
                                $message .=" Please re Log in!";
                                $retailer=(object)null;
                            }
                        }
                    }else{
                        $message .=" Please re Log in!";
                        $retailer=(object)null;
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
    $ret1->status=$ret;
    $ret1->retailer=$retailer;
    $ret1->locations=$locations;
    toutf8($ret1);
    echo json_encode($ret1);
}
    
   
