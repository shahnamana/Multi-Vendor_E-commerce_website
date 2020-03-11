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



class Webappick_Pdf_Invoice_Hooks {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      Webappick_Pdf_Invoice_Engine $orderId store all order ids.
	 */

	public function __construct(  ) {

		if(!empty(get_option("wpifw_invoicing"))){

			# Filter to add Download Invoice button
			if(!empty(get_option("wpifw_download"))) {
				add_filter( 'woocommerce_my_account_my_orders_actions', array($this,"add_my_account_order_action_download_invoice"), 10, 2 );
			}

			# Filter to add Invoice attachment with order email
            if(!empty(get_option("wpifw_order_email"))){
			    add_filter( 'woocommerce_email_attachments', array($this,"attach_invoice_to_order_email"), 90, 4);
                # Filter to add Invoice download link with order email
                add_filter( 'woocommerce_email_after_order_table', array($this,"add_invoice_download_link"), 91, 4);
            }
			# Add Custom MetaBox for PDF Download Button
			add_action("add_meta_boxes", array($this,"add_custom_meta_box"));

			# Register bulk Invoice Making action
			add_filter( 'bulk_actions-edit-shop_order',array($this,"register_bulk_invoice_actions"),11 );

            # Register bulk Invoice Packing Slip Making action
            add_filter( 'bulk_actions-edit-shop_order',array($this,"register_bulk_invoice_packing_slip_actions"),11 );

            # Handle bulk Invoice Making action
			add_filter( 'handle_bulk_actions-edit-post',array($this,"invoice_bulk_action_handler"), 10, 3 );

			# Add a create/view invoice button on admin orders page
			//add_action( 'woocommerce_admin_order_actions_end', array( $this, 'add_back_end_invoice_buttons' ) );

			# Add a create/view invoice packing slip button on admin orders page
			//add_action( 'woocommerce_admin_order_actions_end', array( $this, 'add_back_end_invoice_buttons_packing_slip' ) );

			# Add invoice number to order
			add_action( 'woocommerce_new_order', array( $this, 'add_invoice_number_to_order' ) );
            //add_action( 'woocommerce_order_status_completed', array( $this, 'add_invoice_number_to_order' ) );
            //add_action( 'woocommerce_order_status_cancelled', array( $this, 'add_invoice_number_to_order' ) );


			add_action( 'admin_footer',array($this,"logo_selector_print_scripts"));

            # Add Invoice Download in Order Complete Page
            /*if(!empty(get_option("wpifw_download"))) {
                add_action('woocommerce_thankyou', 'woo_invoice_download_thank_you_page', 20);
            }*/

            # Add Invoice Download in Order Detail Page
            if(!empty(get_option("wpifw_download"))) {
                add_action('woocommerce_order_details_after_order_table', 'woo_invoice_download_view_order_page');
            }
		}
	}


	/**
	 * Add Download Invoice button into My Account Order Actions for Customer
	 *
	 * @param $actions
	 * @param $order
	 *
	 * @return mixed
	 */
	public function add_my_account_order_action_download_invoice( $actions, $order ) {

        if($order->is_paid()){
            $order_id = method_exists( $order, 'get_id' ) ? $order->get_id() : $order->id;
            $actions['wpifw-my-account-invoice'] = array(
                // adjust URL as needed
                'url' => wp_nonce_url( admin_url( 'admin-ajax.php?action=wpifw_generate_invoice&order_id=' . $order_id ), 'webappick-pdf-invoice-for-woocommerce' ),
                'name' => __( 'Download Invoice', 'woo-invoice' ),
                "class" => "wpifw_invoice_action_button"
            );
        }

		return $actions;
	}



    /**
	 * Register MetaBox to add PDF Download Button
	 */
	public function add_custom_meta_box()
	{
		add_meta_box("wpifw-meta-box", "Invoice & Packing Slip", array($this,"pdf_meta_box_markup"), "shop_order", "side", "high", null);
	}



	/**
	 * Add PDF Download button to MetaBox &
     * Add PDF Packing Slip button to Meta Box
	 */
	function pdf_meta_box_markup($object)
	{
		wp_nonce_field(basename(__FILE__), "meta-box-nonce");
		global $post;
		$invoice = wp_nonce_url( admin_url( 'admin-ajax.php?action=wpifw_generate_invoice&order_id=' . $post->ID ), 'webappick-pdf-invoice-for-woocommerce' );
		$invoicePackingSlip = wp_nonce_url( admin_url( 'admin-ajax.php?action=wpifw_generate_invoice_packing_slip&order_id=' . $post->ID ), 'webappick-pdf-invoice-for-woocommerce' );
		?>
        <div class="wpifw_invoice_info">
            <a href="<?php echo $invoice; ?>" target="_blank"><button type="button"  class="wpifw_button_invoice button"><?php _e('Invoice', 'webappick-pdf-invoice-for-woocommerce'); ?></button></a>
            <a href="<?php echo $invoicePackingSlip; ?>" target="_blank"><button type="button"  class="wpifw_button_invoice_packing_slip button"><?php _e('Packing Slip', 'webappick-pdf-invoice-for-woocommerce'); ?></button></a>
        </div>

		<?php
	}


