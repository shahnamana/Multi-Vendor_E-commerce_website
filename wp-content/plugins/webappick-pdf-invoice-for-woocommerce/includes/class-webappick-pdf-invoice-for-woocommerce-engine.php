<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://webappick.com
 * @since      1.0.0
 *
 * @package    Webappick_Pdf_Invoice_For_Woocommerce
 * @subpackage Webappick_Pdf_Invoice_For_Woocommerce/includes
 */

/**
 * The core plugin class that generate PDF Invoice.
 *
 * This is used to generate PDF Invoice
 *
 *
 * @since      1.0.0
 * @package    Webappick_Pdf_Invoice_For_Woocommerce
 * @subpackage Webappick_Pdf_Invoice_For_Woocommerce/includes
 * @author     Md Ohidul Islam <wahid@webappick.com>
 */

class Webappick_Pdf_Invoice_Engine {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   public
     * @var      Webappick_Pdf_Invoice_Engine $orderId store all order ids.
     */

    public $orderIds;
    public $orderId;
    public $products;
    public $orderInfo;
    public $currencySymbol="";
    public $countries;

    /**
     * Webappick_Pdf_Invoice_Engine constructor.
     * @param $orderIds
     */
    public function __construct($orderIds) {

        $this->orderIds=$orderIds;
        $this->products=array();
        $this->orderInfo=array();
        $this->countries= new WC_Countries();
        $this->extractOrdersInfo();

        if(!empty(get_option("wpifw_currency_code"))){
            $this->currencySymbol=" (".get_woocommerce_currency().")";
        }

    }

