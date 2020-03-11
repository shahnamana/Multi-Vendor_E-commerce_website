<?php


/**
 * Provide settings view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://webappick.com
 * @since      1.0.0
 *
 * @package    Webappick_Pdf_Invoice_For_Woocommerce
 * @subpackage Webappick_Pdf_Invoice_For_Woocommerce/admin/partials
 */

#Checkbox Value to compare
$current=1;

$logo_dir = plugin_dir_url( dirname( __FILE__ ) ) .'images/woo-invoice-logo.svg';
$banner_dir = plugin_dir_url( dirname( __FILE__ ) ) .'images/get-woo-invoice-pro.svg';

$style="max-width:80%;display:block;margin:0 auto;border: 3px solid #0F74A6;";
$style2="max-width:80%;display:block;margin:0 auto;border: 3px solid #1AA15F;";


if(substr(get_option( 'wpifw_logo_attachment_id' ), 0, 7 ) === "http://" || substr(get_option( 'wpifw_logo_attachment_id' ), 0, 8 ) === "https://"){
    $image_id = attachment_url_to_postid( get_option( 'wpifw_logo_attachment_id' ) );
    $fullsize_path = get_attached_file( $image_id );
    update_option("wpifw_logo_attachment_id",$fullsize_path);
    update_option('wpifw_logo_attachment_image_id',$image_id);
}

?>

<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Woo Invoice', 'woo-invoice'); ?></h1>
</div><!-- end .wrap -->

