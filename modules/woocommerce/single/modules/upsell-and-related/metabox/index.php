<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'NammOrganic_Shop_Metabox_Single_Upsell_Related' ) ) {
    class NammOrganic_Shop_Metabox_Single_Upsell_Related {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

			add_filter( 'namm_organic_shop_product_custom_settings', array( $this, 'namm_organic_shop_product_custom_settings' ), 10 );

		}

        function namm_organic_shop_product_custom_settings( $options ) {

			$ct_dependency      = array ();
			$upsell_dependency  = array ( 'show-upsell', '==', 'true');
			$related_dependency = array ( 'show-related', '==', 'true');
			if( function_exists('namm_organic_shop_single_module_custom_template') ) {
				$ct_dependency['dependency'] 	= array ( 'product-template', '!=', 'custom-template');
				$upsell_dependency 				= array ( 'product-template|show-upsell', '!=|==', 'custom-template|true');
				$related_dependency 			= array ( 'product-template|show-related', '!=|==', 'custom-template|true');
			}

			$product_options = array (

				array_merge (
					array(
						'id'         => 'show-upsell',
						'type'       => 'select',
						'title'      => esc_html__('Show Upsell Products', 'namm-organic'),
						'class'      => 'chosen',
						'default'    => 'admin-option',
						'attributes' => array( 'data-depend-id' => 'show-upsell' ),
						'options'    => array(
							'admin-option' => esc_html__( 'Admin Option', 'namm-organic' ),
							'true'         => esc_html__( 'Show', 'namm-organic'),
							null           => esc_html__( 'Hide', 'namm-organic'),
						)
					),
					$ct_dependency
				),

				array(
					'id'         => 'upsell-column',
					'type'       => 'select',
					'title'      => esc_html__('Choose Upsell Column', 'namm-organic'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'namm-organic' ),
						1              => esc_html__( 'One Column', 'namm-organic' ),
						2              => esc_html__( 'Two Columns', 'namm-organic' ),
						3              => esc_html__( 'Three Columns', 'namm-organic' ),
						4              => esc_html__( 'Four Columns', 'namm-organic' ),
					),
					'dependency' => $upsell_dependency
				),

				array(
					'id'         => 'upsell-limit',
					'type'       => 'select',
					'title'      => esc_html__('Choose Upsell Limit', 'namm-organic'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'namm-organic' ),
						1              => esc_html__( 'One', 'namm-organic' ),
						2              => esc_html__( 'Two', 'namm-organic' ),
						3              => esc_html__( 'Three', 'namm-organic' ),
						4              => esc_html__( 'Four', 'namm-organic' ),
						5              => esc_html__( 'Five', 'namm-organic' ),
						6              => esc_html__( 'Six', 'namm-organic' ),
						7              => esc_html__( 'Seven', 'namm-organic' ),
						8              => esc_html__( 'Eight', 'namm-organic' ),
						9              => esc_html__( 'Nine', 'namm-organic' ),
						10              => esc_html__( 'Ten', 'namm-organic' ),
					),
					'dependency' => $upsell_dependency
				),

				array_merge (
					array(
						'id'         => 'show-related',
						'type'       => 'select',
						'title'      => esc_html__('Show Related Products', 'namm-organic'),
						'class'      => 'chosen',
						'default'    => 'admin-option',
						'attributes' => array( 'data-depend-id' => 'show-related' ),
						'options'    => array(
							'admin-option' => esc_html__( 'Admin Option', 'namm-organic' ),
							'true'         => esc_html__( 'Show', 'namm-organic'),
							null           => esc_html__( 'Hide', 'namm-organic'),
						)
					),
					$ct_dependency
				),

				array(
					'id'         => 'related-column',
					'type'       => 'select',
					'title'      => esc_html__('Choose Related Column', 'namm-organic'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'namm-organic' ),
						2              => esc_html__( 'Two Columns', 'namm-organic' ),
						3              => esc_html__( 'Three Columns', 'namm-organic' ),
						4              => esc_html__( 'Four Columns', 'namm-organic' ),
					),
					'dependency' => $related_dependency
				),

				array(
					'id'         => 'related-limit',
					'type'       => 'select',
					'title'      => esc_html__('Choose Related Limit', 'namm-organic'),
					'class'      => 'chosen',
					'default'    => 4,
					'options'    => array(
						'admin-option' => esc_html__( 'Admin Option', 'namm-organic' ),
						1              => esc_html__( 'One', 'namm-organic' ),
						2              => esc_html__( 'Two', 'namm-organic' ),
						3              => esc_html__( 'Three', 'namm-organic' ),
						4              => esc_html__( 'Four', 'namm-organic' ),
						5              => esc_html__( 'Five', 'namm-organic' ),
						6              => esc_html__( 'Six', 'namm-organic' ),
						7              => esc_html__( 'Seven', 'namm-organic' ),
						8              => esc_html__( 'Eight', 'namm-organic' ),
						9              => esc_html__( 'Nine', 'namm-organic' ),
						10              => esc_html__( 'Ten', 'namm-organic' ),
					),
					'dependency' => $related_dependency
				)

			);

			$options = array_merge( $options, $product_options );

			return $options;

		}

    }
}

NammOrganic_Shop_Metabox_Single_Upsell_Related::instance();