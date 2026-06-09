<?php
/**
 * Designer Cut Flowers brand defaults.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'namm_organic_dcf_palette' ) ) {
	function namm_organic_dcf_palette() {
		return array(
			'primary'           => '#A7377B',
			'primary_rgb'       => namm_organic_hex2rgba( '#A7377B', false ),
			'secondary'         => '#D99ABF',
			'secondary_rgb'     => namm_organic_hex2rgba( '#D99ABF', false ),
			'tertiary'          => '#F8DCE8',
			'tertiary_rgb'      => namm_organic_hex2rgba( '#F8DCE8', false ),
			'quaternary'        => '#7F2A6D',
			'quaternary_rgb'    => namm_organic_hex2rgba( '#7F2A6D', false ),
			'body_bg'           => '#FFFFFF',
			'body_bg_rgb'       => namm_organic_hex2rgba( '#FFFFFF', false ),
			'body_text'         => '#5E5360',
			'body_text_rgb'     => namm_organic_hex2rgba( '#5E5360', false ),
			'headalt'           => '#17131C',
			'headalt_rgb'       => namm_organic_hex2rgba( '#17131C', false ),
			'link'              => '#17131C',
			'link_rgb'          => namm_organic_hex2rgba( '#17131C', false ),
			'link_hover'        => '#A7377B',
			'link_hover_rgb'    => namm_organic_hex2rgba( '#A7377B', false ),
			'border'            => '#EAD7E3',
			'border_rgb'        => namm_organic_hex2rgba( '#EAD7E3', false ),
			'accent_text'       => '#FFFFFF',
			'accent_text_rgb'   => namm_organic_hex2rgba( '#FFFFFF', false ),
		);
	}
}

if ( ! function_exists( 'namm_organic_dcf_css_var' ) ) {
	function namm_organic_dcf_css_var( $var, $palette_key ) {
		$palette = namm_organic_dcf_palette();
		return isset( $palette[ $palette_key ] ) ? $var . ': ' . $palette[ $palette_key ] . ';' : '';
	}
}

if ( ! function_exists( 'namm_organic_dcf_asset_uri' ) ) {
	function namm_organic_dcf_asset_uri( $file ) {
		return NAMM_ORGANIC_ROOT_URI . '/assets/images/dcf/' . ltrim( $file, '/' );
	}
}

if ( ! function_exists( 'namm_organic_dcf_favicon_links' ) ) {
	function namm_organic_dcf_favicon_links() {
		if ( has_site_icon() ) {
			return;
		}

		$icon = esc_url( namm_organic_dcf_asset_uri( 'icono.svg' ) );
		echo '<link rel="icon" href="' . $icon . '" type="image/svg+xml">' . "\n";
		echo '<link rel="shortcut icon" href="' . $icon . '" type="image/svg+xml">' . "\n";
	}
}

add_action( 'wp_head', 'namm_organic_dcf_favicon_links', 1 );
add_action( 'admin_head', 'namm_organic_dcf_favicon_links', 1 );
add_action( 'login_head', 'namm_organic_dcf_favicon_links', 1 );

add_action( 'wp_head', function() {
	echo '<link rel="preload" href="' . esc_url( namm_organic_dcf_asset_uri( 'logo.svg' ) ) . '" as="image" type="image/svg+xml">' . "\n";
}, 2 );

add_filter( 'namm_organic_primary_color_css_var', function() { return namm_organic_dcf_css_var( '--wdtPrimaryColor', 'primary' ); } );
add_filter( 'namm_organic_primary_rgb_color_css_var', function() { return namm_organic_dcf_css_var( '--wdtPrimaryColorRgb', 'primary_rgb' ); } );
add_filter( 'namm_organic_secondary_color_css_var', function() { return namm_organic_dcf_css_var( '--wdtSecondaryColor', 'secondary' ); } );
add_filter( 'namm_organic_secondary_rgb_color_css_var', function() { return namm_organic_dcf_css_var( '--wdtSecondaryColorRgb', 'secondary_rgb' ); } );
add_filter( 'namm_organic_tertiary_color_css_var', function() { return namm_organic_dcf_css_var( '--wdtTertiaryColor', 'tertiary' ); } );
add_filter( 'namm_organic_tertiary_rgb_color_css_var', function() { return namm_organic_dcf_css_var( '--wdtTertiaryColorRgb', 'tertiary_rgb' ); } );
add_filter( 'namm_organic_quaternary_color_css_var', function() { return namm_organic_dcf_css_var( '--wdtQuaternaryColor', 'quaternary' ); } );
add_filter( 'namm_organic_quaternary_rgb_color_css_var', function() { return namm_organic_dcf_css_var( '--wdtQuaternaryColorRgb', 'quaternary_rgb' ); } );
add_filter( 'namm_organic_body_bg_color_css_var', function() { return namm_organic_dcf_css_var( '--wdtBodyBGColor', 'body_bg' ); } );
add_filter( 'namm_organic_body_bg_rgb_color_css_var', function() { return namm_organic_dcf_css_var( '--wdtBodyBGColorRgb', 'body_bg_rgb' ); } );
add_filter( 'namm_organic_body_text_color_css_var', function() { return namm_organic_dcf_css_var( '--wdtBodyTxtColor', 'body_text' ); } );
add_filter( 'namm_organic_body_text_rgb_color_css_var', function() { return namm_organic_dcf_css_var( '--wdtBodyTxtColorRgb', 'body_text_rgb' ); } );
add_filter( 'namm_organic_headalt_color_css_var', function() { return namm_organic_dcf_css_var( '--wdtHeadAltColor', 'headalt' ); } );
add_filter( 'namm_organic_headalt_rgb_color_css_var', function() { return namm_organic_dcf_css_var( '--wdtHeadAltColorRgb', 'headalt_rgb' ); } );
add_filter( 'namm_organic_link_color_css_var', function() { return namm_organic_dcf_css_var( '--wdtLinkColor', 'link' ); } );
add_filter( 'namm_organic_link_rgb_color_css_var', function() { return namm_organic_dcf_css_var( '--wdtLinkColorRgb', 'link_rgb' ); } );
add_filter( 'namm_organic_link_hover_color_css_var', function() { return namm_organic_dcf_css_var( '--wdtLinkHoverColor', 'link_hover' ); } );
add_filter( 'namm_organic_link_hover_rgb_color_css_var', function() { return namm_organic_dcf_css_var( '--wdtLinkHoverColorRgb', 'link_hover_rgb' ); } );
add_filter( 'namm_organic_border_color_css_var', function() { return namm_organic_dcf_css_var( '--wdtBorderColor', 'border' ); } );
add_filter( 'namm_organic_border_rgb_color_css_var', function() { return namm_organic_dcf_css_var( '--wdtBorderColorRgb', 'border_rgb' ); } );
add_filter( 'namm_organic_accent_text_color_css_var', function() { return namm_organic_dcf_css_var( '--wdtAccentTxtColor', 'accent_text' ); } );
add_filter( 'namm_organic_accent_text_rgb_color_css_var', function() { return namm_organic_dcf_css_var( '--wdtAccentTxtColorRgb', 'accent_text_rgb' ); } );

if ( ! function_exists( 'namm_organic_dcf_typography' ) ) {
	function namm_organic_dcf_typography( $settings ) {
		$settings['font-family']   = 'Montserrat';
		$settings['font-fallback'] = '"Montserrat", sans-serif';
		return $settings;
	}
}

add_filter( 'namm_organic_google_fonts_list', function() {
	return array( 'Montserrat:300,400,500,600,700,800,900' );
} );
add_filter( 'namm_organic_body_typo_customizer_update', 'namm_organic_dcf_typography' );
add_filter( 'namm_organic_h1_typo_customizer_update', 'namm_organic_dcf_typography' );
add_filter( 'namm_organic_h2_typo_customizer_update', 'namm_organic_dcf_typography' );
add_filter( 'namm_organic_h3_typo_customizer_update', 'namm_organic_dcf_typography' );
add_filter( 'namm_organic_h4_typo_customizer_update', 'namm_organic_dcf_typography' );
add_filter( 'namm_organic_h5_typo_customizer_update', 'namm_organic_dcf_typography' );
add_filter( 'namm_organic_h6_typo_customizer_update', 'namm_organic_dcf_typography' );

add_filter( 'body_class', function( $classes ) {
	$classes[] = 'dcf-flowers-theme';
	return $classes;
} );

add_action( 'wp_enqueue_scripts', function() {
	wp_dequeue_style( 'namm-organic-dcf-refresh' );
	wp_enqueue_style(
		'namm-organic-dcf-refresh',
		NAMM_ORGANIC_ROOT_URI . '/assets/css/dcf-refresh.css',
		array( 'namm_organic-theme' ),
		NAMM_ORGANIC_THEME_VERSION,
		'all'
	);
}, 999 );

add_action( 'namm_organic_after_enqueue_js', function() {
	wp_enqueue_script(
		'namm-organic-dcf-layout',
		NAMM_ORGANIC_ROOT_URI . '/assets/js/dcf-layout.js',
		array( 'jquery' ),
		NAMM_ORGANIC_THEME_VERSION,
		true
	);
}, 99 );
