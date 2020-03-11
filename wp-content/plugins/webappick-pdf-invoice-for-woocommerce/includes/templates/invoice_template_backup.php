<?php

$html=<<<HEAD
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>

        @page{
            margin: 20px;
        }

        body{
            font-family: "raleway";
            font-size: 12px;
            background: #EAE8E9;
            min-height: 100%;
        }


        .pageBreak {
            page: teacher;
            page-break-after: always;
        }

        .invoice-box {
            position: relative;
            max-width: 800px;
            margin:0 auto;
            padding: 20px;
            height: 100%;
            border: 2px solid;
            color: #555;
        }
        .invoice-box .row-logo{
            margin-bottom: 20px;
        }
        .invoice-box .row-logo .logo-text{

            float: right;
            text-transform: uppercase;
            overflow: auto;
            width: 30%;
        }

        .row-head .to{width: 32%;float:left;overflow: auto}
        .row-head .form{width: 32%; float: left;margin-top: 44px;
            margin-left: 32px;overflow: auto
        }
        .row-head .date{
            width: 30%;
            float: right;
            overflow: auto;
            margin-top: 65px;}

        .row-head{

            display: block;
            width: 100%;
            margin: 50px 0;
            padding-bottom: 15px;
            overflow: auto;

        }

        .invoice-box table {
            width: 100%;
            text-align: left;
        }
        .invoice-box table tr td{
            border-bottom: 1px solid #DCDADB;
            padding: 10px 0;
        }

        .invoice-box table td {
            vertical-align: top;
        }
        .invoice-box table{
            /*border-bottom: 2px solid;*/
        }
        .invoice-box table td.quantity {
            padding-left: 20px;
        }

        .invoice-box table tr.top{
            padding-bottom: 20px;
            width: 100%;
        }

        .invoice-box table tr.top table td.logo-text {
            /*line-height: 45px;*/
            text-align: right;
            text-transform: uppercase;
            font-weight: 700;
        }
        .invoice-box table tr.information {
            /*line-height: 45px;*/
            width: 100%;
            margin-bottom: 20px;
            border:none;
        }
        .invoice-box table tr.information-one {
            /*line-height: 45px;*/
            width: 100%;
            margin-bottom: 20px;
        }
        .invoice-box table tr.information-one td {
            /*line-height: 45px;*/
            width: 20%;
        }
        .invoice-box table tr.information-one td h4 {
            /*line-height: 45px;*/
            margin-bottom: 10px;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }



    </style>

</head>

<body>
HEAD;


