<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('functionsLib.php');
function createEmail($pass){
    
    $body="";
    $body.="Dear Client\r\n";
    $body.="\r\n";
    $body.="As your requirment, this email is sent to help you to reset your password.\r\n";
    $body.="Your new password is shown below:\r\n";
    $body.="----------------------------\r\n";
    //$body.="Email: ".$email."\r\n";
    $body.="Password: ".$pass."\r\n";
    $body.="----------------------------\r\n";
    $body.="Please change your password immediately to avoid potential loss.\r\n";
    $body.="\r\n";
    $body.="Sincerely,\n";
    $body.="SalePointer Support Team \r\n";
    return $body;
}
$re=0;
$message="";
try{
    $email=$_GET["email"];
    $phone =$_GET["phone"];
    $newpass= randomString(9);
    //--------------------------------------------------------------------------
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
       // $query  ="EXEC proc_memberForgetPass '$email','$phone','$newpass'";
       
       $query_select = "Select * from dbo.U01_UserMaster where EMailAddress='$email' and PhoneNumber='$phone'";
       $execute_select=odbc_exec($sqlconn,$query_select);
       
      if(odbc_num_rows($execute_select) > 0)
      {
       
        $query  ="Update dbo.U01_UserMaster set PassWord= '$newpass' where EMailAddress='$email' and PhoneNumber='$phone'";
        //echo $query;
    
         $execute=odbc_exec($sqlconn,$query);
            //echo $execute;
             $get_data = array();
         if ($execute){
          
             $re = 1;
             // $message .= "The new password has been sent to you, pleae check your mail box.";
              $subject="Salepointer: reset password";
                    $body=createEmail($newpass);
                    if (sendmail($email,$subject,$body)){
                        $message .= "The new password has been sent to you, pleae check your mail box.";
                    }
         }
      }
         else
         {
             $re = 0;
             
        
                        $message .= "The email could be invalid. Please contact our staff to reset your email!";
             
         }
         /*else{
            $re= 0;
            $message .=  'ERROR: non-execution.';
         }*/
         odbc_close($sqlconn);  
    }
    else{
        $re= -1;
        $message .=  'ERROR: non-connection.';
    }
}
catch (Exception $e){
   
}
finally{
    if ($sqlconn){
         odbc_close($sqlconn);
    }
   // $ret=(object)array("state"=>$re,"message"=>$message);
     $get_data['salepointer'][] = array("state"=>$re,"message"=>$message);
    toutf8($get_data);
    echo json_encode($get_data);
}