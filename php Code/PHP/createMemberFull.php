<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('functionsLib.php');

//Merchant email
function createConfirmationEmailForMerchant($email,$pass,$hash){
    //$file = file_get_contents("picture.jpg");
    // $myAttachment = chunk_split(base64_encode(file_get_contents( "http://www.wincoredata.com/upload/QrcodeImgs/Barcoded.jpg")));

//	$fileAttachment =	file_get_contents("http://www.wincoredata.com/upload/QrcodeImgs/Barcoded.jpg");
   $confirmUrl="http://www.wincoredata.com/PHP/memberConfirmation.php?email=".urlencode($email)."&hash=".urlencode($hash);
   $code = $_POST["Qrcode"];
   $imageName = $_POST["Qrcodefilename"];
   $fullname = ucfirst($_POST["first"])." ".ucfirst($_POST["last"]);
   /* $body="";
    $body.='<html><body>';
    $body.='<h3>Thanks for signing up!<h3><br><br>';
    $body.='<h4>Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.</h4><br><br>';
    $body.='<br><br>';
    $body.="Email: ".$email."\r\n";
    $body.='<br>';
    $body.="Password: ".$pass."\r\n";
    $body.='<br>';
    $body.="QrCode: ". $_POST["Qrcode"]."\r\n";
    $body.='<br>';
    $body.="Click on this link to activate your account \r\n";
     $body.='<br>';
    $body.=$confirmUrl;
     $body.='<br>';
    $body.='<img src="http://www.wincoredata.com/upload/QrcodeImgs/Barcoded.jpg" alt="QrCode">';
    $body.='</body></html>';*/
  $body = '  <html>
<head>
  <title>Salepointer: Sign up confirmation</title>
</head>
<body>
  <p>Dear '.$fullname.',</p>
  <p>Thanks for signing up with SalePointer! Your One-Stop Deals Management App.</p>
  <p>Your merchant account has been created.Your account will be verified in 2-3 business days. You will receive an email confirmation after verification with your account detials.</p>
<p>Let us know if there is anything we can help!</p>
<p>Best Regards,</p>
<p>SalePointer Support team</p>
<p>1-647-691-5882</p>
<p>1-800-690-5102</p>
<p>support.salepointer@brainvision.ca<br>www.SalePointer.com</p>



</body>
</html>';
    return $body;
}





