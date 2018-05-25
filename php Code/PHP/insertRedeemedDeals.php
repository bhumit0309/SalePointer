<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//header('Content-type: text/plain; charset=utf-16');

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

$server='sql7.hostek.com';
$database='BV_WBFCMS_PROTO';
$sqluser='Liao';
$sqlpwd='Liao123!';        
$constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database";

$result = array();

$sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
if ($sqlconn){
    	

    $DealId = $_GET['DealId'];
    $CustomerId = $_GET['CustomerId'];
    $UserId = $_GET['UserId'];
    $DealName = $_GET['DealName'];
    $Address = $_GET['Address'];
    $RegularPrice = $_GET['RegularPrice'];
    $DiscountPrice = $_GET['DiscountPrice'];
    $Savings = $_GET['Savings'];
   // $Date = $_GET['date'];
    $Qty = $_GET['Qty'];
    $QrCode = $_GET['QrCode'];
   // $Status = $_GET['stat'];
    
    
    $Date = date('Y-m-d H:i:s');
    $query = "INSERT INTO dbo.R02_RedeemMaster (DealId,CustomerId,UserId,DealName,Location,RegularPrice,DiscountPrice,Saving,Qty,QrCode) VALUES
   ('".$DealId."', '".$CustomerId."','".$UserId."','".$DealName."','".$Address."','".$RegularPrice."','".$DiscountPrice."','".$Savings."','".$Qty."','".$QrCode."')";

    //$query="exec dbo.proc_getDeals_5 '$catCode','$retailers',$latitude,$longitude,$range,$discount";
    //$query="exec dbo.proc_getDeals_9 '$catCode','$retailers',$latitude,$longitude,$range,$discount";
    //$query="exec dbo.proc_getDeals_11 '$catCode','$retailers',$latitude,$longitude,$range,$discount";
    // $query="exec dbo.proc_getDeals_12 '$catCode','$retailers',$latitude,$longitude,$range,$discount";
    
   // $stmt = odbc_prepare($sqlconn,$query);
   // $execute=odbc_exec($sqlconn,$query);
   
   
   $execute= odbc_exec($sqlconn, $query);
                

   
   /* check for errors */
   if (!$execute)
   {
    /* error */
    echo "Whoops"; 
    $result['salepointer'][] = array(
				'status' => 'false'
			);
    }
    else
    {
     $result['salepointer'][] = array(
				'status' => 'true'
			);
    }
    
   
    
    echo json_encode($result);
    odbc_close($sqlconn);
}
else{
    echo json_encode($result);
}
?>
