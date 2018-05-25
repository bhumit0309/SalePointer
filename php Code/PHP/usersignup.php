<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*require_once ('functionsLib.php');*/

if(isset($_GET['name']) && isset($_GET['emailid']) && isset($_GET['password']) && isset($_GET['phoneno']))
{
	$full_name = $_GET['name'];
    $user_password = $_GET['password'];
    $user_email = $_GET['emailid'];
	$user_phone = $_GET['phoneno'];
}
else
{
	echo "you must pass parameter because it's using get method";
	echo "<br> EX:"."?username=Om&password=om&emailid=sdkfjs?&phone=234234";
}


if(isset($_GET['name']) && isset($_GET['emailid']) && isset($_GET['password']) && isset($_GET['phoneno']))
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
        
             $sql = "SELECT * FROM dbo.U01_UserMaster where EmailAddress = '".$user_email."'";
             $res=odbc_exec($sqlconn,$sql);
            
             $get_data = array();
             
             while(odbc_fetch_row($res))
            { 
            
            
				$num_rows = 1;
				break;
            }
            //$num_rows = sqlsrv_num_rows($res);
            
          //  echo "ROWs".$num_rows;
          if (  $num_rows  > 0) {
        
             $get_data['salepointer'][] = array(
				'status' => 'User already registered.'
			);
        }else{
            
            
        // Input into staff database
        $query = "INSERT INTO dbo.U01_UserMaster(UserName,PassWord,EmailAddress,RegistrationDate,FirstName,PhoneNumber) VALUES ('$user_email','$user_password','$user_email','$today','$full_name','$user_phone')";
        
        //echo $query;
      //  $result = mssql_query($dbc,$query)or die('Error querying MSSQL database');

        $res_query=odbc_exec($sqlconn,$query);
       // $res = sqlsrv_query($sqlconn,$query);
        
        $get_data = array();
                
                $get_data['salepointer'][] = array(
				'status' => 'true'
                
			);
      }
        }
        else
        {  
            $get_data['salepointer'][] = array(
				'status' => 'false'
			);
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