	/**
	 * Add PDF Invoice bulk action to order list action &
     * Add PDF Invoice Packing Slip bulk to order list action
	 */
	public function invoice_bulk_action_handler( $redirect_to, $doaction, $post_ids ) {
		if ( $doaction !== 'wpifw_bulk_invoice' ) {
			return $redirect_to;
		}
        if ( $doaction !== 'wpifw_bulk_invoice_packing_slip' ) {
            return $redirect_to;
        }
		foreach ( $post_ids as $post_id ) {
			// Perform action for each post.
		}
		$redirect_to = add_query_arg( 'bulk_emailed_posts', count( $post_ids ), $redirect_to );
		return $redirect_to;
	}

	/**
	 * Register bulk invoice making action
	 */
	function register_bulk_invoice_actions($bulk_actions) {
		$bulk_actions['wpifw_bulk_invoice'] = __( 'Make PDF Invoice', 'woo-invoice');
		return $bulk_actions;
	}

    /**  Register bulk invoice packing slip making action
     * @param $bulk_actions
     * @return mixed
     */
    function register_bulk_invoice_packing_slip_actions($bulk_actions) {
        $bulk_actions['wpifw_bulk_invoice_packing_slip'] = __( 'Make Packing Slip', 'woo-invoice');
        return $bulk_actions;
    }

	/**
	 * Add shipping list actions to the orders listing
	 *
	 * @param WC_Order $order
	 */
	public function add_back_end_invoice_buttons( $order ) {

		// Get Order ID (compatibility all WC versions)
		$order_id = method_exists( $order, 'get_id' ) ? $order->get_id() : "";

		$url   = wp_nonce_url( admin_url( 'admin-ajax.php?action=wpifw_generate_invoice&order_id=' . $order_id ), 'wpifw_generate_invoice' );
		$text  = __( "PDF Invoice", 'woo-invoice' );
		$class = "tips parcial wpifw_invoice wpifw_invoice_action_button";

		echo '<a href="' . $url . '" class="button ' . $class . '" data-tip="' . $text . '" title="' . $text . '">' . $text . '</a>';

	}

    /**
     * Add shipping list packing slip actions to the orders listing
     *
     * @param WC_Order $order
     */
    public function add_back_end_invoice_buttons_packing_slip( $order ) {

        // Get Order ID (compatibility all WC versions)
        $order_id = method_exists( $order, 'get_id' ) ? $order->get_id() : "";

        $url   = wp_nonce_url( admin_url( 'admin-ajax.php?action=wpifw_generate_invoice_packing_slip&order_id=' . $order_id ), 'wpifw_generate_invoice_packing_slip' );
        $text  = __( "Packing Slip", 'woo-invoice' );
        $class = "tips parcial wpifw_invoice_packing_slip wpifw_button_invoice_packing_slip";

        echo '<a href="' . $url . '" target="_blank"  class="button ' . $class . '" data-tip="' . $text . '" title="' . $text . '">' . $text . '</a>';

    }

    /**
     * Attach Invoice with Order Email
     *
     * @param $attachments
     * @param $status
     * @param $order
     * @return array
     * @throws \Mpdf\MpdfException
     */
	public function attach_invoice_to_order_email($attachments, $status, $order) {

	    if(!$order instanceof WC_Order){
	        return $attachments;
        }

        if($order->is_paid()){
            $orderId= $order->get_id();

            $allowed_statuses = array(
                'new_order',
                'customer_invoice',
                'customer_processing_order',
                'customer_completed_order',
                'customer_completed_renewal_order',
                'customer_processing_renewal_order'
            );

            $invoiceId = get_post_meta($orderId,"wpifw_invoice_no",true);

            # TODO If file exists condition apply , not working
            WPIFW_PDF($orderId)->savePdf($invoiceId);

            if ( isset( $status ) && in_array( $status, $allowed_statuses ) ) {
                $pdf_path = WPIFW_INVOICE_DIR."Invoice-".$invoiceId.".pdf";
                $attachments[] = $pdf_path;
            }
        }

        return $attachments;
	}


