<?php
/*
* Note here we are using $_GET method so our url is:
* http://localhost/webservices/checklogin.php?username=Om&userpasssword=om
* for test
*/

if(isset($_GET['emailid']) && isset($_GET['password']))
{

    $user_password = $_GET['password'];
    $user_email = $_GET['emailid'];
}
else
{
	echo "you must pass parameter because it's using get method";
	echo "<br> EX:"."?username=Om&password=om&emailid=sdkfjs?&phone=234234";
}


if(isset($_GET['emailid']) && isset($_GET['password']))
{
try{
        $server='sql7.hostek.com';
        $database='BV_WBFCMS_PROTO';
        $sqluser='Liao';
        $sqlpwd='Liao123!';        
        $constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database";
        $sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
        
        if ($sqlconn){
            
           // echo "Success.".$today."\n";
        
       // Check the User is already available or not.
        
             $sql = "SELECT * FROM dbo.U01_UserMaster where EmailAddress = '".$user_email."' and PassWord='".$user_password."'";
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
				'status' => 'true'
                
			);
			
        }else{
        
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