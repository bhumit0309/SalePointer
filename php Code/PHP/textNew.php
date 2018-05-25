<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'functionsLib.php';
function createConfirmationEmail($email,$pass,$hash){
    $confirmUrl="http://www.wincoredata.com/PHP/memberConfirmation.php?email=$email&hash=$hash";
    $body="";
    $body.="Thanks for signing up!\r\n";
    $body.="Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.\r\n";
    $body.="----------------------------\r\n";
    $body.="Email: ".$email."\r\n";
    $body.="Password: ".$pass."\r\n";
    $body.="----------------------------\r\n";
    $body.="Click on this link to activate your account \r\n";
    $body.=$confirmUrl;
    return $body;
}
//require_once 'functionsLib.php';
$rad ='1234567';
echo randomString2(9);
echo "<br/>";
echo randomString(9);
echo "<br/>";
if (validateEmail ('liao@yahoo.ca')) {
    echo "true";
}else{
    echo "false";
}
echo "<br/>";
echo "test";
echo "<br/>";
echo md5(uniqid(rand()));
echo "<br/>";

$email="support.salepointer@brainvision.ca";
$subject="Salepointer: Confirmation";
$message= createConfirmationEmail($email,"test","test");
if (sendmail($email,$subject,$message)){
    echo "yes";
}else{
    echo "no";
}