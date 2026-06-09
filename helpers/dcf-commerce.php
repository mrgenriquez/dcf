<?php
/**
 * DCF commerce defaults.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'namm_organic_required_plugins_list', function( $plugins ) {
	return array_values( array_filter( $plugins, function( $plugin ) {
		return empty( $plugin['slug'] ) || 'yith-woocommerce-compare' !== $plugin['slug'];
	} ) );
} );

if ( ! function_exists( 'namm_organic_dcf_disable_compare' ) ) {
	function namm_organic_dcf_disable_compare() {
		remove_action( 'namm_organic_woo_loop_product_button_elements_compare', 'namm_organic_shop_woo_loop_product_button_elements_compare' );

		if ( function_exists( 'namm_organic_woo_remove_anonymous_object_action' ) ) {
			namm_organic_woo_remove_anonymous_object_action( 'woocommerce_after_shop_loop_item', 'YITH_Woocompare_Frontend', 'add_compare_link', 20 );
			namm_organic_woo_remove_anonymous_object_action( 'woocommerce_single_product_summary', 'YITH_Woocompare_Frontend', 'add_compare_link', 35 );
		}
	}
}

add_action( 'after_setup_theme', 'namm_organic_dcf_disable_compare', 100 );
add_action( 'init', 'namm_organic_dcf_disable_compare', 100 );
add_action( 'wp_loaded', 'namm_organic_dcf_disable_compare', 100 );

add_filter( 'woocommerce_product_add_to_cart_text', function( $text, $product ) {
	if ( ! $product instanceof WC_Product ) {
		return $text;
	}

	if ( ! $product->is_in_stock() ) {
		return __( 'View product', 'namm-organic' );
	}

	if ( $product->is_type( 'grouped' ) ) {
		return __( 'View products', 'namm-organic' );
	}

	return __( 'Buy', 'namm-organic' );
}, 999, 2 );

add_filter( 'woocommerce_product_single_add_to_cart_text', function() {
	return __( 'Buy', 'namm-organic' );
}, 999 );

add_filter( 'gettext', function( $translated, $text, $domain ) {
	if ( 'woocommerce' !== $domain ) {
		return $translated;
	}

	$labels = array(
		'Add to cart'    => __( 'Buy', 'namm-organic' ),
		'Buy product'    => __( 'Buy', 'namm-organic' ),
		'Select options' => __( 'Buy', 'namm-organic' ),
		'Read more'      => __( 'View product', 'namm-organic' ),
	);

	return $labels[ $text ] ?? $translated;
}, 20, 3 );

add_action( 'woocommerce_after_shop_loop_item', function() {
	global $product;

	if ( ! $product instanceof WC_Product ) {
		return;
	}

	echo '<div class="dcf-product-card-action">';
	echo '<a class="button dcf-view-details-button" href="' . esc_url( $product->get_permalink() ) . '">' . esc_html__( 'View details', 'namm-organic' ) . '</a>';
	echo '</div>';
}, 80 );

add_action( 'wp_enqueue_scripts', function() {
	$css = '
		.compare,
		.yith-woocompare-button,
		.wccm_btn_wrapper,
		table.compare-list {
			display: none !important;
		}
	';

	wp_register_style( 'namm-organic-dcf-commerce', false, array(), NAMM_ORGANIC_THEME_VERSION );
	wp_enqueue_style( 'namm-organic-dcf-commerce' );
	wp_add_inline_style( 'namm-organic-dcf-commerce', $css );
}, 80 );
