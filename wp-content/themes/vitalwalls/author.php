<?php
get_header();

// Get the Current Author Info
$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author')); ?>

	<div class="mainwrap shop">
		<div class="main clearfix">
			<div class="author-info">
				<div class="auth-avatar">
					<?php echo get_avatar($curauth->ID, 256); ?>
				</div>
				<div class="auth-details">
				   	<h2><?php echo $curauth->display_name; ?></h2>

					<p><?php echo $curauth->description; ?></p>
				</div>
				<div class="clearfix"></div>
			</div>

			<div class="auth-prod-head">
				<span><?php echo $curauth->display_name; ?>'s Products</span>
			</div>

			<div class="homerecent">
				<ul class="author-products clearfix">
					<?php 
					$args = array(
						'author' => $curauth->ID, 
						'post_type' => 'product',
						'posts_per_page' => 12,
						'paged' => get_query_var('paged')
					);
					
					// The Loop
					$loop = new WP_Query( $args );
						if ( $loop->have_posts() ) {
							while ( $loop->have_posts() ) : $loop->the_post();
								woocommerce_get_template_part( 'content', 'product' );
							endwhile;

							get_template_part('/includes/wp-pagenavi');
							if(function_exists('wp_pagenavi')) { wp_pagenavi(); }

						} else {
							echo __( 'No products found' );
						}
						wp_reset_postdata();
					?>
				</ul>
				
			</div>
		</div>
	</div>

<?php get_footer(); ?>