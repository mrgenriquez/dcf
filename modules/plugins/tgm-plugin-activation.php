<?php
/**
 * Recommends plugins for use with the theme via the TGMA Script
 *
 * @package NammOrganic WordPress theme
 */

function namm_organic_tgmpa_plugins_register() {

	// Get array of recommended plugins.

	$plugins_list = array(
        array(
            'name'               => esc_html__('Namm Organic Plus', 'namm-organic'),
            'slug'               => 'namm-organic-plus',
            'source'             => NAMM_ORGANIC_MODULE_DIR . '/plugins/namm-organic-plus.zip',
            'required'           => true,
            'version'            => '1.0.6',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => esc_html__('Namm Organic Pro', 'namm-organic'),
            'slug'               => 'namm-organic-pro',
            'source'             => NAMM_ORGANIC_MODULE_DIR . '/plugins/namm-organic-pro.zip',
            'required'           => true,
            'version'            => '1.0.4',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'     => esc_html__('Elementor', 'namm-organic'),
            'slug'     => 'elementor',
            'required' => true,
        ),
        array(
            'name'               => esc_html__('WeDesignTech Elementor Addon', 'namm-organic'),
            'slug'               => 'wedesigntech-elementor-addon',
            'source'             => NAMM_ORGANIC_MODULE_DIR . '/plugins/wedesigntech-elementor-addon.zip',
            'required'           => true,
            'version'            => '1.0.9',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => esc_html__('WeDesignTech Portfolio', 'namm-organic'),
            'slug'               => 'wedesigntech-portfolio',
            'source'             => NAMM_ORGANIC_MODULE_DIR . '/plugins/wedesigntech-portfolio.zip',
            'required'           => true,
            'version'            => '1.0.3',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'     => esc_html__('WooCommerce', 'namm-organic'),
            'slug'     => 'woocommerce',
            'required' => false,
        ),
        array(
            'name'               => esc_html__('Namm Organic Shop', 'namm-organic'),
            'slug'               => 'namm-organic-shop',
            'source'             => NAMM_ORGANIC_MODULE_DIR . '/plugins/namm-organic-shop.zip',
            'required'           => false,
            'version'            => '1.0.2',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'     => esc_html__('YITH WooCommerce Wishlist', 'namm-organic'),
            'slug'     => 'yith-woocommerce-wishlist',
            'required' => false,
        ),
        array(
            'name'     => esc_html__('Contact Form 7', 'namm-organic'),
            'slug'     => 'contact-form-7',
            'required' => true,
        ),
        array(
            'name'     => esc_html__('Woocommerce Currency Switcher', 'namm-organic'),
            'slug'     => 'woocommerce-currency-switcher',
            'required' => false,
        ),
        array(
            'name'     => esc_html__('One Click Demo Import', 'namm-organic'),
            'slug'     => 'one-click-demo-import',
            'required' => true,
        )
	);
   
    $plugins = apply_filters('namm_organic_required_plugins_list', $plugins_list);
	// Register notice
	tgmpa( $plugins, array(
		'id'           => 'namm_organic_theme',
		'domain'       => 'namm-organic',
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,
		'is_automatic' => true,
		'dismissable'  => true,
	) );

}
add_action( 'tgmpa_register', 'namm_organic_tgmpa_plugins_register' );
