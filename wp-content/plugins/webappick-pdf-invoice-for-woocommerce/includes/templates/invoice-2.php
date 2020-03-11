<=head-start=>
<html>
<head>
    <meta charset="utf-8">
    <title>{{INVOICE}}</title>
    <style>

        @page{
            margin: 20px;
            /*footer: html_invoiceFooter;*/
        }

        body{
            font-family: "raleway";
            background: #EAE8E9;
            min-height: 100%;
            font-size: 11px;

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

        .invoice-box table {
            width: 100%;
            text-align: left;
        }
        .invoice-box table tr td{
            border-bottom: 1px solid #DCDADB;
            padding: 10px 0;
        }

        .invoice-box table tr.last-tr td {
            border-bottom:0;
        }

        .invoice-box table td {
            vertical-align: top;
        }

        /*.invoice-box table{
            border-bottom: 2px solid;
        }*/

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

        .woocommerce-Price-currencySymbol {
            font-family: 'Currencies';
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
            font-weight: 700;
            text-transform: uppercase;
            font-size: 25px;
            border-bottom: 0px
        }

        .invoice-order {
            width:100%;
            float:left;
            overflow:hidden
        }
        .invoice-order table.order-table {
            margin-top: 0px;
            margin-bottom: 10px
        }
        table.order-table tr td:nth-child(1) {
            width: 30%;
            border-bottom: 0px
        }
        table.order-table tr td:nth-child(2) {
            width: 30%;
            border-bottom: 0px;
            padding: 10px;
        }
        table.order-table tr td:nth-child(3) {
            width: 40%;
            border-bottom: 0px;
            padding: 10px;
        }

        table.product-table {
            border-top: 2px solid;
            border-bottom:2px solid;
            border-collapse: collapse;
        }
        table.product-table tr {
            height:50px;
        }
        table.product-table tr.product-list-header td.product {
            font-size: 10px;
            padding-left: 5px;
            width: 50%;
        }
        table.product-table tr.product-list td.product {
            font-size: 10px;
            padding-left: 5px;
        }
        table.product-table tr:nth-child(1) td {
            background:#000;
            color:#fff;
            border-top:0;
            border-bottom:0;
            text-transform: uppercase;
        }

        table.product-table .last-td {
            text-align: right;
            padding-right: 20px;
        }
        table.product-table .total-label {
            text-align: right;
            font-style: normal;
            font-weight: bold;
        }

        .invoice-footer {
            padding:20px 10px 10px 10px;
        }
        .invoice-footer table.invoice-footer-table {
            width:100%;
            margin-top: 0px;
            border: 0;
        }
        table.invoice-footer-table tr td {
            width: 50%;
            border-bottom: 0px;
            vertical-align: bottom;
            font-size: 9px;
        }

    </style>

</head>
<=head-end=>

<=body-top-start=>
<body>

<!-- Action for Invoice custom css -->
<style>
    {{WOO_INVOICE_CUSTOM_STYLE}}
</style>

<!-- Action Before all content on the document-->
{{WOO_INVOICE_BEFORE_DOCUMENT}}

<div class='invoice-box {{pagebreak}}'>

    <table class="header-table">
        <tbody>
        <tr>
            <td>
                <img class="header-logo" src="{{LOGO}}" alt="" style="width:{{LOGO_WIDTH}}">
            </td>
            <td>
                <b class="header-title">{{INVOICE}}</b>

                <!-- Action After the document label (Invoice, Packing Slip etc.)-->
                <br>{{WOO_INVOICE_AFTER_DOCUMENT_LABEL}}

            </td>
        </tr>
        </tbody>
    </table>

    <div class="invoice-order">
        <table class="order-table">
            <tbody>
                <tr>
                    <td>

                        <!-- Action Before the billing address-->
                        <p>{{WOO_INVOICE_BEFORE_BILLING_ADDRESS}}</p>

                        <p>{{TO_$order_id}}</p>

                        <!-- Action After the billing address-->
                        <p>{{WOO_INVOICE_AFTER_BILLING_ADDRESS}}</p>

                    </td>
                    <td>
                        <p>{{FROM}}</p>
                    </td>
                    <td>

                        <!-- Action Data Before the order data (invoice number, order date, etc.)-->
                        <p>{{WOO_INVOICE_BEFORE_ORDER_DATA}}</p>

                        <!--body-top-invoice_payment_start-->
                        <span class="order-info-label">{{INVOICE_PAYMENT_METHOD_TITLE_TEXT}}</span> : <span class="order-info-value">{{INVOICE_PAYMENT_METHOD_TITLE_TEXT_$order_id}}</span> <br>
                        <!--body-top-invoice_payment_end-->
                        <span class="order-info-label">{{ORDER_NUMBER_TEXT}}</span> : <span class="order-info-value">{{ORDER_NUMBER_$order_id}}</span> <br>
                        <span class="order-info-label">{{ORDER_DATE_TEXT}}</span> : <span class="order-info-value">{{ORDER_DATE_$order_id}}</span> <br>
                        <span class="order-info-label">{{INVOICE_NUMBER_TEXT}}</span> : <span class="order-info-value">{{INVOICE_NUMBER_$order_id}}</span> <br>
                        <span class="order-info-label">{{INVOICE_DATE_TEXT}}</span> : <span class="order-info-value">{{INVOICE_DATE_$order_id}}</span> <br>

                        <!-- Action After the order data-->
                        {{WOO_INVOICE_AFTER_ORDER_DATA}}

                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!--Action Before the order details table with all items-->
    {{WOO_INVOICE_BEFORE_ORDER_DETAILS}}

    <table cellpadding="0" cellspacing="0" class="product-table">
        <tr class="product-list-header">
            <td class="product first-td"><b>{{PRODUCT}}</b></td>
            <td class="price"><b>{{PRICE}}</b></td>
            <td class="quantity"><b>{{QUANTITY}}</b></td>
            <td class="total last-td"><b>{{ROW_TOTAL}}</b></td>
        </tr>
        <=body-top-end=>
        <=product-loop-start=>
        <tr class="product-list">
            <td class="product first-td">{{P_DESCRIPTION_$id}}</td>
            <td class="price">{{P_PRICE_$id}}</td>
            <td class="quantity ">{{P_QUANTITY_$id}}</td>
            <td class="total last-td">{{P_TOTAL_$id}}</td>
        </tr>
        <=product-loop-end=>
        <=body-bottom-start=>

        <=body-remove-sub-total-start=>
        <tr>
            <td colspan="3" class="sum-total total-label">{{SUBTOTAL_TEXT}}</td>
            <td class="total-fig total-value last-td">{{SUBTOTAL_$order_id}}</td>
        </tr>
        <=body-remove-sub-total-end=>
        <=body-remove-tax-start=>
        <tr>
            <td colspan="3" class="tax total-label">{{TAX_TEXT}}</td>
            <td class="tax-fig total-value last-td">{{TAX_$order_id}}</td>
        </tr>
        <=body-remove-tax-end=>
        <=body-remove-shipping-start=>
        <tr>
            <td colspan="3" class="tax total-label">{{SHIPPING_TEXT}}</td>
            <td class="tax-fig total-value last-td">{{SHIPPING_$order_id}}</td>
        </tr>
        <=body-remove-shipping-end=>

        <=body-remove-discount-start=>
        <tr>
            <td colspan="3" class="tax total-label">{{DISCOUNT_TEXT}}</td>
            <td class="tax-fig total-value last-td">{{DISCOUNT_$order_id}}</td>
        </tr>
        <=body-remove-discount-end=>

        <=body-remove-refund-start=>
        <tr>
            <td colspan="3" class="tax total-label">{{REFUND_TEXT}}</td>
            <td class="tax-fig total-value last-td">{{REFUND_$order_id}}</td>
        </tr>
        <=body-remove-refund-end=>
        <=body-remove-total-start=>
        <tr class="last-tr">
            <td colspan="3" class="total total-label">{{GRAND_TOTAL_TEXT}}{{CURRENCY}}</td>
            <td class="total-fig total-value last-td">{{GRAND_TOTAL_$order_id}}</td>
        </tr>
        <=body-remove-total-end=>
    </table>

    <!--Action After the order details table-->
    {{WOO_INVOICE_AFTER_ORDER_DETAILS}}

    <htmlpagefooter name="invoiceFooter">
        <div class="invoice-footer">

            <div class="order-note">
                <!--Action Before the customer/shipping notes (left of the order details)-->
                {{WOO_INVOICE_BEFORE_CUSTOMER_NOTES}}

                {{ORDER_NOTE}}

                <!--Action After the customer/shipping notes (left of the order details)-->
                {{WOO_INVOICE_AFTER_CUSTOMER_NOTES}}
            </div>

            <table class="invoice-footer-table">
                <tbody>
                    <tr>
                        <=body-remove-footer-1-start=>
                        <td class="order-term-condition">
                            <table>
                                <tr>
                                    <td>
                                        <pre>{{TERMS_AND_CONDITION}} </pre>
                                    </td>
                                </tr>
                            </table>

                        </td>
                        <=body-remove-footer-1-end=>
                        <=body-remove-footer-1-start=>
                        <td class="order-other-info">
                            <table>
                                <tr>
                                    <td>
                                        <pre>{{OTHER_INFORMATION}}</pre>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <=body-remove-footer-2-end=>
                    </tr>
                </tbody>
            </table>

            <!--Action After all content on the document in footer-->
            {{WOO_INVOICE_AFTER_DOCUMENT}}

        </div>
   </htmlpagefooter>

</div>

<=body-bottom-end=>
<=footer-bottom-start=>
<sethtmlpagefooter name="invoiceFooter" value="1" />
<=footer-bottom-end=>
<=footer-start=>
</body>
</html>
<=footer-end=>

