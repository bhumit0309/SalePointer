<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div>
            <h2>Confirmation</h2>
        </div>
        <br/>
        <div>
            <?php
                $email='';
                $hash='';
                $message='';
                if (isset($_GET['email']) &&  !empty($_GET['email'])){
                    $email=$_GET['email'];
                }else {
                    echo 'Invalid approach, please use the link that has been send to your email.';
                    exit(0);
                }
                if (isset($_GET['hash']) &&  !empty($_GET['hash'])){
                    $hash=$_GET['hash'];
                }else {
                    echo 'Invalid approach, please use the link that has been send to your email.';
                    exit(0);
                }
                
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
                            
                            $query ="EXEC proc_memberConfirmation '$email','$hash'";

                            $execute=odbc_exec($sqlconn,$query);
                            if($execute){
                                if (odbc_fetch_row($execute)){
                                    $re= odbc_result($execute, 'State');
                                    $message=odbc_result($execute,'Message');
                                }else{
                                    $message=  'ERROR 3: An error occured during confrimation. Please contact our staff.';
                                }
                            }
                            else{
                                $message=  'ERROR 2: An error occured during confrimation. Please try again!';
                            }
                            odbc_close($sqlconn);       
                        }
                        else{
                            
                            $message=  'ERROR 1: Can not connect to database. Please try again!.';
                        }
                    }
                    catch(Exception $e){
                        //echo "ERROR; ".$e->getMessage();
                         //$re= -2;
                         $message=  "ERROR 4; ".$e->getMessage();
                    }
                    finally{
                        if ($sqlconn){
                             odbc_close($sqlconn);
                        }
                        echo $message; 
                    }
             ?>
        </div>
    </body>
</html>




