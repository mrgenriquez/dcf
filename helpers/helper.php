<?php
if ( ! function_exists( 'namm_organic_template_part' ) ) {
	/**
	 * Function that echo module template part.
	 */
	function namm_organic_template_part( $module, $template, $slug = '', $params = array() ) {
		echo namm_organic_get_template_part( $module, $template, $slug, $params );
	}
}

if ( ! function_exists( 'namm_organic_get_template_part' ) ) {
	/**
	 * Function that load module template part.
	 */
	function namm_organic_get_template_part( $module, $template, $slug = '', $params = array() ) {

		$file_path = '';
		$html      =  '';

		$template_path = NAMM_ORGANIC_MODULE_DIR . '/' . $module;
		$temp_path = $template_path . '/' . $template;

		if ( ! empty( $temp_path ) ) {
			if ( ! empty( $slug ) ) {
				$file_path = "{$temp_path}-{$slug}.php";
				if ( ! file_exists( $file_path ) ) {
					$file_path = $temp_path . '.php';
				}
			} else {
				$file_path = $temp_path . '.php';
			}
		}

		$file_path = apply_filters( 'namm_organic_get_template_plugin_part', $file_path, $module, $template, $slug);

		if ( is_array( $params ) && count( $params ) ) {
			extract( $params );
		}

		if ( $file_path && file_exists( $file_path ) ) {
			ob_start();
			include( $file_path );
			$html = ob_get_clean();
		}

		return $html;
	}
}

if ( ! function_exists( 'namm_organic_get_page_id' ) ) {
	function namm_organic_get_page_id() {

		$page_id = get_queried_object_id();

		if( is_archive() || is_search() || is_404() || ( is_front_page() && is_home() ) ) {
			$page_id = -1;
		}

		return $page_id;
	}
}

/* Convert hexdec color string to rgb(a) string */
if ( ! function_exists( 'namm_organic_hex2rgba' ) ) {
	function namm_organic_hex2rgba($color, $opacity = false) {

		$default = 'rgb(0,0,0)';

		if(empty($color)) {
			return $default;
		}

		if ($color[0] == '#' ) {
			$color = substr( $color, 1 );
		}

		if (strlen($color) == 6) {
				$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
				$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
				return $default;
		}

		$rgb =  array_map('hexdec', $hex);

		if($opacity){
			if(abs($opacity) > 1) {
				$opacity = 1.0;
			}
			$output = implode(",",$rgb).','.$opacity;
		} else {
			$output = implode(",",$rgb);
		}

		return $output;

	}
}

if ( ! function_exists( 'namm_organic_html_output' ) ) {
	function namm_organic_html_output( $html ) {
		return apply_filters( 'namm_organic_html_output', $html );
	}
}


if ( ! function_exists( 'namm_organic_theme_defaults' ) ) {
	/**
	 * Function to load default values
	 */
	function namm_organic_theme_defaults() {

		$defaults = array (
			'primary_color' => '#A7377B',
			'primary_color_rgb' => namm_organic_hex2rgba('#A7377B', false),
			'secondary_color' => '#D99ABF',
			'secondary_color_rgb' => namm_organic_hex2rgba('#D99ABF', false),
			'tertiary_color' => '#F8DCE8',
			'tertiary_color_rgb' => namm_organic_hex2rgba('#F8DCE8', false),
			'quaternary_color' => '#7F2A6D',
			'quaternary_color_rgb' => namm_organic_hex2rgba('#7F2A6D', false),
			'body_bg_color' => '#FFFFFF',
			'body_bg_color_rgb' => namm_organic_hex2rgba('#FFFFFF', false),
			'body_text_color' => '#5E5360',
			'body_text_color_rgb' => namm_organic_hex2rgba('#5E5360', false),
			'headalt_color' => '#17131C',
			'headalt_color_rgb' => namm_organic_hex2rgba('#17131C', false),
			'link_color' => '#17131C',
			'link_color_rgb' => namm_organic_hex2rgba('#17131C', false),
			'link_hover_color' => '#A7377B',
			'link_hover_color_rgb' => namm_organic_hex2rgba('#A7377B', false),
			'border_color' => '#EAD7E3',
			'border_color_rgb' => namm_organic_hex2rgba('#EAD7E3', false),
			'accent_text_color' => '#FFFFFF',
			'accent_text_color_rgb' => namm_organic_hex2rgba('#FFFFFF', false),

			'body_typo' => array (
				'font-family' => "Montserrat",
				'font-fallback' => '"Montserrat", sans-serif',
				'font-weight' => 400,
				'fs-desktop' => 18,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.5,
				'lh-desktop-unit' => ''
			),
			'h1_typo' => array (
				'font-family' => "Montserrat",
				'font-fallback' => '"Montserrat", sans-serif',
				'font-weight' => 600,
				'fs-desktop' => 60,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.25,
				'lh-desktop-unit' => ''
			),
			'h2_typo' => array (
				'font-family' => "Montserrat",
				'font-fallback' => '"Montserrat", sans-serif',
				'font-weight' => 600,
				'fs-desktop' => 50,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.25,
				'lh-desktop-unit' => ''
			),
			'h3_typo' => array (
				'font-family' => "Montserrat",
				'font-fallback' => '"Montserrat", sans-serif',
				'font-weight' => 600,
				'fs-desktop' => 42,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.25,
				'lh-desktop-unit' => ''
			),
			'h4_typo' => array (
				'font-family' => "Montserrat",
				'font-fallback' => '"Montserrat", sans-serif',
				'font-weight' => 600,
				'fs-desktop' => 30,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.25,
				'lh-desktop-unit' => ''
			),
			'h5_typo' => array (
				'font-family' => "Montserrat",
				'font-fallback' => '"Montserrat", sans-serif',
				'font-weight' => 600,
				'fs-desktop' => 26,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.25,
				'lh-desktop-unit' => ''
			),
			'h6_typo' => array (
				'font-family' => "Montserrat",
				'font-fallback' => '"Montserrat", sans-serif',
				'font-weight' => 600,
				'fs-desktop' => 20,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.25,
				'lh-desktop-unit' => ''
			),
			'extra_typo' => array (
				'font-family' => "Montserrat",
				'font-fallback' => '"Montserrat", sans-serif',
				'font-weight' => 600,
				'fs-desktop' => 16,
				'fs-desktop-unit' => 'px',
				'lh-desktop' => 1.1,
				'lh-desktop-unit' => ''
			),

		);

		return $defaults;

	}
}
