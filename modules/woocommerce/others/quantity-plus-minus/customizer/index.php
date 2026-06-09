<?php

/**
 * WooCommerce - Others - Quantity Plus Minus - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'NammOrganic_Shop_Customizer_Others_Quantity_Plus_Minus' ) ) {

    class NammOrganic_Shop_Customizer_Others_Quantity_Plus_Minus {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'namm_organic_woo_others_settings', array( $this, 'others_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function others_settings( $settings ) {

            $enable_quantity_plusminus             = namm_organic_customizer_settings('wdt-woo-others-enable-quantity-plusminus' );
            $settings['enable_quantity_plusminus'] = $enable_quantity_plusminus;

            return $settings;

        }

        function register( $wp_customize ) {

            /**
             * Option : Enable Quantity Plus Minus
             */

                $wp_customize->add_setting(
                    NAMM_ORGANIC_CUSTOMISER_VAL . '[wdt-woo-others-enable-quantity-plusminus]', array(
                        'type' => 'option',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    )
                );

                $wp_customize->add_control(
                    new NammOrganic_Customize_Control_Switch(
                        $wp_customize, NAMM_ORGANIC_CUSTOMISER_VAL . '[wdt-woo-others-enable-quantity-plusminus]', array(
                            'type'    => 'wdt-switch',
                            'label'   => esc_html__( 'Enable Quantity Plus Minus', 'namm-organic'),
                            'section' => 'woocommerce-others-section',
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'namm-organic' ),
                                'off' => esc_attr__( 'No', 'namm-organic' )
                            )
                        )
                    )
                );

        }

    }

}


if( !function_exists('namm_organic_shop_customizer_others_quantity_plus_minus') ) {
	function namm_organic_shop_customizer_others_quantity_plus_minus() {
		return NammOrganic_Shop_Customizer_Others_Quantity_Plus_Minus::instance();
	}
}

namm_organic_shop_customizer_others_quantity_plus_minus();