<div class="woo-invoice-wrap">
    <div class="woo-invoice-dashboard-header">
        <a class="wapk-woo-invoice-admin-logo" href="http://bit.ly/woo-invoice-free" target="_blank"><img src="<?php _e($logo_dir,'woo-invoice') ?>" alt="Woo Invoice"></a>
        <a class="wapk-woo-invoice-get-product-btn" href="http://bit.ly/woo-invoice-free" target="_blank"><img src="<?php _e($banner_dir,'woo-invoice') ?>" alt="Woo Invoice"></a>
        <a class="wapk-woo-invoice-support-btn" target="_blank" href="https://wordpress.org/support/plugin/webappick-pdf-invoice-for-woocommerce/#new-topic-0"><?php _e('Get free support','woo-invoice') ?></a>
    </div><!-- end .woo-invoice-dashboard-header -->
    <div class="woo-invoice-dashboard-body">
        <div class="woo-invoice-dashboard-sidebar">
            <div class="woo-invoice-sidebar-navbar woo-invoice-sidebar-navbar-vertical woo-invoice-fixed-left woo-invoice-sidebar-navbar-expand-md woo-invoice-sidebar-navbar-light" id="woo-invoice-sidebar">
                <div class="container-fluid">

                    <!-- Toggler -->
                    <button class="woo-invoice-sidebar-navbar-toggler" type="button" data-toggle="collapse" data-target="#webappickSidebarCollapse" aria-controls="webappickSidebarCollapse" aria-expanded="false" aria-label="Toggle woo-invoice-navigation">
                        <span class="woo-invoice-sidebar-navbar-toggler-icon"></span>
                    </button>

                    <!-- Brand -->
                    <!-- <a class="woo-invoice-sidebar-navbar-brand" href="https://webappick.com"><img src="../wp-content/plugins/woo-invoice-boilerplate/admin/images/woo-invoice-logo.png" alt="WEBAPPICK" style="width:100px;"></a> -->

                    <!-- Collapse -->
                    <ul class="collapse woo-invoice-sidebar-navbar-collapse" id="webappickSidebarCollapse">

                        <ul class="woo-invoice-sidebar-navbar-nav woo-invoice-mb-md-4">
                            <li class="woo-invoice-sidebar-nav-item">
                                <a class="woo-invoice-sidebar-nav-link" href="#">
                                    <?php _e('Settings','woo-invoice') ?>
                                </a>
                            </li>
                            <li class="woo-invoice-sidebar-nav-item">
                                <a class="woo-invoice-sidebar-nav-link" href="#">
                                    <?php _e('Seller & Buyer','woo-invoice') ?>
                                </a>
                            </li>
                            <li class="woo-invoice-sidebar-nav-item">
                                <a class="woo-invoice-sidebar-nav-link" href="#">
                                    <?php _e('Localization','woo-invoice') ?>
                                </a>
                            </li>
                            <li class="woo-invoice-sidebar-nav-item">
                                <a class="woo-invoice-sidebar-nav-link" href="#">
                                    <?php _e('Bulk download','woo-invoice') ?>
                                </a>
                            </li>
                            <li class="woo-invoice-sidebar-nav-item">
                                <a class="woo-invoice-sidebar-nav-link" href="#">
                                    <?php _e('Free vs Premium','woo-invoice') ?>
                                </a>
                            </li>
                        </ul>

                    </ul>
                </div>
            </div>
        </div><!-- end .woo-invoice-dashboard-sidebar -->
        <div class="woo-invoice-dashboard-content">

            <!--START SETTING TAB-->
            <li>
                <div class="woo-invoice-row">
                    <div class="woo-invoice-col-sm-8 woo-invoice-col-12">
                        <div class="woo-invoice-card">
                            <div class="woo-invoice-card-body">
                                <form action="" method="post">
                                    <?php wp_nonce_field('invoice_form_nonce'); ?>
                                    <div class="woo-invoice-form-group">
                                        <div class="woo-invoice-custom-control woo-invoice-custom-switch" style="padding-left:0!important;">
                                            <div class="woo-invoice-toggle-label">
                                                <span class="woo-invoice-checkbox-label"><?php _e('Enable Invoicing', 'woo-invoice'); ?></span>
                                            </div>
                                            <div class="woo-invoice-toggle-container" tooltip="Enable Invoicing to generate automatically." flow="right">
                                                <input type="checkbox" class="woo-invoice-custom-control-input" id ="wpifw_invoicing" name="wpifw_invoicing" value="1" <?php checked(get_option('wpifw_invoicing'),$current,true); ?>>
                                                <label class="woo-invoice-custom-control-label" for="wpifw_invoicing"></label>
                                            </div>
                                        </div>
                                    </div><!-- end .woo-invoice-form-group -->
                                    <div class="woo-invoice-form-group">
                                        <div class="woo-invoice-custom-control woo-invoice-custom-switch" style="padding-left:0!important;">
                                            <div class="woo-invoice-toggle-label">
                                                <span class="woo-invoice-checkbox-label"><?php _e('Allow Download', 'woo-invoice'); ?></span>
                                            </div>
                                            <div class="woo-invoice-toggle-container" tooltip="Allow customer to download invoice from my account order list." flow="right">
                                                <input title="Allow Customer to Download Invoice From My Account"  type="checkbox" class="woo-invoice-custom-control-input" id ="wpifw_download" name="wpifw_download" value="1" <?php checked(get_option('wpifw_download'),$current,true); ?>>
                                                <label class="woo-invoice-custom-control-label tips" for="wpifw_download" title="Allow Customer to Download Invoice From My Account"></label>
                                            </div>
                                        </div>
                                    </div><!-- end .woo-invoice-form-group -->
                                    <div class="woo-invoice-form-group">
                                        <div class="woo-invoice-custom-control woo-invoice-custom-switch" style="padding-left:0!important;">
                                            <div class="woo-invoice-toggle-label">
                                                <span class="woo-invoice-checkbox-label"><?php _e('Attach to Order Email', 'woo-invoice'); ?></span>
                                            </div>
                                            <div class="woo-invoice-toggle-container" tooltip="Attach Invoice to completed order email." flow="right">
                                                <input type="checkbox" id ="atttoorder"  class="woo-invoice-custom-control-input atttoorder" name="wpifw_order_email" value="1" <?php checked(get_option('wpifw_order_email'),$current,true); ?>>
                                                <label class="woo-invoice-custom-control-label tips" for="atttoorder"></label>
                                            </div>
                                        </div>
                                    </div><!-- end .woo-invoice-form-group -->
                                    <div class="woo-invoice-form-group woo-invoice-template-select" tooltip="" flow="right">

                                        <label class="woo-invoice-custom-label" for="templateid"><?php _e('Invoice Template', 'woo-invoice'); ?></label>
                                        <a class="woo-invoice-btn woo-invoice-btn-primary" data-toggle="modal" data-target="#winvoiceModalTemplates" style="color:#fff"><?php _e('Select Template', 'woo-invoice-pro'); ?></a>
                                        <div class="woo-invoice-modal fade" id="winvoiceModalTemplates" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="woo-invoice-modal-dialog woo-invoice-modal-dialog-centered" role="document">
                                                <div class="woo-invoice-modal-content">
                                                    <div class="woo-invoice-modal-card" data-toggle="lists" data-lists-values="[&quot;name&quot;]">
                                                        <div class="woo-invoice-card-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true" style="font-size: 30px;text-align: right;display: block;">×</span>
                                                            </button>
                                                        </div>

                                                        <div class="woo-invoice-card-body" style="height:950px">

                                                            <div class="woo-invoice-row">
                                                                <div class="woo-invoice-col-sm-4">
                                                                    <a href="#" class="woo-invoice-template-selection" data-template="invoice-1"><img src="https://woo-invoice-assets.s3.amazonaws.com/template-image/invoice-1.png" alt="" style="<?php if(get_option("wpifw_templateid") == "invoice-1") { echo $style2;}else{echo $style;}  ?>"></a>
                                                                </div>
                                                                <div class="woo-invoice-col-sm-4">
                                                                    <a href="#" class="woo-invoice-template-selection" data-template="invoice-2"><img src="https://woo-invoice-assets.s3.amazonaws.com/template-image/invoice-2.png" alt="" style="<?php if(get_option("wpifw_templateid") == "invoice-2") { echo $style2;}else{echo $style;}  ?>"></a>
                                                                </div>

                                                                <div class="woo-invoice-col-sm-4" style="position:relative">
                                                                    <a href="#" class="woo-invoice-element-disable" data-template="" style="position: absolute;top: 0;z-index: 3333;"><img src="https://woo-invoice-assets.s3.amazonaws.com/template-image/invoice-3.png" alt="" style="max-width:80%;display:block;margin:0 auto;border: 3px solid #0F74A6;"></a>
                                                                    <div style="width: 80%;height: 284px;position: absolute;top: 0;z-index:1111;background: #ddd;opacity: 0.7;margin-left: 25px;"></div>
                                                                    <a href="https://webappick.com/plugin/woocommerce-pdf-invoice-packing-slips/" target="_blank" style="position: absolute;top: 0;z-index: 2222;background: #DC4C40;color: #fff;padding: 5px;border-radius: 3px;text-transform: uppercase;margin: 120px 80px;">Premium</a>
                                                                </div>
                                                                <div class="woo-invoice-col-sm-4" style="position:relative;margin-top: 25px;">
                                                                    <a href="#" class="woo-invoice-element-disable" data-template="" style="position: absolute;top: 0;z-index: 3333;"><img src="https://woo-invoice-assets.s3.amazonaws.com/template-image/invoice-4.png" alt="" style="max-width:80%;display:block;margin:0 auto;border: 3px solid #0F74A6;"></a>
                                                                    <div style="width: 80%;height: 281px;position: absolute;top: 0;z-index:1111;background: #ddd;opacity: 0.7;margin-left: 25px;"></div>
                                                                    <a href="https://webappick.com/plugin/woocommerce-pdf-invoice-packing-slips/" target="_blank" style="position: absolute;top: 0;z-index: 2222;background: #DC4C40;color: #fff;padding: 5px;border-radius: 3px;text-transform: uppercase;margin: 120px 80px;">Premium</a>
                                                                </div>
                                                                <div class="woo-invoice-col-sm-4" style="position:relative;margin-top: 25px;">
                                                                    <a href="#" class="woo-invoice-element-disable" data-template="" style="position: absolute;top: 0;z-index: 3333;"><img src="https://woo-invoice-assets.s3.amazonaws.com/template-image/invoice-5.png" alt="" style="max-width:80%;display:block;margin:0 auto;border: 3px solid #0F74A6;"></a>
                                                                    <div style="width: 80%;height: 281px;position: absolute;top: 0;z-index:1111;background: #ddd;opacity: 0.7;margin-left: 25px;"></div>
                                                                    <a href="https://webappick.com/plugin/woocommerce-pdf-invoice-packing-slips/" target="_blank" style="position: absolute;top: 0;z-index: 2222;background: #DC4C40;color: #fff;padding: 5px;border-radius: 3px;text-transform: uppercase;margin: 120px 80px;">Premium</a>
                                                                </div>
                                                                <div class="woo-invoice-col-sm-4" style="position:relative;margin-top: 25px;">
                                                                    <a href="#" class="woo-invoice-element-disable" data-template="" style="position: absolute;top: 0;z-index: 3333;"><img src="https://woo-invoice-assets.s3.amazonaws.com/template-image/invoice-6.png" alt="" style="max-width:80%;display:block;margin:0 auto;border: 3px solid #0F74A6;"></a>
                                                                    <div style="width: 80%;height: 281px;position: absolute;top: 0;z-index:1111;background: #ddd;opacity: 0.7;margin-left: 25px;"></div>
                                                                    <a href="https://webappick.com/plugin/woocommerce-pdf-invoice-packing-slips/" target="_blank" style="position: absolute;top: 0;z-index: 2222;background: #DC4C40;color: #fff;padding: 5px;border-radius: 3px;text-transform: uppercase;margin: 120px 80px;">Premium</a>
                                                                </div>
                                                                <div class="woo-invoice-col-sm-4" style="position:relative;margin-top: 25px;top: 280px;">
                                                                    <a href="#" class="woo-invoice-element-disable" data-template="" style="position: absolute;top: 0;z-index: 3333;"><img src="https://woo-invoice-assets.s3.amazonaws.com/template-image/invoice-7.png" alt="" style="max-width:80%;display:block;margin:0 auto;border: 3px solid #0F74A6;"></a>
                                                                    <div style="width: 80%;height: 281px;position: absolute;top: 0;z-index:1111;background: #ddd;opacity: 0.7;margin-left: 25px;"></div>
                                                                    <a href="https://webappick.com/plugin/woocommerce-pdf-invoice-packing-slips/" target="_blank" style="position: absolute;top: 0;z-index: 2222;background: #DC4C40;color: #fff;padding: 5px;border-radius: 3px;text-transform: uppercase;margin: 120px 80px;">Premium</a>
                                                                </div>
                                                                <div class="woo-invoice-col-sm-4" style="position:relative;margin-top: 25px;top: 280px;">
                                                                    <a href="#" class="woo-invoice-element-disable" data-template="" style="position: absolute;top: 0;z-index: 3333;"><img src="https://woo-invoice-assets.s3.amazonaws.com/template-image/invoice-8.png" alt="" style="max-width:80%;display:block;margin:0 auto;border: 3px solid #0F74A6;"></a>
                                                                    <div style="width: 80%;height: 281px;position: absolute;top: 0;z-index:1111;background: #ddd;opacity: 0.7;margin-left: 25px;"></div>
                                                                    <a href="https://webappick.com/plugin/woocommerce-pdf-invoice-packing-slips/" target="_blank" style="position: absolute;top: 0;z-index: 2222;background: #DC4C40;color: #fff;padding: 5px;border-radius: 3px;text-transform: uppercase;margin: 120px 80px;">Premium</a>
                                                                </div>
                                                                <div class="woo-invoice-col-sm-4" style="position:relative;margin-top: 25px;top: 280px;">
                                                                    <a href="#" class="woo-invoice-element-disable" data-template="" style="position: absolute;top: 0;z-index: 3333;"><img src="https://woo-invoice-assets.s3.amazonaws.com/template-image/invoice-9.png" alt="" style="max-width:80%;display:block;margin:0 auto;border: 3px solid #0F74A6;"></a>
                                                                    <div style="width: 80%;height: 281px;position: absolute;top: 0;z-index:1111;background: #ddd;opacity: 0.7;margin-left: 25px;"></div>
                                                                    <a href="https://webappick.com/plugin/woocommerce-pdf-invoice-packing-slips/" target="_blank" style="position: absolute;top: 0;z-index: 2222;background: #DC4C40;color: #fff;padding: 5px;border-radius: 3px;text-transform: uppercase;margin: 120px 80px;">Premium</a>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="woo-invoice-card-footer">
                                                            <button class="woo-invoice-btn woo-invoice-btn-primary" data-dismiss="modal" aria-label="Close" style="float:right;margin-bottom: 20px;">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end .woo-invoice-form-group -->
                                    <div class="woo-invoice-form-group" tooltip="" flow="right">
                                        <label class="woo-invoice-custom-label" for="invno"><?php _e('Next Invoice No.', 'woo-invoice'); ?></label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control woo-invoice-number-input" type="number" id ="invno" name="wpifw_invoice_no" value="<?php echo esc_attr(get_option("wpifw_invoice_no")); ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group" tooltip="" flow="right">
                                        <label class="woo-invoice-custom-label" for="invprefix"><?php _e('Invoice No. Prefix', 'woo-invoice'); ?></label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="invprefix" name="wpifw_invoice_no_prefix" value="<?php echo esc_attr(get_option("wpifw_invoice_no_prefix")); ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group" tooltip="" flow="right">
                                        <label class="woo-invoice-custom-label" for="insuff"><?php _e('Invoice No. Suffix', 'woo-invoice'); ?></label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="insuff" name="wpifw_invoice_no_suffix" value="<?php echo esc_attr(get_option("wpifw_invoice_no_suffix")); ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group" tooltip="Keep Empty for no limit" flow="right">
                                        <label class="woo-invoice-custom-label" for="title-limit"><?php _e('Product Title limit', 'woo-invoice'); ?></label>
                                        <input class="woo-invoice-fixed-width woo-invoice-number-input woo-invoice-form-control" type="number" id ="title-limit" name="wpifw_invoice_product_title_length" value="<?php echo esc_attr(get_option("wpifw_invoice_product_title_length")); ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group" tooltip="" flow="right">
                                        <label class="woo-invoice-custom-label" for="disid"> <?php _e('Display ID/SKU', 'woo-invoice'); ?></label>
                                        <select class="woo-invoice-fixed-width woo-invoice-select-control" id="disid" name="wpifw_disid">
                                            <option value="SKU" <?php selected(get_option('wpifw_disid'),"SKU",true); ?>><?php _e('SKU', 'woo-invoice'); ?></option>
                                            <option value="ID" <?php selected(get_option('wpifw_disid'),"ID",true); ?>><?php _e('ID', 'woo-invoice'); ?></option>
                                            <option value="None" <?php selected(get_option('wpifw_disid'),"None",true); ?>><?php _e('None', 'woo-invoice'); ?></option>
                                        </select>
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group" tooltip="" flow="right">
                                        <label class="woo-invoice-custom-label" for="date"> <?php _e('Date Format', 'woo-invoice'); ?></label>
                                        <select class="woo-invoice-fixed-width woo-invoice-select-control" id="date" name="wpifw_date_format">
                                            <option value="d M, o" <?php selected(get_option('wpifw_date_format'),"d M, o",true); ?> >Date Month, Year</option>
                                            <option value="m/d/y" <?php selected(get_option('wpifw_date_format'),"m/d/y",true); ?> >mm/dd/yy</option>
                                            <option value="d/m/y" <?php selected(get_option('wpifw_date_format'),"m/d/y",true); ?> >dd/mm/yy</option>
                                            <option value="y/m/d" <?php selected(get_option('wpifw_date_format'),"y/m/d",true); ?> >yy/mm/dd</option>
                                            <option value="d/m/Y" <?php selected(get_option('wpifw_date_format'),"d/m/Y",true); ?>>dd/mm/yyyy</option>
                                            <option value="Y/m/d" <?php selected(get_option('wpifw_date_format'),"Y/m/d",true); ?>>yyyy/mm/dd</option>
                                            <option value="m/d/Y" <?php selected(get_option('wpifw_date_format'),"m/d/Y",true); ?>>mm/dd/yyyy</option>
                                            <option value="y-m-d" <?php selected(get_option('wpifw_date_format'),"y-m-d",true); ?>>yy-mm-dd</option>
                                            <option value="Y-m-d" <?php selected(get_option('wpifw_date_format'),"Y-m-d",true); ?>>yyyy-mm-dd</option>
                                        </select>
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group" tooltip="" flow="right">
                                        <label class="woo-invoice-custom-label" for="wpifw_pdf_invoice_button_behaviour"> <?php _e('Invoice download as', 'woo-invoice'); ?></label>
                                        <select class="woo-invoice-fixed-width woo-invoice-select-control" id="wpifw_pdf_invoice_button_behaviour" name="wpifw_pdf_invoice_button_behaviour">
                                            <option value="new_tab" <?php selected(get_option('wpifw_pdf_invoice_button_behaviour'),"new_tab",true); ?> >Open in new tab</option>
                                            <option value="download" <?php selected(get_option('wpifw_pdf_invoice_button_behaviour'),"download",true); ?> >Direct download</option>
                                        </select>
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <div class="woo-invoice-custom-control woo-invoice-custom-switch" style="padding-left:0!important;">
                                            <div class="woo-invoice-toggle-label">
                                                <span class="woo-invoice-checkbox-label"><?php _e('Display Currency Code', 'woo-invoice'); ?></span>
                                            </div>
                                            <div class="woo-invoice-toggle-container"  tooltip="" flow="right">
                                                <input type="checkbox" class="woo-invoice-custom-control-input" id ="discurrency" name="wpifw_currency_code" value="1" <?php checked(get_option('wpifw_currency_code'),$current,true); ?> >
                                                <label class="woo-invoice-custom-control-label" title="Display Currency Code into Invoice Total" for="discurrency"></label>
                                            </div>
                                        </div>
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <div class="woo-invoice-custom-control woo-invoice-custom-switch" style="padding-left:0!important;">
                                            <div class="woo-invoice-toggle-label">
                                                <span class="woo-invoice-checkbox-label"><?php _e('Display Payment Method', 'woo-invoice'); ?></span>
                                            </div>
                                            <div class="woo-invoice-toggle-container" tooltip="" flow="right">
                                                <input type="checkbox" class="woo-invoice-custom-control-input" id ="disPayment" name="wpifw_payment_method_show" value="1" <?php checked(get_option('wpifw_payment_method_show'),$current,true); ?> >
                                                <label class="woo-invoice-custom-control-label" title="Display Payment Method into Invoice" for="disPayment"></label>
                                            </div>
                                        </div>
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <div class="woo-invoice-custom-control woo-invoice-custom-switch" style="padding-left:0!important;">
                                            <div class="woo-invoice-toggle-label">
                                                <span class="woo-invoice-checkbox-label"><?php _e('Display Order Note', 'woo-invoice'); ?></span>
                                            </div>
                                            <div class="woo-invoice-toggle-container" tooltip="" flow="right">
                                                <input type="checkbox" class="woo-invoice-custom-control-input" id ="wpifw_show_order_note" name="wpifw_show_order_note" value="1" <?php checked(get_option('wpifw_show_order_note'),$current,true); ?> >
                                                <label class="woo-invoice-custom-control-label" for="wpifw_show_order_note"></label>
                                            </div>
                                        </div>
                                    </div><!-- end .woo-invoice-form-group -->



                                    <div class="woo-invoice-card-footer woo-invoice-save-changes-selector">
                                        <input style="float:right;" class="woo-invoice-btn woo-invoice-btn-primary" type="submit" name="wpifw_submit" value="<?php _e('Save Changes', 'woo-invoice'); ?>" />
                                    </div><!-- end .woo-invoice-card-footer -->
                                </form>
                            </div><!-- end .woo-invoice-card-body -->
                        </div><!-- end .woo-invoice-card -->
                    </div><!-- end .woo-invoice-col-sm-8 -->
                    <div class="woo-invoice-col-sm-4 woo-invoice-col-12">
                        <div class="woo-invoice-card">
                            <div class="woo-invoice-card-header">
                                <h4><?php _e('SELECTED TEMPLATE', 'woo-invoice'); ?></h4>
                            </div><!-- end .woo-invoice-card-header -->
                            <div class="woo-invoice-card-body">
                                <img class="woo-invoice-template-preview" src="https://woo-invoice-assets.s3.amazonaws.com/template-image/<?php echo get_option('wpifw_templateid'); ?>.png" alt="">
                            </div><!-- end .woo-invoice-card-body -->
                        </div><!-- end .woo-invoice-card -->
                    </div><!-- end .woo-invoice-col-sm-4 -->
                </div><!-- end .woo-invoice-row -->
            </li>
            <!--END SETTING TAB-->

            <!--START SELLER & BUYER  TAB-->
            <li>
                <div class="woo-invoice-row">
                    <div class="woo-invoice-col-sm-8">
                        <div class="woo-invoice-card">
                            <div class="woo-invoice-card-body">
                                <form action="" method="post">
                                    <?php wp_nonce_field('seller_form_nonce'); ?>
                                    <h3><?php _e('Seller Block', 'woo-invoice'); ?></h3>
                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="logo"><?php _e('Logo image', 'woo-invoice'); ?></label>

                                        <div style="display:inline-block;">
                                            <?php wp_enqueue_media(); ?>
                                            <input id="wpifw_upload_logo_button" type="button" class="button" value="<?php _e( 'Upload Logo', 'woo-invoice'); ?>" />
                                            <input type='hidden' name='wpifw_logo_attachment_id' id='wpifw_logo_attachment_id' value='<?php echo get_option( 'wpifw_logo_attachment_image_id' ); ?>'>
                                        </div>
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="logo-height-width"><?php _e('Logo size (%)', 'woo-invoice'); ?></label>
                                        <input class="woo-invoice-uploaded-logo-width woo-invoice-fixed-width woo-invoice-form-control" type="text" name="wpifw_logo_width" value='<?php echo get_option( 'wpifw_logo_width' ); ?>'>
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="bltitle"><?php _e('Block title', 'woo-invoice'); ?></label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="bltitle" name="wpifw_block_title_from" value="<?php echo esc_attr(get_option("wpifw_block_title_from")); ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="cname"><?php _e('Company name', 'woo-invoice'); ?></label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="cname" name="wpifw_cname" value="<?php echo esc_attr(get_option("wpifw_cname")); ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-tinymce-label" for="cdetails"><?php _e('Company details', 'woo-invoice'); ?></label>

                                        <div class="woo-invoice-tinymce-textarea">
                                            <textarea style="height:150px;" class="woo-invoice-form-control" id="cdetails" name="wpifw_cdetails" value=""><?php echo stripslashes(esc_attr(get_option("wpifw_cdetails"))); ?></textarea>
                                        </div><!-- end .woo-invoice-tinymce-textarea -->
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-tinymce-label" for="terms-and-condition"><?php _e('Footer 1', 'woo-invoice'); ?></label>

                                        <div class="woo-invoice-tinymce-textarea">
                                            <textarea style="height:150px;" class="woo-invoice-form-control" id="terms-and-condition" name="wpifw_terms_and_condition" value=""><?php echo stripslashes(esc_textarea(get_option("wpifw_terms_and_condition"))); ?></textarea>
                                        </div><!-- end .woo-invoice-tinymce-textarea -->

                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-tinymce-label" for="other-information"><?php _e('Footer 2', 'woo-invoice'); ?></label>

                                        <div class="woo-invoice-tinymce-textarea">
                                            <textarea style="height:150px;" class="woo-invoice-form-control" id="other-information" name="wpifw_other_information" value=""><?php echo stripslashes(esc_textarea(get_option("wpifw_other_information"))); ?></textarea>
                                        </div>
                                    </div><!-- end .woo-invoice-form-group -->

                                    <h3><?php _e('Buyer Block', 'woo-invoice'); ?></h3>

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="btitle"><?php _e('Block title', 'woo-invoice'); ?></label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="btitle" name="wpifw_block_title_to" value="<?php echo esc_attr(get_option("wpifw_block_title_to")); ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label woo-invoice-buyer-label" for="buyer"><?php _e('Buyer details layout', 'woo-invoice'); ?></label>

                                        <div class="woo-invoice-tinymce-textarea">
                                            <textarea style="height:150px;" class="woo-invoice-form-control" id="buyer" name="wpifw_buyer" value=""><?php echo esc_textarea(get_option("wpifw_buyer")); ?></textarea>
                                            <br/>
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <td><code>{{billing_first_name}}</code></td>
                                                    <td><code>{{billing_last_name}}</code></td>
                                                </tr>
                                                <tr>
                                                    <td><code>{{billing_company}}</code></td>
                                                    <td><code>{{billing_address_1}}</code></td>
                                                </tr>
                                                <tr>
                                                    <td><code>{{billing_address_2}}</code></td>
                                                    <td><code>{{billing_city}}</code></td>
                                                </tr>
                                                <tr>
                                                    <td><code>{{billing_state}}</code></td>
                                                    <td><code>{{billing_postcode}}</code></td>
                                                </tr>
                                                <tr>
                                                    <td><code>{{billing_country}}</code></td>
                                                    <td><code>{{billing_phone}}</code></td>
                                                </tr>
                                                <tr>
                                                    <td><code>{{billing_email}}</code></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><code>{{shipping_first_name}}</code></td>
                                                    <td><code>{{shipping_last_name}}</code></td>
                                                </tr>
                                                <tr>
                                                    <td><code>{{shipping_company}}</code></td>
                                                    <td><code>{{shipping_address_1}}</code></td>
                                                </tr>
                                                <tr>
                                                    <td><code>{{shipping_address_2}}</code></td>
                                                    <td><code>{{shipping_city}}</code></td>
                                                </tr>
                                                <tr>
                                                    <td><code>{{shipping_state}}</code></td>
                                                    <td><code>{{shipping_postcode}}</code></td>
                                                </tr>
                                                <tr>
                                                    <td><code>{{shipping_country}}</code></td>
                                                    <td><code>{{shipping_phone}}</code></td>
                                                </tr>
                                                <tr>
                                                    <td><code>{{shipping_email}}</code></td>
                                                    <td></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div><!-- end .woo-invoice-tinymce-textarea -->

                                    </div><!-- end .woo-invoice-form-group -->
                                    <div class="woo-invoice-card-footer woo-invoice-save-changes-selector">
                                        <input type="submit" style="float:right;" name="wpifw_submit_seller&buyer" value="<?php _e('Save Changes', 'woo-invoice'); ?>" class="woo-invoice-btn woo-invoice-btn-primary" />
                                    </div><!-- end .woo-invoice-card-footer -->
                                </form>

                            </div><!-- end .woo-invoice-card-body -->
                        </div><!-- end .woo-invoice-card -->
                    </div><!-- end .woo-invoice-col-sm-8 -->
                    <div class="woo-invoice-col-sm-4">
                        <div class="woo-invoice-card">
                            <div class="woo-invoice-card-header">
                                <div class="woo-invoice-card-header-title">
                                    <b><?php _e('Logo Preview', 'woo-invoice'); ?></b>
                                </div>
                            </div>
                            <div class="woo-invoice-card-body">
                                <div class='wpifw_logo-preview-wrapper'>
                                    <?php
                                    if(get_option( 'wpifw_logo_attachment_image_id' ) != false && !empty(get_option( 'wpifw_logo_attachment_image_id' ))) {
                                        $url = wp_get_attachment_url( get_option( 'wpifw_logo_attachment_image_id' ) );
                                        ?>
                                        <img style="max-width:90px;display: block;margin:0 auto;" id='wpifw_logo-preview' src='<?php echo $url ?>'>
                                        <?php
                                    } else {
                                        ?>
                                        <img style="max-width:90px;display: block;margin:0 auto;" id='wpifw_logo-preview' src=''>
                                        <?php
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div><!-- end .woo-invoice-col-sm-4 -->
                </div><!-- end .woo-invoice-row -->
            </li>
            <!--END SELLER & BUYER  TAB-->

            <!--START LOCALIZATION TAB-->
            <li>
                <div class="woo-invoice-row">
                    <div class="woo-invoice-col-8">
                        <div class="woo-invoice-card">
                            <div class="woo-invoice-card-body">
                                <form action="" method="post">
                                    <?php wp_nonce_field('localization_form_nonce'); ?>
                                    <h3><?php _e('Invoice block', 'woo-invoice'); ?></h3>

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="invoice">Invoice</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="invoice" name="wpifw_INVOICE_TITLE" value="<?php echo !empty(get_option("wpifw_INVOICE_TITLE"))?esc_attr(get_option("wpifw_INVOICE_TITLE")):'Invoice'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="payment_method">Payment Method</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="payment_method" name="wpifw_payment_method_text" value="<?php echo !empty(get_option("wpifw_payment_method_text"))?esc_attr(get_option("wpifw_payment_method_text")):'Payment Method'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="Invoice-number">Invoice Number</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="Invoice-number" name="wpifw_INVOICE_NUMBER_TEXT" value="<?php echo !empty(get_option("wpifw_INVOICE_NUMBER_TEXT"))?esc_attr(get_option("wpifw_INVOICE_NUMBER_TEXT")):'Invoice Number'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="Invoice-date">Invoice Date</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="Invoice-date" name="wpifw_INVOICE_DATE_TEXT" value="<?php echo !empty(get_option("wpifw_INVOICE_DATE_TEXT"))?esc_attr(get_option("wpifw_INVOICE_DATE_TEXT")):'Invoice Date'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="order_number">Order Number</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="order_number" name="wpifw_ORDER_NUMBER_TEXT" value="<?php echo !empty(get_option("wpifw_ORDER_NUMBER_TEXT"))?esc_attr(get_option("wpifw_ORDER_NUMBER_TEXT")):'Order Number'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="order_date">Order Date</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="order_date" name="wpifw_ORDER_DATE_TEXT" value="<?php echo !empty(get_option("wpifw_ORDER_DATE_TEXT"))?esc_attr(get_option("wpifw_ORDER_DATE_TEXT")):'Order Date'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="sl">SL</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="sl" name="wpifw_SL" value="<?php echo !empty(get_option("wpifw_SL"))?esc_attr(get_option("wpifw_SL")):'SL'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="product">Product</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="product" name="wpifw_PRODUCT" value="<?php echo !empty(get_option("wpifw_PRODUCT"))?esc_attr(get_option("wpifw_PRODUCT")):'Product'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="price">Price</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="price" name="wpifw_PRICE" value="<?php echo !empty(get_option("wpifw_PRICE"))?esc_attr(get_option("wpifw_PRICE")):'Price'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="quantity">Quantity</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="quantity" name="wpifw_QUANTITY" value="<?php echo !empty(get_option("wpifw_QUANTITY"))?esc_attr(get_option("wpifw_QUANTITY")):'Quantity'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="total">Total</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="total" name="wpifw_ROW_TOTAL" value="<?php echo !empty(get_option("wpifw_ROW_TOTAL"))?esc_attr(get_option("wpifw_ROW_TOTAL")):'Total'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="su-total">Sub Total</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="su-total" name="wpifw_SUBTOTAL_TEXT" value="<?php echo !empty(get_option("wpifw_SUBTOTAL_TEXT"))?esc_attr(get_option("wpifw_SUBTOTAL_TEXT")):'Sub Total'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="Tax1">Tax</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="Tax1" name="wpifw_TAX_TEXT" value="<?php echo !empty(get_option("wpifw_TAX_TEXT"))?esc_attr(get_option("wpifw_TAX_TEXT")):'Tax'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="discount">Discount</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="discount" name="wpifw_DISCOUNT_TEXT" value="<?php echo !empty(get_option("wpifw_DISCOUNT_TEXT"))?esc_attr(get_option("wpifw_DISCOUNT_TEXT")):'Discount'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="grand-total-tax">REFUNDED</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="refund-tax" name="wpifw_REFUNDED_TEXT" value="<?php echo !empty(get_option("wpifw_REFUNDED_TEXT"))?esc_attr(get_option("wpifw_REFUNDED_TEXT")):'Refunded'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="shipping">SHIPPING</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="shipping" name="wpifw_SHIPPING_TEXT" value="<?php echo !empty(get_option("wpifw_SHIPPING_TEXT"))?esc_attr(get_option("wpifw_SHIPPING_TEXT")):'Shipping'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="grand-total-tax">Grand Total</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="grand-total-tax" name="wpifw_GRAND_TOTAL_TEXT" value="<?php echo !empty(get_option("wpifw_GRAND_TOTAL_TEXT"))?esc_attr(get_option("wpifw_GRAND_TOTAL_TEXT")):'Grand Total'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label woo-invoice-download-invoice" for="grand-total-tax">Download Invoice<br><span style="font-size: xx-small">(For Email template)</span></label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="grand-total-tax" name="wpifw_DOWNLOAD_INVOICE_TEXT" value="<?php echo !empty(get_option("wpifw_DOWNLOAD_INVOICE_TEXT"))?esc_attr(get_option("wpifw_DOWNLOAD_INVOICE_TEXT")):'Download Invoice'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <h3><?php _e('Packing Slip block', 'woo-invoice'); ?></h3>


                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="packing_slip">Packing Slip</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="packing_slip" name="wpifw_PACKING_SLIP_TEXT" value="<?php echo !empty(get_option("wpifw_PACKING_SLIP_TEXT"))?esc_attr(get_option("wpifw_PACKING_SLIP_TEXT")):'Packing Slip'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="Invoice-number_slip">Order Number</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="Invoice-number_slip" name="wpifw_PACKING_SLIP_ORDER_NUMBER_TEXT" value="<?php echo !empty(get_option("wpifw_PACKING_SLIP_ORDER_NUMBER_TEXT"))?esc_attr(get_option("wpifw_PACKING_SLIP_ORDER_NUMBER_TEXT")):'Order Number'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="Invoice-date">Order Date</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="Invoice-date" name="wpifw_PACKING_SLIP_ORDER_DATE_TEXT" value="<?php echo !empty(get_option("wpifw_PACKING_SLIP_ORDER_DATE_TEXT"))?esc_attr(get_option("wpifw_PACKING_SLIP_ORDER_DATE_TEXT")):'Order Date'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="shipping_method">Shipping method</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="shipping_method" name="wpifw_PACKING_SLIP_ORDER_METHOD_TEXT" value="<?php echo !empty(get_option("wpifw_PACKING_SLIP_ORDER_METHOD_TEXT"))?esc_attr(get_option("wpifw_PACKING_SLIP_ORDER_METHOD_TEXT")):'Shipping method'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="product">Product</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="product" name="wpifw_PACKING_SLIP_PRODUCT_TEXT" value="<?php echo !empty(get_option("wpifw_PACKING_SLIP_PRODUCT_TEXT"))?esc_attr(get_option("wpifw_PACKING_SLIP_PRODUCT_TEXT")):'Product'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="weight">Weight</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="weight" name="wpifw_PACKING_SLIP_WEIGHT_TEXT" value="<?php echo !empty(get_option("wpifw_PACKING_SLIP_WEIGHT_TEXT"))?esc_attr(get_option("wpifw_PACKING_SLIP_WEIGHT_TEXT")):'Weight'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="quantity">Quantity</label>
                                        <input class="woo-invoice-fixed-width woo-invoice-form-control" type="text" id ="quantity" name="wpifw_PACKING_SLIP_QUANTITY_TEXT" value="<?php echo !empty(get_option("wpifw_PACKING_SLIP_QUANTITY_TEXT"))?esc_attr(get_option("wpifw_PACKING_SLIP_QUANTITY_TEXT")):'Quantity'; ?>">
                                    </div><!-- end .woo-invoice-form-group -->



                                    <div class="woo-invoice-card-footer woo-invoice-save-changes-selector">
                                        <input type="submit" style="float:right;" name="wpifw_submit_localization" value="<?php _e('Save Changes', 'woo-invoice'); ?>" class="woo-invoice-btn woo-invoice-btn-primary" />
                                    </div><!-- end .woo-invoice-card-footer -->

                                </form>
                            </div><!-- end .woo-invoice-card-body -->
                        </div><!-- end .woo-invoice-card -->
                    </div><!-- end .woo-invoice-col-8 -->
                </div><!-- end .woo-invoice-row -->
            </li>
            <!--END LOCALIZATION TAB-->

            <!--START BULK DOWNLOAD TAB-->
            <li>
                <div class="woo-invoice-row">
                    <div class="woo-invoice-col-8">
                        <div class="woo-invoice-card">
                            <div class="woo-invoice-card-body">
                                <form action="" method="post" target="_blank">
                                    <?php wp_nonce_field('bulk_download_form_nonce'); ?>
                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="disid"> <?php _e('Bulk Type', 'woo-invoice'); ?></label>
                                        <select class="woo-invoice-fixed-width woo-invoice-select-control" id="disid" name="wpifw_bulk_type">
                                            <option value="WPIFW_INVOICE_DOWNLOAD" <?php selected(get_option('wpifw_disid'),"SKU",true); ?>><?php _e('Invoice', 'woo-invoice'); ?></option>
                                            <option value="WPIFW_PACKING_SLIP" <?php selected(get_option('wpifw_disid'),"ID",true); ?>><?php _e('Packing Slip', 'woo-invoice'); ?></option>
                                        </select>
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="Date-from"> <?php _e('Date From', 'woo-invoice'); ?></label>
                                        <input class="woo-invoice-fixed-width woo-invoice-datepicker woo-invoice-form-control" id ="Date-from" name="wpifw_date_from" placeholder="<?php _e('Date From', 'woo-invoice'); ?>" max="<?php echo date('Y-m-d');?>" required autocomplete="off">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-form-group">
                                        <label class="woo-invoice-custom-label" for="Date-to"> <?php _e('Date To', 'woo-invoice'); ?></label>
                                        <input class="woo-invoice-fixed-width woo-invoice-datepicker woo-invoice-form-control" id ="Date-to" name="wpifw_date_to" placeholder="<?php _e('Date To', 'woo-invoice'); ?>" max="<?php echo date('Y-m-d');?>" required autocomplete="off">
                                    </div><!-- end .woo-invoice-form-group -->

                                    <div class="woo-invoice-card-footer">
                                        <input type="submit" style="float: right;" name="wpifw_submit_bulk_download" value="<?php _e('Download', 'woo-invoice'); ?>" class="woo-invoice-btn woo-invoice-btn-primary" />
                                    </div><!-- end .woo-invoice-card-footer -->

                                </form>
                            </div><!-- end .woo-invoice-card-body -->
                        </div><!-- end .woo-invoice-card -->
                    </div><!-- end .woo-invoice-col-8 -->
                </div><!-- end .woo-invoice-row -->
            </li>
            <!--END BULK DOWNLOAD TAB-->

            <!--START FREE VS PREMIUM TAB-->
            <li>
                <div class="woo-invoice-row">
                    <div class="woo-invoice-col-8">
                        <div class="woo-invoice-card">
                            <div class="woo-invoice-card-body">
                                <table width="100%">
                                    <tr >
                                        <th style="padding: 20px;font-size:18px" width="50%">Features</th>
                                        <th width="25%" style="text-align: center;font-size:18px">Free</th>
                                        <th width="25%" style="text-align: center;font-size:18px">Premium</th>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Automatic Invoicing</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-yes"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Attach to Order Email</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-yes"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Invoice Download From My Account</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-yes"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Custom Date Format</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-yes"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Display ID/SKU</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-yes"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Display Currency Code</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-yes"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Display Payment Method</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-yes"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Packing Slip</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-yes"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Footer Info Section</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-yes"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Bulk Invoice/Packing Slip Download</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-yes"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Invoice Template Translation</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-yes"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Total Tax</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-yes"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Individual Product Tax & Tax %</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Total Without Tax</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Paid Stamp</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Authorized Signature</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Product per Page</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Custom Invoice Numbering Options</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Display Product Image</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Display Product Category</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Display Product Short Description</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Display Discounted Price</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Proforma Invoice</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">WPML Compatibility</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">WooCommerce Subscription Compatibility</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature">Shipping Label Print</td>
                                        <td class="woo-invoice-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
                                        <td class="woo-invoice-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
                                    </tr>
                                    <tfoot>
                                    <tr>
                                        <td class="woo-invoice-proFree-feature"></td>
                                        <td class="woo-invoice-proFree-free"></td>
                                        <td class="woo-invoice-proFree-pro"><a href="http://bit.ly/woo-invoice-free" target="_blank"><button class="woo-invoice-btn woo-invoice-btn-success">Buy Now</button></a></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div><!-- end .woo-invoice-card -->
                        </div><!-- end .woo-invoice-card -->
                    </div><!-- end .woo-invoice-col-8 -->
                </div><!-- end .woo-invoice-row -->
            </li>
            <!--END FREE VS PREMIUM TAB-->

        </div><!-- end .woo-invoice-dashboard-content -->
    </div><!-- end .woo-invoice-dashboard-body -->
</div><!-- end .woo-invoice-wrap -->