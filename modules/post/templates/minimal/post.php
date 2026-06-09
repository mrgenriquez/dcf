<?php
	$template_args['post_ID'] = $ID;
	$template_args['post_Style'] = $Post_Style;
	$template_args = array_merge( $template_args, namm_organic_single_post_params() ); ?>

	<!-- Post Header -->
	<div class="post-header">

		<?php namm_organic_template_part( 'post', 'templates/'.$Post_Style.'/parts/category', '', $template_args ); ?>

		<div class="clear"></div>

	   	<?php if( $template_args['enable_title'] ) : ?>
		        <?php namm_organic_template_part( 'post', 'templates/'.$Post_Style.'/parts/title', '', $template_args ); ?>
		<?php endif; ?>
        <?php namm_organic_template_part( 'post', 'templates/'.$Post_Style.'/parts/date', '', $template_args ); ?>

	</div><!-- Post Header -->

    <?php namm_organic_template_part( 'post', 'templates/'.$Post_Style.'/parts/image', '', $template_args ); ?>

    <!-- Post Meta -->
    <div class="post-meta">

    	<!-- Meta Left -->
    	<div class="meta-left">
			<?php namm_organic_template_part( 'post', 'templates/'.$Post_Style.'/parts/author', '', $template_args ); ?>
    	</div><!-- Meta Left -->
    	<!-- Meta Right -->
    	<div class="meta-right">
			<?php namm_organic_template_part( 'post', 'templates/post-extra/social', '', $template_args ); ?>
			<?php namm_organic_template_part( 'post', 'templates/'.$Post_Style.'/parts/comment', '', $template_args ); ?>
    	</div><!-- Meta Right -->

    </div><!-- Post Meta -->

    <!-- Post Dynamic -->
    <?php echo apply_filters( 'namm_organic_single_post_dynamic_template_part', namm_organic_get_template_part( 'post', 'templates/'.$Post_Style.'/parts/dynamic', '', $template_args ) ); ?><!-- Post Dynamic -->