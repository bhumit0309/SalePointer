<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require('class.phpmailer.php');
require('class.smtp.php');

function toutf8(&$input) {
    if (is_string($input)) {
       
        //$input=mb_convert_encoding($input, "UTF-8", "ASCII");
        if (!json_encode($input)){
            $input = utf8_encode($input);
        }
             
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

function randomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ&_?!';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function randomString2($len){
    $result = "";
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz&_?!0123456789";
    $charArray = str_split($chars);
    for($i = 0; $i < $len; $i++){
	    $randItem = array_rand($charArray);
	    $result .= "".$charArray[$randItem];
    }
    return $result;
}

function validateEmail ($email){
    if (filter_var($email,FILTER_VALIDATE_EMAIL)){
        list($userName, $mailDomain) = split("@", $email); 
        if (checkdnsrr($mailDomain, "MX")) { 
            return true;
        } 
        
    } 
    return false;
}

function sendmail($to,$subject,$message){
                  $mail = new PHPMailer();
                  $mail->IsSMTP();
                  $mail->SMTPAuth = true;
                  $mail->Host = "mail17.hostek.com";
                  $mail->Port = 465;
                  $mail->Username = "support.salepointer@brainvision.ca";
                  $mail->Password = "John3:16";
                  $mail->SMTPSecure = 'ssl';
                  $mail->SetFrom('support.salepointer@brainvision.ca', 'SalePointer Support Team');
                  $mail->Subject = $subject;
                  $mail->Body = $message;
                  $mail->AddAddress($to);
             if(!$mail->Send()) {
              return false;
            } else {
              return true;
            }       
}
function sendhtmlmail($to,$subject,$message){
                  $mail = new PHPMailer();
                  $mail->IsSMTP();
                  $mail->SMTPAuth = true;
                  $mail->Host = "mail17.hostek.com";
                  $mail->Port = 465;
                  $mail->Username = "support.salepointer@brainvision.ca";
                  $mail->Password = "John3:16";
                  $mail->SMTPSecure = 'ssl';
                  $mail->SetFrom('support.salepointer@brainvision.ca', 'SalePointer Support Team');
                  $mail->Subject = $subject;
                  $mail->Body = $message;
                  $mail->isHTML(true);
                  $mail->AddAddress($to);
             if(!$mail->Send()) {
              return false;
            } else {
              return true;
            }       
}


function deletefile ($httppath){
    $re = null;
    $count=0;
    try{
        $fh=fopen("../upload/imagedeletelog.txt","a");
        $truepath=  str_replace("http://".$_SERVER["HTTP_HOST"], $_SERVER["DOCUMENT_ROOT"], $httppath, $count);
        if ($count >0 && file_exists($truepath)){
            if (unlink($truepath)){
                $t=date("Y-m-d H:i:s",time());
                $m=$t."  successfully delete file ".$httppath."\n";
                if($fh){
                     $fw=fwrite($fh, $m);    
                }                         
                $re=true;
            }else{
                $t=date("Y-m-d H:i:s",time());
                $m=$t."  failed to delete file 1: ".$httppath."\n";
                if($fh){
                    $fw=fwrite($fh, $m);
                }
                $re=false;
            }
        }else{
             $t=date("Y-m-d H:i:s",time());
             $m=$t."  failed to delete file 2: ".$httppath."\n";
             if($fh){
                $fw=fwrite($fh, $m);
             }
             $re=false;
        }
    }
    catch (Exception $e){     
        $t=date("Y-m-d H:i:s",time());
        $m=$t."  failed to delete file 3: ".$httppath."\n";
        $m .= $t." php exception: ".$e->getMessage()."\n";
        if ($fh){
            $fw=fwrite($fh, $m);
        }
        $re=false;
    }
    finally{
        if ($fh){
            try { fclose($fh); }
            catch (Exception $e) {return false;}
        }
        return $re;
    }
}
function saveImage ($fullpath,$base64Img){
    $re=false;
    $fh= null;
    try{
        $decoded_img = base64_decode($base64Img);
        $fh = fopen($fullpath,"wb");
            if ($fh){
                $fw = fwrite($fh, $decoded_img);
                fclose($fh);
                if ($fw > 0) {
                    $re = true;
                }else{
                    $re = false;
                }
            }else{
                $re = false;
            }
    }
    catch(Exception $e){
        $re = false;
    }
    finally{
      if (is_resource($fh)){
           try {fclose($fh); }
           catch (Exception $e) { return false; }
       } 
       return $re; 
    }
}
function resetImage ($httppath, $base64Img) {
    $re = false; 
    $fh = null;
    try{
        $decoded_img = base64_decode($base64Img);
        $truepath=  str_replace("http://".$_SERVER["HTTP_HOST"], $_SERVER["DOCUMENT_ROOT"], $httppath, $count);
        //$decoded_img = base64_decode($encoded_base64);
        if ($count>0 && file_exists($truepath)){
            $fh = fopen($truepath,"wb");
            if ($fh){
                $fw = fwrite($fh, $decoded_img);
                //fclose($fh);
                if ($fw > 0) {
                    $re = true;
                }else{
                    $re = false;
                }
            }else{
                $re = false;
            }
        }
        else {
            $re = false;
        }
    }
    catch (Exception $e){
        $re = false;
    }
    finally {
       if (is_resource($fh)){
           try {fclose($fh); }
           catch (Exception $e) { return false; }
       } 
       return $re; 
    }
}

function get_client_ip() {
    //$ipaddress = '';
    try {
         $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
            //$ipaddress = '';
        return $ipaddress;
    }
    catch (Exception $e) {
        return null;
    }
}

function callToken(){
    try{    //Live endpoint
            $clientId="AQMY5p8Dxn9YhuRPqQTJcjeMeJE2qrsbXztX-XGackrtWF74Npz2aU9a0gTh3X2wn4FaFcTpIwC5UMcv";
            $secret="ELi_I5a5MNiJuug15WcBYBQD2jm-AhkGQnvDB7L397MFm9abD5bfmi5bcXSp4USd9giGto35AdO6azYO";
            $apihttp="https://api.paypal.com/v1/oauth2/token";
            
            $ch = curl_init();
            //curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
            curl_setopt($ch, CURLOPT_URL, $apihttp);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
            curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

            $result = curl_exec($ch);
            $info = curl_getinfo($ch);
            $code=$info["http_code"];

            curl_close($ch);

            if($code != 200 || empty($result)){
              //return null;
                $token = null;
            } //die("Error: No response.");
            else
            {
                $json = json_decode($result);
                //print_r($json->access_token);
                //var_export($json);
                //return $json->access_token;
                $token = $json->access_token;
            }
            //curl_close($ch);
           
    }
    catch(Exception $e){
        $code=0;
        $token=null;
    }
    finally{
        if (is_resource($ch)){
            curl_close($ch);
        }
        $re= new stdClass();
        $re->code = $code;
        $re->token = $token;
        return $re;
    }
}

function getPaymentToken (){
    $i = 0;
    $max = 5;
    $re = null;
    $code = 0;
    do {
        $re=callToken();
        $code = $re->code;
        $i=$i+1;
    }while ($code != 200 && $i<$max);
    return $re->token;
}

function lookupPayment ($paymentId,$token){
    
    $header = array();
    $header[]="Content-Type: application/json";
    $header[]="Authorization: Bearer $token";
    
    ////$url="http://www.wincoredata.com/PHP/getAllCustomers.php ";
    //$url="https://api.sandbox.paypal.com/v1/payments/payment/$paymentId";
    $url="https://api.paypal.com/v1/payments/payment/$paymentId";
    try{
        //$curl=  curl_init($url);
        $curl=  curl_init();
        curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
        curl_setopt($curl,CURLOPT_URL,$url);  
        //----------------------------------------
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSLVERSION, 6);
        curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST, 'SSLv3');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        //------------------------------------------
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    
        $curl_response=  curl_exec($curl);
        $info=curl_getinfo($curl);
        $code = $info["http_code"];
        curl_close($curl);
        if ($code !=200 || $curl_response === false){
           $details = (object)null; 
        }else{
           $json = $curl_response;
           $details = json_decode($json);
        }
        //echo "<br/>";
        //echo "http_code is : ";
        //echo $info["http_code"];
        //echo "<br/>";
        /*
        if ($info["http_code"]==401){
            echo 're_call the token!';
        }else{
            echo $info["http_code"];
        }
        
        if ($curl_response === false){
            //$info=curl_getinfo($curl); // array ["http_code"]==200-> okay
            //curl_close($curl);
            //var_export($info);
            $r=null;
        }else{
            $json = $curl_response;
            $r = json_decode($json);
        } 
        */     
        //curl_close($curl);
    }
    catch(Exception $e){
        $code = 0;
        $details = (object)null; 
    }
    finally {
        if (is_resource($curl)){
            curl_close($curl);
        }
        $r= new stdClass();
        $r->code = $code;
        $r->details = $details;
        return $r;
    }
   
}

function verifyPayment ($paymentId){
    $i=0;
    $max=5;
    $code = 0;
    $token = getPaymentToken ();  
    do{
        if ($code == 401 || $token==null){
            $token = getPaymentToken ();
        }
        if ($token !=null){
            $response = lookupPayment($paymentId, $token);
            $code =$response->code;
            if ($code==200){
                $details =$response->details;
            }else{
                $details=(object)null;
            }
        }else{
            $code=0;
            $details=(object)null;
        }     
        $i=$i+1;
    }while($code !=200 && $i<$max);
    return $details;
}

