<?php
/**
 * WooCommerce Invoice Free Plugin Uses Tracker
 * Uses Webappick Insights for tracking
 * @since 1.2.2
 * @version 1.0.0
 */
if( ! defined( 'ABSPATH' ) ) die();

if ( ! class_exists( 'WooInvoiceWebAppickAPI' ) ) {
    /**
     * Class WooInvoiceWebAppickAPI
     */
    final class WooInvoiceWebAppickAPI {
	
	    /**
	     * Singleton instance
	     * @var WooInvoiceWebAppickAPI
	     */
	    protected static $instance;
	
	    /**
	     * @var WebAppick\AppServices\Client
	     */
	    protected $client = null;
	
	    /**
	     * @var WebAppick\AppServices\Insights
	     */
	    protected $insights = null;
	
	    /**
	     * Promotions Class Instance
	     * @var WebAppick\AppServices\Promotions
	     */
	    public $promotion = null;
	
	    /**
	     * Plugin License Manager
	     * @var WebAppick\AppServices\License
	     */
	    protected $license = null;
	
	    /**
	     * Plugin Updater
	     * @var WebAppick\AppServices\Updater
	     */
	    protected $updater = null;
	
	    /**
	     * Initialize
	     * @return WooInvoiceWebAppickAPI
	     */
	    public static function getInstance() {
		    if( is_null( self::$instance ) ) self::$instance = new self();
		    return self::$instance;
	    }

        /**
         * Class constructor
         *
         * @return void
         * @since 1.0.0
         *
         */
        private function __construct() {
	        if (!class_exists('WebAppick\AppServices\Client')) {
		        /** @noinspection PhpIncludeInspection */
		        require_once WAPDFINVOICE_LIBS_PATH . 'WebAppick/AppServices/Client.php';
	        }
	        $this->client = new WebAppick\AppServices\Client( '28261c3c-793e-4c74-bf7f-2837b8c6ddb4', 'Woo Invoice Free', WAPDFINVOICE_FREE_FILE );
	        // Load
	        $this->insights = $this->client->insights(); // Plugin Insights
	        $this->promotion = $this->client->promotions(); // Promo offers
	
	        // Setup
	        $this->promotion->set_source( 'https://api.bitbucket.org/2.0/snippets/woofeed/RLbyop/files/woo-feed-notice.json' );
	
	        // Initialize
	        $this->insightInit();
	        $this->promotion->init();
        }

        /**
         * Cloning is forbidden.
         * @since 1.0.2
         */
	    public function __clone() {
		    _doing_it_wrong( __FUNCTION__, __( 'Cloning is forbidden.', 'woo-invoice' ), '1.0.2' );
	    }
	
	    /**
	     * Initialize Insights
	     * @return void
	     */
	    private function insightInit() {
		    $this->insights->add_extra( [
			    'products'   => $this->insights->get_post_count( 'product' ),
			    'variations' => $this->insights->get_post_count( 'product_variation' ),
			    'orders'     => $this->insights->get_post_count( 'order' ),
		    ] );
		    $projectSlug = $this->client->getSlug();
		    add_filter( $projectSlug . '_what_tracked', [ $this, 'data_we_collect' ], 10, 1 );
		    add_filter( "WebAppick_{$projectSlug}_Support_Ticket_Recipient_Email", function(){
			    return 'support@webappick.com';
		    }, 10 );
		    add_filter( "WebAppick_{$projectSlug}_Support_Ticket_Email_Template", [ $this, 'supportTicketTemplate' ], 10 );
		    add_filter( "WebAppick_{$projectSlug}_Support_Request_Ajax_Success_Response", [ $this, 'supportResponse' ], 10 );
		    add_filter( "WebAppick_{$projectSlug}_Support_Request_Ajax_Error_Response", [ $this, 'supportErrorResponse' ], 10 );
		    add_filter( "WebAppick_{$projectSlug}_Support_Page_URL", function(){
			    return 'https://webappick.com/support/';
		    }, 10 );
		    $this->insights->init();
	    }
	
	    /**
	     * Generate Support Ticket Email Template
	     * @return string
	     */
	    public function supportTicketTemplate() {
		    // dynamic variable format __INPUT_NAME__
		    /** @noinspection HtmlUnknownTarget */
		    $template = '<div style="margin: 10px auto;"><p>Website : <a href="__WEBSITE__">__WEBSITE__</a><br>Plugin : %s (v.%s)</p></div>';
		    $template = sprintf( $template, $this->client->getName(), $this->client->getProjectVersion() );
		    $template .= '<div style="margin: 10px auto;"><hr></div>';
		    $template .= '<div style="margin: 10px auto;"><h3>__SUBJECT__</h3></div>';
		    $template .= '<div style="margin: 10px auto;">__MESSAGE__</div>';
		    $template .= '<div style="margin: 10px auto;"><hr></div>';
		    $template .= sprintf(
			    '<div style="margin: 50px auto 10px auto;"><p style="font-size: 12px;color: #009688">%s</p></div>',
			    'Message Processed With WebAppick Service Library (v.' . $this->client->getClientVersion() . ')'
		    );
		    return $template;
	    }
	
	    /**
	     * Generate Support Ticket Ajax Response
	     * @return string
	     */
	    public function supportResponse() {
		    $response        = '';
		    $response        .= sprintf( '<h3>%s</h3>', esc_html__( 'Thank you -- Support Ticket Submitted.', 'woo-feed' ) );
		    $ticketSubmitted = esc_html__( 'Your ticket has been successfully submitted.', 'woo-feed' );
		    $twenty4Hours    = sprintf( '<strong>%s</strong>', esc_html__( '24 hours', 'woo-feed' ) );
		    $notification    = sprintf( esc_html__( 'You will receive an email notification from "support@webappick.com" in your inbox within %s.', 'woo-feed' ), $twenty4Hours );
		    $followUp        = esc_html__( 'Please Follow the email and WebAppick Support Team will get back with you shortly.', 'woo-feed' );
		    $response        .= sprintf( '<p>%s %s %s</p>', $ticketSubmitted, $notification, $followUp );
		    $docLink         = sprintf( '<a class="button button-primary" href="https://webappick.helpscoutdocs.com/" target="_blank"><span class="dashicons dashicons-media-document" aria-hidden="true"></span> %s</a>', esc_html__( 'Documentation', 'woo-feed' ) );
		    $vidLink         = sprintf( '<a class="button button-primary" href="http://bit.ly/2u6giNz" target="_blank"><span class="dashicons dashicons-video-alt3" aria-hidden="true"></span> %s</a>', esc_html__( 'Video Tutorials', 'woo-feed' ) );
		    $response        .= sprintf( '<p>%s %s</p>', $docLink, $vidLink );
		    $response        .= '<br><br><br>';
		    $toc             = sprintf( '<a href="https://webappick.com/terms-and-conditions/" target="_blank">%s</a>', esc_html__( 'Terms & Conditions', 'woo-feed' ) );
		    $pp              = sprintf( '<a href="https://webappick.com/privacy-policy/" target="_blank">%s</a>', esc_html__( 'Privacy Policy', 'woo-feed' ) );
		    $policy          = sprintf( esc_html__( 'Please read our %s and %s', 'woo-feed' ), $toc, $pp );
		    $response        .= sprintf( '<p style="font-size: 12px;">%s</p>', $policy );
		    return $response;
	    }
	
	    /**
	     * Set Error Response Message For Support Ticket Request
	     * @return string
	     */
	    public function supportErrorResponse() {
		    return sprintf(
			    '<div class="mui-error"><p>%s</p><p>%s</p><br><br><p style="font-size: 12px;">%s</p></div>',
			    esc_html__( 'Something Went Wrong. Please Try The Support Ticket Form On Our Website.', 'woo-feed' ),
			    sprintf( '<a class="button button-primary" href="https://webappick.com/support/" target="_blank">%s</a>', esc_html__( 'Get Support', 'woo-feed' ) ),
			    esc_html__( 'Support Ticket form will open in new tab in 5 seconds.', 'woo-feed' )
		    );
	    }
	
	    /**
	     * Set Data Collection description for the tracker
	     * @param $data
	     *
	     * @return array
	     */
	    public function data_we_collect($data) {
		    $data = array_merge( $data, [
			    esc_html__( 'Number of products in your site.', 'woo-invoice' ),
			    esc_html__( 'Number of Orders in your site.', 'woo-invoice' ),
			    esc_html__( 'Site name, language and url.', 'woo-invoice' ),
			    esc_html__( 'Number of active and inactive plugins.', 'woo-invoice' ),
			    esc_html__( 'Your name and email address.', 'woo-invoice' ),
		    ] );
		
		    return $data;
	    }
	
	    public function get_data_collection_description() {
		    return $this->insights->get_data_collection_description();
	    }
	
	    /**
	     * Update Tracker OptIn
	     *
	     * @param bool $override optional. ignore last send datetime settings if true.
	     * @return void
	     * @see Insights::send_tracking_data()
	     */
	    public function trackerOptIn( $override = false ) {
		    $this->insights->optIn( $override );
	    }
	
	    /**
	     * Update Tracker OptOut
	     * @return void
	     */
	    public function trackerOptOut() {
		    $this->insights->optOut();
	    }
	
	    /**
	     * Check if tracking is enable
	     * @return bool
	     */
	    public function is_tracking_allowed() {
		    return $this->insights->is_tracking_allowed();
	    }
    }
}