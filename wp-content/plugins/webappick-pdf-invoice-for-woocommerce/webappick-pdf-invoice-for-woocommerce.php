<?php
/*
Plugin Name:  Woo Invoice
Plugin URI:   https://webappick.com
Description:  Automatic Generate PDF Invoice and attach  with order email for WooCommerce.
Version:      1.3.4
Author:       WebAppick
Author URI:   https://webappick.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  woo-invoice
Domain Path:  /languages

WP Requirement & Test
Requires at least: 4.4
Tested up to: 5.4-alpha-46743
Requires PHP: 5.6

WC requires at least: 3.2
WC tested up to: 3.9
*/


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */

define( 'WAPDFINVOICE_VERSION', '1.3.4' );

if( ! defined( 'WAPDFINVOICE_FREE_FILE') ) {
    /**
     * Plugin Base File
     * @since 1.2.2
     * @var string
     */
    define( 'WAPDFINVOICE_FREE_FILE', __FILE__ );
}
if( ! defined( 'WAPDFINVOICE_PATH' ) ) {
    /**
     * Plugin Path with trailing slash
     * @var string dirname( __FILE__ )
     */
    /** @define "WAPDFINVOICE_PATH" "./" */
    define( 'WAPDFINVOICE_PATH', plugin_dir_path( __FILE__ ) );
}
if( ! defined( 'WAPDFINVOICE_ADMIN_PATH' ) ) {
    /**
     * Admin File Path with trailing slash
     * @var string
     */
    define( 'WAPDFINVOICE_ADMIN_PATH', WAPDFINVOICE_PATH . 'admin/' );
}
if( ! defined( 'WAPDFINVOICE_LIBS_PATH' ) ) {
    /**
     * Admin File Path with trailing slash
     * @var string
     */
    define( 'WAPDFINVOICE_LIBS_PATH', WAPDFINVOICE_PATH . 'libs/' );
}
if( ! defined( 'WAPDFINVOICE_PLUGIN_URL' ) ) {
    /**
     * Plugin Directory URL
     * @var string
     * @since 1.2.2
     */
    define( 'WAPDFINVOICE_PLUGIN_URL', trailingslashit( plugin_dir_url(__FILE__) ) );
}
if( ! defined( 'WAPDFINVOICE_PLUGIN_BASE_NAME' ) ) {
    /**
     * Plugin Base name..
     * @var string
     * @since 1.2.2
     */
    define( 'WAPDFINVOICE_PLUGIN_BASE_NAME', plugin_basename(__FILE__) );
}

/**
 * Webappick Service API
 */
require WAPDFINVOICE_PATH . 'includes/class-woo-invoice-webappick-api.php';
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-webappick-pdf-invoice-for-woocommerce-activator.php
 */
function activate_webappick_pdf_invoice_for_woocommerce() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-webappick-pdf-invoice-for-woocommerce-activator.php';
    Webappick_Pdf_Invoice_For_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-webappick-pdf-invoice-for-woocommerce-deactivator.php
 */
function deactivate_webappick_pdf_invoice_for_woocommerce() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-webappick-pdf-invoice-for-woocommerce-deactivator.php';
    Webappick_Pdf_Invoice_For_Woocommerce_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_webappick_pdf_invoice_for_woocommerce' );
