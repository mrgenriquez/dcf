<?php
/**
 * Listing Options - Image Effect
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'NammOrganic_Woo_Listing_Option_Label_Design' ) ) {

    class NammOrganic_Woo_Listing_Option_Label_Design extends NammOrganic_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-label-design';
            $this->option_name          = esc_html__('Product Label Design', 'namm-organic');
            $this->option_type          = array ( 'class', 'value-css' );
            $this->option_default_value = 'product-label-boxed';
            $this->option_value_prefix  = 'product-label-';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'namm_organic_woo_custom_product_template_common_options', array( $this, 'woo_custom_product_template_common_options'), 75, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_common_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'common';
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
                'product-label-boxed'      => esc_html__('Boxed', 'namm-organic'),
                'product-label-circle'  => esc_html__('Circle', 'namm-organic'),
                'product-label-rounded'   => esc_html__('Rounded', 'namm-organic'),
                'product-label-angular'   => esc_html__('Angular', 'namm-organic'),
                'product-label-ribbon'   => esc_html__('Ribbon', 'namm-organic'),
            );
            $settings['default'] =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('namm_organic_woo_listing_option_label_design') ) {
	function namm_organic_woo_listing_option_label_design() {
		return NammOrganic_Woo_Listing_Option_Label_Design::instance();
	}
}

namm_organic_woo_listing_option_label_design();