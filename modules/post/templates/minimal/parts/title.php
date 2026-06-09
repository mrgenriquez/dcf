<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<!-- Entry Title -->
<div class="single-entry-title"><?php if( is_sticky( $post_ID ) ) echo '<span class="sticky-post">'.esc_html__('Featured', 'namm-organic').'</span>'; ?><h2><?php the_title();?></h2></div><!-- Entry Title -->