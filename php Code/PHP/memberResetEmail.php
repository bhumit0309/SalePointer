<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('functionsLib.php');
function createEmail($email,$hash){
    $confirmUrl="http://www.wincoredata.com/PHP/memberConfirmation.php?email=".urlencode($email)."&hash=".urlencode($hash);
    $body="";
    $body.="Your email has been updated !\r\n";
    $body.="Since your email was changed, to confirm the validity of the new email address please re-activate your account by pressing the url below.\r\n";
    $body.="Here is your new email: \r\n";
    $body.="----------------------------\r\n";
    $body.="Email: ".$email."\r\n";
    //$body.="Password: ".$pass."\r\n";
    $body.="----------------------------\r\n";
    $body.="Click on this link to re-activate your account \r\n";
    $body.=$confirmUrl;
    return $body;
}
$oldEmail=$_POST["oldemail"];
$newEmail=$_POST["newemail"];
$pass = $_POST["pass"];
$re=0;
$message="";
if (!validateEmail($newEmail)){
    $re=-40;
    $message="Email is not valid!";
    $ret=(object)array("state"=>$re,"message"=>$message);
    toutf8($ret);
    echo json_encode($ret);
    exit(0);
}
$hash=md5(uniqid(rand()));
try {
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
    
    $sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
    if ($sqlconn){
         $query  ="EXEC dbo.proc_memberResetEmail '$oldEmail','$newEmail','$pass','$hash'";
         $execute=odbc_exec($sqlconn,$query);
         if ($execute){
             if (odbc_fetch_row($execute)){
                $re= odbc_result($execute, 'State');
                $message .=odbc_result($execute,'Message');
                if ($re>0){
                    $subject="Salepointer: email change confirmation";
                    $body=createEmail($newEmail,$hash);
                    if (sendmail($newEmail,$subject,$body)){
                        $message .= "\r\n Since the email address has been changed, we need to validate the new email address. Pleae check the confirmation email in your mail box.";
                    }else{
                        $re=0;
                        $message .= "\r\n Can not send the confirmation email. The email could be invalid. Please contact our staff to reset your email!";
                        //------------------------------------------------------
                        $email="support.salepointer@brainvision.ca";
                        $subject="Salepointer: email change notefication-back up";
                        sendmail($email,$subject,$body);
                        //------------------------------------------------------
                    }
                }
             }
             else{
                 $re=-50;
                 $message="ERROR: error occurred during getting execution results!";
             }
         }
         else{
            $re= -20;
            $message .=  'ERROR: non-execution.';
         }
         odbc_close($sqlconn);  
    }
    else{
        $re= -10;
        $message .=  'ERROR: non-connection.';
    }
}
catch (Exception $e){
    $re= -30;
    $message .=  "ERROR; ".$e->getMessage();
}
finally {
    if ($sqlconn){
         odbc_close($sqlconn);
    }
    $ret=(object)array("state"=>$re,"message"=>$message);
    toutf8($ret);
    echo json_encode($ret);
}
