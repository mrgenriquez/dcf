<?php

if( ! function_exists('namm_organic_event_breadcrumb_title') ) {
    function namm_organic_event_breadcrumb_title($title) {
        if( get_post_type() == 'tribe_events' && is_single()) {
            $etitle = esc_html__( 'Event Detail', 'namm-organic' );
            return '<h1>'.$etitle.'</h1>';
        } else {
            return $title;
        }
    }

    add_filter( 'namm_organic_breadcrumb_title', 'namm_organic_event_breadcrumb_title', 20, 1 );
}

?>