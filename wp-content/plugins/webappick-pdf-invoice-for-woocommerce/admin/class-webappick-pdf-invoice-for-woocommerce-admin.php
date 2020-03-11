<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://webappick.com
 * @since      1.0.0
 *
 * @package    Webappick_Pdf_Invoice_For_Woocommerce
 * @subpackage Webappick_Pdf_Invoice_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Webappick_Pdf_Invoice_For_Woocommerce
 * @subpackage Webappick_Pdf_Invoice_For_Woocommerce/admin
 * @author     Md Ohidul Islam <wahid@webappick.com>
 */


class Webappick_Pdf_Invoice_For_Woocommerce_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Webappick_Pdf_Invoice_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Webappick_Pdf_Invoice_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
        wp_enqueue_style( 'slick',  plugin_dir_url(__FILE__) . 'css/slick.css', array(),$this->version );
        wp_enqueue_style( 'slick-theme',  plugin_dir_url(__FILE__) . 'css/slick-theme.css', array(),$this->version );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/webappick-pdf-invoice-for-woocommerce-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'webappick-boilerplate', plugin_dir_url( __FILE__ ) . 'css/webappick-boilerplate-admin.css', array(), $this->version, 'all' );
        wp_enqueue_style( 'flatpickr', plugin_dir_url( __FILE__ ) . 'css/flatpickr.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Webappick_Pdf_Invoice_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Webappick_Pdf_Invoice_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/webappick-pdf-invoice-for-woocommerce-bundle.min.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( 'flatpickr-js', plugin_dir_url( __FILE__ ) . 'js/flatpickr.min.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( 'webappick-pdf-invoice-free-js', plugin_dir_url( __FILE__ ) . 'js/webappick-pdf-invoice-for-woocommerce-admin.js', array( 'jquery', 'flatpickr-js' ), $this->version, true );
        wp_enqueue_script( "jquery-slick", plugin_dir_url(__FILE__) . 'js/slick.js', array( 'jquery', 'jquery-migrate' ), $this->version, false );

		$wpifw_nonce = wp_create_nonce('wpifw_pdf_nonce');
		wp_localize_script($this->plugin_name, 'wpifw_ajax_obj', array(
			'wpifw_ajax_url' => admin_url('admin-ajax.php'),
			'nonce' => $wpifw_nonce,
		));
		wp_enqueue_script($this->plugin_name,"wpifw_ajax_obj");
		
	}


	public function add_my_account_order_actions( $actions, $order ) {
		$order_id = method_exists( $order, 'get_id' ) ? $order->get_id() : $order->id;
		$actions['invoice'] = array(
			// adjust URL as needed
			'url' => wp_nonce_url( admin_url( 'admin-ajax.php?action=wpifw_generate_invoice&order_id=' . $order_id ), 'webappick-pdf-invoice-for-woocommerce' ),
			'name' => __( 'Download Invoice', 'woo-invoice-pdf-invoice-for-woocommerce' ),
		);

		return $actions;
	}

}