# Calculate Page Break
$tOrder=count($orders);
$or=1;
$pageBreak="pageBreak";
//echo "<pre>";
//print_r($orders);
foreach ($orders as $order_id=>$order){

    # Process Page Break
    if($tOrder==$or){
        $pageBreak="";
    }
    $or++;

    $body=<<<HEADER
    
    <div class='invoice-box $pageBreak'>

    <table border="0" width="100%" style="margin-top: 0px;margin-bottom: 10px;">
        <tbody>
        <tr style="height: 400px;">
            <td style="width: 50%; border-bottom: 0px">
                <img src="{{LOGO}}" alt="" width="200" height="100">
            </td>
            <td  style="text-align: right;width: 50%;padding-right: 50px;font-weight: 700;text-transform: uppercase;font-size: 30px;border-bottom: 0px"><b>Invoice.</b></td>
        </tr>
        </tbody>
    </table>

    <table border="0" width="100%" style="margin-top: 0px;margin-bottom: 10px">
        <tbody>
        <tr style="height: 50px;">
            <td style="width: 40%;border-bottom: 0px">
                {{TO_$order_id}}
            </td>
            <td style="width: 40%;border-bottom: 0px;">
                {{FROM}}
            </td>
        </tr>
        </tbody>
    </table>
    <table border="0" width="100%" style="margin-top: 0px;margin-bottom: 10px">
        <tbody>
        <tr>
            <td style="width: 20%;border-bottom: 0px"></td>

            <td style="width: 20%;border-bottom: 0px;text-align: center">
                <h4 style="margin-bottom:0px;font-size: 13px;">{{INVOICE_NUMBER_TEXT}}</h4>
                {{INVOICE_NUMBER_$order_id}}
            </td>
            <td style="width: 20%;border-bottom: 0px;text-align: center">
                <h4 style="margin-bottom:0px;font-size: 13px;">{{INVOICE_DATE_TEXT}}</h4>
                {{INVOICE_DATE_$order_id}}
            </td>
            <td style="width: 20%;border-bottom: 0px;text-align: center">
                <h4 style="margin-bottom:0px;font-size: 13px;" >{{ORDER_NUMBER_TEXT}}</h4>
                {{ORDER_NUMBER_$order_id}}
            </td>

            <td style="width: 20%;border-bottom: 0px;text-align: center">
                <h4 style="margin-bottom:0px;font-size: 13px;">{{ORDER_DATE_TEXT}}</h4>
                {{ORDER_DATE_$order_id}}
            </td>
        </tr>
        </tbody>
    </table>
    <table cellpadding="0" cellspacing="0" style="border-top: 2px solid; border-bottom:2px solid">

        <tr style="height:50px">
            <td width="10%" style="font-size: 13px;text-transform: uppercase"><b>{{SL}}</b></td>
            <td width="40%" style="font-size: 13px;text-transform: uppercase;"><b>{{PRODUCT}}</b></td>
            <td width="20%" style="font-size: 13px;text-transform: uppercase"><b>{{PRICE}}</b></td>
            <td width="10%" style="font-size: 13px;text-transform: uppercase"><b>{{QUANTITY}}</b></td>
            <td width="20%" style="font-size: 13px;text-transform: uppercase;text-align: right;padding-right: 20px;"><b>{{ROW_TOTAL}}</b></td>
        </tr>

HEADER;

    # Display Product Information
    if(isset($order['wpifw_products'])){
        $p=0;
        foreach ($order['wpifw_products'] as $key=>$value){
            if($p==3){
                break;
            }
            $id=$value['product_id'];

            $body.=<<<POD
                <tr style="height:50px">
                    <td class="td-height">{{P_SL_$id}}</td>
                    <td class="td-height">{{P_DESCRIPTION_$id}}</td>
                    <td class="td-height">{{P_PRICE_$id}}</td>
                    <td class="quantity td-height">{{P_QUANTITY_$id}}</td>
                    <td class="td-height" style="text-align: right; padding-right: 20px;">{{P_TOTAL_$id}}</td>
                 </tr>
POD;

        }
    }



    # Display Total Information
    $body.=<<<FOOTER
        <tr style="height:50px">
            <td colspan="4" class="sum-total td-height" style="text-align: right;font-style: normal;font-weight: bold;">{{SUBTOTAL_TEXT}}</td>
            <td class="total-fig td-height" style="text-align: right;padding-right: 20px;">{{SUBTOTAL_$order_id}}</td>

        </tr>
        <tr style="height:50px">
            <td colspan="4"  class="tax td-height" style="text-align: right;font-style: normal;font-weight: bold;">{{TAX_TEXT}}</td>
            <td class="tax-fig td-height" style="text-align: right;padding-right: 20px;">{{TAX_$order_id}}</td>
        </tr>
        <tr style="height:50px">
            <td colspan="4"  class="tax td-height" style="text-align: right;font-style: normal;font-weight: bold;">{{DISCOUNT_TEXT}}</td>
            <td class="tax-fig td-height" style="text-align: right;padding-right: 20px;">{{DISCOUNT_$order_id}}</td>
        </tr>
        <tr style="height:50px">
            <td colspan="4"  class="total td-height" style="text-align: right;font-style: normal;font-weight: bold;">{{GRAND_TOTAL_TEXT}}{{CURRENCY}}</td>
            <td class="total-fig td-height" style="text-align: right;padding-right: 20px;">{{GRAND_TOTAL_$order_id}}</td>
        </tr>

    </table>

</div>
FOOTER;

    $html.=$this->replaceOrderString($order,$body);

}

# Display Invoice body closing
$html.=<<<FOOT
</body>
</html>
FOOT;

echo $html;

