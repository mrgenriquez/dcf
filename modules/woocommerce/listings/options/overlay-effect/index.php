<?php

/**
 * Listing Options - Overlay Effect
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'NammOrganic_Woo_Listing_Option_Overlay_Effect' ) ) {

    class NammOrganic_Woo_Listing_Option_Overlay_Effect extends NammOrganic_Woo_Listing_Option_Core {

        private static $_instance = null;

        public $option_slug;

        public $option_name;

        public $option_type;

        public $option_default_value;

        public $option_value_prefix;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            $this->option_slug          = 'product-overlay-effect';
            $this->option_name          = esc_html__('Overlay Effect', 'namm-organic');
            $this->option_type          = array ( 'class', 'value-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = 'product-overlay-';

            $this->render_backend();

        }

        /*
        Backend Render
        */

            function render_backend() {

                /* Custom Product Templates - Options */
                    add_filter( 'namm_organic_woo_custom_product_template_hover_options', array( $this, 'woo_custom_product_template_hover_options'), 20, 1 );

            }

        /*
        Custom Product Templates - Options
        */
            function woo_custom_product_template_hover_options( $template_options ) {

                array_push( $template_options, $this->setting_args() );

                return $template_options;

            }

        /*
        Setting Group
        */
            function setting_group() {

                return 'hover';

            }

        /*
        Setting Arguments
        */
            function setting_args() {

                $settings                                 =  array ();

                $settings['id']                           =  $this->option_slug;
                $settings['type']                         =  'select';
                $settings['title']                        =  $this->option_name;
                $settings['options']                      =  array (
                    ''                                    => esc_html__('None', 'namm-organic'),
                    'product-overlay-fixed'               => esc_html__('Fixed', 'namm-organic'),
                    'product-overlay-toptobottom'         => esc_html__('Top to Bottom', 'namm-organic'),
                    'product-overlay-bottomtotop'         => esc_html__('Bottom to Top', 'namm-organic'),
                    'product-overlay-righttoleft'         => esc_html__('Right to Left', 'namm-organic'),
                    'product-overlay-lefttoright'         => esc_html__('Left to Right', 'namm-organic'),
                    'product-overlay-middle'              => esc_html__('Middle', 'namm-organic'),
                    'product-overlay-middleradial'        => esc_html__('Middle Radial', 'namm-organic'),
                    'product-overlay-gradienttoptobottom' => esc_html__('Gradient - Top to Bottom', 'namm-organic'),
                    'product-overlay-gradientbottomtotop' => esc_html__('Gradient - Bottom to Top', 'namm-organic'),
                    'product-overlay-gradientrighttoleft' => esc_html__('Gradient - Right to Left', 'namm-organic'),
                    'product-overlay-gradientlefttoright' => esc_html__('Gradient - Left to Right', 'namm-organic'),
                    'product-overlay-gradientradial'      => esc_html__('Gradient - Radial', 'namm-organic'),
                    'product-overlay-flash'               => esc_html__('Flash', 'namm-organic'),
                    'product-overlay-scale'               => esc_html__('Scale', 'namm-organic'),
                    'product-overlay-horizontalelastic'   => esc_html__('Horizontal - Elastic', 'namm-organic'),
                    'product-overlay-verticalelastic'     => esc_html__('Vertical - Elastic', 'namm-organic')
                );
                $settings['default']                      =  $this->option_default_value;

                return $settings;

            }

    }

}

if( !function_exists('namm_organic_woo_listing_option_overlay_effect') ) {
	function namm_organic_woo_listing_option_overlay_effect() {
		return NammOrganic_Woo_Listing_Option_Overlay_Effect::instance();
	}
}

namm_organic_woo_listing_option_overlay_effect();