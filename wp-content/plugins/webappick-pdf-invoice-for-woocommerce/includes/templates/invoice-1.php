<=head-start=>
<!doctype html>
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

        .woocommerce-Price-currencySymbol { 
            font-family: 'Currencies';
        }



    </style>

</head>
<=head-end=>

<=body-top-start=>
<body>

    <div class='invoice-box {{pagebreak}}'>

        <!-- Action Before all content on the document-->
        {{WOO_INVOICE_BEFORE_DOCUMENT}}

        <table border="0" width="100%" style="margin-top: 0px;margin-bottom: 10px;">
            <tbody>
            <tr style="height: 400px;">
                <td style="width: 50%; border-bottom: 0px">
                    <img src="{{LOGO}}" alt="" style="width:{{LOGO_WIDTH}}">
                </td>
                <td  style="text-align: right;width: 50%;padding-right: 50px;font-weight: 700;text-transform: uppercase;font-size: 25px;border-bottom: 0px">
                    <b>{{INVOICE}}.</b>

                    <!-- Action After the document label (Invoice, Packing Slip etc.)-->
                    <br>{{WOO_INVOICE_AFTER_DOCUMENT_LABEL}}

                </td>
                <!--<barcode code="{{ORDER_NUMBER_$order_id}}" type="C128A" size="1.0" height="1.5" />-->

            </tr>
            </tbody>
        </table>

        <table border="0" width="100%" style="margin-top: 0px;margin-bottom: 10px">
            <tbody>
            <tr style="height: 50px;">
                <td style="width: 40%;border-bottom: 0px">

                    <!-- Action Before the billing address-->
                    <p>{{WOO_INVOICE_BEFORE_BILLING_ADDRESS}}</p>

                    {{TO_$order_id}}

                    <!-- Action After the billing address-->
                    <p>{{WOO_INVOICE_AFTER_BILLING_ADDRESS}}</p>

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
                <=body-top-invoice_payment_start=>
                <td style="width: 20%;border-bottom: 0px">
                    <h4 style="margin-bottom:0px;">{{INVOICE_PAYMENT_METHOD_TITLE_TEXT}}</h4>
                    {{INVOICE_PAYMENT_METHOD_TITLE_TEXT_$order_id}}
                </td>
                <=body-top-invoice_payment_end=>
                <td style="width: 20%;border-bottom: 0px;text-align: center">
                    <h4 style="margin-bottom:0px;">{{INVOICE_NUMBER_TEXT}}</h4>
                    {{INVOICE_NUMBER_$order_id}}
                </td>
                <=body-remove-invoice-date-start=>
                <td style="width: 20%;border-bottom: 0px;text-align: center">
                    <h4 style="margin-bottom:0px;">{{INVOICE_DATE_TEXT}}</h4>
                    {{INVOICE_DATE_$order_id}}
                </td>
                <=body-remove-invoice-date-end=>
                <td style="width: 20%;border-bottom: 0px;text-align: center">
                    <h4 style="margin-bottom:0px;" >{{ORDER_NUMBER_TEXT}}</h4>
                    {{ORDER_NUMBER_$order_id}}
                </td>

                <td style="width: 20%;border-bottom: 0px;text-align: center">
                    <h4 style="margin-bottom:0px;">{{ORDER_DATE_TEXT}}</h4>
                    {{ORDER_DATE_$order_id}}
                </td>
            </tr>
            </tbody>
        </table>


        <!--Action Before the order details table with all items-->
        {{WOO_INVOICE_BEFORE_ORDER_DETAILS}}

        <table cellpadding="0" cellspacing="0" style="border-top: 2px solid; border-bottom:2px solid">

            <tr style="height:50px">
                <td width="50%" style="text-transform: uppercase;"><b>{{PRODUCT}}</b></td>
                <td  style="text-transform: uppercase"><b>{{PRICE}}</b></td>
                <td  style="text-transform: uppercase"><b>{{QUANTITY}}</b></td>
                <td  style="text-transform: uppercase;text-align: right;padding-right: 20px;"><b>{{ROW_TOTAL}}</b></td>
            </tr>
            <=body-top-end=>
                  <=product-loop-start=>
                    <tr style="height:50px">
                        <td class="td-height">{{P_DESCRIPTION_$id}}</td>
                        <td class="td-height">{{P_PRICE_$id}}</td>
                        <td class="quantity td-height">{{P_QUANTITY_$id}}</td>
                        <td class="td-height" style="text-align: right; padding-right: 20px;">{{P_TOTAL_$id}}</td>
                     </tr>
                 <=product-loop-end=>
            <=body-bottom-start=>

            <=body-remove-sub-total-start=>
            <tr style="height:50px">
                <td colspan="3" class="sum-total td-height" style="text-align: right;font-style: normal;font-weight: bold;">{{SUBTOTAL_TEXT}}</td>
                <td class="total-fig td-height" style="text-align: right;padding-right: 20px;">{{SUBTOTAL_$order_id}}</td>
            </tr>
            <=body-remove-sub-total-end=>
            <=body-remove-tax-start=>
            <tr style="height:50px">
                <td colspan="3"  class="tax td-height" style="text-align: right;font-style: normal;font-weight: bold;">{{TAX_TEXT}}</td>
                <td class="tax-fig td-height" style="text-align: right;padding-right: 20px;">{{TAX_$order_id}}</td>
            </tr>
            <=body-remove-tax-end=>
            <=body-remove-discount-start=>
            <tr style="height:50px">
                <td colspan="3"  class="tax td-height" style="text-align: right;font-style: normal;font-weight: bold;">{{DISCOUNT_TEXT}}</td>
                <td class="tax-fig td-height" style="text-align: right;padding-right: 20px;">{{DISCOUNT_$order_id}}</td>
            </tr>
            <=body-remove-discount-end=>

            <=body-remove-shipping-start=>
            <tr style="height:50px">
                <td colspan="3"  class="tax td-height" style="text-align: right;font-style: normal;font-weight: bold;">{{SHIPPING_TEXT}}</td>
                <td class="tax-fig td-height" style="text-align: right;padding-right: 20px;">{{SHIPPING_$order_id}}</td>
            </tr>
            <=body-remove-shipping-end=>
            <=body-remove-refund-start=>
            <tr style="height:50px">
                <td colspan="3"  class="total td-height" style="text-align: right;font-style: normal;font-weight: bold;">{{REFUND_TEXT}}</td>
                <td class="total-fig td-height" style="text-align: right;padding-right: 20px;">{{REFUND_$order_id}}</td>
            </tr>
            <=body-remove-refund-end=>
            <=body-remove-total-start=>
            <tr style="height:50px">
                <td colspan="3"  class="total td-height" style="text-align: right;font-style: normal;font-weight: bold;">{{GRAND_TOTAL_TEXT}}{{CURRENCY}}</td>
                <td class="total-fig td-height" style="text-align: right;padding-right: 20px;">{{GRAND_TOTAL_$order_id}}</td>
            </tr>
            <=body-remove-total-end=>
        </table>

        <!--Action After the order details table-->
        {{WOO_INVOICE_AFTER_ORDER_DETAILS}}

        <htmlpagefooter name="invoiceFooter">
            <div class="footer-details" style="padding:20px 10px 10px 10px">

                <!--Action Before the customer/shipping notes (left of the order details)-->
                {{WOO_INVOICE_BEFORE_CUSTOMER_NOTES}}

                {{ORDER_NOTE}}

                <!--Action After the customer/shipping notes (left of the order details)-->
                {{WOO_INVOICE_AFTER_CUSTOMER_NOTES}}

                <table border="0" style="width:100%;margin-top: 0px;">
                    <tbody>
                        <tr>
                            <=body-remove-footer-1-start=>
                            <td style="width: 50%;border-bottom: 0px;vertical-align: bottom;">
                                <table><tr><td style="border-bottom:0;">
                                    <pre style="font-size: 9px;">{{TERMS_AND_CONDITION}} </pre>
                                </td></tr></table>

                            </td>
                            <=body-remove-footer-1-end=>
                            <=body-remove-footer-1-start=>
                            <td style="width: 50%;border-bottom: 0px;vertical-align: bottom;">
                                <table>
                                    <tr>
                                        <td style="border-bottom:0;">
                                            <pre style="font-size: 9px;">{{OTHER_INFORMATION}}</pre>
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

