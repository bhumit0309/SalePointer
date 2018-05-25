<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'functionsLib.php';

$server='sql7.hostek.com';
$database='BV_WBFCMS_PROTO';
$sqluser='Liao';
$sqlpwd='Liao123!';   
 
$constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database";
try {
    ////$cid = $_POST["customerid"];
    ////$token = $_POST["token"];
    $iid = $_POST["invid"];
    $pidlive = $_POST["payid"];
    //$pidlive="PAY-6PW7001961773384HLBWGGCQ";
    
    $reftype="payment_id";
    $ref=$pidlive;
    
    $isapprove=false;
    $method="n/a";
    $amount=0;
    $currency="n/a";
    $createtime="null";
    $updatetime="null";
    
    $re=0;
    $m="";
    $message="";
    //$payInfo = verifyPayment ($pid,$token);
    $payInfo =verifyPayment ($pidlive);
    if ($payInfo != null){
        if ($payInfo->state == "approved"){
            $isapprove=true;
            //echo $payInfo->state;
            //echo "<br/>";
            $method=$payInfo->payer->payment_method;
            $amount=$payInfo->transactions[0]->amount->total;
            $currency=$payInfo->transactions[0]->amount->currency;
            $createtime=$payInfo->transactions[0]->related_resources[0]->sale->create_time;
            $updatetime=$payInfo->transactions[0]->related_resources[0]->sale->update_time;
        }
        else {
            $re= -200;
            $m=  'The payment is not approved by paypal ';
        }
        /*
         echo $method;     echo "<br/>";
         echo $amount;     echo "<br/>";
         echo $currency;   echo "<br/>";
         echo $createtime; echo "<br/>";
         echo  $updatetime;echo "<br/>";
        //echo $payInfo;
        //toutf8($payInfo);
        //echo json_encode($payInfo);
         */
    }
    else{
        $re= -100;
        $m=  'Did not get response from paypal,re try verification! ';
    }
    /*------------------------------------------------------------------------*/  
    $query ="EXEC proc_payInvoice $iid,'$method',$amount,'$currency','$reftype','$ref',$isapprove,'$createtime','$updatetime'";
    $sqlconn=  odbc_connect($constr, $sqluser, $sqlpwd);
    if ($sqlconn){
        $result = odbc_exec($sqlconn, $query);
        if ($result){
            $r= odbc_fetch_object($result);
            if ($r){
                $re=$r->state;
                $message=$r->message;  
                if (!empty($m)){
                    $message=$message."\n".$m;
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
catch (Exception $exc) {
    //echo $exc->getTraceAsString();
     $re= -30;
     $message=  "ERROR; ".$exc->getMessage();
} 
finally {
     //if ($sqlconn){
    if (is_resource($sqlconn)){
        odbc_close($sqlconn);
    }
    $ret=(object)array("state"=>$re,"message"=>$message);
    toutf8($ret);
    echo json_encode($ret);
}


