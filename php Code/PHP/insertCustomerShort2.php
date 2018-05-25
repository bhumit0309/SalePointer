<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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

//$add="";
//$city="";
//$province="";
//$country="";
//$post="";
$fileName="";
$filePath="";
$message="";

if (isset($_POST["base64Img"])&& isset($_POST["fileName"])){
    $encoded_base64 = $_POST["base64Img"];
    $fileName = $_POST["fileName"];
    //$path="/upload/";
    $path="/upload/StoreImgs";
    $fullPath="..".$path.$fileName;
    //echo $encoded_base64."___Okay!!!"; 
    
    $decoded_img = base64_decode($encoded_base64);
    $fh =fopen($fullPath,"wb");
    $fw=  fwrite($fh, $decoded_img);
    //$fw=fwrite($fh,"hello!!!");
    fclose($fh);
    if ($fw != false) {
        $filePath="http://".$_SERVER['HTTP_HOST'].$path;
        $message="UPLOAD_OKAY";
    }else{
        $fileName="";
        $filePath="";
        $message="UPLOAD_failed";
    }
}
$name=$_POST["name"];
$add=$_POST["add"];
$city=$_POST["city"];
$province=$_POST["province"];
$country=$_POST["country"];
$post=$_POST["post"];
$phone=$_POST["phone"];
$email=$_POST["email"];
$lat=$_POST["lat"];
$lng=$_POST["lng"];
try{
    
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
    $constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database;Client_CSet=UTF-8;Server_CSet=UCS-2";
    
    $sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
    if ($sqlconn){
        //$query="exec dbo.proc_getDeals_4 '$catCode','$retailers',$latitude,$longitude,$range,$discount,'$sortBy'";
        //$query ="SELECT DISTINCT RetailerId,RetailerName,RImgName,RImgPath FROM dbo.vw_AllCustomers";
        $query ="EXEC dbo.proc_insertReLocCust2 @RetaiLerName='$name',@RImagePath='$filePath',@RImageFileName='$fileName',@Address1='$add',@City='$city',@ProvinceAddr='$province', @PostCode='$post',@CountryAddr='$country', @Phone1='$phone',@Email = '$email',@Lat=$lat,@Lng=$lng";//, @TypeCode=N'F01'";
    	
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
        //echo "ERROR: connection.";
        $re= -10;
        $message=  'ERROR: non-connection.';
    }
}
catch(Exception $e){
    //echo "ERROR; ".$e->getMessage();
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




