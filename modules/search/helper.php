<?php

    add_action('wp_ajax_namm_organic_search_data_fetch' , 'namm_organic_search_data_fetch');
	add_action('wp_ajax_nopriv_namm_organic_search_data_fetch','namm_organic_search_data_fetch');
	function namm_organic_search_data_fetch(){

        check_ajax_referer( 'namm_organic_ajax_search', 'nonce' );

        $search_val = isset( $_POST['search_val'] ) ? sanitize_text_field( wp_unslash( $_POST['search_val'] ) ) : '';
        $search_val = trim( $search_val );

        if ( strlen( $search_val ) < 2 ) {
            wp_die();
        }

        $cache_key = 'namm_search_' . md5( strtolower( $search_val ) );
        $cached    = get_transient( $cache_key );

        if ( false !== $cached ) {
            echo $cached;
            wp_die();
        }

        ob_start();
        $the_query = new WP_Query( array(
            'posts_per_page'      => 5,
            's'                   => $search_val,
            'post_type'           => array( 'post', 'product' ),
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
            'no_found_rows'       => true,
        ) );
        if( $the_query->have_posts() ) :
            while( $the_query->have_posts() ): $the_query->the_post(); ?>
                <li class="quick_search_data_item">
                    <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title();?></a>
                </li>
            <?php endwhile;
            wp_reset_postdata();
        else:
            echo'<p>'. esc_html__( 'No Results Found', 'namm-organic') .'</p>';
        endif;
        $html = ob_get_clean();
        set_transient( $cache_key, $html, 10 * MINUTE_IN_SECONDS );

        echo $html;
        wp_die();
}

?>
