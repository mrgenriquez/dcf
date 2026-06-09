<?php
add_action( 'namm_organic_after_main_css', 'footer_style' );
function footer_style() {
    wp_enqueue_style( 'namm_organic-footer', get_theme_file_uri('/modules/footer/assets/css/footer.css'), false, NAMM_ORGANIC_THEME_VERSION, 'all');
}

add_action( 'namm_organic_footer', 'footer_content' );
function footer_content() {
    namm_organic_template_part( 'content', 'content', 'footer' );
}

add_action( 'namm_organic_before_enqueue_js', 'namm_organic_sticky_footer_js' );
if( !function_exists( 'namm_organic_sticky_footer_js' ) ) {
    function namm_organic_sticky_footer_js() {
        wp_enqueue_script('sticky-footer', get_theme_file_uri('/modules/footer/assets/js/footer.js'), array(), false, true);
    }
}