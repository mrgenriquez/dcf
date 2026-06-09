<?php
/**
 * AI search, answer engine and performance helpers.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'namm_organic_has_seo_plugin' ) ) {
	function namm_organic_has_seo_plugin() {
		return defined( 'WPSEO_VERSION' )
			|| defined( 'RANK_MATH_VERSION' )
			|| defined( 'AIOSEO_VERSION' )
			|| defined( 'SEOPRESS_VERSION' );
	}
}

if ( ! function_exists( 'namm_organic_ai_clean_text' ) ) {
	function namm_organic_ai_clean_text( $text, $length = 220 ) {
		$text = wp_strip_all_tags( strip_shortcodes( (string) $text ) );
		$text = preg_replace( '/\s+/', ' ', $text );
		return trim( wp_trim_words( $text, max( 1, absint( $length / 7 ) ), '' ) );
	}
}

if ( ! function_exists( 'namm_organic_ai_seo_defaults' ) ) {
	function namm_organic_ai_seo_defaults() {
		return array(
			'brand_name'     => 'Designer Cut Flowers',
			'description'    => 'Designer Cut Flowers creates premium floral experiences, bouquets and flower products with a refined DCF visual identity.',
			'phone'          => '',
			'email'          => '',
			'address'        => '',
			'social_urls'    => '',
			'llms_products'  => 20,
			'enable_llms'    => 1,
			'enable_schema'  => 1,
			'enable_meta'    => 1,
		);
	}
}

if ( ! function_exists( 'namm_organic_ai_seo_options' ) ) {
	function namm_organic_ai_seo_options() {
		$options = get_option( 'namm_organic_ai_seo_options', array() );
		return wp_parse_args( is_array( $options ) ? $options : array(), namm_organic_ai_seo_defaults() );
	}
}

if ( ! function_exists( 'namm_organic_ai_seo_sanitize_options' ) ) {
	function namm_organic_ai_seo_sanitize_options( $input ) {
		$input    = is_array( $input ) ? $input : array();
		$defaults = namm_organic_ai_seo_defaults();

		return array(
			'brand_name'    => sanitize_text_field( $input['brand_name'] ?? $defaults['brand_name'] ),
			'description'   => sanitize_textarea_field( $input['description'] ?? $defaults['description'] ),
			'phone'         => sanitize_text_field( $input['phone'] ?? '' ),
			'email'         => sanitize_email( $input['email'] ?? '' ),
			'address'       => sanitize_textarea_field( $input['address'] ?? '' ),
			'social_urls'   => sanitize_textarea_field( $input['social_urls'] ?? '' ),
			'llms_products' => max( 1, min( 100, absint( $input['llms_products'] ?? $defaults['llms_products'] ) ) ),
			'enable_llms'   => empty( $input['enable_llms'] ) ? 0 : 1,
			'enable_schema' => empty( $input['enable_schema'] ) ? 0 : 1,
			'enable_meta'   => empty( $input['enable_meta'] ) ? 0 : 1,
		);
	}
}

add_action( 'admin_init', function() {
	register_setting(
		'namm_organic_ai_seo',
		'namm_organic_ai_seo_options',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'namm_organic_ai_seo_sanitize_options',
			'default'           => namm_organic_ai_seo_defaults(),
		)
	);
} );

add_action( 'admin_menu', function() {
	add_theme_page(
		__( 'DCF AI SEO', 'namm-organic' ),
		__( 'DCF AI SEO', 'namm-organic' ),
		'manage_options',
		'dcf-ai-seo',
		'namm_organic_ai_seo_settings_page'
	);
} );

if ( ! function_exists( 'namm_organic_ai_seo_settings_page' ) ) {
	function namm_organic_ai_seo_settings_page() {
		$options = namm_organic_ai_seo_options();
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'DCF AI SEO', 'namm-organic' ); ?></h1>
			<p><?php esc_html_e( 'Base information for AI search, GEO, AEO, llms.txt and structured data.', 'namm-organic' ); ?></p>
			<form method="post" action="options.php">
				<?php settings_fields( 'namm_organic_ai_seo' ); ?>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="dcf-brand-name"><?php esc_html_e( 'Brand name', 'namm-organic' ); ?></label></th>
						<td><input class="regular-text" id="dcf-brand-name" name="namm_organic_ai_seo_options[brand_name]" type="text" value="<?php echo esc_attr( $options['brand_name'] ); ?>"></td>
					</tr>
					<tr>
						<th scope="row"><label for="dcf-description"><?php esc_html_e( 'AI description', 'namm-organic' ); ?></label></th>
						<td><textarea class="large-text" id="dcf-description" name="namm_organic_ai_seo_options[description]" rows="4"><?php echo esc_textarea( $options['description'] ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="dcf-phone"><?php esc_html_e( 'Phone', 'namm-organic' ); ?></label></th>
						<td><input class="regular-text" id="dcf-phone" name="namm_organic_ai_seo_options[phone]" type="text" value="<?php echo esc_attr( $options['phone'] ); ?>"></td>
					</tr>
					<tr>
						<th scope="row"><label for="dcf-email"><?php esc_html_e( 'Email', 'namm-organic' ); ?></label></th>
						<td><input class="regular-text" id="dcf-email" name="namm_organic_ai_seo_options[email]" type="email" value="<?php echo esc_attr( $options['email'] ); ?>"></td>
					</tr>
					<tr>
						<th scope="row"><label for="dcf-address"><?php esc_html_e( 'Address', 'namm-organic' ); ?></label></th>
						<td><textarea class="large-text" id="dcf-address" name="namm_organic_ai_seo_options[address]" rows="3"><?php echo esc_textarea( $options['address'] ); ?></textarea></td>
					</tr>
					<tr>
						<th scope="row"><label for="dcf-social-urls"><?php esc_html_e( 'Social URLs', 'namm-organic' ); ?></label></th>
						<td>
							<textarea class="large-text code" id="dcf-social-urls" name="namm_organic_ai_seo_options[social_urls]" rows="4"><?php echo esc_textarea( $options['social_urls'] ); ?></textarea>
							<p class="description"><?php esc_html_e( 'One URL per line. These become sameAs links in Organization schema.', 'namm-organic' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="dcf-llms-products"><?php esc_html_e( 'Products in llms.txt', 'namm-organic' ); ?></label></th>
						<td><input id="dcf-llms-products" name="namm_organic_ai_seo_options[llms_products]" type="number" min="1" max="100" value="<?php echo esc_attr( $options['llms_products'] ); ?>"></td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Features', 'namm-organic' ); ?></th>
						<td>
							<label><input name="namm_organic_ai_seo_options[enable_meta]" type="checkbox" value="1" <?php checked( $options['enable_meta'] ); ?>> <?php esc_html_e( 'AI-friendly meta tags', 'namm-organic' ); ?></label><br>
							<label><input name="namm_organic_ai_seo_options[enable_schema]" type="checkbox" value="1" <?php checked( $options['enable_schema'] ); ?>> <?php esc_html_e( 'Schema graph', 'namm-organic' ); ?></label><br>
							<label><input name="namm_organic_ai_seo_options[enable_llms]" type="checkbox" value="1" <?php checked( $options['enable_llms'] ); ?>> <?php esc_html_e( 'llms.txt endpoint', 'namm-organic' ); ?></label>
						</td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}
}

add_action( 'add_meta_boxes', function() {
	$screens = array( 'page', 'post' );
	if ( post_type_exists( 'product' ) ) {
		$screens[] = 'product';
	}

	foreach ( $screens as $screen ) {
		add_meta_box( 'namm-organic-ai-answer', __( 'AI / AEO Answer', 'namm-organic' ), 'namm_organic_ai_answer_metabox', $screen, 'normal', 'high' );
	}
} );

if ( ! function_exists( 'namm_organic_ai_answer_metabox' ) ) {
	function namm_organic_ai_answer_metabox( $post ) {
		wp_nonce_field( 'namm_organic_ai_answer_save', 'namm_organic_ai_answer_nonce' );
		$value = get_post_meta( $post->ID, '_namm_organic_ai_answer', true );
		?>
		<p><?php esc_html_e( 'Write a concise answer that AI assistants can quote or summarize for this page.', 'namm-organic' ); ?></p>
		<textarea class="large-text" name="namm_organic_ai_answer" rows="4"><?php echo esc_textarea( $value ); ?></textarea>
		<?php
	}
}

add_action( 'save_post', function( $post_id ) {
	if ( ! isset( $_POST['namm_organic_ai_answer_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['namm_organic_ai_answer_nonce'] ) ), 'namm_organic_ai_answer_save' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$value = isset( $_POST['namm_organic_ai_answer'] ) ? sanitize_textarea_field( wp_unslash( $_POST['namm_organic_ai_answer'] ) ) : '';

	if ( $value ) {
		update_post_meta( $post_id, '_namm_organic_ai_answer', $value );
	} else {
		delete_post_meta( $post_id, '_namm_organic_ai_answer' );
	}
} );

if ( ! function_exists( 'namm_organic_ai_seo_meta' ) ) {
	function namm_organic_ai_seo_meta() {
		$options = namm_organic_ai_seo_options();

		if ( empty( $options['enable_meta'] ) ) {
			return;
		}

		echo "\n" . '<meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1">' . "\n";

		if ( namm_organic_has_seo_plugin() ) {
			return;
		}

		$description = '';

		if ( is_singular() ) {
			$post = get_post();
			if ( $post ) {
				$answer      = get_post_meta( $post->ID, '_namm_organic_ai_answer', true );
				$description = $answer ? $answer : ( has_excerpt( $post ) ? get_the_excerpt( $post ) : $post->post_content );
			}
		} elseif ( is_category() || is_tag() || is_tax() ) {
			$description = term_description();
		} else {
			$description = $options['description'] ? $options['description'] : get_bloginfo( 'description' );
		}

		$description = namm_organic_ai_clean_text( $description, 170 );
		if ( $description ) {
			echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
		}
	}
	add_action( 'wp_head', 'namm_organic_ai_seo_meta', 2 );
}

if ( ! function_exists( 'namm_organic_ai_schema_graph' ) ) {
	function namm_organic_ai_schema_graph() {
		if ( is_admin() || is_feed() || wp_doing_ajax() ) {
			return;
		}

		$options = namm_organic_ai_seo_options();
		if ( empty( $options['enable_schema'] ) ) {
			return;
		}

		$site_url = home_url( '/' );
		$logo_id  = get_theme_mod( 'custom_logo' );
		$graph    = array(
			array(
				'@type'           => 'WebSite',
				'@id'             => trailingslashit( $site_url ) . '#website',
				'url'             => $site_url,
				'name'            => get_bloginfo( 'name' ),
				'description'     => $options['description'] ? $options['description'] : get_bloginfo( 'description' ),
				'inLanguage'      => get_bloginfo( 'language' ),
				'potentialAction' => array(
					'@type'       => 'SearchAction',
					'target'      => home_url( '/?s={search_term_string}' ),
					'query-input' => 'required name=search_term_string',
				),
			),
			array(
				'@type'      => 'Organization',
				'@id'        => trailingslashit( $site_url ) . '#organization',
				'name'       => $options['brand_name'] ? $options['brand_name'] : get_bloginfo( 'name' ),
				'url'        => $site_url,
				'inLanguage' => get_bloginfo( 'language' ),
			),
		);

		if ( $logo_id ) {
			$logo = wp_get_attachment_image_src( $logo_id, 'full' );
			if ( $logo ) {
				$graph[1]['logo'] = array(
					'@type'  => 'ImageObject',
					'url'    => $logo[0],
					'width'  => isset( $logo[1] ) ? (int) $logo[1] : null,
					'height' => isset( $logo[2] ) ? (int) $logo[2] : null,
				);
			}
		} elseif ( function_exists( 'namm_organic_dcf_asset_uri' ) ) {
			$graph[1]['logo'] = array(
				'@type' => 'ImageObject',
				'url'   => namm_organic_dcf_asset_uri( 'logo.svg' ),
			);
		}

		if ( $options['phone'] ) {
			$graph[1]['telephone'] = $options['phone'];
		}

		if ( $options['email'] ) {
			$graph[1]['email'] = $options['email'];
		}

		if ( $options['address'] ) {
			$graph[1]['address'] = array(
				'@type'         => 'PostalAddress',
				'streetAddress' => $options['address'],
			);
		}

		if ( $options['social_urls'] ) {
			$same_as = array_filter( array_map( 'esc_url_raw', preg_split( '/\r\n|\r|\n/', $options['social_urls'] ) ) );
			if ( $same_as ) {
				$graph[1]['sameAs'] = array_values( $same_as );
			}
		}

		if ( is_singular() ) {
			$post = get_post();
			$type = is_singular( 'product' ) ? 'Product' : ( is_singular( 'post' ) ? 'Article' : 'WebPage' );

			if ( 'Product' !== $type ) {
				$answer = get_post_meta( $post->ID, '_namm_organic_ai_answer', true );
				$graph[] = array_filter( array(
					'@type'            => $type,
					'@id'              => get_permalink() . '#content',
					'url'              => get_permalink(),
					'headline'         => get_the_title(),
					'description'      => namm_organic_ai_clean_text( $answer ? $answer : ( has_excerpt() ? get_the_excerpt() : $post->post_content ), 220 ),
					'datePublished'    => get_the_date( DATE_W3C ),
					'dateModified'     => get_the_modified_date( DATE_W3C ),
					'inLanguage'       => get_bloginfo( 'language' ),
					'isPartOf'         => array( '@id' => trailingslashit( $site_url ) . '#website' ),
					'publisher'        => array( '@id' => trailingslashit( $site_url ) . '#organization' ),
					'mainEntityOfPage' => get_permalink(),
				) );
			}
		}

		echo "\n" . '<script type="application/ld+json">' . wp_json_encode(
			array(
				'@context' => 'https://schema.org',
				'@graph'   => $graph,
			),
			JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
		) . '</script>' . "\n";
	}
	add_action( 'wp_head', 'namm_organic_ai_schema_graph', 30 );
}

if ( ! function_exists( 'namm_organic_ai_product_schema' ) ) {
	function namm_organic_ai_product_schema( $markup, $product ) {
		if ( ! class_exists( 'WC_Product' ) || ! $product instanceof WC_Product ) {
			return $markup;
		}

		$answer = get_post_meta( $product->get_id(), '_namm_organic_ai_answer', true );
		$markup['description'] = namm_organic_ai_clean_text( $answer ? $answer : ( $product->get_short_description() ? $product->get_short_description() : $product->get_description() ), 320 );

		$categories = wc_get_product_terms( $product->get_id(), 'product_cat', array( 'fields' => 'names' ) );
		if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
			$markup['category'] = implode( ', ', $categories );
		}

		$brand = $product->get_attribute( 'brand' );
		if ( $brand ) {
			$markup['brand'] = array(
				'@type' => 'Brand',
				'name'  => $brand,
			);
		}

		return array_filter( $markup );
	}
	add_filter( 'woocommerce_structured_data_product', 'namm_organic_ai_product_schema', 20, 2 );
}

if ( ! function_exists( 'namm_organic_ai_llms_txt' ) ) {
	function namm_organic_ai_llms_txt() {
		$options = namm_organic_ai_seo_options();

		if ( empty( $options['enable_llms'] ) ) {
			return;
		}

		$path = isset( $_SERVER['REQUEST_URI'] ) ? wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH ) : '';
		$llms_path = wp_parse_url( home_url( '/llms.txt' ), PHP_URL_PATH );

		if ( untrailingslashit( $llms_path ) !== untrailingslashit( $path ) ) {
			return;
		}

		status_header( 200 );
		header( 'Content-Type: text/plain; charset=' . get_bloginfo( 'charset' ) );

		$lines = array(
			'# ' . get_bloginfo( 'name' ),
			'',
			'> ' . ( $options['description'] ? $options['description'] : get_bloginfo( 'description' ) ),
			'',
			'## Core URLs',
			'- Home: ' . home_url( '/' ),
			'- Search: ' . home_url( '/?s={query}' ),
		);

		if ( class_exists( 'WooCommerce' ) ) {
			$shop_id = wc_get_page_id( 'shop' );
			if ( $shop_id && $shop_id > 0 ) {
				$lines[] = '- Shop: ' . get_permalink( $shop_id );
			}

			$products = wc_get_products( array(
				'status'  => 'publish',
				'limit'   => absint( $options['llms_products'] ),
				'orderby' => 'date',
				'order'   => 'DESC',
				'return'  => 'objects',
			) );

			if ( $products ) {
				$lines[] = '';
				$lines[] = '## Products';

				foreach ( $products as $product ) {
					$summary = namm_organic_ai_clean_text( $product->get_short_description() ? $product->get_short_description() : $product->get_description(), 140 );
					$price   = $product->get_price() !== '' ? wp_strip_all_tags( wc_price( $product->get_price() ) ) : 'Price unavailable';
					$stock   = $product->is_in_stock() ? 'in stock' : 'out of stock';
					$lines[] = '- ' . $product->get_name() . ': ' . get_permalink( $product->get_id() ) . ' | ' . $price . ' | ' . $stock . ( $summary ? ' | ' . $summary : '' );
				}
			}
		}

		echo implode( "\n", $lines );
		exit;
	}
	add_action( 'template_redirect', 'namm_organic_ai_llms_txt', 0 );
}
