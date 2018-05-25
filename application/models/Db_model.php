<?php

Class Db_model extends CI_Model {
        public function getData($username, $password) {
$r=null;
$message="";

$server='sql7.hostek.com';
$database='BV_WBFCMS_PROTO_1';
$sqluser='Ankit';
$sqlpwd='Ankit123!';  
$constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database";
try {
    
    $sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
    if ($sqlconn){

        $query ="exec proc_getAllCustromer2"; 
		//'$email','$pass'";
        $execute=odbc_exec($sqlconn,$query);
        if ($status = odbc_fetch_object($execute)){
            $customer_id = odbc_result($execute, "RetailerName");
            print_r($customer_id);
        odbc_result_all($execute);
              $customer_id = odbc_next_result($execute, "RetailerName");
            print_r($customer_id);
//            
        }
        else
        {
            $message="ERROR: error occurred during sql execution.";
            $status=(object) array("state"=>-20,"message"=>$message);

        }

        odbc_close($sqlconn);
    }
    else{

        $message="ERROR: no database server connection.";
        $status=(object) array("state"=>-10,"message"=>$message);
    }
}
catch (Exception $e){
    $message="ERROR; ".$e->getMessage();
    $status=(object) array("state"=>-30,"message"=>$message);
    $customer_id=(object)null;
    $locations=array();
}
 finally {
    if ($sqlconn){
         odbc_close($sqlconn);
    }
//    $result->customer_id=$customer_id;
//	echo $result->custromer_id;
}
        
//return $result;
    }
}