    /**
     * Generate Bulk or Single PDF Invoice
     */
    public function generatePDF( $orderId = null ) {

        #TODO Remove the below method after version 2.0
        $this->replaceOldBuyerAddress();

        $upload=wp_upload_dir();
        $baseDir=$upload['basedir'];

        ob_start();
        $orders=$this->orderInfo;
        # DEBUG
//        echo "<pre>";
//        //print_r(wc_get_product(128));
//        $this->getTemplateContent('invoice',$orders);
//        die();

        /*echo "<pre>";print_r($orders);die();*/

        # Get Template Content
        if($this->orderIds){
            echo $this->getTemplateContent('invoice',$orders);
        }
        else{
            require plugin_dir_path( __FILE__ ) . 'templates/empty.php';
        }
        $html = ob_get_contents();
        ob_end_clean();



        $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => $baseDir,
            'fontDir' => array_merge($fontDirs, [
                plugin_dir_path(__FILE__) . 'templates/fonts',
            ]),
            'fontdata' => $fontData + [
                    'Lato' => [
                        'R' => "Lato-Regular.ttf",
                        'B' => "Lato-Bold.ttf",
                        'I' => "Lato-Italic.ttf",
                        'BI' => "Lato-BoldItalic.ttf",
                    ],
                    'currencies' => [
                        'R' => "Currencies.ttf",
                    ]
                ],
            'default_font' => 'Lato',
            'mode' => 'utf-8',
            'format'=>'A4'
        ]);

        $invoiceId = get_post_meta($orderId,"wpifw_invoice_no",true);

        $mpdf->shrink_tables_to_fit=0;

        $mpdf->WriteHTML($html);
        if(get_option('wpifw_pdf_invoice_button_behaviour') == "download") {
            $output=$mpdf->Output("Invoice-".$invoiceId.'.pdf', 'D');
        } else {
            $output=$mpdf->Output("Invoice-".$invoiceId.'.pdf', 'I');
        }
        exit;
    }


    /**
     * Generate Bulk or Single PDF Invoice Packing Slip
     */
    public function generatePackingSlip( $orderId = null ) {

        #TODO Remove the below method after version 2.0
        $this->replaceOldBuyerAddress();

        $upload=wp_upload_dir();
        $baseDir=$upload['basedir'];
        ob_start();
        $orders=$this->orderInfo;

        # DEBUG
        //echo "<pre>";print_r($orders);die();

        # Get Template Content
        if($this->orderIds){
            echo $this->getTemplateContent('slip',$orders);
        }
        else{
            require plugin_dir_path( __FILE__ ) . 'templates/empty.php';
        }
        $html = ob_get_contents();
        ob_end_clean();



        $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => $baseDir,
            'fontDir' => array_merge($fontDirs, [
                plugin_dir_path(__FILE__) . 'templates/fonts',
            ]),
            'fontdata' => $fontData + [
                    'Lato' => [
                        'R' => "Lato-Regular.ttf",
                        'B' => "Lato-Bold.ttf",
                        'I' => "Lato-Italic.ttf",
                        'BI' => "Lato-BoldItalic.ttf",
                    ]
                ],
            'default_font' => 'Lato',
            'mode' => 'utf-8',
            'format'=>'A4'
        ]);

        $invoiceId = get_post_meta($orderId,"wpifw_invoice_no",true);
        $mpdf->shrink_tables_to_fit=0;

        $mpdf->WriteHTML($html);
        $output=$mpdf->Output('Packing-Slip-'.$invoiceId.'.pdf', 'I');
        exit;
    }


    /**
     * Extract all order information and store as array
     */
    public function extractOrdersInfo(  ) {
        $orderIds=explode(",",$this->orderIds);
        //echo "<pre>";print_r($orderIds);die();
        foreach ($orderIds as $order_key=>$order_id){

            # Initialize order information into array
            $order = wc_get_order($order_id);

            if(!is_a($order, 'WC_Order_Refund')){
                $shipping_method = $order->get_shipping_method();
                $payment_method = $order->get_payment_method_title();
                $order_data=$order->get_data();
                foreach ($order_data as $order_key=>$order_value){
                    $this->orderInfo[$order_id][$order_key]=$order_value;
                }


                # Set Order Date according to plugin settings
                $date=$order->get_date_completed();
                if(!is_object($date)){
                    $date=$order->get_date_created();
                }
                $this->orderInfo[$order_id]['wpifw_order_date']=$date->date("d M, o");


                # Get Products by Order Id
                foreach ($order->get_items() as $item_key => $item_values):

                    $item_id = $item_values->get_id();
                    $product = $item_values->get_product();
                    $product_data=$product->get_data();
                    $item_data = $item_values->get_data();

                    foreach ($item_data as $key=>$value){
                        $this->products[$order_id][$item_id][$key]=$value;
                    }

                    $this->products[$order_id][$item_id]['rrrr']=wc_get_order_item_meta($item_id,"_line_subtotal_tax",true);
                    $this->products[$order_id][$item_id]['pid']=$product_data['id'];
                    $this->products[$order_id][$item_id]['sku']=$product_data['sku'];
                    $this->products[$order_id][$item_id]['product_info'] = wc_get_product($product_data['id']);

                endforeach;
                //echo "<pre>";print_r($this->products);die();
                $this->orderInfo[$order_id]['wpifw_products']       =    $this->products[$order_id];
                $this->orderInfo[$order_id]['all_products']         =    $this->products;
                $this->orderInfo[$order_id]['shipping_method']      =    $shipping_method;
                $this->orderInfo[$order_id]['payment_method_title'] =    $payment_method;

            }
        }

    }


    /** Make Invoice / Packing Slip Content from Template
     * @param $type
     * @param $orders
     * @return bool|mixed|string
     */

    public function getTemplateContent($type, $orders)
    {
        $template="";
        $productPerPage=10;
        $content="";
        if($type=="invoice"){
            # Get Invoice Content
            //$template=file_get_contents(plugin_dir_path(__FILE__) .'templates/invoice.php');

            $selected_invoice_template = get_option('wpifw_templateid');
            if($selected_invoice_template && !empty($selected_invoice_template)) {
                $template = file_get_contents(plugin_dir_path(dirname(__FILE__)) .'includes/templates/'.$selected_invoice_template.'.php');
            } else{
                $template = file_get_contents(plugin_dir_path(dirname(__FILE__)) .'includes/templates/invoice-1.php');
            }

        }elseif ($type=="slip"){
            # Get Invoice Slip Content
            $template=file_get_contents(plugin_dir_path(__FILE__) .'templates/invoice_packing_slip.php');
            $productPerPage+=2;
        }


        $pageBreak="pageBreak";

        # Get Template Header
        $content = $this->get_string_between($template, "<=head-start=>", "<=head-end=>", array("{{PACKING_SLIP_TEXT}}", '{{INVOICE}}'), array((!empty($PACKING_SLIP_TEXT)?$PACKING_SLIP_TEXT:"PACKING SLIP"), (!empty(get_option('wpifw_INVOICE_TITLE'))?get_option('wpifw_INVOICE_TITLE'):"INVOICE")));

        foreach ($orders as $order_id=>$order) {

            $productChunk = array_chunk($order['wpifw_products'], $productPerPage);
            $totalChunk = count($productChunk);


            foreach ($productChunk as $cKey => $chunk) {
                # Calculate Page Break
                if ($totalChunk==1) {
                    $pageBreak="";
                }else if($cKey != ($totalChunk - 1)){
                    $pageBreak="";
                }

                # Get Template Body
                $body = $this->get_string_between($template, "<=body-top-start=>", "<=body-top-end=>", array("{{pagebreak}}", '$order_id'), array($pageBreak, $order_id));

                # Get Products
                foreach ($chunk as $pKey => $value) {
                    $id = ($value['variation_id']>0)?$value['variation_id']."_".$value['id']:$value['product_id']."_".$value['id'];
                    $body .= $this->get_string_between($template, "<=product-loop-start=>", "<=product-loop-end=>", '$id', $id);
                }

                # Get Template Body Bottom
                $body .= $this->get_string_between($template, "<=body-bottom-start=>", "<=body-bottom-end=>", '$order_id', $order_id);

                if ($cKey != ($totalChunk - 1)) {
                    # Remove Total Info
                    $body = $this->remove_string_between($body, "<=body-remove-sub-total-start=>", "<=body-remove-sub-total-end=>");
                    $body = $this->remove_string_between($body, "<=body-remove-tax-start=>", "<=body-remove-tax-end=>");
                    $body = $this->remove_string_between($body, "<=body-remove-discount-start=>", "<=body-remove-discount-end=>");
                    $body = $this->remove_string_between($body, "<=body-remove-shipping-start=>", "<=body-remove-shipping-end=>");
                    $body = $this->remove_string_between($body, "<=body-remove-total-start=>", "<=body-remove-total-end=>");
                    $body = $this->remove_string_between($body, "<=body-remove-footer-1-start=>", "<=body-remove-footer-1-end=>");
                    $body = $this->remove_string_between($body, "<=body-remove-footer-2-start=>", "<=body-remove-footer-2-end=>");
                    

                } else {
                    if (!get_option('wpifw_payment_method_show')) {
                        $body = $this->remove_string_between($body, "<=body-top-invoice_payment_start=>", "<=body-top-invoice_payment_end=>");
                    }
                    if (!get_option('wpifw_payment_method_show')) {
                        $body = $this->remove_string_between($body, "<!--body-top-invoice_payment_start-->", "<!--body-top-invoice_payment_end-->");
                    }
                    // Header Invoice Payment Method Show/Hide
                    if ( ! get_option( 'wpifw_payment_method_show' ) ) {
                        $body = $this->remove_string_between( $body, "<!--body-top-invoice_payment_start-->", "<!--body-top-invoice_payment_end-->" );
                    }
                    if (!$order['total_tax']) {
                        $body = $this->remove_string_between($body, "<=body-remove-tax-start=>", "<=body-remove-tax-end=>");
                    }
                    if (!$order['discount_total']) {
                        $body = $this->remove_string_between($body, "<=body-remove-discount-start=>", "<=body-remove-discount-end=>");
                    }
                    if (!$order['shipping_total'] || $order['shipping_total'] == 0.00) {
                        $body = $this->remove_string_between($body, "<=body-remove-shipping-start=>", "<=body-remove-shipping-end=>");
                    }
                    if (empty((array)wc_get_order( $order_id )->get_refunds())) {
                       $body = $this->remove_string_between($body, "<=body-remove-refund-start=>", "<=body-remove-refund-end=>");
                    }
                    
                }

                if($this->processInvoiceDate($order) == ""){
                    $body = $this->remove_string_between($body, "<=body-remove-invoice-date-start=>", "<=body-remove-invoice-date-end=>");
                }

                # Replace string codes
                $content .= $this->replaceOrderString($order, $body);
            }
            $content .= $this->get_string_between($template, "<=footer-bottom-start=>", "<=footer-bottom-end=>");
        }

        # Get Template Footer
        $content .= $this->get_string_between($template, "<=footer-start=>", "<=footer-end=>");

       return $content;
    }

    /**
     * Get Template Strings between Template Codes
     *
     * @param $string
     * @param string $start Template code to start
     * @param string $end Template Code to end
     * @param string $toReplace Order or Product id to replace
     * @param string $replaceWith  Order or Product id replace with
     * @return bool|mixed|string
     */
    public function get_string_between($string, $start, $end, $toReplace="", $replaceWith=""){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        $finalString=substr($string, $ini, $len);
        $finalString=str_replace($toReplace,$replaceWith,$finalString);
        return $finalString;
    }

    /**
     * Remove Template Strings between Template Codes
     * @param $string
     * @param $start
     * @param $end
     * @return mixed
     */
    public function remove_string_between($string, $start, $end){
        $beginningPos = strpos($string, $start);
        $endPos = strpos($string, $end);
        if ($beginningPos === false || $endPos === false) {
            return $string;
        }

        $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);
        $string =  str_replace($textToDelete, '', $string);
        return $string;
    }

    /**
     * Find and Replace all dynamic string for Invoice Template
     * @param $order
     * @param $string
     * @return mixed
     */
    public function replaceOrderString($order,$string) {

        $id                             = $order['id'];
        $INVOICE_NUMBER_TEXT            = get_option('wpifw_INVOICE_NUMBER_TEXT');
        $INVOICE_DATE_TEXT              = get_option('wpifw_INVOICE_DATE_TEXT');
        $INVOICE_TITLE                  = get_option('wpifw_INVOICE_TITLE');
        $ORDER_NUMBER_TEXT              = get_option('wpifw_ORDER_NUMBER_TEXT');
        $ORDER_DATE_TEXT                = get_option('wpifw_ORDER_DATE_TEXT');
        $REFUNDED_TEXT                  = get_option('wpifw_REFUNDED_TEXT');
        $SL                             = get_option('wpifw_SL');
        $PRODUCT                        = get_option('wpifw_PRODUCT');
        $PRICE                          = get_option('wpifw_PRICE');
        $QUANTITY                       = get_option('wpifw_QUANTITY');
        $ROW_TOTAL                      = get_option('wpifw_ROW_TOTAL');
        $SUBTOTAL_TEXT                  = get_option('wpifw_SUBTOTAL_TEXT');
        $TAX_TEXT                       = get_option('wpifw_TAX_TEXT');
        $DISCOUNT_TEXT                  = get_option('wpifw_DISCOUNT_TEXT');
        $SHIPPING_TEXT                  = get_option('wpifw_SHIPPING_TEXT');
        $GRAND_TOTAL_TEXT               = get_option('wpifw_GRAND_TOTAL_TEXT');
        $LOGO_HEIGHT                    = get_option('wpifw_logo_height');
        $LOGO_WIDTH                     = get_option('wpifw_logo_width');
        $TERMS_AND_CONDITION            = stripslashes(get_option('wpifw_terms_and_condition'));
        $OTHER_INFORMATION              = stripslashes(get_option('wpifw_other_information'));

        #For Packing slip localization setting setup
        $PACKING_SLIP_TEXT              = get_option('wpifw_PACKING_SLIP_TEXT');
        $PACKING_SLIP_ORDER_NUMBER_TEXT = get_option('wpifw_PACKING_SLIP_ORDER_NUMBER_TEXT');
        $PACKING_SLIP_ORDER_DATE_TEXT   = get_option('wpifw_PACKING_SLIP_ORDER_DATE_TEXT');
        $PACKING_SLIP_ORDER_METHOD_TEXT = get_option('wpifw_PACKING_SLIP_ORDER_METHOD_TEXT');
        $PACKING_SLIP_PRODUCT_TEXT      = get_option('wpifw_PACKING_SLIP_PRODUCT_TEXT');
        $PACKING_SLIP_WEIGHT_TEXT       = get_option('wpifw_PACKING_SLIP_WEIGHT_TEXT');
        $PACKING_SLIP_QUANTITY_TEXT     = get_option('wpifw_PACKING_SLIP_QUANTITY_TEXT');
        $PAYMENT_METHOD_TEXT            = get_option('wpifw_payment_method_text');
        #Product Information To Replace
        $pInfoReplace       = array();
        $prodToReplace      =array();
        #Product Information Replace With
        $prodReplaceWith    =array();
        $subtotal           = 0;
        foreach ($order['wpifw_products'] as $p_key=>$p_value){
            $product            = $p_value['product_info'];
            $subtotal           = $subtotal + $p_value['subtotal'];
            $pid                = ($p_value['variation_id']>0)?$p_value['variation_id']:$p_value['product_id'];
            $orderPrice    = $p_value['subtotal'] / $p_value['quantity'];

            $pInfoReplace[ "{{P_SL_".$pid."_".$p_value['id']."}}" ]            = $pid;
            $pInfoReplace[ "{{P_DESCRIPTION_".$pid."_".$p_value['id']."}}" ]   = $this->processProductInfo($p_value['name'],$p_value['sku'],$pid);
            $pInfoReplace[ "{{P_PRICE_".$pid."_".$p_value['id']."}}" ]         = $this->formatPrice($orderPrice,$order['id']);
            $pInfoReplace[ "{{P_QUANTITY_".$pid."_".$p_value['id']."}}" ]      = $p_value['quantity'];
            $pInfoReplace[ "{{P_TOTAL_".$pid."_".$p_value['id']."}}" ]         = $this->formatPrice($p_value['subtotal'],$order['id']);
            $pInfoReplace[ "{{WEIGHT_".$pid."_".$p_value['id']."}}" ]          =  $this->getProductWeight($product);
        }

        $refund_order = wc_get_order( $order['id'] );
        $order_refunds = $refund_order->get_refunds();
        $refund_total=0;
        $line_subtotal_tax = 0;
        foreach( $order_refunds as $refund ){
            foreach( $refund->get_items() as $item_id => $item ){
                $refund_total = $refund_total+$item->get_subtotal();
                $line_subtotal_tax = $line_subtotal_tax+$item->get_subtotal_tax();
            }
        }

        # Assign shipping method for multiple bulk action
        if(isset($order['shipping_method']) && is_array($order['shipping_method'])){
            foreach ($order['shipping_method'] as $s_key=>$s_value){
                $pInfoReplace[ "{{ORDER_METHOD" . $s_value['shipping_method'] . "}}" ] = $s_value['shipping_method'];
            }
        }
        
        $textToReplace=array(
            "{{LOGO}}"                                      => $this->resizeStoreLogo(),
            "{{TO_$id}}"                                    => $this->processBillingAddress($order),
            "{{FROM}}"                                      => $this->SellerInfo(),
            "{{INVOICE_NUMBER_TEXT}}"                       => (!empty($INVOICE_NUMBER_TEXT)?$INVOICE_NUMBER_TEXT:"INVOICE NUMBER"),
            "{{INVOICE_DATE_TEXT}}"                         => (!empty($INVOICE_DATE_TEXT)?$INVOICE_DATE_TEXT:"INVOICE DATE"),
            "{{ORDER_NUMBER_TEXT}}"                         => (!empty($ORDER_NUMBER_TEXT)?$ORDER_NUMBER_TEXT:"ORDER NUMBER"),
            "{{ORDER_DATE_TEXT}}"                           => (!empty($ORDER_DATE_TEXT)?$ORDER_DATE_TEXT:"ORDER DATE"),
            "{{SL}}"                                        => (!empty($SL)?$SL:"SL"),
            "{{PRODUCT}}"                                   => (!empty($PRODUCT)?$PRODUCT:"PRODUCTS"),
            "{{PRICE}}"                                     => (!empty($PRICE)?$PRICE:"PRICE"),
            "{{QUANTITY}}"                                  => (!empty($QUANTITY)?$QUANTITY:"QUANTITY"),
            "{{ROW_TOTAL}}"                                 => (!empty($ROW_TOTAL)?$ROW_TOTAL:"TOTAL"),
            "{{SUBTOTAL_TEXT}}"                             => (!empty($SUBTOTAL_TEXT)?$SUBTOTAL_TEXT:"SUB TOTAL"),
            "{{REFUND_TEXT}}"                               => (!empty($REFUNDED_TEXT)?$REFUNDED_TEXT:"REFUNDED"),
            "{{TAX_TEXT}}"                                  => (!empty($TAX_TEXT)?$TAX_TEXT:"TAX"),
            "{{DISCOUNT_TEXT}}"                             => (!empty($DISCOUNT_TEXT)?$DISCOUNT_TEXT:"DISCOUNT"),
            "{{SHIPPING_TEXT}}"                             => (!empty($SHIPPING_TEXT)?$SHIPPING_TEXT:"SHIPPING"),
            "{{GRAND_TOTAL_TEXT}}"                          => (!empty($GRAND_TOTAL_TEXT)?$GRAND_TOTAL_TEXT:"TOTAL"),
            "{{ORDER_NUMBER_$id}}"                          => $id,
            "{{ORDER_DATE_$id}}"                            => $this->processOrderDate($order),
            "{{INVOICE_NUMBER_$id}}"                        => get_post_meta($id,"wpifw_invoice_no",true),
            "{{INVOICE_DATE_$id}}"                          => $this->processInvoiceDate($order),
            "{{SUBTOTAL_$id}}"                              => $this->formatPrice($subtotal,$order['id']),
            "{{REFUND_$id}}"                                => $this->formatPrice($refund_total,$order['id']),
            "{{TAX_$id}}"                                   => (!empty($order['total_tax']))?$this->formatPrice(($order['total_tax']+$line_subtotal_tax),$order['id']):"",
            "{{DISCOUNT_$id}}"                              => (!empty($order['discount_total']))?$this->formatPrice($order['discount_total'],$order['id']):"",
            "{{SHIPPING_$id}}"                              => (!empty($order['shipping_total']))?$this->formatPrice($order['shipping_total'],$order['id']):"",
            "{{GRAND_TOTAL_$id}}"                           => $this->formatPrice(($order['total']+$refund_total+$line_subtotal_tax),$order['id']),
            "{{CURRENCY}}"                                  => $this->getCurrencyCode($order['id']),
            "{{ORDER_METHOD_$id}}"                          => $order['shipping_method'],
            "{{WEIGHT}}"                                    => "WEIGHT",
            "{{WEIGHT_$id}}"                                => "WEIGHT_$id",
            "{{INVOICE}}"                                   => (!empty($INVOICE_TITLE)?$INVOICE_TITLE:"INVOICE"),
            "{{PACKING_SLIP_TEXT}}"                         => (!empty($PACKING_SLIP_TEXT)?$PACKING_SLIP_TEXT:"PACKING SLIP"),
            "{{PACKING_SLIP_ORDER_NUMBER_TEXT}}"            => (!empty($PACKING_SLIP_ORDER_NUMBER_TEXT)?$PACKING_SLIP_ORDER_NUMBER_TEXT:"ORDER NUMBER"),
            "{{PACKING_SLIP_ORDER_DATE_TEXT}}"              => (!empty($PACKING_SLIP_ORDER_DATE_TEXT)?$PACKING_SLIP_ORDER_DATE_TEXT:"ORDER DATE"),
            "{{PACKING_SLIP_ORDER_METHOD_TEXT}}"            => (!empty($PACKING_SLIP_ORDER_METHOD_TEXT)?$PACKING_SLIP_ORDER_METHOD_TEXT:"SHIPPING METHOD"),
            "{{PACKING_SLIP_PRODUCT_TEXT}}"                 => (!empty($PACKING_SLIP_PRODUCT_TEXT)?$PACKING_SLIP_PRODUCT_TEXT:"PRODUCT"),
            "{{PACKING_SLIP_WEIGHT_TEXT}}"                  => (!empty($PACKING_SLIP_WEIGHT_TEXT)?$PACKING_SLIP_WEIGHT_TEXT:"WEIGHT"),
            "{{PACKING_SLIP_QUANTITY_TEXT}}"                => (!empty($PACKING_SLIP_QUANTITY_TEXT)?$PACKING_SLIP_QUANTITY_TEXT:"QUANTITY"),
            "{{LOGO_HEIGHT}}"                               => (!empty($LOGO_HEIGHT))? $LOGO_HEIGHT . '%':"",
            "{{LOGO_WIDTH}}"                                => (!empty($LOGO_WIDTH))? $LOGO_WIDTH . '%':"",
            "{{TERMS_AND_CONDITION}}"                       => (!empty($TERMS_AND_CONDITION))? $TERMS_AND_CONDITION:"",
            "{{OTHER_INFORMATION}}"                         => (!empty($OTHER_INFORMATION))? $OTHER_INFORMATION:"",
            "{{INVOICE_PAYMENT_METHOD_TITLE_TEXT}}"         => (!empty($PAYMENT_METHOD_TEXT))? $PAYMENT_METHOD_TEXT:"PAYMENT METHOD",
            "{{INVOICE_PAYMENT_METHOD_TITLE_TEXT_$id}}"     => (!empty($order['payment_method_title']))? $order['payment_method_title']:"",
            "{{ORDER_NOTE}}"                                => $this->get_order_note($order['id']),

            //Woo Hook Insert
            "{{WOO_INVOICE_BEFORE_DOCUMENT}}"               => $this->woo_invoice_before_document($id),
            "{{WOO_INVOICE_AFTER_DOCUMENT}}"                => $this->woo_invoice_after_document($id),
            "{{WOO_INVOICE_AFTER_DOCUMENT_LABEL}}"          => $this->woo_invoice_after_document_label($id),
            "{{WOO_INVOICE_BEFORE_BILLING_ADDRESS}}"        => $this->woo_invoice_before_billing_address($id),
            "{{WOO_INVOICE_AFTER_BILLING_ADDRESS}}"         => $this->woo_invoice_after_billing_address($id),
            "{{WOO_INVOICE_BEFORE_ORDER_DATA}}"             => $this->woo_invoice_before_order_data($id),
            "{{WOO_INVOICE_AFTER_ORDER_DATA}}"              => $this->woo_invoice_after_order_data($id),
            "{{WOO_INVOICE_BEFORE_ORDER_DETAILS}}"          => $this->woo_invoice_before_order_details($id),
            "{{WOO_INVOICE_AFTER_ORDER_DETAILS}}"           => $this->woo_invoice_after_order_details($id),
            "{{WOO_INVOICE_BEFORE_CUSTOMER_NOTES}}"         => $this->woo_invoice_before_customer_notes($id),
            "{{WOO_INVOICE_AFTER_CUSTOMER_NOTES}}"          => $this->woo_invoice_after_customer_notes($id),

            "{{WOO_INVOICE_CUSTOM_STYLE}}"                  => $this->woo_invoice_custom_style(),

            "{{WOO_PACKING_SLIP_CUSTOM_STYLE}}"             => $this->woo_packing_slip_custom_style($id),

            "{{WOO_PACKING_SLIP_BEFORE_DOCUMENT}}"          => $this->woo_packing_slip_before_document($id),
            "{{WOO_PACKING_SLIP_AFTER_DOCUMENT}}"           => $this->woo_packing_slip_after_document($id),
            "{{WOO_PACKING_SLIP_AFTER_DOCUMENT_LABEL}}"     => $this->woo_packing_slip_after_document_label($id),
            "{{WOO_PACKING_SLIP_BEFORE_BILLING_ADDRESS}}"   => $this->woo_packing_slip_before_billing_address($id),
            "{{WOO_PACKING_SLIP_AFTER_BILLING_ADDRESS}}"    => $this->woo_packing_slip_after_billing_address($id),
            "{{WOO_PACKING_SLIP_BEFORE_ORDER_DATA}}"        => $this->woo_packing_slip_before_order_data($id),
            "{{WOO_PACKING_SLIP_AFTER_ORDER_DATA}}"         => $this->woo_packing_slip_after_order_data($id),
            "{{WOO_PACKING_SLIP_BEFORE_ORDER_DETAILS}}"     => $this->woo_packing_slip_before_order_details($id),
            "{{WOO_PACKING_SLIP_AFTER_ORDER_DETAILS}}"      => $this->woo_packing_slip_after_order_details($id),

        );

        # Replace Order Information
        $html = str_replace( array_keys( $textToReplace ), array_values( $textToReplace ), $string );
        # Replace Product Information
        $html = str_replace( array_keys( $pInfoReplace ), array_values( $pInfoReplace ), $html );

        return $html;
    }


    /**
     * Get Individual product weight for making invoice/ invoice slip
     * @param $product
     * @return string
     */
    public function getProductWeight($product){

        $weight=$product->get_weight();
        $weight = wc_format_weight($weight);
        return $weight;
    }

    /**
     * Get Currency code (Ex. USD)
     * @param $orderId
     * @return string
     */
    public function getCurrencyCode($orderId) {
        if(!empty(get_option("wpifw_currency_code"))){
            return '('.wc_get_order($orderId)->get_currency(). ')';
        } else {
            return '';
        }
    }

    /**
     * Get Order Note of each order for invoice
     * @param $orderId
     * @return string
     */
    public function get_order_note($orderId) {
        if(get_option("wpifw_show_order_note") == '1' && !empty(wc_get_order($orderId)->get_customer_note())){
            return "<p style='margin-top:10px;margin-left:5px;'>Order Note: ".wc_get_order($orderId)->get_customer_note()."</p>";
        } else {
            return '';
        }
    }

    /**
     * Format product price with currency symbol
     *
     * @param $price
     * @param $orderId
     *
     * @return string
     */
    public function formatPrice($price,$orderId = null) {

        //$price = wc_format_decimal($price . '.00', wc_get_price_decimals());

//        if(!empty(get_option("wpifw_currency_symbol"))){
            return sprintf(get_woocommerce_price_format(), '<span style="font-family: Currencies">'.get_woocommerce_currency_symbol(wc_get_order($orderId)->get_currency()).'</span>', $price);
//        }else{
//            return wc_price($price);
//        }
    }


    #TODO Remove the below method after version 2.0
    public function replaceOldBuyerAddress()
    {
        $buyerAddress=get_option('wpifw_buyer');

        $newAddress=str_replace(
            array('{{first_name}}','{{last_name}}','{{company}}','{{address_1}}','{{address_2}}','{{city}}','{{postcode}}','{{state}}','{{country}}','{{phone}}','{{email}}',),
            array('{{billing_first_name}}','{{billing_last_name}}','{{billing_company}}','{{billing_address_1}}','{{billing_address_2}}','{{billing_city}}','{{billing_postcode}}','{{billing_state}}','{{billing_country}}','{{billing_phone}}','{{billing_email}}',),
            $buyerAddress
        );

        update_option('wpifw_buyer',$newAddress);

    }


    /**
     * Save PDF Invoice to Upload directory
     * @param $invoiceId
     * @return string
     * @throws \Mpdf\MpdfException
     */
    public function savePdf($invoiceId) {

        #TODO Remove the below method after version 2.0
        $this->replaceOldBuyerAddress();

        $upload  = wp_upload_dir();
        $baseDir = $upload['basedir'];

        ob_start();
        $orders = $this->orderInfo;
        if($orders){
            echo $this->getTemplateContent('invoice',$orders);
        }
        $html = ob_get_contents();
        ob_end_clean();

        $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => $baseDir,
            'fontDir' => array_merge($fontDirs, [
                plugin_dir_path(__FILE__) . 'templates/fonts',
            ]),
            'fontdata' => $fontData + [
                    'Lato' => [
                        'R' => "Lato-Regular.ttf",
                        'B' => "Lato-Bold.ttf",
                        'I' => "Lato-Italic.ttf",
                        'BI' => "Lato-BoldItalic.ttf",
                    ]
                ],
            'default_font' => 'Lato',
            'mode' => 'utf-8',
            'format'=>'A4'
        ]);


        $mpdf->shrink_tables_to_fit=0;
        $mpdf->WriteHTML($html);
        return $mpdf->Output(WPIFW_INVOICE_DIR."Invoice-".$invoiceId.".pdf","F");
    }

    /** Set date format according to plugin settings
     * @param $order
     * @return mixed
     */
    public function processOrderDate( $order) {
        $date=$order['date_created'];

        $format="d M, o";
        $getFormat=get_option("wpifw_date_format");
        if(!empty($getFormat)){
            $format=$getFormat;
        }
        return  $date->date($format);

    }

    /**
     * Get invoice date according to plugin settings
     * @param $order
     * @return string
     */

    public function processInvoiceDate( $order) {
        #TODO get plugins date format settings
        $date=$order['date_completed'];


        if(!empty($date)) {
            $format="d M, o";
            $getFormat=get_option("wpifw_date_format");
            if(!empty($getFormat)){
                $format=$getFormat;
            }
            return  $date->date($format);
        } else {
            return "";
        } 

    }

    /**
     * Set billing address according to plugin settings
     *
     * @param $order
     *
     * @return string
     */
    public function processBillingAddress($order) {

        $details=sanitize_textarea_field(get_option("wpifw_buyer"));

        $toReplace=array(
            "{{billing_first_name}}",
            "{{billing_last_name}}",
            "{{billing_company}}",
            "{{billing_address_1}}",
            "{{billing_address_2}}",
            "{{billing_city}}",
            "{{billing_state}}",
            "{{billing_postcode}}",
            "{{billing_country}}",
            "{{billing_phone}}",
            "{{billing_email}}",
            "{{shipping_first_name}}",
            "{{shipping_last_name}}",
            "{{shipping_company}}",
            "{{shipping_address_1}}",
            "{{shipping_address_2}}",
            "{{shipping_city}}",
            "{{shipping_state}}",
            "{{shipping_postcode}}",
            "{{shipping_country}}",
            "{{shipping_phone}}",
            "{{shipping_email}}",
        );
        $replaceWith=array(
            !empty($order['billing']['first_name'])?$order['billing']['first_name']:"",
            !empty($order['billing']['last_name'])?$order['billing']['last_name']:"",
            !empty($order['billing']['company'])?$order['billing']['company']:"",
            !empty($order['billing']['address_1'])?$order['billing']['address_1']:"",
            !empty($order['billing']['address_2'])?$order['billing']['address_2']:"",
            !empty($order['billing']['city'])?$order['billing']['city']:"",
            !empty($order['billing']['state'])?$this->getStateLabel($order['shipping']['country'],$order['billing']['state']):"",
            !empty($order['billing']['postcode'])?$order['billing']['postcode']:"",
            !empty($order['billing']['country'])?$this->getCountryLabel($order['billing']['country']):"",
            !empty($order['billing']['phone'])?$order['billing']['phone']:"",
            !empty($order['billing']['email'])?$order['billing']['email']:"",
            !empty($order['shipping']['first_name'])?$order['shipping']['first_name']:$this->replaceShippingAddress($order['billing']['first_name']),
            !empty($order['shipping']['last_name'])?$order['shipping']['last_name']:$this->replaceShippingAddress($order['billing']['last_name']),
            !empty($order['shipping']['company'])?$order['shipping']['company']:$this->replaceShippingAddress($order['billing']['company']),
            !empty($order['shipping']['address_1'])?$order['shipping']['address_1']:$this->replaceShippingAddress($order['billing']['address_1']),
            !empty($order['shipping']['address_2'])?$order['shipping']['address_2']:$this->replaceShippingAddress($order['billing']['address_2']),
            !empty($order['shipping']['city'])?$order['shipping']['city']:$this->replaceShippingAddress($order['billing']['city']),
            !empty($order['shipping']['state'])?$this->getStateLabel($order['shipping']['country'],$order['shipping']['state']):$this->replaceShippingAddress($order['billing']['state']),
            !empty($order['shipping']['postcode'])?$order['shipping']['postcode']:$this->replaceShippingAddress($order['billing']['postcode']),
            !empty($order['shipping']['country'])?$this->getCountryLabel($order['shipping']['country']):$this->replaceShippingAddress($order['billing']['country']),
            !empty($order['shipping']['phone'])?$order['shipping']['phone']:$this->replaceShippingAddress($order['billing']['phone']),
            !empty($order['shipping']['email'])?$order['shipping']['email']:$this->replaceShippingAddress($order['billing']['email']),
        );

        # Get the translated title for TO
        $to=get_option("wpifw_block_title_to");
        # Replace Billing information according to customers settings
        $address=str_replace($toReplace,$replaceWith,$details);
        # Remove Empty Line
        $address = preg_replace("/\n\n/","\n",$address);
        $address = preg_replace("/\r\n|\r|\n/",'<br>',$address);
        return "<b>".$to."</b><br>".$address;
    }

    /**
     * if shipping informations are empty, replace with billing informations
     * @param $args
     * @return string
     */

    public function replaceShippingAddress ($args) {
        if(!empty($args)) {
            return $args;
        } else {
            return "==";
        }
    }

    /**
     * Get Country label by country code
     * @param $countryCode
     *
     * @return mixed
     */
    private function getCountryLabel($countryCode)
    {
        if(empty($countryCode)){
            return;
        }

        $Countries=$this->countries->get_countries();
        return $Countries[$countryCode];
    }

    /**
     * Get State label by Country code and State code
     * @param $countryCode
     * @param $stateCode
     *
     * @return mixed
     */
    private function getStateLabel($countryCode,$stateCode)
    {
        if(empty($countryCode) || empty($stateCode)){
            return;
        }

        $states=$this->countries->get_states($countryCode);
        return $states[$stateCode];
    }

    /**
     * Format Product Name
     * @param $name
     * @param $sku
     * @param $id
     * @return string
     */
    public function processProductInfo($name,$sku,$id ) {
        $pName='';

        // Action Before the item meta (for each item in the order details table) for action
        $pName .= '<p>';
        if ($this->woo_invoice_before_item_meta( $id ) && $this->woo_packing_slip_before_item_meta( $id )){
            $pName = $this->woo_invoice_before_item_meta( $id );
        }else{
            $pName = $this->woo_invoice_before_item_meta( $id );
            $pName = $this->woo_packing_slip_before_item_meta( $id );
        }
        $pName .= '</p>';

        $product_title_length = get_option("wpifw_invoice_product_title_length");
        if(strlen($name)>$product_title_length && $product_title_length != false && $product_title_length != ""){
            $name =substr($name,0,$product_title_length). "...";
            $pName .= '<p>'.$name;
        } else {
            $pName .= '<p>'.$name;
        }

        $displayInfo=get_option("wpifw_disid");
        if(!empty($displayInfo)){
            if($displayInfo=="ID"){
                $pName.="<br/><span style='font-size: x-small;color: #525659;'>ID: $id</span>";
            }elseif ($displayInfo=="SKU"){
                if(!empty($sku)){
                    $pName.="<br/><span style='font-size: x-small;color: #525659;'>SKU: ".$sku."</span>";
                }

            }
        }

        // Action After the item meta (for each item in the order details table) for action
        $pName .= '<p>';
        if ($this->woo_invoice_after_item_meta( $id ) && $this->woo_packing_slip_after_item_meta( $id )){
            $pName .= $this->woo_invoice_after_item_meta( $id );
        }else{
            $pName .= $this->woo_invoice_after_item_meta( $id );
            $pName .= $this->woo_packing_slip_after_item_meta( $id );
        }
        $pName .= '</p>';

        return $pName;
    }

    /**
     * Set shipping address according to plugin settings
     */
    public function processShippingAddress( ) {

    }

    /**
     * Set invoice number according to plugin settings
     */
    public function processInvoiceNumber(  ) {

    }

    /**
     * Set order number according to plugin settings
     */
    public function processOrderNumber(  ) {

    }

    /**
     * Resize store logo according to plugin settings
     */
    public function resizeStoreLogo() {
        if(get_option( 'wpifw_logo_attachment_id' ) != false){

            if(substr(get_option( 'wpifw_logo_attachment_id' ), 0, 7 ) === "http://" || substr(get_option( 'wpifw_logo_attachment_id' ), 0, 8 ) === "https://"){
                $image_id = attachment_url_to_postid( get_option( 'wpifw_logo_attachment_id' ) );
                $fullsize_path = get_attached_file( $image_id );
                update_option("wpifw_logo_attachment_id",$fullsize_path);
                update_option('wpifw_logo_attachment_image_id',$image_id);
            }
            return get_option( 'wpifw_logo_attachment_id' );//get_option("wpifw_store_logo");
        } else {
            if(has_custom_logo()) {
                $custom_logo_id = get_theme_mod( 'custom_logo' );
                $custom_logo_url = wp_get_attachment_image_url( $custom_logo_id , 'full' );
                return $custom_logo_url;
            }
        }
    }

    /**
     * Set store logo according to plugin settings
     */
    public function invoiceText(  ) {

    }

    /**
     * Set product Information according to plugin settings
     */
    public function productInformation(  ) {

    }

    /**
     * Customer Info according to plugin settings
     */
    public function BuyerInfo(  ) {

    }

    /**
     * Seller Info according to plugin settings
     */
    public function SellerInfo( ) {
        $from=get_option("wpifw_block_title_from");
        $company=get_option("wpifw_cname");
        $address=str_replace("\n","<br>",sanitize_textarea_field(stripslashes(get_option("wpifw_cdetails"))));

        return "<b>$from</b><br>$company<br>$address";
    }

    /**
     * Set localization value according to plugin settings
     */
    public function localization(  ) {

    }



    //Woo Hook
    /**
     * Set Data Before all content on the document
     *
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_invoice_before_document($orderId) {
        $order = ($orderId) ? wc_get_order($orderId) : null;
        ob_start();
        //do_action('woo_invoice_before_document', $order);
        do_action( 'woo_invoice_before_document', $order, 'invoice' );
        return ob_get_clean();
    }

    /**
     * Set Data After all content on the document
     *
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_invoice_after_document($orderId) {
        $order = ($orderId) ? wc_get_order($orderId) : null;
        ob_start();
        do_action( 'woo_invoice_after_document', $order, 'invoice' );
        return ob_get_clean();
    }

    /**
     * Set Data After the document label (Invoice, Packing Slip etc.)
     *
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_invoice_after_document_label($orderId) {
        $order = ($orderId) ? wc_get_order($orderId) : null;
        ob_start();
        do_action( 'woo_invoice_after_document_label', $order, 'invoice' );
        return ob_get_clean();
    }

    /**
     * Set Data Before the billing address
     *
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_invoice_before_billing_address($orderId) {
        $order = ($orderId) ? wc_get_order($orderId) : null;
        ob_start();
        do_action( 'woo_invoice_before_billing_address', $order, 'invoice' );
        return ob_get_clean();
    }

    /**
     * Set Data After the billing address
     *
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_invoice_after_billing_address($orderId) {
        $order = ($orderId) ? wc_get_order($orderId) : null;
        ob_start();
        do_action( 'woo_invoice_after_billing_address', $order, 'invoice' );
        return ob_get_clean();
    }

    /**
     * Set Data Before the order data (invoice number, order date, etc.)
     *
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_invoice_before_order_data($orderId) {
        $order = ($orderId) ? wc_get_order($orderId) : null;
        ob_start();
        do_action( 'woo_invoice_before_order_data', $order, 'invoice' );
        return ob_get_clean();
    }

    /**
     * Set Data After the order data
     *
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_invoice_after_order_data($orderId) {
        $order = ($orderId) ? wc_get_order($orderId) : null;
        ob_start();
        do_action( 'woo_invoice_after_order_data', $order, 'invoice' );
        return ob_get_clean();
    }

    /**
     * Set Data Before the order details table with all items
     *
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_invoice_before_order_details($orderId) {
        $order = ($orderId) ? wc_get_order($orderId) : null;
        ob_start();
        do_action( 'woo_invoice_before_order_details', $order, 'invoice' );
        return ob_get_clean();
    }

    /**
     * Set Data After the order details table
     *
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_invoice_after_order_details($orderId) {
        $order = ($orderId) ? wc_get_order($orderId) : null;
        ob_start();
        do_action( 'woo_invoice_after_order_details', $order, 'invoice' );
        return ob_get_clean();
    }

    /**
     * Set Data Before the item meta (for each item in the order details table)
     *
     * @param $productId Product ID
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_invoice_before_item_meta( $productId, $orderId = null ) {
        ob_start();
        do_action( 'woo_invoice_before_item_meta', $productId, 'invoice' );
        return ob_get_clean();
    }

    /**
     * Set Data After the item meta (for each item in the order details table)
     *
     * @param $productId Product ID
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_invoice_after_item_meta( $productId, $orderId = null ) {
        ob_start();
        do_action( 'woo_invoice_after_item_meta', $productId, 'invoice' );
        return ob_get_clean();
    }

    /**
     * Set Data Before the customer/shipping notes
     *
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_invoice_before_customer_notes($orderId) {
        $order = ($orderId) ? wc_get_order($orderId) : null;
        ob_start();
        do_action( 'woo_invoice_before_customer_notes', $order, 'invoice' );
        return ob_get_clean();
    }

    /**
     * Set Data After the customer/shipping notes
     *
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_invoice_after_customer_notes($orderId) {
        $order = ($orderId) ? wc_get_order($orderId) : null;
        ob_start();
        do_action( 'woo_invoice_after_customer_notes', $order, 'invoice' );
        return ob_get_clean();
    }

    /**
     * Set Data After the customer/shipping notes
     *
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_invoice_custom_style() {
        ob_start();
        do_action( 'woo_invoice_custom_style', 'invoice' );
        return ob_get_clean();
    }


    /**
     * Set Data After the customer/shipping notes
     *
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_packing_slip_custom_style() {
        ob_start();
        do_action( 'woo_invoice_custom_style', 'packing-slip' );
        return ob_get_clean();
    }


    //Woo Packing Slip Hook
    /**
     * Set Data Before all content on the document
     *
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_packing_slip_before_document($orderId) {
        $order = ($orderId) ? wc_get_order($orderId) : null;
        ob_start();
        do_action( 'woo_invoice_before_document', $order, 'packing-slip' );
        return ob_get_clean();
    }

    /**
     * Set Data After all content on the document
     *
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_packing_slip_after_document($orderId) {
        $order = ($orderId) ? wc_get_order($orderId) : null;
        ob_start();
        do_action( 'woo_invoice_after_document', $order, 'packing-slip' );
        return ob_get_clean();
    }

    /**
     * Set Data After the document label (Invoice, Packing Slip etc.)
     *
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_packing_slip_after_document_label($orderId) {
        $order = ($orderId) ? wc_get_order($orderId) : null;
        ob_start();
        do_action( 'woo_invoice_after_document_label', $order, 'packing-slip' );
        return ob_get_clean();
    }

    /**
     * Set Data Before the billing address
     *
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_packing_slip_before_billing_address($orderId) {
        $order = ($orderId) ? wc_get_order($orderId) : null;
        ob_start();
        do_action( 'woo_invoice_before_billing_address', $order, 'packing-slip' );
        return ob_get_clean();
    }

    /**
     * Set Data After the billing address
     *
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_packing_slip_after_billing_address($orderId) {
        $order = ($orderId) ? wc_get_order($orderId) : null;
        ob_start();
        do_action( 'woo_invoice_after_billing_address', $order, 'packing-slip' );
        return ob_get_clean();
    }

    /**
     * Set Data Before the order data (invoice number, order date, etc.)
     *
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_packing_slip_before_order_data($orderId) {
        $order = ($orderId) ? wc_get_order($orderId) : null;
        ob_start();
        do_action( 'woo_invoice_before_order_data', $order, 'packing-slip' );
        return ob_get_clean();
    }

    /**
     * Set Data After the order data
     *
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_packing_slip_after_order_data($orderId) {
        $order = ($orderId) ? wc_get_order($orderId) : null;
        ob_start();
        do_action( 'woo_invoice_after_order_data', $order, 'packing-slip' );
        return ob_get_clean();
    }

    /**
     * Set Data Before the order details table with all items
     *
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_packing_slip_before_order_details($orderId) {
        $order = ($orderId) ? wc_get_order($orderId) : null;
        ob_start();
        do_action( 'woo_invoice_before_order_details', $order, 'packing-slip' );
        return ob_get_clean();
    }

    /**
     * Set Data After the order details table
     *
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_packing_slip_after_order_details($orderId) {
        $order = ($orderId) ? wc_get_order($orderId) : null;
        ob_start();
        do_action( 'woo_invoice_after_order_details', $order, 'packing-slip' );
        return ob_get_clean();
    }

    /**
     * Set Data Before the item meta (for each item in the order details table)
     *
     * @param $productId Product ID
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_packing_slip_before_item_meta( $productId, $orderId = null ) {
        ob_start();
        do_action('woo_invoice_before_item_meta', $productId, 'packing-slip' );
        return ob_get_clean();
    }

    /**
     * Set Data After the item meta (for each item in the order details table)
     *
     * @param $productId Product ID
     * @param $orderId Order ID
     *
     * @return string
     */
    private function woo_packing_slip_after_item_meta( $productId, $orderId = null ) {
        ob_start();
        do_action('woo_invoice_after_item_meta', $productId, 'packing-slip' );
        return ob_get_clean();
    }



}

# Initialize Invoice Engine
function WPIFW_PDF($orderIds){
    return $invoice = new Webappick_Pdf_Invoice_Engine($orderIds);
}