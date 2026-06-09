<?php

/**
 * WooCommerce - Single - Module - Upsell & Related - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'NammOrganic_Shop_Customizer_Single_Upsell_Related' ) ) {

    class NammOrganic_Shop_Customizer_Single_Upsell_Related {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function register( $wp_customize ) {

            /**************
             *  Upsell
             **************/

                /**
                * Option : Show Upsell Products
                */
                    $wp_customize->add_setting(
                        NAMM_ORGANIC_CUSTOMISER_VAL . '[wdt-single-product-upsell-display]', array(
                            'type' => 'option',
                            'sanitize_callback' => 'wp_filter_nohtml_kses'
                        )
                    );

                    $wp_customize->add_control(
                        new NammOrganic_Customize_Control_Switch(
                            $wp_customize, NAMM_ORGANIC_CUSTOMISER_VAL . '[wdt-single-product-upsell-display]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Upsell Products', 'namm-organic'),
                                'section' => 'woocommerce-single-page-upsell-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'namm-organic' ),
                                    'off' => esc_attr__( 'No', 'namm-organic' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Upsell Title
                 */
                    $wp_customize->add_setting(
                        NAMM_ORGANIC_CUSTOMISER_VAL . '[wdt-single-product-upsell-title]', array(
                            'type' => 'option',
                            'sanitize_callback' => 'wp_filter_nohtml_kses'
                        )
                    );

                    $wp_customize->add_control(
                        NAMM_ORGANIC_CUSTOMISER_VAL . '[wdt-single-product-upsell-title]', array(
                            'type'       => 'text',
                            'section'    => 'woocommerce-single-page-upsell-section',
                            'label'      => esc_html__( 'Upsell Title', 'namm-organic' )
                        )
                    );

                /**
                 * Option : Upsell Column
                 */
                    $wp_customize->add_setting(
                        NAMM_ORGANIC_CUSTOMISER_VAL . '[wdt-single-product-upsell-column]', array(
                            'type' => 'option',
                            'sanitize_callback' => 'wp_filter_nohtml_kses'
                        )
                    );

                    $wp_customize->add_control( new NammOrganic_Customize_Control_Radio_Image(
                        $wp_customize, NAMM_ORGANIC_CUSTOMISER_VAL . '[wdt-single-product-upsell-column]', array(
                            'type' => 'wdt-radio-image',
                            'label' => esc_html__( 'Upsell Column', 'namm-organic'),
                            'section' => 'woocommerce-single-page-upsell-section',
                            'choices' => apply_filters( 'namm_organic_woo_upsell_columns_options', array(
                                1 => array(
                                    'label' => esc_html__( 'One Column', 'namm-organic' ),
                                    'path' => namm_organic_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-column.png'
                                ),
                                2 => array(
                                    'label' => esc_html__( 'One Half Column', 'namm-organic' ),
                                    'path' => namm_organic_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-half-column.png'
                                ),
                                3 => array(
                                    'label' => esc_html__( 'One Third Column', 'namm-organic' ),
                                    'path' => namm_organic_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-third-column.png'
                                ),
                                4 => array(
                                    'label' => esc_html__( 'One Fourth Column', 'namm-organic' ),
                                    'path' => namm_organic_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-fourth-column.png'
                                )
                            ))
                        )
                    ));


                /**
                * Option : Upsell Limit
                */
                    $wp_customize->add_setting(
                        NAMM_ORGANIC_CUSTOMISER_VAL . '[wdt-single-product-upsell-limit]', array(
                            'type' => 'option',
                            'sanitize_callback' => 'wp_filter_nohtml_kses'
                        )
                    );

                    $wp_customize->add_control(
                        new NammOrganic_Customize_Control(
                            $wp_customize, NAMM_ORGANIC_CUSTOMISER_VAL . '[wdt-single-product-upsell-limit]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Upsell Limit', 'namm-organic'),
                                'section'  => 'woocommerce-single-page-upsell-section',
                                'choices'  => array (
                                    1 => esc_html__( '1', 'namm-organic' ),
                                    2 => esc_html__( '2', 'namm-organic' ),
                                    3 => esc_html__( '3', 'namm-organic' ),
                                    4 => esc_html__( '4', 'namm-organic' ),
                                    5 => esc_html__( '5', 'namm-organic' ),
                                    6 => esc_html__( '6', 'namm-organic' ),
                                    7 => esc_html__( '7', 'namm-organic' ),
                                    8 => esc_html__( '8', 'namm-organic' ),
                                    9 => esc_html__( '9', 'namm-organic' ),
                                    10 => esc_html__( '10', 'namm-organic' ),
                                )
                            )
                        )
                    );

                /**
                 * Option : Product Style Template
                 */
                    $wp_customize->add_setting(
                        NAMM_ORGANIC_CUSTOMISER_VAL . '[wdt-single-product-upsell-style-template]', array(
                            'type' => 'option',
                            'sanitize_callback' => 'wp_filter_nohtml_kses'
                        )
                    );

                    $wp_customize->add_control(
                        new NammOrganic_Customize_Control(
                            $wp_customize, NAMM_ORGANIC_CUSTOMISER_VAL . '[wdt-single-product-upsell-style-template]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Product Style Template', 'namm-organic'),
                                'section'  => 'woocommerce-single-page-upsell-section',
                                'choices'  => namm_organic_woo_listing_customizer_settings()->product_templates_list()
                            )
                        )
                    );


            /**************
             *  Related
             **************/

                /**
                * Option : Show Related Products
                */
                    $wp_customize->add_setting(
                        NAMM_ORGANIC_CUSTOMISER_VAL . '[wdt-single-product-related-display]', array(
                            'type' => 'option',
                            'sanitize_callback' => 'wp_filter_nohtml_kses'
                        )
                    );

                    $wp_customize->add_control(
                        new NammOrganic_Customize_Control_Switch(
                            $wp_customize, NAMM_ORGANIC_CUSTOMISER_VAL . '[wdt-single-product-related-display]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Related Products', 'namm-organic'),
                                'section' => 'woocommerce-single-page-related-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'namm-organic' ),
                                    'off' => esc_attr__( 'No', 'namm-organic' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Related Title
                 */
                    $wp_customize->add_setting(
                        NAMM_ORGANIC_CUSTOMISER_VAL . '[wdt-single-product-related-title]', array(
                            'type' => 'option',
                            'sanitize_callback' => 'wp_filter_nohtml_kses'
                        )
                    );

                    $wp_customize->add_control(
                        NAMM_ORGANIC_CUSTOMISER_VAL . '[wdt-single-product-related-title]', array(
                            'type'       => 'text',
                            'section'    => 'woocommerce-single-page-related-section',
                            'label'      => esc_html__( 'Related Title', 'namm-organic' )
                        )
                    );

                /**
                 * Option : Related Column
                 */
                    $wp_customize->add_setting(
                        NAMM_ORGANIC_CUSTOMISER_VAL . '[wdt-single-product-related-column]', array(
                            'type' => 'option',
                            'sanitize_callback' => 'wp_filter_nohtml_kses'
                        )
                    );

                    $wp_customize->add_control( new NammOrganic_Customize_Control_Radio_Image(
                        $wp_customize, NAMM_ORGANIC_CUSTOMISER_VAL . '[wdt-single-product-related-column]', array(
                            'type' => 'wdt-radio-image',
                            'label' => esc_html__( 'Related Column', 'namm-organic'),
                            'section' => 'woocommerce-single-page-related-section',
                            'choices' => apply_filters( 'namm_organic_woo_related_columns_options', array(
                                1 => array(
                                    'label' => esc_html__( 'One Column', 'namm-organic' ),
                                    'path' => namm_organic_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-column.png'
                                ),
                                2 => array(
                                    'label' => esc_html__( 'One Half Column', 'namm-organic' ),
                                    'path' => namm_organic_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-half-column.png'
                                ),
                                3 => array(
                                    'label' => esc_html__( 'One Third Column', 'namm-organic' ),
                                    'path' => namm_organic_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-third-column.png'
                                ),
                                4 => array(
                                    'label' => esc_html__( 'One Fourth Column', 'namm-organic' ),
                                    'path' => namm_organic_shop_single_module_upsell_related()->module_dir_url() . 'customizer/images/one-fourth-column.png'
                                )
                            ))
                        )
                    ));


                /**
                * Option : Related Limit
                */
                    $wp_customize->add_setting(
                        NAMM_ORGANIC_CUSTOMISER_VAL . '[wdt-single-product-related-limit]', array(
                            'type' => 'option',
                            'sanitize_callback' => 'wp_filter_nohtml_kses'
                        )
                    );

                    $wp_customize->add_control(
                        new NammOrganic_Customize_Control(
                            $wp_customize, NAMM_ORGANIC_CUSTOMISER_VAL . '[wdt-single-product-related-limit]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Related Limit', 'namm-organic'),
                                'section'  => 'woocommerce-single-page-related-section',
                                'choices'  => array (
                                    1 => esc_html__( '1', 'namm-organic' ),
                                    2 => esc_html__( '2', 'namm-organic' ),
                                    3 => esc_html__( '3', 'namm-organic' ),
                                    4 => esc_html__( '4', 'namm-organic' ),
                                    5 => esc_html__( '5', 'namm-organic' ),
                                    6 => esc_html__( '6', 'namm-organic' ),
                                    7 => esc_html__( '7', 'namm-organic' ),
                                    8 => esc_html__( '8', 'namm-organic' ),
                                    9 => esc_html__( '9', 'namm-organic' ),
                                    10 => esc_html__( '10', 'namm-organic' ),
                                )
                            )
                        )
                    );

                /**
                 * Option : Product Style Template
                 */
                    $wp_customize->add_setting(
                        NAMM_ORGANIC_CUSTOMISER_VAL . '[wdt-single-product-related-style-template]', array(
                            'type' => 'option',
                            'sanitize_callback' => 'wp_filter_nohtml_kses'
                        )
                    );

                    $wp_customize->add_control(
                        new NammOrganic_Customize_Control(
                            $wp_customize, NAMM_ORGANIC_CUSTOMISER_VAL . '[wdt-single-product-related-style-template]', array(
                                'type'     => 'select',
                                'label'    => esc_html__( 'Product Style Template', 'namm-organic'),
                                'section'  => 'woocommerce-single-page-related-section',
                                'choices'  => namm_organic_woo_listing_customizer_settings()->product_templates_list()
                            )
                        )
                    );


        }

    }

}


if( !function_exists('namm_organic_shop_customizer_single_upsell_related') ) {
	function namm_organic_shop_customizer_single_upsell_related() {
		return NammOrganic_Shop_Customizer_Single_Upsell_Related::instance();
	}
}

namm_organic_shop_customizer_single_upsell_related();