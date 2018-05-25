<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'functionsLib.php';

//echo uniqid('IMG_',false).'.jpg';
$re=0;
$message="";
$l= new stdClass();
$locations = array();
$ret1 = new stdClass();

$server='sql7.hostek.com';
$database='BV_WBFCMS_PROTO';
$sqluser='Liao';
$sqlpwd='Liao123!';   
 
$constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database";
try{
    
    $ucode = $_POST["ucode"];
    $lid =$_POST["lid"];
    $add=$_POST["add"];
    $city=$_POST["city"];
    $prov=$_POST["prov"];
    $post=$_POST["post"];
    $country=$_POST["country"];
    $phone=$_POST["phone"];
    $contp=$_POST["contp"];
    $info=$_POST["info"];
    $lat=$_POST["lat"];
    $lng=$_POST["lng"];
    
    //@UCODE NCHAR(36),
    //@LID BIGINT,
	//@Address NVARCHAR(150),
	//@City NVARCHAR(50),
	//@Prov NVARCHAR(3),
	//@PostCode NVARCHAR(10),
	//@Country NVARCHAR(3),
	//@Phone NVARCHAR(15),
	//@ContPerson NVARCHAR(100),
	//@Info NVARCHAR(4000),
	//@Lat float,
	//@Lng float	
    
    $query ="EXEC proc_memberUpdateOneLocation2 '$ucode',$lid,'$add','$city','$prov','$post','$country','$phone','$contp','$info',$lat,$lng";
    $sqlconn=  odbc_connect($constr, $sqluser, $sqlpwd);
    if ($sqlconn){
        $result = odbc_exec($sqlconn, $query);
        if ($result){
            $r= odbc_fetch_object($result);
            if ($r){
                $re=$r->state;
                $message=$r->message;           
                if (odbc_next_result($result)){
                    while($l=  odbc_fetch_object($result)){
                        $locations[]=$l;
                    }
                }else{
                    $message .= " Please re log in!";
                }
            }else{
                $re= -20;
                $message=  'ERROR: no response from the database!.';
            }
        }else{
            $re=-40;
            $message=  'ERROR: non-execution.';
        }
        odbc_close($sqlconn);
    }else{
        $re= -10;
        $message=  'ERROR: non-connection.';
    }
}
catch(Exception $e){
     $re= -30;
     $message=  "ERROR; ".$e->getMessage();
}
finally{
     if ($sqlconn){
        odbc_close($sqlconn);
    }
    $ret=(object)array("state"=>$re,"message"=>$message);
    $ret1->status=$ret;
    $ret1->locations=$locations;
    toutf8($ret1);
    echo json_encode($ret1);
}
    
