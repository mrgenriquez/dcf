<?php
/**
 * Listing Options - Image Effect
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'NammOrganic_Woo_Listing_Option_Hover_Image_Effect' ) ) {

    class NammOrganic_Woo_Listing_Option_Hover_Image_Effect extends NammOrganic_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-hover-image-effect';
            $this->option_name          = esc_html__('Image Effect', 'namm-organic');
            $this->option_type          = array ( 'class', 'value-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = 'product-hover-image-';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'namm_organic_woo_custom_product_template_hover_options', array( $this, 'woo_custom_product_template_hover_options'), 10, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_hover_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'hover';
        }

        /**
         * Setting Args
         */
        function setting_args() {
            $settings            =  array ();
            $settings['id']      =  $this->option_slug;
            $settings['type']    =  'select';
            $settings['title']   =  $this->option_name;
            $settings['options'] =  array (
                ''                                => esc_html__('None', 'namm-organic'),
                'product-hover-image-blur'        => esc_html__('Blur', 'namm-organic'),
                'product-hover-image-blackwhite'  => esc_html__('Black & White', 'namm-organic'),
                'product-hover-image-fadeinleft'  => esc_html__('Fade In Left', 'namm-organic'),
                'product-hover-image-fadeinright' => esc_html__('Fade In Right', 'namm-organic'),
                'product-hover-image-rotate'      => esc_html__('Rotate', 'namm-organic'),
                'product-hover-image-rotatealt'   => esc_html__('Rotate - Alt', 'namm-organic'),
                'product-hover-image-scalein'     => esc_html__('Scale In', 'namm-organic'),
                'product-hover-image-scaleout'    => esc_html__('Scale Out', 'namm-organic'),
                'product-hover-image-floatout'    => esc_html__('Float Up', 'namm-organic')

            );
            $settings['default'] =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('namm_organic_woo_listing_option_hover_image_effect') ) {
	function namm_organic_woo_listing_option_hover_image_effect() {
		return NammOrganic_Woo_Listing_Option_Hover_Image_Effect::instance();
	}
}

namm_organic_woo_listing_option_hover_image_effect();