//Albert email
function createConfirmationEmail($email,$pass,$hash){
    //$file = file_get_contents("picture.jpg");
    // $myAttachment = chunk_split(base64_encode(file_get_contents( "http://www.wincoredata.com/upload/QrcodeImgs/Barcoded.jpg")));

//	$fileAttachment =	file_get_contents("http://www.wincoredata.com/upload/QrcodeImgs/Barcoded.jpg");
   $confirmUrl="http://www.wincoredata.com/PHP/memberConfirmation.php?email=".urlencode($email)."&hash=".urlencode($hash);
   $code = $_POST["Qrcode"];
   $imageName = $_POST["Qrcodefilename"];
   $fullname = ucfirst($_POST["first"])." ".ucfirst($_POST["last"]);
   /* $body="";
    $body.='<html><body>';
    $body.='<h3>Thanks for signing up!<h3><br><br>';
    $body.='<h4>Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.</h4><br><br>';
    $body.='<br><br>';
    $body.="Email: ".$email."\r\n";
    $body.='<br>';
    $body.="Password: ".$pass."\r\n";
    $body.='<br>';
    $body.="QrCode: ". $_POST["Qrcode"]."\r\n";
    $body.='<br>';
    $body.="Click on this link to activate your account \r\n";
     $body.='<br>';
    $body.=$confirmUrl;
     $body.='<br>';
    $body.='<img src="http://www.wincoredata.com/upload/QrcodeImgs/Barcoded.jpg" alt="QrCode">';
    $body.='</body></html>';*/
  $body = '  <html>
<head>
  <title>Salepointer: Sign up confirmation</title>
</head>
<body>
  <p>Dear '.$fullname.',</p>
  <p>Thanks for signing up with SalePointer! Your One-Stop Deals Management App.</p>
  <p>Your merchant account has been created, please activate your account by clicking the following Url link below.</p>
  <p><a href="'.$confirmUrl.'">Activate Account</a></p>
  <p>Once you have activated your account, you can login with the following credentials:</p>
  <table>
    <tr>
     <th>Email_Id :</th><td>'.$email.'</td>
    </tr>
    <tr>
      <th>Password:</th><td>'.$pass.'</td>
    </tr>
    <tr>
      <th>QR_Code :</th><td>'.$code.'</td>
    </tr>
  </table>
  <br><a href="http://www.wincoredata.com/upload/QrcodeImgs/'.rawurlencode($imageName).'"><img src="http://www.wincoredata.com/upload/QrcodeImgs/'.rawurlencode($imageName).'" style="width:128px;height:128px;" alt="QrCode"></a><br>
  <p>With SalePointer, you are able to use the QR code for your very own promotions. You can send exclusive deals and coupons to your potential and current customers. This QR code can be scanned by SalePointers customers who like to redeem the offer from you when they are ready to cash out. You can print and stick a copy of the QR code for them to redeem at your cashier. With SalePointer, it will bring more sales to your store!</p>
<p>Let us know if there is anything we can help!</p>
<p>Best Regards,</p>
<p>SalePointer Support team</p>
<p>1-647-691-5882</p>
<p>1-800-690-5102</p>
<p>support.salepointer@brainvision.ca<br>www.SalePointer.com</p>



</body>
</html>';
    return $body;
}
$fileName="";
$filePath="";
$message="";
$re=0;
$email=$_POST["email"];
if (!validateEmail($email)){
    $re=-40;
    $message="Email is not valid!";
    $ret=(object)array("state"=>$re,"message"=>$message);
    toutf8($ret);
    echo json_encode($ret);
    exit(0);
}

if (isset($_POST["base64Img"])&& isset($_POST["fileName"])){
    $encoded_base64 = $_POST["base64Img"];
    $fileName = $_POST["fileName"];
   
    //$path="/upload/";
    $path="/upload/StoreImgs/";
    $fullPath="..".$path.$fileName;
    //echo $encoded_base64."___Okay!!!"; 
    
    $decoded_img = base64_decode($encoded_base64);
    $fh =fopen($fullPath,"wb");
    $fw=  fwrite($fh, $decoded_img);
    //$fw=fwrite($fh,"hello!!!");
    fclose($fh);
    if ($fw != false) {
        $filePath="http://".$_SERVER['HTTP_HOST'].$path;
        $message="Image was successully uploaded. \r\n";
    }else{
        $fileName="";
        $filePath="";
        $message="Failed to upload image. \r\n";
    }
}


if (isset($_POST["base64QrCode"])&& isset($_POST["Qrcodefilename"])){
    
   
    $encoded_base64_Qr = $_POST["base64QrCode"];
    $fileName_Qr = $_POST["Qrcodefilename"];
    // $fileName1 = $fileName.".jpg" 
    //$path="/upload/";
    $path_Qr="/upload/QrcodeImgs/";
    $fullPath_Qr="..".$path_Qr.$fileName_Qr;
    //echo $encoded_base64."___Okay!!!"; 
    
    $decoded_img_Qr = base64_decode($encoded_base64_Qr);
    $fh =fopen($fullPath_Qr,"wb");
    $fw=  fwrite($fh, $decoded_img_Qr);
    //$fw=fwrite($fh,"hello!!!");
    fclose($fh);
    if ($fw != false) {
        $filePath1="http://".$_SERVER['HTTP_HOST'].$path_Qr;
        $message="Image was successully uploaded. \r\n";
    }else{
        $fileName_Qr="";
        $filePath1="";
        $message="Failed to upload image. \r\n";
    }
}
$store=$_POST["store"];
$add=$_POST["add"];
$city=$_POST["city"];
$province=$_POST["province"];
$country=$_POST["country"];
$post=$_POST["post"];
$phone=$_POST["phone"];
$personalphone=$_POST["personalnumber"];
//$email=$_POST["email"];
$lat=$_POST["lat"];
$lng=$_POST["lng"];
$type=$_POST["type"];
$first=$_POST["first"];
$last=$_POST["last"];
$catCode=$_POST["cat"];
$QrCode = $_POST["Qrcode"];
$base64_QrCode_Img = $_POST["base64QrCode"];
//$fileName = $_POST["Qrcodefilename"];
//if (isset($_POST["cat"])){
//    $catCode=$_POST["cat"];
//}
//-------------------------------
if (isset($_POST["des"])){
    $des=$_POST["des"];
}else{
    $des="N/A";
}
//-------------------------------

