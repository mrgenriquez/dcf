<?php

/**
 * content-product.php hooks
 *
 * woocommerce_before_shop_loop_item_title
 */


/** Hook: woocommerce_before_shop_loop_item_title. **/

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

if( ! function_exists( 'namm_organic_shop_woo_loop_product_thumbnail' ) ) {

	function namm_organic_shop_woo_loop_product_thumbnail() {

		global $product;

		$product_id = $product->get_id();

		// Loop defined variables

		$show_secondary_image_on_hover = wc_get_loop_prop( 'product-thumb-secondary-image-onhover' );
		$show_secondary_image_on_hover = (isset($show_secondary_image_on_hover) && !empty($show_secondary_image_on_hover)) ? true : false;

		$display_bg_image = wc_get_loop_prop( 'product-thumb-image-display-type' );
		$display_bg_image = (isset($display_bg_image) && !empty($display_bg_image)) ? true : false;

		$product_thumb_content = wc_get_loop_prop( 'product-thumb-content' );
		$product_thumb_content = (isset($product_thumb_content['enabled']) && !empty($product_thumb_content['enabled'])) ? array_keys ( $product_thumb_content['enabled'] ) : false;

		$product_overlay_bgcolor = wc_get_loop_prop( 'product-overlay-bgcolor' );
		$product_overlay_bgcolor = (isset($product_overlay_bgcolor) && !empty($product_overlay_bgcolor)) ? 'style="background-color:'.esc_attr($product_overlay_bgcolor).';"' : '';

		$product_hover_style = wc_get_loop_prop( 'product-hover-style' );

		$product_thumb_content_overlay_bgcolor = '';
		if($product_hover_style == 'product-hover-egrpovrcnt') {
			$product_thumb_content_overlay_bgcolor = $product_overlay_bgcolor;
		}

		$product_show_labels = wc_get_loop_prop( 'product-show-label' );
		$product_show_labels = (isset($product_show_labels) && $product_show_labels == 'true') ? true : false;

		$product_show_offer_percentage = wc_get_loop_prop( 'product-show-offer-percentage' );
		$product_show_offer_percentage = (isset($product_show_offer_percentage) && $product_show_offer_percentage == 'thumb') ? true : false;

		echo '<div class="product-thumb">';

			// Featrued Item
			if($product_show_labels) {

				if( $product->is_featured() ) {
					echo '<div class="featured-tag">
									<div>
										<i class="wdticon-thumb-tack"></i>
										<span>'.esc_html__('Featured', 'namm-organic').'</span>
									</div>
								</div>';
				}

			}

			// Images

			echo '<a class="image" href="'.esc_url($product->get_permalink()).'" title="'.esc_attr($product->get_name()).'">';

				if($product_hover_style != 'product-hover-egrpovrcnt') {
					echo '<div class="product-thumb-overlay" '.namm_organic_html_output($product_overlay_bgcolor).'></div>';
				}

				// Product Labels
				if($product_show_labels) {

					echo '<div class="product-labels">';

						if( $product->is_on_sale() && $product->is_in_stock() ) {
							echo '<span class="onsale"><span>'.esc_html__('Sale', 'namm-organic').'</span></span>';
						} else if( !$product->is_in_stock() ) {
							echo '<span class="out-of-stock"><span>'.esc_html__('Sold Out','namm-organic').'</span></span>';
						}

						$settings = get_post_meta( $product_id, '_custom_settings', true );

						if(isset($settings['product-new-label']) && $settings['product-new-label'] == 'true') {
							echo '<span class="new"><span>'.esc_html__('New', 'namm-organic').'</span></span>';
						}

					echo '</div>';

				}

				// Product Offer Percentage
				if($product_show_offer_percentage) {
					echo namm_organic_shop_woo_loop_product_offer_percentage($product);
				}


				// Action to run before product thumb image
				do_action( 'namm_organic_woo_before_product_thumb_image', $product_id );


				$product_thumbnail_id = get_post_thumbnail_id($product_id);
				$product_image_alt = get_post_meta( $product_thumbnail_id, '_wp_attachment_image_alt', true );
				$product_image_alt = ! empty( $product_image_alt ) ? $product_image_alt : $product->get_name();
				$primary_image_src = wp_get_attachment_image_src($product_thumbnail_id, 'woocommerce_thumbnail', false);
				$primary_image_src = isset($primary_image_src[0]) ? $primary_image_src[0] : wc_placeholder_img_src( 'woocommerce_thumbnail' );

				$secondary_image_src = '';
				if($show_secondary_image_on_hover) {

					$attachment_ids = $product->get_gallery_image_ids();
					if(isset($attachment_ids['0'])) {
						$secondary_image_src = wp_get_attachment_image_src($attachment_ids['0'], 'woocommerce_thumbnail', false);
						$secondary_image_src = isset($secondary_image_src[0]) ? $secondary_image_src[0] : '';
					}

				}

				if($display_bg_image) {
					echo '<div class="primary-image" style="background-image:url('.esc_url($primary_image_src).')"></div>';
				} else if ( $product_thumbnail_id ) {
					echo '<div class="primary-image">' . wp_get_attachment_image(
						$product_thumbnail_id,
						'woocommerce_thumbnail',
						false,
						array(
							'alt'      => $product_image_alt,
							'title'    => $product->get_name(),
							'decoding' => 'async',
							'loading'  => 'lazy',
						)
					) . '</div>';
				} else {
					echo '<div class="primary-image"><img src="'.esc_url($primary_image_src).'" alt="'.esc_attr($product->get_name()).'" title="'.esc_attr($product->get_name()).'" decoding="async" loading="lazy" /></div>';
				}

				if($secondary_image_src != '') {
					if($display_bg_image) {
						echo '<div class="secondary-image" style="background-image:url('.esc_url($secondary_image_src).')"></div>';
					} else {
						$secondary_image_alt = get_post_meta( $attachment_ids['0'], '_wp_attachment_image_alt', true );
						$secondary_image_alt = ! empty( $secondary_image_alt ) ? $secondary_image_alt : $product->get_name();
						echo '<div class="secondary-image">' . wp_get_attachment_image(
							$attachment_ids['0'],
							'woocommerce_thumbnail',
							false,
							array(
								'alt'      => $secondary_image_alt,
								'title'    => $product->get_name(),
								'decoding' => 'async',
								'loading'  => 'lazy',
							)
						) . '</div>';
					}
				}

			echo '</a>';


			// Content

			if($product_thumb_content) {

				namm_organic_shop_woo_loop_product_thumb_content_setup($product_thumb_content);

				echo '<div class="product-thumb-content" '.namm_organic_html_output($product_thumb_content_overlay_bgcolor).'>';
					do_action('namm_organic_woo_loop_product_thumb_content', 'thumb');
					remove_all_actions('namm_organic_woo_loop_product_thumb_content');
				echo '</div>';

			}

		echo "</div>";

	}

	add_action( 'woocommerce_before_shop_loop_item_title', 'namm_organic_shop_woo_loop_product_thumbnail', 10 );

}



?>
