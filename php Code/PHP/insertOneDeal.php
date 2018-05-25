<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 
//header('Content-type: text/plain; charset=ucs2');

function toutf8(&$input) {
    if (is_string($input)) {
       
        //$input=mb_convert_encoding($input, "UTF-8", "ASCII");
        $input = utf8_encode($input);
        
             
    } else if (is_array($input)) {
        foreach ($input as &$value) {
            toutf8($value);
           
        }

        unset($value);
    } else if (is_object($input)) {
        $vars = array_keys(get_object_vars($input));
       

        foreach ($vars as $var) {
            toutf8($input->$var);
        }

    }
   
}

//------------------------------------------------------------------------------
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
        $re=-10;
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
    
$locations=$_POST["locations"];
$retailerId=$_POST["rid"];
$catCode=$_POST["cat"];
$item=$_POST["item"];
$description=$_POST["des"];
$oprice=$_POST["oprice"];
$dprice=$_POST["dprice"];
$units=$_POST["units"];
$effdate=$_POST["effdate"];
$expdate=$_POST["expdate"];

try{
    
    $server='sql7.hostek.com';
    $database='BV_WBFCMS_PROTO';
    $sqluser='Liao';
    $sqlpwd='Liao123!';        
    
    $constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database;Client_CSet=UTF-8;Server_CSet=UTF-16";
    
    $sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
    if ($sqlconn){
        //$query="exec dbo.proc_getDeals_4 '$catCode','$retailers',$latitude,$longitude,$range,$discount,'$sortBy'";
        //$query ="SELECT DISTINCT RetailerId,RetailerName,RImgName,RImgPath FROM dbo.vw_AllCustomers";
        //$query ="EXEC dbo.proc_insertReLocCust2 @RetaiLerName='$name',@RImagePath='$filePath',@RImageFileName='$fileName',@Address1='$add',@City='$city',@ProvinceAddr='$province', @PostCode='$post',@CountryAddr='$country', @Phone1='$phone',@Email = '$email',@Lat=$lat,@Lng=$lng, @TypeCode=N'F01'";
    	//$query ="EXEC dbo.proc_insertOneDeal @LocIdList='$locations', @RetailerId=$retailerId,@CatCode='$catCode',@ItemName='$item',@Description='$description',@OriginalPrice=$oprice,@DiscountPrice=$dprice,@Units='$units',@EffectiveDate='$effdate',@ExpiryDate='$expdate',@ImageFileName='$fileName',@ImagePath='$filePath'";
        
        $query ="EXEC dbo.proc_insertOneDeal1 @LocIdList='$locations', @RetailerId=$retailerId,@CatCode='$catCode',@ItemName='$item',@Description='$description',@OriginalPrice=$oprice,@DiscountPrice=$dprice,@Units='$units',@EffectiveDate='$effdate',@ExpiryDate='$expdate',@ImageFileName='$fileName',@ImagePath='$filePath'";
     
     
        $execute=odbc_exec($sqlconn,$query);
        if($execute){
            odbc_fetch_row($execute);
            $re= odbc_result($execute, 'State');
            $message=odbc_result($execute,'Message');
        }
        else{
            $re= -10;
            $message=  'ERROR: non-execution.';
        }
        odbc_close($sqlconn);       
    }
    else{
        $re= -10;
        $message=  'ERROR: non-connection.';
    }
}
catch(Exception $e){
     $re= -20;
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
    
    
  
