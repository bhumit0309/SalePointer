<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ('functionsLib.php');
$to='liao_xinqing@yahoo.ca';
$subject='Invoice';
$body="<html>
    <head>
        <!--
        <title>TODO supply a title</title>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        -->
        <style type='text/css'>
            .title {
                text-align:center;
                font-weight: bold;
                font-size: 15px;
                color:white;
                background-color: cornflowerblue;
                //border-bottom: 1px solid black;
            }
            .itemtitle{
                text-align:left;
                font-weight:bold;
            }
            .item{
                padding:10px;
            }
            .bb td {
                border-bottom: 1px dashed black;
            }
        </style>
    </head>
    <body>
        <div>
            <p>
                Dear Client,
            </p>
            <br/>
            <p>
                This is your Invoice for your recent plan.
            </p>
        </div>
        <br/>
        <table border='0'>
            <tr>
                <td colspan='2' class='title'>Invoice</td>
            </tr>
            <tr>
                <td class='itemtitle'>Invoice Date</td>
                <td class='item'>2017-02-01</td>
            <tr/>
            <tr>
                <td class='itemtitle'>Subscription Period</td>
                <td class='item'>2071-02-01/2017-03-01</td>
            </tr>
            <tr class='bb'>
                <td class='itemtitle'>Due Date</td>
                <td class='item'>2017-02-15</td>
            </tr>
            <tr>
                <td class='itemtitle'>Price</td>
                <td class='item'>CAD 30</td>
            </tr>
            <!--
            <tr>
                <td class='itemtitle'>Discount</td>
                <td class='item'>CAD -15</td>
            </tr>
            -->
            <tr class='bb'>
                <td class='itemtitle'>Carried Balance</td>
                <td class='item'>CAD 0</td>
            </tr>
            <tr>
                <td class='itemtitle'>SubTotal</td>
                <td class='item'>CAD 15</td>
            </tr>
            <tr class='bb'>
                <td class='itemtitle'>Tax (HST)</td>
                <td class='item'>CAD 0.15</td>
            </tr>
            <tr>
                <td class='itemtitle'>Total</td>
                <td class='item'>CAD 15.15</td>
            </tr>
        </table>
        <br/>
        <div>
            <p>
                Thank you for choosing our service!
            </p>
            <br/>
            <p>
                Yours sincerely,
                <br/>
                SalePointer
            </p>
        </div>
    </body>
</html>";
if (sendhtmlmail($to, $subject, $body)){
    echo 'yes';
}else{
    echo 'no';
}


