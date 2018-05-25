<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'functionsLib.php';
try{
/*
$result=false;
$fh=null;
//$re=  odbc_fetch_object($result);
//echo $re;
echo $_SERVER["HTTP_HOST"];
echo '<br/>';
echo  $_SERVER["DOCUMENT_ROOT"];
echo '<br/>';
if (is_resource($fh)){
    echo 'yes';
}else{
    echo 'no';
}
echo '<br/>';
 
 */
/*------------------ test empty function ----------------*/
/*
$s='a';
$s2=trim($s);
if (empty(trim($s))){
//if (trim($s) == null){
    echo 'empty';
}else{
    echo "not empty";
}
*/
    /*-------------------------------------------------------------------------*/
    //$newEmail='oronperetz1@gmail.com';
    $newEmail=$_POST["newemail"];
    if (!validateEmail($newEmail)){
    $re=-40;
    $message="Email is not valid!";
    $ret=(object)array("state"=>$re,"message"=>$message);
    toutf8($ret);
    echo json_encode($ret);
    exit(0);
}
    
    
    if (validateEmail ($newEmail)){
        echo "yes";
    }
    else {
        echo "no";
    }
    
/*-------------------------------------------------------*/
    $clientIdLive="AQMY5p8Dxn9YhuRPqQTJcjeMeJE2qrsbXztX-XGackrtWF74Npz2aU9a0gTh3X2wn4FaFcTpIwC5UMcv";
    $secretLive="ELi_I5a5MNiJuug15WcBYBQD2jm-AhkGQnvDB7L397MFm9abD5bfmi5bcXSp4USd9giGto35AdO6azYO";
    $paymentIdLive="PAY-6PW7001961773384HLBWGGCQ";
/*-------------------------------------------------------*/
    /*
    $clientId="AU164pDYRmC8p3yuOX_F66KSfwBQOE-7abVczj9gPO2j3pM2EUCmZ_uhwyIsVJBGIKLZ0h8sUUz0yfmU";
    $secret="EMR9s3POv2aQ29-21rwLWYtsZMWL7PfIgoH7kzGe-zra1uClcQL808F_GYIInk6r7rMNH-4xskJ7s-sl";
    $body="grant_type=client_credentials";
    ////$t=getPaymentToken ($clientIdLive,$secretLive);
    $t=getPaymentToken ();
    //$t=(object)null;
    if ($t != null){
        echo $t;
        //echo "okey";
    }else{
        echo 'null';
    }
    echo '<br/>';
    $paymentId="PAY-6FX06640PE656162LLBM2IHI";
    //$token='A101.Yr1qTgqVkrsZ-pKxU7wLctb92K07i-ifOGcz4JDToNndYKqTXGnjrNIBMYQvZK4p.jy6T4YB2QDIeZ0tQzzRiGUgFPCO';
    
    //$r=verifyPayment ($paymentIdLive,$t);
    $r=verifyPayment ($paymentIdLive);
     if ($r != null){
        //echo $r;
        var_export($r);
    }else{
        echo 'null';
    }
   */ 
/*-------------- curl test ---------------*/
    /*
    $payment_id="PAY-6FX06640PE656162LLBM2IHI";
    $access_token="A101.yM99jtYNOVYgjiAOdfannStV471JfWvof1KGu9bWNCTlPtW3Ylwx6-bbhEAy-rFn.QFCJoxU2L0HVjwSsNOpH9PbUs4O";
    $header = array();
    //$header[]="Accept: application/json";
    $header[]="Content-Type: application/json "; ////application/x-www-form-urlencoded
    $header[]="Authorization: Bearer $access_token";
    //echo $header[1];
    //echo "<br/>";
    //test
    //$url="http://www.wincoredata.com/PHP/getAllCustomers.php";
    //look_up payment
    $url="https://api.sandbox.paypal.com/v1/payments/payment/$payment_id";
    //token
    //$url="https://api.sandbox.paypal.com/v1/oauth2/token";
    //echo $url;
    ///*
    //$curl=  curl_init($url);
    $curl=  curl_init();
    //echo $curl;
    //
    curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
    curl_setopt($curl,CURLOPT_URL,$url);  
    //curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    //------------------------------------------------------
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSLVERSION, 6);
    curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST, 'SSLv3');
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //------------------------------------------------------
    //auth
    //curl_setopt($ch, CURLOPT_USERPWD, "$clientId:$secret");
    //post
    //curl_setopt($handle, CURLOPT_POST, true);
    //curl_setopt($handle, CURLOPT_POSTFIELDS, $body);
    
    $curl_response=  curl_exec($curl);
    $info=curl_getinfo($curl);
    if ($curl_response === false){
        $info=curl_getinfo($curl); // array ["http_code"]==200-> okay
        //curl_close($curl);
        echo "false";
        echo $info["http_code"];
        echo "<br/>";
        var_export($info);
    }else{
        //echo $curl_response;
        //$info=curl_getinfo($curl);
        echo $info["http_code"];
        if ($info["http_code"]==401){
            echo"code is 401";
        }
        echo "<br/>";
        var_export($info);
        $json = json_decode($curl_response);
        echo "<br/>";
        var_export($json);
        //echo $json[1]->CustomerId;
    }
    //if (is_resource($curl)){
    //    curl_close($curl);
    //}
    curl_close($curl);
    //*/
    
/*----------------------------------------*/
}
catch(Exception $e){
    echo $e->getMessage();
}