register_deactivation_hook( __FILE__, 'deactivate_webappick_pdf_invoice_for_woocommerce' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-webappick-pdf-invoice-for-woocommerce.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_webappick_pdf_invoice_for_woocommerce() {

    $plugin = new Webappick_Pdf_Invoice_For_Woocommerce();
    $plugin->run();
	WooInvoiceWebAppickAPI::getInstance();
}
run_webappick_pdf_invoice_for_woocommerce();


// Pages
if ( ! function_exists( 'woo_invoice_pro_vs_free' ) ) {
    /**
     * Difference between free and premium plugin
     */
    function woo_invoice_pro_vs_free(){
        require WAPDFINVOICE_ADMIN_PATH . "partials/woo-invoice-pro-vs-free.php";
    }
}

/**
 * Register PDF Invoice Menu.
 */
function webappick_wpifw_main_menu_page() {
    add_menu_page(__('Woo Invoice', 'webappick-pdf-invoice-for-woocommerce'), __('Woo Invoice', 'webappick-pdf-invoice-for-woocommerce'), 'manage_options', __FILE__, 'webappick_wpifw_pdf_invoice', 'dashicons-media-spreadsheet');
    add_submenu_page(__FILE__, __('Settings', 'webappick-pdf-invoice-for-woocommerce'), __('Settings', 'webappick-pdf-invoice-for-woocommerce'), 'manage_options', __FILE__, 'webappick_wpifw_pdf_invoice');
    add_submenu_page( __FILE__, __('Premium', 'webappick-pdf-invoice-for-woocommerce'), '<span class="woo-invoice-premium">' . __('Premium', 'webappick-pdf-invoice-for-woocommerce') . '</span>', 'manage_woocommerce', 'webappick-invoice-pro-vs-free', 'woo_invoice_pro_vs_free' );
}
add_action( 'admin_menu', 'webappick_wpifw_main_menu_page' );

/**
 * Translate plugin dashboard according to wordpress language.
 */
function webappick_wpifw_plugin_translate() {
    load_plugin_textdomain( 'webappick-pdf-invoice-for-woocommerce', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'webappick_wpifw_plugin_translate' );

/**
 *  Load Plugin settings page, process and save setting
 */
function webappick_wpifw_pdf_invoice(){

    $invoiceAllow = "wpifw_invoicing";
    $emailAllow = "wpifw_order_email";
    $downloadAllow = "wpifw_download";
    $currencyAllow = "wpifw_currency_code";
    $paymentMethod = "wpifw_payment_method_show";
    $orderNote = "wpifw_show_order_note";
    # Process settings form data and update
    if(isset($_POST['wpifw_submit'])){
        $retrieved_nonce = $_REQUEST['_wpnonce'];
        if (!wp_verify_nonce($retrieved_nonce, 'invoice_form_nonce' ) ) die( 'Failed security check' );
        #If not checkbox is not checked then put empty value
        if(!isset($_POST[$invoiceAllow]) || !isset($_POST[$emailAllow]) || !isset($_POST[$downloadAllow]) || !isset($_POST[$currencyAllow]) || !isset($_POST[$paymentMethod]) || !isset($_POST[$orderNote]) ){
            update_option($invoiceAllow,sanitize_textarea_field(""));
            update_option($emailAllow,sanitize_textarea_field(""));
            update_option($downloadAllow,sanitize_textarea_field(""));
            update_option($currencyAllow,sanitize_text_field(""));
            update_option($paymentMethod,sanitize_text_field(""));
            update_option($orderNote,sanitize_text_field(""));
        }
        foreach($_POST as $key=>$value){
                update_option($key,sanitize_text_field($value));
        }
    }

    #Seller&Buyer form submitted, update the option settings
    if(isset($_POST['wpifw_submit_seller&buyer'])){
        $retrieved_nonce = $_REQUEST['_wpnonce'];
        if (!wp_verify_nonce($retrieved_nonce, 'seller_form_nonce' ) ) die( 'Failed security check' );
        foreach($_POST as $key=>$value){
            if($key == "wpifw_terms_and_condition" || $key == "wpifw_other_information"){
                update_option($key,$value);
            } elseif($key=="wpifw_buyer" || $key=="wpifw_cdetails" ) {
                update_option($key,sanitize_textarea_field($value));
            } elseif($key == "wpifw_logo_attachment_id") {
                $fullsize_path = get_attached_file( $value );
                update_option($key,$fullsize_path);
                update_option('wpifw_logo_attachment_image_id',$value);
            } else{
                update_option($key,sanitize_text_field($value));
            }
        }
    }

    #Localization form submitted, update the option settings
    if(isset($_POST['wpifw_submit_localization'])){
        $retrieved_nonce = $_REQUEST['_wpnonce'];
        if (!wp_verify_nonce($retrieved_nonce, 'localization_form_nonce' ) ) die( 'Failed security check' );
        foreach($_POST as $key => $value){
            update_option($key,sanitize_text_field(strtoupper($value)));
        }
    }

    #Batch Download Form submitting checked started
    if(isset($_POST['wpifw_submit_bulk_download'])){
        $retrieved_nonce = $_REQUEST['_wpnonce'];
        if (!wp_verify_nonce($retrieved_nonce, 'bulk_download_form_nonce' ) ) die( 'Failed security check' );
        $args = array(
            'date_created' => $_POST['wpifw_date_from'] . '...' . $_POST['wpifw_date_to'],
            'limit' => -1,
            'return' => 'ids'
        );
        $orderIds = wc_get_orders( $args );

        $orderIds = implode(',',$orderIds);

        session_start();
        $_SESSION['order_ids'] = $orderIds;

        #Bulk type checked and downloads the invoice and slip between the input dates
       if($_POST['wpifw_bulk_type'] == 'WPIFW_INVOICE_DOWNLOAD'){

           /*header("location:".htmlspecialchars_decode(wp_nonce_url( admin_url( 'admin-ajax.php?action=wpifw_generate_invoice&order_id=' . $orderIds ), 'webappick-pdf-invoice-for-woocommerce' )));*/

           header("location:".htmlspecialchars_decode(wp_nonce_url( admin_url( 'admin-ajax.php?action=wpifw_generate_invoice' ), 'webappick-pdf-invoice-for-woocommerce' )));

       }else if($_POST['wpifw_bulk_type'] == 'WPIFW_PACKING_SLIP' ){

           /*header("location:".htmlspecialchars_decode(wp_nonce_url( admin_url( 'admin-ajax.php?action=wpifw_generate_invoice_packing_slip&order_id=' . $orderIds ), 'webappick-pdf-invoice-for-woocommerce' )));
*/
           header("location:".htmlspecialchars_decode(wp_nonce_url( admin_url( 'admin-ajax.php?action=wpifw_generate_invoice_packing_slip' ), 'webappick-pdf-invoice-for-woocommerce' )));
       }

    }

    #Batch Download Form submitting checked ended

    # Load plugin settings view
    require plugin_dir_path(__FILE__) . 'admin/partials/webappick-pdf-invoice-for-woocommerce-admin-display.php';
}



/**
 * Process PDF Invoice Making Action
 */
add_action('wp_ajax_wpifw_generate_invoice', 'webappick_wpifw_generate_invoice');
function webappick_wpifw_generate_invoice($orderIds)
{
    if(isset($_REQUEST['order_id'])){
        $orderIds=sanitize_text_field($_REQUEST['order_id']);
    }elseif (isset($_REQUEST['order_ids'])){
        $orderIds=sanitize_text_field($_REQUEST['order_ids']);
    }

    session_start();
    if(isset($_SESSION['order_ids'])) {
       $orderIds=$_SESSION['order_ids']; 
       unset($_SESSION['order_ids']);
    }

    WPIFW_PDF($orderIds)->generatePDF($orderIds);

}

/**
 * Process PDF Packing slip Making Action
 */
add_action('wp_ajax_wpifw_generate_invoice_packing_slip', 'webappick_wpifw_generate_invoice_packing_slip');
function webappick_wpifw_generate_invoice_packing_slip($orderIds)
{

    if(isset($_REQUEST['order_id'])){
        $orderIds=sanitize_text_field($_REQUEST['order_id']);
    }elseif (isset($_REQUEST['order_ids'])){
        $orderIds=sanitize_text_field($_REQUEST['order_ids']);
    }

    session_start();
    if(isset($_SESSION['order_ids'])) {
       $orderIds=$_SESSION['order_ids']; 
       unset($_SESSION['order_ids']);
    }
    WPIFW_PDF($orderIds)->generatePackingSlip($orderIds);

}

/**
 * Process invoice template number
 */

add_action('wp_ajax_wpifw_save_pdf_template', 'wInvoice_save_pdf_template');
function wInvoice_save_pdf_template() {
    $template = $_POST['template'];
    update_option('wpifw_templateid',$template);
    wp_send_json_success($template);
}

/**
 * review notice layout
 */

add_action( 'admin_notices', 'woo_pdf_review_notice' );

function woo_pdf_review_notice() {

    $options = get_option('woo_pdf_review_notice');
    $notice = '<div class="woo-pdf-review-notice notice notice-info is-dismissible">';
    $notice .= '<div class="woo-pdf-review-notice-left"><img src="'.plugin_dir_url(__FILE__).'admin/images/woo-invoice-only-icon.png" alt="woo-invoice"></div>';
    $notice .= '<div class="woo-pdf-review-notice-right">';
    $notice .= '<p><b>:) We have spent countless hours developing this free plugin for you, and we would really appreciate it if you dropped us a quick rating. Your opinion matters a lot to us. It helps us to get better. Thanks for using PDF Invoice and Packing Slip WooCommerce.</b></p>';
    $notice .= '<ul>';
    $notice .= '<li><a val="given" href="#" target="_blank" style="font-weight:bold">Review Here</a></li>';
    $notice .= '<li><a val="later" href="#">Remind me later</a></li>';
    $notice .= '<li><a val="never" href="#">I would not</a></li>';
    $notice .= '</ul>';
    $notice .= '</div>';
    $notice .= '</div>';
    
    if(!$options && time()>= get_option('woo-invoice-activation-time') + (60*60*24*15)){
        echo $notice;
    }else if(is_array($options)) {
        if((!array_key_exists('review_notice',$options)) || ($options['review_notice'] =='later' && time()>=($options['updated_at'] + (60*60*24*30) )))
            echo $notice;
    }
}


/**
 * Show Review request admin notice
 */
add_action('wp_ajax_save_review_notice', 'woo_pdf_save_review_notice');
function woo_pdf_save_review_notice() {
    $notice = sanitize_text_field($_POST['notice']);
    $value['review_notice'] = $notice;
    $value['updated_at'] = time();

    update_option('woo_pdf_review_notice',$value);
    wp_send_json_success($value);
}

/**
 * Add extra settings link in plugins page
 */

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'woo_invoice_plugin_action_links' );
function woo_invoice_plugin_action_links( $links ) {
    $links[] = '<a style="color:#8e44ad;" href="'.admin_url( 'admin.php?page=webappick-pdf-invoice-for-woocommerce/webappick-pdf-invoice-for-woocommerce.php' ).'" target="_blank">' . __( 'Settings', 'woo-invoice-pro' ) . '</a>';
    $links[] = '<a style="color:green;" href="http://bit.ly/woo-invoice-free" target="_blank">' . __( '<b>Get Pro</b>', 'Woo Invoice' ) . '</a>';
    /*$links[] = '<a style="color:#8e44ad;" href="http://webappick.helpscoutdocs.com/" target="_blank">' . __( 'Documentation', 'Woo Invoice' ) . '</a>';*/
    return $links;
}