    /**
     * @param $order
     * @param $sent_to_admin
     * @param $plain_text
     * @param $email
     */
    public function add_invoice_download_link($order, $sent_to_admin, $plain_text, $email){
        $upload  = wp_upload_dir();
        $baseUrl = $upload['baseurl'];
        $allowed_statuses = array(
            'new_order',
            'customer_invoice',
            'processing',
            'completed',
        );
        $status = $order->get_status();

        if ( method_exists( $order, 'get_id' ) ) {
            $orderId= $order->get_id();
        }else{
            $orderId= isset($order->id) ? $order->id : false;
        }

        $invoiceId = get_post_meta($orderId,"wpifw_invoice_no",true);

        if(file_exists(WPIFW_INVOICE_DIR."Invoice-".$invoiceId.".pdf") &&  (isset( $status ) && in_array( $status, $allowed_statuses ))){
             $downloadLink = $baseUrl.'/WPIFW-INVOICE/'."Invoice-".$invoiceId.".pdf";
             $DOWNLOAD_INVOICE_TEXT=get_option("wpifw_DOWNLOAD_INVOICE_TEXT");
             $DOWNLOAD_INVOICE_TEXT=($DOWNLOAD_INVOICE_TEXT)?$DOWNLOAD_INVOICE_TEXT:"Download Invoice";
             echo ' <a href="'.$downloadLink.'" target="_blank"  class="button wpifw_invoice" data-tip="" title="">'.$DOWNLOAD_INVOICE_TEXT.'</a> <br><br/>';
        }

    }


    /** Add Invoice number to order
     * @param $orderId
     * @throws \Mpdf\MpdfException
     */
	public function add_invoice_number_to_order($orderId) {
	    $getPrefix=get_option("wpifw_invoice_no_prefix");
        $prefix=!empty($getPrefix)?$getPrefix:"";

		$getSuffix=get_option("wpifw_invoice_no_suffix");
		$suffix=!empty($getSuffix)?$getSuffix:"";

		$getNext=get_option("wpifw_invoice_no");
		$nextNo=!empty($getNext)?$getNext:1;

		$invoiceNo=$prefix.$nextNo.$suffix;

		update_option("wpifw_invoice_no",$nextNo+1);
		add_post_meta($orderId,"wpifw_invoice_no",$invoiceNo);
	}


	/**
	 *  Add Logo uploader script to footer
	 */
    public function logo_selector_print_scripts() {

    $my_saved_attachment_post_id = get_option( 'wpifw_logo_selector_attachment_id', 0 );

    ?><script type='text/javascript'>

        jQuery(document).ready(function ($) {

		   jQuery(document).on("click", "#wpifw_upload_logo_button", function (e) {
		      e.preventDefault();
		      var $button = $(this);


		      // Create the media frame.
		      var file_frame = wp.media.frames.file_frame = wp.media({
		         title: 'Select or upload image',
		         library: { // remove these to show all
		            type: 'image' // specific mime
		         },
		         button: {
		            text: 'Select'
		         },
		         multiple: false  // Set to true to allow multiple files to be selected
		      });

		      // When an image is selected, run a callback.
		      file_frame.on('select', function () {
		         // We set multiple to false so only get one image from the uploader

		         var attachment = file_frame.state().get('selection').first().toJSON();

		         console.log(attachment);

		         $( '#wpifw_logo-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
                 $( '#wpifw_logo_attachment_id' ).val( attachment.id );

		         $button.siblings('input').val(attachment.id).change();

		      });

		      // Finally, open the modal
		      file_frame.open();
		   });
		});



    </script>
    <?php
    }

}

/**
 * Add download invoice button in order receive actions.
 *
 * @param int $order_id Order ID
 *
 * @return void
 */
function woo_invoice_download_thank_you_page($order_id)
{
    $url = wp_nonce_url(admin_url('admin-ajax.php?action=wpifw_generate_invoice&order_id=' . $order_id), 'woo-invoice'); ?>
    <a class="woocommerce-button button wpifw-my-account-invoice alignright" href="<?php echo $url; ?>"
       target="_blank"><?php _e('Download Invoice', 'woo-invoice') ?></a>
    <?php
}

/**
 * Add download invoice button in order view actions.
 *
 * @param stdClass $order Order Info
 *
 * @return void
 */
function woo_invoice_download_view_order_page($order)
{
    $order_id = method_exists( $order, 'get_id' ) ? $order->get_id() : $order->id;
    $url = wp_nonce_url(admin_url('admin-ajax.php?action=wpifw_generate_invoice&order_id=' . $order_id), 'woo-invoice'); ?>
    <a class="woocommerce-button button wpifw-my-account-invoice" href="<?php echo $url; ?>"
       target="_blank"><?php _e('Download Invoice', 'woo-invoice') ?></a>
    <?php
}

new Webappick_Pdf_Invoice_Hooks();