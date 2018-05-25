<?php
$server='sql7.hostek.com';
$database='BV_WBFCMS_PROTO_1';
$sqluser='Liao';
$sqlpwd='Liao123!';  

$constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database";
$sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);

?>