if (isset($_POST["pass"])){
    $pass=$_POST["pass"];
}
else {
    $pass = randomString(9);
}
$hash = md5(uniqid(rand())); 

try{
    
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
        
        $query  ="EXEC dbo.proc_insertReLocCustMem  ";
        $query .="@RetaiLerName='$store'";
        //------------------------------------
        $query .=",@Description='$des'";
        //------------------------------------
        $query .=",@RImagePath='$filePath'";
        $query .=",@RImageFileName='$fileName'";
        $query .=",@RCatCode='$catCode'";
        $query .=",@Address1='$add'";
        $query .=",@City='$city'";
        $query .=",@ProvinceAddr='$province'";
        $query .=",@PostCode='$post'";
        $query .=",@CountryAddr='$country'";
        $query .=",@Phone1='$phone'";
        $query .=",@Phone2='$personalphone'";
        $query .=",@Email = '$email'";
        $query .=",@Lat=$lat ";
        $query .=",@Lng=$lng ";
        $query .=",@TypeCode='$type'";       
        $query .=",@FirstName='$first'";
	    $query .=",@LastName='$last'";
    	$query .=",@Password='$pass'";
    	$query .=",@HashCode='$hash'";
    	$query .=",@QrCode='$QrCode'";
    	
        $execute=odbc_exec($sqlconn,$query);
        if($execute){
            if (odbc_fetch_row($execute)){
                $re= odbc_result($execute, 'State');
                $message .=odbc_result($execute,'Message');
                if ($re >0){
                    $subject="Salepointer: Sign up confirmation";
                    $subject_email = "support.salepointer@brainvision.ca";
                    $body= createConfirmationEmailForMerchant($email,$pass,$hash);
                    $email_Albert = "alam905639@gmail.com";
                    $body_Albert= createConfirmationEmail($email,$pass,$hash); // This is for albert
                    $eol = "\r\n";  
                    // Define the headers for From and HTML
                    $headers = "From: " . $subject . "<" . $subject_email . ">".$eol;
                    $headers .= "MIME-Version: 1.0" . $eol;
                    $headers .= "Content-type: text/html; charset=iso-8859-1" . $eol;

                    if (mail($email,$subject,$body,$headers) && mail($email_Albert,$subject,$body_Albert,$headers) ){
                        $message .= "\r\n The confirmation email has been sent. Pleae check your mail box.";
                    }else{
                        $re=0;
                        $message.= "\r\n Can not send the confirmation email. The email could be invalid. Please contact our staff to reset your email!";
                    }
                }
            }
        }
        else{
            $re= -20;
            $message .=  'ERROR: non-execution.';
        }
        odbc_close($sqlconn);       
    }
    else{
        //echo "ERROR: connection.";
        $re= -10;
        $message .=  'ERROR: non-connection.';
    }
}
catch(Exception $e){
    //echo "ERROR; ".$e->getMessage();
     $re= -30;
     $message .=  "ERROR; ".$e->getMessage();
}
finally{
    if ($sqlconn){
         odbc_close($sqlconn);
    }
    $ret=(object)array("state"=>$re,"message"=>$message,"QrCode"=>$QrCode);
    toutf8($ret);
    echo json_encode($ret);
}



