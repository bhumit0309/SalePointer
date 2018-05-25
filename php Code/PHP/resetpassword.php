<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*require_once ('functionsLib.php');*/

if(isset($_GET['oldpass']) && isset($_GET['newpass']) && isset($_GET['emailId']))
{
	$old_password = $_GET['oldpass'];
    $new_password = $_GET['newpass'];
    $emailId = $_GET['emailId'];
	
}
else
{
	echo "you must pass parameter because it's using get method";
	echo "<br> EX:"."?username=Om&password=om&emailid=sdkfjs?&phone=234234";
}


if(isset($_GET['oldpass']) && isset($_GET['newpass']) && isset($_GET['emailId']) )
{
    $re=0;
    try{
        $server='sql7.hostek.com';
        $database='BV_WBFCMS_PROTO';
        $sqluser='Liao';
        $sqlpwd='Liao123!';        
        $constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database";
        $sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
        $today = date("Y-m-d H:i:s");   
        if ($sqlconn){
            
           // echo "Success.".$today."\n";
        
       // Check the User is already available or not.
        
        
       $query_select = "Select * from dbo.U01_UserMaster where EMailAddress='$emailId' and PassWord='$old_password'";
       $execute_select=odbc_exec($sqlconn,$query_select);
       
      if(odbc_num_rows($execute_select) > 0)
      {
            // $sql = "SELECT * FROM dbo.U01_UserMaster where EmailAddress = '".$user_email."'";
             $sql = "UPDATE dbo.U01_UserMaster SET PassWord = '".$new_password."' where EMailAddress = '".$emailId."' and PassWord = '".$old_password."'";
             $res=odbc_exec($sqlconn,$sql);
            
             $get_data = array();
           
        
             $get_data['salepointer'][] = array(
				'status' => 'true'
			);
        
            
       
             
      }
        else
        {  
            $get_data['salepointer'][] = array(
				'status' => 'false'
			);
        }
    }
    }
    catch(Exception $e){
     
       
    }
    finally {
        if ($sqlconn){
            odbc_close($sqlconn);
        }
    
    } 
}




echo json_encode($get_data);



?>

