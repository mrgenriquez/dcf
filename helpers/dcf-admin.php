<?php
/**
 * DCF login and admin experience.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'DCF_ADMIN_SLUG' ) ) {
	define( 'DCF_ADMIN_SLUG', 'dcf-admin' );
}

if ( ! function_exists( 'namm_organic_dcf_admin_url' ) ) {
	function namm_organic_dcf_admin_url( $redirect_to = '' ) {
		$args = array();

		if ( $redirect_to ) {
			$args['redirect_to'] = $redirect_to;
		}

		$url = home_url( '/' . DCF_ADMIN_SLUG . '/' );

		return $args ? add_query_arg( $args, $url ) : $url;
	}
}

if ( ! function_exists( 'namm_organic_dcf_handle_admin_route' ) ) {
	function namm_organic_dcf_handle_admin_route() {
		$request_path = isset( $_SERVER['REQUEST_URI'] ) ? wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH ) : '';
		$request_path = trim( (string) $request_path, '/' );

		if ( DCF_ADMIN_SLUG !== $request_path ) {
			return;
		}

		$redirect_to = isset( $_GET['redirect_to'] ) ? rawurldecode( sanitize_text_field( wp_unslash( $_GET['redirect_to'] ) ) ) : admin_url();

		if ( is_user_logged_in() ) {
			wp_safe_redirect( $redirect_to );
			exit;
		}

		wp_safe_redirect(
			add_query_arg(
				array(
					'dcf-login'   => '1',
					'redirect_to' => $redirect_to,
				),
				site_url( 'wp-login.php', 'login' )
			)
		);
		exit;
	}
}

add_action( 'init', 'namm_organic_dcf_handle_admin_route', 0 );

add_action( 'init', function() {
	add_rewrite_rule( '^' . DCF_ADMIN_SLUG . '/?$', 'index.php?dcf_login=1', 'top' );
} );

add_action( 'after_switch_theme', 'flush_rewrite_rules' );

add_filter( 'query_vars', function( $vars ) {
	$vars[] = 'dcf_login';
	return $vars;
} );

add_action( 'template_redirect', function() {
	if ( ! get_query_var( 'dcf_login' ) ) {
		return;
	}

	$redirect_to = isset( $_GET['redirect_to'] ) ? rawurldecode( sanitize_text_field( wp_unslash( $_GET['redirect_to'] ) ) ) : admin_url();

	if ( is_user_logged_in() ) {
		wp_safe_redirect( $redirect_to );
		exit;
	}

	wp_safe_redirect(
		add_query_arg(
			array(
				'dcf-login'   => '1',
				'redirect_to' => $redirect_to,
			),
			site_url( 'wp-login.php', 'login' )
		)
	);
	exit;
} );

add_filter( 'login_url', function( $login_url, $redirect ) {
	return namm_organic_dcf_admin_url( $redirect );
}, 10, 2 );

add_filter( 'login_headerurl', function() {
	return home_url( '/' );
} );

add_filter( 'login_headertext', function() {
	return __( 'DCF Flowers', 'namm-organic' );
} );

add_action( 'login_enqueue_scripts', function() {
	$palette = function_exists( 'namm_organic_dcf_palette' ) ? namm_organic_dcf_palette() : array();
	$primary = isset( $palette['primary'] ) ? $palette['primary'] : '#A7377B';
	$soft    = isset( $palette['tertiary'] ) ? $palette['tertiary'] : '#F8DCE8';
	$text    = isset( $palette['headalt'] ) ? $palette['headalt'] : '#17131C';
	$border  = isset( $palette['border'] ) ? $palette['border'] : '#EAD7E3';

	wp_enqueue_style(
		'namm-organic-dcf-login-font',
		'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap',
		array(),
		null
	);

	$css = "
		body.login {
			background:
				radial-gradient(circle at top left, {$soft} 0, rgba(248, 220, 232, .68) 28%, transparent 46%),
				linear-gradient(135deg, #fff 0%, #fff8fb 48%, {$soft} 100%);
			color: {$text};
			font-family: Montserrat, sans-serif;
		}
		.login h1 a {
			background-image: url('" . esc_url( function_exists( 'namm_organic_dcf_asset_uri' ) ? namm_organic_dcf_asset_uri( 'logo.svg' ) : NAMM_ORGANIC_ROOT_URI . '/assets/images/logo.svg' ) . "');
			background-position: center;
			background-repeat: no-repeat;
			background-size: contain;
			border-radius: 18px;
			height: 92px;
			width: 280px;
		}
		.login form {
			background: rgba(255, 255, 255, .92);
			border: 1px solid {$border};
			border-radius: 18px;
			box-shadow: 0 20px 55px rgba(23, 19, 28, .12);
			padding: 28px;
		}
		.login label {
			color: {$text};
			font-weight: 600;
		}
		.login form .input,
		.login input[type='text'] {
			border-color: {$border};
			border-radius: 12px;
			box-shadow: none;
			font-size: 16px;
			min-height: 46px;
		}
		.login form .input:focus {
			border-color: {$primary};
			box-shadow: 0 0 0 1px {$primary};
		}
		.wp-core-ui .button-primary {
			background: {$primary};
			border-color: {$primary};
			border-radius: 999px;
			font-family: Montserrat, sans-serif;
			font-weight: 700;
			padding: 2px 20px;
		}
		.wp-core-ui .button-primary:hover,
		.wp-core-ui .button-primary:focus {
			background: {$text};
			border-color: {$text};
		}
		.login #nav a,
		.login #backtoblog a,
		.login .privacy-policy-page-link a {
			color: {$text};
			font-weight: 600;
		}
		.login #nav a:hover,
		.login #backtoblog a:hover,
		.login .privacy-policy-page-link a:hover {
			color: {$primary};
		}
	";

	wp_add_inline_style( 'login', $css );
} );

add_action( 'admin_enqueue_scripts', function() {
	$palette = function_exists( 'namm_organic_dcf_palette' ) ? namm_organic_dcf_palette() : array();
	$primary = isset( $palette['primary'] ) ? $palette['primary'] : '#A7377B';
	$soft    = isset( $palette['tertiary'] ) ? $palette['tertiary'] : '#F8DCE8';
	$text    = isset( $palette['headalt'] ) ? $palette['headalt'] : '#17131C';
	$border  = isset( $palette['border'] ) ? $palette['border'] : '#EAD7E3';

	wp_enqueue_style(
		'namm-organic-dcf-admin-font',
		'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap',
		array(),
		null
	);

	wp_register_style( 'namm-organic-dcf-admin', false, array(), NAMM_ORGANIC_THEME_VERSION );
	wp_enqueue_style( 'namm-organic-dcf-admin' );

	wp_add_inline_style(
		'namm-organic-dcf-admin',
		"
		body.wp-admin,
		.wp-admin input,
		.wp-admin select,
		.wp-admin textarea,
		.wp-admin button {
			font-family: Montserrat, sans-serif;
		}
		#wpadminbar,
		#adminmenu,
		#adminmenu .wp-submenu,
		#adminmenuback,
		#adminmenuwrap {
			background: {$text};
		}
		#wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
			content: '';
			display: block;
			width: 22px;
			height: 22px;
			margin-top: 5px;
			background: url('" . esc_url( function_exists( 'namm_organic_dcf_asset_uri' ) ? namm_organic_dcf_asset_uri( 'icono.svg' ) : NAMM_ORGANIC_ROOT_URI . '/assets/images/dcf/icono.svg' ) . "') center / contain no-repeat;
		}
		#wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item,
		#wpadminbar.nojq #wp-admin-bar-wp-logo:hover > .ab-item,
		#wpadminbar #wp-admin-bar-wp-logo > .ab-item:focus {
			background: {$primary};
		}
		#adminmenu li.menu-top:hover,
		#adminmenu li.opensub > a.menu-top,
		#adminmenu li > a.menu-top:focus,
		#adminmenu .wp-has-current-submenu .wp-submenu,
		#adminmenu .wp-has-current-submenu .wp-submenu.sub-open,
		#adminmenu .wp-has-current-submenu.opensub .wp-submenu {
			background: #261d2c;
		}
		#adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head,
		#adminmenu .wp-menu-arrow,
		#adminmenu .wp-menu-arrow div,
		#adminmenu li.current a.menu-top,
		#adminmenu li.wp-has-current-submenu a.wp-has-current-submenu {
			background: {$primary};
		}
		.wp-core-ui .button-primary {
			background: {$primary};
			border-color: {$primary};
			border-radius: 999px;
			font-weight: 700;
		}
		.wp-core-ui .button-primary:hover,
		.wp-core-ui .button-primary:focus {
			background: {$text};
			border-color: {$text};
		}
		.wrap h1,
		.wrap h2 {
			color: {$text};
			font-weight: 800;
		}
		.notice,
		.postbox,
		.card {
			border-color: {$border};
			border-radius: 10px;
		}
		.wp-core-ui .notice.is-dismissible {
			border-left-color: {$primary};
		}
		#wpcontent {
			background: linear-gradient(180deg, {$soft} 0, #f6f7f7 180px);
		}
		"
	);
} );

add_action( 'admin_bar_menu', function( $wp_admin_bar ) {
	if ( ! is_object( $wp_admin_bar ) || ! method_exists( $wp_admin_bar, 'add_node' ) ) {
		return;
	}

	$wp_admin_bar->add_node(
		array(
			'id'    => 'wp-logo',
			'title' => '<span class="ab-icon" aria-hidden="true"></span><span class="screen-reader-text">' . esc_html__( 'DCF Flowers', 'namm-organic' ) . '</span>',
			'href'  => home_url( '/' ),
			'meta'  => array(
				'title' => esc_attr__( 'DCF Flowers', 'namm-organic' ),
			),
		)
	);

	$wp_admin_bar->remove_node( 'about' );
	$wp_admin_bar->remove_node( 'wporg' );
	$wp_admin_bar->remove_node( 'documentation' );
	$wp_admin_bar->remove_node( 'support-forums' );
	$wp_admin_bar->remove_node( 'feedback' );
	$wp_admin_bar->remove_node( 'contribute' );
	$wp_admin_bar->remove_node( 'learn' );
}, 11 );
