<=head-start=>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{PACKING_SLIP_TEXT}}</title>
    <style>

        @page{
            margin: 20px;
        }

        body{
            font-family: "raleway";
            font-size: 11px;
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



        table.header-table {
            margin-top: 0px;
            margin-bottom: 10px;
            border: 0px;
            width: 100%;
        }
        table.header-table tr td:nth-child(1) {
            width: 50%;
            border-bottom: 0px
        }
        table.header-table tr td:nth-child(2) {
            text-align:right;
            width: 50%;
            padding-right: 50px;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 25px;
            border-bottom: 0px
        }


        .invoice-order {
            overflow:hidden;
            margin-left:20px;
            margin-right:20px;
        }
        .invoice-order table {
            border: 0px;
            width: 100%;
            margin-top: 0px;
            margin-bottom: 10px;
        }
        .invoice-order table tr td {
            border-bottom: 0px;
        }
        div.invoice-order .order-to {
            float:left;
            width:33%;
        }
        div.invoice-order .order-from {
            float:left;
            width:33%;
        }
        div.invoice-order .order-info {
            float:right;
            width:33%;
        }


        table.product-table {
            border-top: 2px solid;
            border-bottom:2px solid;
            border-collapse: collapse;
        }
        table.product-table tr.product-list-header {
            height:50px;
        }
        table.product-table tr.product-list-header td {
            text-transform: uppercase;
        }
        table.product-table tr.product-list-header td.product {
            width: 40%;
        }
        table.product-table tr.product-list td.weight {
            width: 10%;
            padding-left: 20px;
        }
        table.product-table tr td.quantity {
            width: 10%;
            text-align: center
        }


        .footer-details {
            padding:20px 10px 0px 10px
        }


    </style>

</head>
<=head-end=>

<=body-top-start=>
<body>

<!-- Action for Packing Slip custom css -->
<style>
    {{WOO_PACKING_SLIP_CUSTOM_STYLE}}
</style>

<!-- Action Before all content on the document-->
{{WOO_PACKING_SLIP_BEFORE_DOCUMENT}}

<div class='invoice-box {{pagebreak}}'>
    <table class="header-table">
        <tbody>
        <tr>
            <td>
                <img class="header-logo" src="{{LOGO}}" alt="" style="width:{{LOGO_WIDTH}}">
            </td>
            <td>
                <b class="header-title">{{PACKING_SLIP_TEXT}}.</b>

                <!-- Action After the document label (Invoice, Packing Slip etc.)-->
                <br>{{WOO_PACKING_SLIP_AFTER_DOCUMENT_LABEL}}

            </td>
        </tr>
        </tbody>
    </table>

    <div class="invoice-order">
            <div class="order-to">
                <table>
                    <tbody>
                    <tr>
                        <td>

                            <!-- Action Before the billing address-->
                            <p>{{WOO_PACKING_SLIP_BEFORE_BILLING_ADDRESS}}</p>

                            {{TO_$order_id}}

                            <!-- Action After the billing address-->
                            <p>{{WOO_PACKING_SLIP_AFTER_BILLING_ADDRESS}}</p>

                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="order-from">
                <table>
                    <tbody>
                    <tr>
                        <td>
                            {{FROM}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="order-info">
                <table>
                    <tbody>
                    <tr>
                        <td>

                            <!-- Action Data Before the order data (invoice number, order date, etc.)-->
                            <p>{{WOO_PACKING_SLIP_BEFORE_ORDER_DATA}}</p>

                            <!--body-top-invoice_payment_start-->
                            <span class="order-info-label">{{INVOICE_PAYMENT_METHOD_TITLE_TEXT}}</span> : <span class="order-info-value">{{INVOICE_PAYMENT_METHOD_TITLE_TEXT_$order_id}}</span> <br>
                            <!--body-top-invoice_payment_end-->
                            <span class="order-info-label">{{ORDER_NUMBER_TEXT}}</span> : <span class="order-info-value">{{ORDER_NUMBER_$order_id}}</span> <br>
                            <span class="order-info-label">{{ORDER_DATE_TEXT}}</span> : <span class="order-info-value">{{ORDER_DATE_$order_id}}</span> <br>

                            <!-- Action After the order data-->
                            {{WOO_PACKING_SLIP_AFTER_ORDER_DATA}}

                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Action Before the order details table with all items-->
        {{WOO_PACKING_SLIP_BEFORE_ORDER_DETAILS}}

        <table class="product-table">
            <tr class="product-list-header">
                <td class="product"><b>{{PACKING_SLIP_PRODUCT_TEXT}}</b></td>
                <td class="weight"><b>{{PACKING_SLIP_WEIGHT_TEXT}}</b></td>
                <td class="quantity"><b>{{PACKING_SLIP_QUANTITY_TEXT}}</b></td>
            </tr>
            <=body-top-end=>
            <=product-loop-start=>
            <tr class="product-list">
                <td class="product">{{P_DESCRIPTION_$id}} </td>
                <td class="weight">{{WEIGHT_$id}}</td>
                <td class="quantity">{{P_QUANTITY_$id}} </td>

             </tr>
            <=product-loop-end=>
            <=body-bottom-start=>
        </table>

        <!-- Action After the order details table-->
        {{WOO_PACKING_SLIP_AFTER_ORDER_DETAILS}}

        <htmlpagefooter name="invoiceFooter">
            <div class="footer-details">

                <!-- Action After all content on the document in footer-->
                {{WOO_PACKING_SLIP_AFTER_DOCUMENT}}

            </div>
        </htmlpagefooter>
    </div>
    <=body-bottom-end=>
    <=footer-start=>
    <sethtmlpagefooter name="invoiceFooter" value="1" />
</body>
</html>
<=footer-end=>

