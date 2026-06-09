<?php

/**
 * Listing Options - Product Thumb Content
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'NammOrganic_Woo_Listing_Option_Thumb_Element_Group' ) ) {

    class NammOrganic_Woo_Listing_Option_Thumb_Element_Group extends NammOrganic_Woo_Listing_Option_Core {

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

            $this->option_slug          = 'product-thumb-element-group';
            $this->option_name          = esc_html__('Element Group Content', 'namm-organic');
            $this->option_type          = array ( 'html', 'value-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = '';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {

            /* Custom Product Templates - Options */
            add_filter( 'namm_organic_woo_custom_product_template_thumb_options', array( $this, 'woo_custom_product_template_thumb_options'), 55, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_thumb_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'thumb';
        }

        /**
         * Setting Arguments
         */
        function setting_args() {

            $settings            =  array ();
            $settings['id']      =  $this->option_slug;
            $settings['type']    =  'sorter';
            $settings['title']   =  $this->option_name;
            $settings['default'] =  array (
                'enabled' => array(
                    'title' => esc_html__('Title', 'namm-organic'),
                    'price' => esc_html__('Price', 'namm-organic'),
                ),
                'disabled'         => array(
                    'cart'           => esc_html__('Cart', 'namm-organic'),
                    'wishlist'       => esc_html__('Wishlist', 'namm-organic'),
                    'compare'        => esc_html__('Compare', 'namm-organic'),
                    'quickview'      => esc_html__('Quick View', 'namm-organic'),
                    'category'       => esc_html__('Category', 'namm-organic'),
                    'button_element' => esc_html__('Button Element', 'namm-organic'),
                    'icons_group'    => esc_html__('Icons Group', 'namm-organic'),
                    'excerpt'        => esc_html__('Excerpt', 'namm-organic'),
                    'rating'         => esc_html__('Rating', 'namm-organic'),
                    'separator'      => esc_html__('Separator', 'namm-organic'),
                    'swatches'       => esc_html__('Swatches', 'namm-organic')
                ),
            );
            $settings['enabled_title']  =  esc_html__('Active Elements', 'namm-organic');
            $settings['disabled_title'] =  esc_html__('Deatcive Elements', 'namm-organic');

            return $settings;
        }
    }

}

if( !function_exists('namm_organic_woo_listing_option_thumb_element_group') ) {
	function namm_organic_woo_listing_option_thumb_element_group() {
		return NammOrganic_Woo_Listing_Option_Thumb_Element_Group::instance();
	}
}

namm_organic_woo_listing_option_thumb_element_group();