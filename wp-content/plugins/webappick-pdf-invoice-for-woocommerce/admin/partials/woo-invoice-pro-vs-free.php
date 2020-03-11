<?php
/**
 * Premium vs Free version
 *
 * @link       https://webappick.com/
 * @since      1.0.0
 *
 * @package    Woo_woo-invoice
 * @subpackage Woo_invoice/admin/partial
 * @author     Ohidul Islam <wahid@webappick.com>
 * @version    1.3.2
 */
if( ! function_exists( 'add_action' ) ) die();
// ### REF > utm parameters http://bit.ly/woo-invoice-free
$features = array(
    array(
        'thumb'        => esc_url( WAPDFINVOICE_PLUGIN_URL ) . '/admin/images/features/automated-invoicing.svg',
        'title'        => 'Automated Invoicing',
        'description'  => 'This WooCommerce PDF invoice plugin automatically generates woocommerce invoice.',
    ),
    array(
        'thumb'        => esc_url( WAPDFINVOICE_PLUGIN_URL ) . '/admin/images/features/easy-setup.svg',
        'title'        => 'Easy Setup',
        'description'  => 'WooCommerce PDF Invoice pro (Woo Invoice Pro) plugin is straightforward to set up.',
    ),
    array(
        'thumb'        => esc_url( WAPDFINVOICE_PLUGIN_URL ) . 'admin/images/features/packing-slip.svg',
        'title'        => 'Packing Slip',
        'description'  => 'Generate, customize, and print the packing slips for your orders.',
    ),
    array(
        'thumb'        => esc_url( WAPDFINVOICE_PLUGIN_URL ) . 'admin/images/features/signature.svg',
        'title'        => 'Signature',
        'description'  => 'Woo Invoice Pro allows you to attach your signature with invoices.',
    ),
    array(
        'thumb'        => esc_url( WAPDFINVOICE_PLUGIN_URL ) . 'admin/images/features/paid-stamp.svg',
        'title'        => 'Paid Stamp',
        'description'  => 'Include Paid Stamp in your invoice. Paid Stamp indicates that the bill is already paid.',
    ),
    array(
        'thumb'        => esc_url( WAPDFINVOICE_PLUGIN_URL ) . 'admin/images/features/tax.svg',
        'title'        => 'Tax',
        'description'  => 'This plugin supports woocommerce multiple tax classes (rates).',
    ),
    array(
        'thumb'        => esc_url( WAPDFINVOICE_PLUGIN_URL ) . 'admin/images/features/bulk-download.svg',
        'title'        => 'Bulk Download',
        'description'  => 'Export multiple invoices and packaging slips between a custom date range',
    ),
    array(
        'thumb'        => esc_url( WAPDFINVOICE_PLUGIN_URL ) . 'admin/images/features/wpml-compatible.svg',
        'title'        => 'WPML Compatible',
        'description'  => 'Take advantage of Woo Invoice plugin, as it is WPML compatible.',
    ),
);
$pricingFeatures = array(
    __( 'Unlimited Orders', 'webappick-pdf-invoice-for-woocommerce' ),
    __( 'Support for 1 Year', 'webappick-pdf-invoice-for-woocommerce' ),
    __( 'Updates for 1 Year', 'webappick-pdf-invoice-for-woocommerce' ),
    __( 'Automated Invoicing', 'webappick-pdf-invoice-for-woocommerce' ),
    __( 'Easy Setup', 'webappick-pdf-invoice-for-woocommerce' ),
    __( 'Multiple Tax Classes', 'webappick-pdf-invoice-for-woocommerce' ),
    __( 'Attach Signature', 'webappick-pdf-invoice-for-woocommerce' ),
    __( 'Include Paid Stamp', 'webappick-pdf-invoice-for-woocommerce' ),
    __( 'Generate Packing Slip', 'webappick-pdf-invoice-for-woocommerce' ),
    __( 'Bulk Download Support', 'webappick-pdf-invoice-for-woocommerce' ),
    __( 'WPML Compatible', 'webappick-pdf-invoice-for-woocommerce' ),
    __( '3<sup>rd</sup> Party Plugin Supports', 'webappick-pdf-invoice-for-woocommerce'),
);
$pricing = array(
    array(
        'title'             => __( 'Personal', 'webappick-pdf-invoice-for-woocommerce' ),
        'currency'          => '$',
        'amount'            => 59,
        'period'            => __( 'Yearly', 'webappick-pdf-invoice-for-woocommerce' ),
        'allowed_domain'    => 1,
        'featured'          => __( 'Popular', 'webappick-pdf-invoice-for-woocommerce' ),
        'cart_url'          => 'https://webappick.com/plugin/woocommerce-pdf-invoice-packing-slips/?add-to-cart=51372&variation_id=51374&attribute_pa_license=single-site-119-usd',
    ),
    array(
        'title'             => __( 'Plus', 'webappick-pdf-invoice-for-woocommerce' ),
        'currency'          => '$',
        'amount'            => 99,
        'period'            => __( 'Yearly', 'webappick-pdf-invoice-for-woocommerce' ),
        'allowed_domain'    => 5,
        'featured'          => null,
        'cart_url'          => 'https://webappick.com/plugin/woocommerce-pdf-invoice-packing-slips/?add-to-cart=51372&variation_id=51373&attribute_pa_license=two-site-199-usd',
    ),
    array(
        'title'             => __( 'Expert', 'webappick-pdf-invoice-for-woocommerce' ),
        'currency'          => '$',
        'amount'            => 149,
        'period'            => __( 'Yearly', 'webappick-pdf-invoice-for-woocommerce' ),
        'allowed_domain'    => 10,
        'featured'          => null,
        'cart_url'          => 'https://webappick.com/plugin/woocommerce-pdf-invoice-packing-slips/?add-to-cart=51372&variation_id=51375&attribute_pa_license=five-site-229-usd',
    ),
);
$allowedHtml = array( 'br' => array(), 'code' => array(), 'sub' => array(), 'sup' => array(), 'span' => array(), 'a' => array( 'href' => array(), 'target' => array() ), );
ob_start();
foreach( $pricingFeatures as $feature ) { ?>
    <li class="item">
	<span class="woo-invoice-price__table__feature">
		<span class="dashicons dashicons-yes" aria-hidden="true"></span>
		<span><?php echo wp_kses( $feature, $allowedHtml ); ?></span>
	</span>
    </li>
<?php }
$pricingFeatures = ob_get_clean();
$compareTable = array(
    array(
        'title' => __('Automatic Invoicing', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => true,
    ),
    array(
        'title' => __('Attach to Order Email', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => true,
    ),
    array(
        'title' => __('Invoice Download From My Account', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => true,
    ),
    array(
        'title' => __('Custom Date Format', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => true,
    ),
    array(
        'title' => __('Display ID/SKU', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => true,
    ),
    array(
        'title' => __('Display Currency Code', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => true,
    ),
    array(
        'title' => __('Display Payment Method', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => true,
    ),
    array(
        'title' => __('Packing Slip', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => true,
    ),
    array(
        'title' => __('Footer Info Section', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => true,
    ),
    array(
        'title' => __('Bulk Invoice/Packing Slip Download', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => true,
    ),
    array(
        'title' => __('Invoice Template Translation', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => true,
    ),
    array(
        'title' => __('Total Tax', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => true,
    ),
    array(
        'title' => __('Individual Product Tax & Tax %', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => false,
    ),
    array(
        'title' => __('Total Without Tax', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => false,
    ),
    array(
        'title' => __('Paid Stamp', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => false,
    ),
    array(
        'title' => __('Authorized Signature', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => false,
    ),
    array(
        'title' => __('Product per Page', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => false,
    ),
    array(
        'title' => __('Custom Invoice Numbering Options', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => false,
    ),
    array(
        'title' => __('Display Product Image', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => false,
    ),
    array(
        'title' => __('Display Product Category', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => false,
    ),
    array(
        'title' => __('Display Product Short Description', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => false,
    ),
    array(
        'title' => __('Display Discounted Price', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => false,
    ),
    array(
        'title' => __('Proforma Invoice', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => false,
    ),
    array(
        'title' => __('WPML Compatibility', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => false,
    ),
    array(
        'title' => __('WooCommerce Subscription Compatibility', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => false,
    ),
    array(
        'title' => __('Shipping Label Print', 'webappick-pdf-invoice-for-woocommerce'),
        'free' => false,
    ),
);
$compareTableFreeFeatures = $compareTableProFeatures = '';
foreach( $compareTable as $feature ) {
    $compareTableFreeFeatures .= sprintf( '<li class="%s"><span class="dashicons dashicons-%s" aria-hidden="true"></span><span>%s</span></li>', $feature['free'] ? 'available' : 'unavailable', $feature['free'] ? 'yes' : 'no', wp_kses( $feature['title'], $allowedHtml ) );
    $compareTableProFeatures  .= sprintf( '<li class="available"><span class="dashicons dashicons-yes" aria-hidden="true"></span><span>%s</span></li>', wp_kses( $feature['title'], $allowedHtml ) );
}
$testimonials = array(
    array(
        'comment'  => 'Plenty of available options and everything works fine and as expected. Excellent plugin overall. Keep up the good work.',
        'name'     => 'Max D.',
        'meta'     => '',
        'avatar'   => '',
    ),
    array(
        'comment'  => 'Woo Invoice plugin works very well. It\'s very professional, flexible and fantastic. Thanks for making this awesome plugin.',
        'name'     => 'Gracious T.',
        'meta'     => '',
        'avatar'   => '',
    ),
    array(
        'comment'  => 'I was running a woocommerce online store and used the free version for a long time. I needed some more functionalities including price with tax and discount to add in the invoice. So I have switched to the premium version. It works fine, and now I am satisfied using this plugin.',
        'name'     => 'Rosend S.',
        'meta'     => '',
        'avatar'   => '',
    ),
    array(
        'comment'  => 'It saved my valuable time. The support team replied within a couple of hours and helped me in the right direction. Thanks for the kind cooperation.',
        'name'     => 'Juan C.',
        'meta'     => '',
        'avatar'   => '',
    ),
    array(
        'comment'  => 'Pongo cuatro estrellas por que no era compatible con mi versión WordPress,no añadía correctamente las variantes de algún producto en la factura, por lo demás , un plugin fácil de usar, muy cómodo y completo. Serian cinco estrellas perfectamente si fuese compatible con todas las versiones WordPress. El servio técnico es rápido y correcto.',
        'name'     => 'Rubén R.',
        'meta'     => '',
        'avatar'   => '',
    ),
);
?>

<div class="wrap woo-invoice-admin woo-invoice-woo-invoice-pro-upgrade">
    <div class="woo-invoice-section woo-invoice-woo-invoice-banner">
        <div class="woo-invoice-banner">
            <a href="http://bit.ly/woo-invoice-free" target="_blank">
                <img class="woo-invoice-banner__graphics" src="<?php echo esc_url( WAPDFINVOICE_PLUGIN_URL ); ?>admin/images/woo-invoice-pro-banner.svg" alt="<?php esc_attr_e( 'Upgrade to Wooinvoice Pro to unlock more powerful features.', 'webappick-pdf-invoice-for-woocommerce' ); ?>">
            </a>
        </div>
    </div>
    <div class="clear"></div>
    <div class="woo-invoice-section woo-invoice-features">
        <div class="section-title">
            <h2><?php esc_html_e( 'Why Upgrade', 'woo-woo-invoice' ); ?></h2>
            <span class="section-sub-title"><?php esc_html_e( 'Super charge your Store with awesome features', 'woo-woo-invoice' ); ?></span>
        </div>
        <div class="woo-invoice-feature__list">
            <?php foreach( $features as $feature ) { ?>
                <div class="woo-invoice-feature__item">
                    <div class="woo-invoice-feature__thumb">
                        <img src="<?php echo esc_url( $feature['thumb'] ); ?>" alt="<?php echo esc_attr( $feature['title'] ); ?>" title="<?php echo esc_attr( $feature['title'] ); ?>">
                    </div>
                    <div class="woo-invoice-feature__description">
                        <h3><?php echo wp_kses( $feature['title'], $allowedHtml ); ?></h3>
                        <p><?php echo wp_kses( $feature['description'], $allowedHtml ); ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="woo-invoice-features__more">
            <a class="woo-invoice-button woo-invoice-button-primary woo-invoice-button-hero" href="http://bit.ly/woo-invoice-free" target="_blank">See All Features <svg aria-hidden="true" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 17.5 12.5" xml:space="preserve"><path d="M10.6,1.5c-0.4-0.4-0.4-0.9,0-1.3c0.4-0.3,0.9-0.3,1.3,0l5.3,5.3c0.2,0.2,0.3,0.4,0.3,0.7s-0.1,0.5-0.3,0.7 l-5.3,5.3c-0.4,0.4-0.9,0.4-1.3,0c-0.4-0.4-0.4-0.9,0-1.3l3.8-3.8H0.9C0.4,7.1,0,6.7,0,6.2s0.4-0.9,0.9-0.9h13.5L10.6,1.5z M10.6,1.5"></path></svg></a>
        </div>
    </div>
    <div class="clear"></div>
    <div class="woo-invoice-section woo-invoice-pro-comparison">
        <div class="section-title">
            <h2 id="comparison-header"><?php printf( '%s <span>%s</span> %s', esc_html__( 'Free', 'woo-woo-invoice' ), esc_html__( 'vs', 'woo-woo-invoice' ), esc_html__( 'Pro', 'woo-woo-invoice' ) ); ?></h2>
            <span class="section-sub-title" id="comparison-sub-header"><?php esc_html_e( 'Find the plan that suits best for you business', 'woo-woo-invoice' ); ?></span>
        </div>
        <div class="comparison-table">
            <div class="comparison free">
                <div class="product-header">
                    <img src="<?php echo esc_url( WAPDFINVOICE_PLUGIN_URL ); ?>admin/images/woo-invoice-lite.svg" alt="<?php esc_attr_e( 'Woowoo-invoice Lite', 'woo-woo-invoice' ); ?>">
                </div>
                <ul class="product-features">
                    <?php print( $compareTableFreeFeatures ); ?>
                </ul>
            </div>
            <div class="comparison pro">
                <div class="product-header">
                    <img src="<?php echo esc_url( WAPDFINVOICE_PLUGIN_URL ); ?>admin/images/woo-invoice-pro.svg" alt="<?php esc_attr_e( 'Woowoo-invoice Pro', 'woo-woo-invoice' ); ?>">
                </div>
                <ul class="product-features">
                    <?php print( $compareTableProFeatures ); ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="woo-invoice-section woo-invoice-pricing">
        <div class="section-title">
            <h2 id="pricing_header"><?php esc_html_e( 'Take Your Products To The Next Level', 'woo-woo-invoice' ); ?></h2>
            <span class="section-sub-title" id="pricing_sub_header"><?php esc_html_e( 'Choose your subscription plan and get started', 'woo-woo-invoice' ); ?></span>
        </div>
        <div class="woo-invoice-pricing__table">
            <?php foreach( $pricing as $price ) {
                $integer = $decimal = 0;
                if( false !== strpos( $price['amount'], '.' ) ) list( $integer, $decimal ) = array_map( 'intval', explode( '.', (string) $price['amount'] ) );
                else $integer = $price['amount'];
                ?>
                <div class="woo-invoice-pricing__table__item">
                    <div class="woo-invoice-price__table__wrapper">
                        <div class="woo-invoice-price__table" role="table" aria-labelledby="pricing_header" aria-describedby="pricing_sub_header">
                            <div class="woo-invoice-price__table__header">
                                <h3 class="woo-invoice-price__table__heading"><?php echo esc_html( $price['title'] ); ?></h3>
                            </div>
                            <div class="woo-invoice-price__table__price">
                                <?php if( $integer > 0 || $decimal > 0 ) { ?>
                                    <span class="woo-invoice-price__table__currency"><?php echo esc_html( $price['currency'] ); ?></span>
                                <?php } ?>
                                <span class="woo-invoice-price__table__amount"><?php
                                    if( $integer == 0 && $decimal == 0 ) printf( '<span class="free">%s</span>', esc_html_x( 'Free', 'Free Package Price Display', 'woo-woo-invoice' ) );
                                    if( $integer > 0 || $decimal > 0 ) printf( '<span class="integer-part">%d</span>', esc_html( $integer ) );
                                    if( $decimal > 0 ) printf( '<span class="decimal-part">.%d</span>', esc_html( $integer ) );
                                    if( ! empty( $price['period'] ) ) printf( '<span class="period">/%s</span>', $price['period'] );
                                    ?></span>
                                <?php if( ! empty( $price['allowed_domain'] ) ) {
                                    if( is_numeric( $price['allowed_domain'] ) ) {
                                        $allowed = sprintf(
                                            _n( 'For %d Site', 'For %d Sites', $price['allowed_domain'], 'woo-woo-invoice' ),
                                            $price['allowed_domain']
                                        );
                                    } else $allowed = esc_html( $price['allowed_domain'] );
                                    printf( '<span class="woo-invoice-price__table__amount___legend">%s</span>', $allowed );
                                } ?>
                            </div>
                            <?php printf( '<ul class="woo-invoice-price__table__features">%s</ul>', $pricingFeatures ); ?>
                            <div class="woo-invoice-price__table__footer">
                                <a href="<?php echo esc_url( $price['cart_url'] . '&utm_source=freePlugin&utm_medium=go_premium&utm_campaign=free_to_pro&utm_term=woowoo-invoice' ); ?>" class="woo-invoice-button woo-invoice-button-primary woo-invoice-button-hero" target="_blank"><?php esc_html_e( 'Buy Now', 'woo-woo-invoice' ); ?></a>
                            </div>
                        </div>
                        <?php if( ! empty( $price['featured'] ) ) { ?>
                            <div class="woo-invoice-price__table__ribbon">
                                <div class="woo-invoice-price__table__ribbon__inner"><?php echo esc_html( $price['featured'] ); ?></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="clear"></div>
    <div class="woo-invoice-section woo-invoice-payment">
        <div class="payment-guarantee">
            <div class="guarantee-seal">
                <img src="<?php echo esc_url( WAPDFINVOICE_PLUGIN_URL ); ?>admin/images/14-days-money-back-guarantee.svg" alt="<?php esc_html_e( '14 Days Money Back Guarantee', 'woo-woo-invoice' ); ?>">
            </div>
            <div class="guarantee-detail">
                <h2><?php esc_html_e( '14 Days Money Back Guarantee', 'woo-woo-invoice' ); ?></h2>
                <p><?php esc_html_e( 'After successful purchase, you will be eligible for conditional refund', 'woo-woo-invoice' ); ?></p>
                <a href="https://webappick.com/refund-policy/" target="_blank"><span class="dashicons dashicons-visibility" aria-hidden="true"></span> <?php esc_html_e( 'Refund Policy', 'woo-woo-invoice' ); ?></a>
            </div>
        </div>
        <div class="payment-options">
            <h3><?php esc_html_e( 'Payment Options:', 'woo-woo-invoice' ); ?></h3>
            <div class="options">
                <h4><?php esc_attr_e( 'Credit Cards (Stripe)', 'woo-woo-invoice' ); ?></h4>
                <ul>
                    <li><img src="<?php echo esc_url( WAPDFINVOICE_PLUGIN_URL ); ?>admin/images/payment-options/visa.svg" alt="<?php esc_attr_e( 'Visa', 'woo-woo-invoice' ); ?>"></li>
                    <li><img src="<?php echo esc_url( WAPDFINVOICE_PLUGIN_URL ); ?>admin/images/payment-options/amex.svg" alt="<?php esc_attr_e( 'American Express', 'woo-woo-invoice' ); ?>"></li>
                    <li><img src="<?php echo esc_url( WAPDFINVOICE_PLUGIN_URL ); ?>admin/images/payment-options/mastercard.svg" alt="<?php esc_attr_e( 'Mastercard', 'woo-woo-invoice' ); ?>"></li>
                    <li><img src="<?php echo esc_url( WAPDFINVOICE_PLUGIN_URL ); ?>admin/images/payment-options/discover.svg" alt="<?php esc_attr_e( 'Discover', 'woo-woo-invoice' ); ?>"></li>
                    <li><img src="<?php echo esc_url( WAPDFINVOICE_PLUGIN_URL ); ?>admin/images/payment-options/jcb.svg" alt="<?php esc_attr_e( 'JCB', 'woo-woo-invoice' ); ?>"></li>
                    <li><img src="<?php echo esc_url( WAPDFINVOICE_PLUGIN_URL ); ?>admin/images/payment-options/diners.svg" alt="<?php esc_attr_e( 'Diners', 'woo-woo-invoice' ); ?>"></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="woo-invoice-section woo-invoice-testimonial">
        <div class="section-title">
            <h2><?php esc_html_e( 'Our Happy Customer', 'woo-woo-invoice' ); ?></h2>
            <span class="section-sub-title"><?php esc_html_e( 'Join the squad today!', 'woo-woo-invoice' ); ?></span>
        </div>
        <div class="woo-invoice-testimonial-wrapper">
            <div class="woo-invoice-slider">
                <?php foreach( $testimonials as $testimonial ) { ?>
                    <div class="testimonial-item">
                        <div class="testimonial-item__comment">
                            <p><?php echo wp_kses( $testimonial['comment'], $allowedHtml ); ?></p>
                        </div>
                        <div class="testimonial-item__user">
                            <?php /*<div class="avatar">
							<img src="<?php echo esc_url( $testimonial['avatar'] ); ?>" alt="<?php echo esc_attr( $testimonial['name'] ); ?>">
						</div>*/ ?>
                            <h4 class="author-name"><?php echo esc_html( $testimonial['name'] ); ?></h4>
                            <?php if( isset( $testimonial['meta'] ) && ! empty( $testimonial['meta'] ) ) { ?>
                                <span class="author-meta"><?php echo esc_html( $testimonial['meta'] ); ?></span>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="woo-invoice-section woo-invoice-woo-invoice-cta">
        <div class="woo-invoice-cta">
            <div class="woo-invoice-cta-icon">
                <span class="dashicons dashicons-editor-help" aria-hidden="true"></span>
            </div>
            <div class="woo-invoice-cta-content">
                <h2><?php _e( 'Still need help?', 'woo-woo-invoice' ); ?></h2>
                <p><?php _e( 'Have we not answered your question?<br>Don\'t worry, you can contact us for more information...', 'woo-woo-invoice') ?></p>
            </div>
            <div class="woo-invoice-cta-action">
                <a href="https://webappick.com/support/" class="woo-invoice-button woo-invoice-button-primary" target="_blank"><?php _e( 'Get Support', 'woo-woo-invoice' ); ?></a>
            </div>
        </div>
    </div>
</div>