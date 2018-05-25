<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header("Content-type : bitmap; charset=utf-8");
if (isset($_POST["base64Img"])){
    $encoded_base64 = $_POST["base64Img"];
    $fileName = $_POST["fileName"];
    //--------------------------------------
    //$path="../upload/DealImgs/";
    //$fullPath=$path.$fileName;
    //--------------------------------------
    $path="/upload/DealImgs/";
    $fullPath="..".$path.$fileName;
    //echo $encoded_base64."___Okay!!!"; 
    
    $decoded_img = base64_decode($encoded_base64);
    //echo"decode is okay !!"; 
    $fh =fopen($fullPath,"wb");
    $fw=  fwrite($fh, $decoded_img);
    //$fw=fwrite($fh,"hello!!!");
    fclose($fh);
    //if ($fw != false) {
    if($fw > 0) {
        //echo"UPLOAD_OKAY";
        echo "http://".$_SERVER['HTTP_HOST'].$path.$fileName;
    }else{
        echo"UPLOAD_FAILED";
    }
     
     
    
     
  
}