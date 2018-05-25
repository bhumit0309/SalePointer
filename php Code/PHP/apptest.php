<?php


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$server='sql7.hostek.com';
$database='BV_WBFCMS_PROTO';
$sqluser='Liao';
$sqlpwd='Liao123!';        
$constr="DRIVER={SQL Server};SERVER=$server;DATABASE=$database";
$sqlconn=odbc_connect($constr,$sqluser,$sqlpwd);
$Category =$_GET['cat'];
//echo 'Category=';
//echo $Category;
//echo '</b>';
//$conn = odbc_connect('BV_WBFCMS_PROTO', 'Tan', 'Tan123!');
//$condition = $_GET['x'];
//$discount = $_GET['y'];
//$lat = $_GET['lat'];
//$long = $_GET['long'];
//$distance = $_GET['dis'];
//$filter = $_GET['fil'];

function toutf8(&$input) {
    if (is_string($input)) {
       
        //$input=mb_convert_encoding($input, "UTF-8", "ASCII");
        $input = utf8_encode($input);
        
             
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
//if($filter == 0) {$query = "SELECT DISTINCT DealId,DealType,RetailerId,ItemName, OriginalPrice,DiscountPrice,Percentage,Units,Description,Exclusive,Quantity,ImagePath,ImageFileName,ExpiryDate,D.CatCode,C.Lineage FROM (vw_DealRetLocs D INNER JOIN (SELECT LocationId FROM fn_SearchStoresInRadius($lat,$long,$distance)) L ON D.LocationId=L.LocationId) INNER JOIN C01_CategoryMaster C ON D.CatCode=C.CatCode $condition AND Active='True' AND Percentage >= $discount ORDER BY C.Lineage ASC";}
//if($filter == 1) {$query = "SELECT CatName, CatCode FROM fn_DealsCategories($discount) WHERE Depth = 1 $condition";}
//if($filter == 2) {$query = "SELECT CatName, CatCode FROM fn_DealsCategories($discount) WHERE Depth = 2 $condition";}
//if($filter == 3) {$query = "SELECT L.CatName, L.CatCode, C.CatName as PName FROM (SELECT * FROM fn_DealsCategories($discount) WHERE Depth = 3 $condition) L LEFT JOIN C01_CategoryMaster C ON L.ParentCode=C.CatCode";}
//if($filter == 4) {$query = "SELECT DISTINCT RetailerId,RetailerName FROM R01_RetailerMaster WHERE RetailerId IN (SELECT RetailerId FROM vw_DealRetLocs D INNER JOIN C01_CategoryMaster C ON D.CatCode=C.CatCode $condition AND Percentage >= $discount AND Active='True' AND LocationId IN (SELECT LocationId FROM fn_SearchStoresInRadius($lat,$long,$distance)))";}
//if($filter == 5) {$query = "SELECT Address1,PostCode FROM fn_SearchStoresInRadius($lat,$long,200) L WHERE L.LocationId IN (SELECT D.LocationId FROM vw_DealRetLocs D WHERE DealId=$discount)";}
//$execute = odbc_exec($conn, $query);
//$result = array();

$query="exec dbo.proc_searchWiFiInRadius '$Category'";
$execute=odbc_exec($sqlconn,$query);
$result = array();

while ($r = odbc_fetch_object($execute))
{
    toutf8($r);	
    $result[] = $r;
}

echo json_encode($result);
?>