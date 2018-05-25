<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('functionsLib.php');

$re=-1;
$message="";
$fileName="";
$filePath="";
if (isset($_POST["base64Img"])  && isset($_POST["fileName"]) ){
    $encoded_base64 = $_POST["base64Img"];
    $fileName = $_POST["fileName"];
    //--------------------------------------
    //$path="../upload/DealImgs/";
    //$fullPath=$path.$fileName;
    //--------------------------------------
    $path="/upload/DealImgs/";
    $fullPath="..".$path.$fileName;

    $decoded_img = base64_decode($encoded_base64);
    $fh =fopen($fullPath,"wb");
    $fw=  fwrite($fh, $decoded_img);
    //$fw=fwrite($fh,"hello!!!");
    fclose($fh);
    //if ($fw != false) {
    if($fw > 0) {
        //$filePath="http://".$_SERVER['HTTP_HOST'].$path.$fileName;
        $filePath="http://".$_SERVER['HTTP_HOST'].$path;
        //$message="UPLOAD_OKAY";          
    }else{
        $re=-20;
        $message="Image UPLOAD failed";
        $ret=(object)array("state"=>$re,"message"=>$message);
        toutf8($ret);
        echo json_encode($ret);
        exit(0);
    }
}else{
    $re=-10;
    $message="No images are provided!!";
    $ret=(object)array("state"=>$re,"message"=>$message);
    toutf8($ret);
    echo json_encode($ret);
    exit(0);
}
    
//$locations=$_POST["locations"];
//$retailerId=$_POST["rid"];
$ucode = $_POST["ucode"];
$catCode=$_POST["cat"];
$item=$_POST["item"];
$description=$_POST["des"];
$oprice=$_POST["oprice"];
$dprice=$_POST["dprice"];
$units=$_POST["units"];
$effdate=$_POST["effdate"];
$expdate=$_POST["expdate"];
$exlusive = $_POST["Exclusive"];
$quantity = $_POST["Quantity"];
$coupon = $_POST["Coupon"];
$Qrcode = $_POST["Qrcode"];
//echo $expdate;
//echo $effdate;
try{
    
    $server='sql7.hostek.com';
    $database='BV_WBFCMS_PROTO';
    $sqluser='Liao';
    $sqlpwd='Liao123!';        
    
    $constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database";
    
    $sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
    if ($sqlconn){
           
    	$query ="EXEC dbo.proc_insertOneDeal2 @UCODE='$ucode',@CatCode='$catCode',@ItemName='$item',@Description='$description',@OriginalPrice=$oprice,@DiscountPrice=$dprice,@Units='$units',@EffectiveDate='$effdate',@ExpiryDate='$expdate',@Exclusive='$exlusive',@Quantity='$quantity',@Coupon='$coupon',@ImageFileName='$fileName',@ImagePath='$filePath',@QrCode='$Qrcode'";
     
        $execute=odbc_exec($sqlconn,$query);
        if($execute){
            odbc_fetch_row($execute);
            $re= odbc_result($execute, 'State');
            $message=odbc_result($execute,'Message');
        }
        else{
            $re= -40;
            $message=  'ERROR: non-execution.';
        }
        odbc_close($sqlconn);       
    }
    else{
        $re= -30;
        $message=  'ERROR: non-connection.';
    }
}
catch(Exception $e){
     $re= -50;
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
    
    