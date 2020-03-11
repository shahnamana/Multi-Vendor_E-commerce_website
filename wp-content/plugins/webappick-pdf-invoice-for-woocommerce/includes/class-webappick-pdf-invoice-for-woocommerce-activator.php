<?php

/**
 * Fired during plugin activation
 *
 * @link       https://webappick.com
 * @since      1.0.0
 *
 * @package    Webappick_Pdf_Invoice_For_Woocommerce
 * @subpackage Webappick_Pdf_Invoice_For_Woocommerce/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Webappick_Pdf_Invoice_For_Woocommerce
 * @subpackage Webappick_Pdf_Invoice_For_Woocommerce/includes
 * @author     Md Ohidul Islam <wahid@webappick.com>
 */
class Webappick_Pdf_Invoice_For_Woocommerce_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		# Enable PDF Invoicing
		if(get_option("wpifw_invoicing") == false) {
			update_option("wpifw_invoicing","1");
		}

		if(get_option("wpifw_order_email") == false) {
			update_option("wpifw_order_email","1");
		}
		
		if(get_option("wpifw_download") == false) {
			update_option("wpifw_download","1");
		}

		if(get_option("wpifw_currency_code") == false) {
			update_option("wpifw_currency_code","1");
		}
		
		if(get_option("wpifw_currency_symbol") == false) {
			update_option("wpifw_currency_symbol","1");
		}

		if(get_option("wpifw_disid") == false) {
			update_option("wpifw_disid","SKU");
		}

		if(get_option("wpifw_block_title_from") == false) {
			update_option("wpifw_block_title_from","FROM");
		}

		if(get_option("wpifw_block_title_to") == false) {
			update_option("wpifw_block_title_to","TO");
		}
		
		if(get_option("wpifw_invoice_no") == false) {
			update_option("wpifw_invoice_no","1");
		}

		if(get_option('wpifw_cdetails') == false) {
            if (class_exists('WooCommerce')) {
                $store = new WC_Countries;
                $address = $store->get_base_address();
                $address_2 = $store->get_base_address_2();
                $country = $store->get_base_country(); //BD
                $city = $store->get_base_city(); //Dhaka
                $postcode = $store->get_base_postcode(); //1212
                $store_location = "";
                if ($address != "") {
                    $store_location .= $address . "\n";
                }
                if ($address_2 != "") {
                    $store_location .= $address_2 . "\n";
                }
                if ($city != "") {
                    $store_location .= $city;
                }
                if ($city != "" && $postcode != "") {
                    $store_location .= "-" . $postcode . "\n";
                } else {
                    $store_location .= "\n";
                }
                if ($country != "") {
                    $store_location .= $country;
                }
                update_option("wpifw_cdetails", $store_location);
            }
        }

        if(get_option('wpifw_cname') == false){
            update_option("wpifw_cname",get_bloginfo('name'));
        }


        if(get_option('wpifw_logo_attachment_id') == false) {
            if (has_custom_logo()) {
                $custom_logo_id = get_theme_mod('custom_logo');
                $custom_logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
                update_option("wpifw_logo_attachment_id", $custom_logo_url);
            }
        }

		$customerInfo=<<<INFO
{{billing_first_name}} {{billing_last_name}}
{{billing_company}}
{{billing_address_1}}
{{billing_address_2}}
{{billing_city}} - {{billing_postcode}}
{{billing_state}}
{{billing_country}}
P: {{billing_phone}}
E: {{billing_email}}
INFO;
		
		if(get_option("wpifw_buyer") == false) {
			update_option("wpifw_buyer",$customerInfo);
		}
		
		update_option("woo-invoice-activation-time",time());
		

	}

}
