<?php
/**
 * The Author base for MPC Themes
 *
 * Displays single author.
 *
 * @package WordPress
 * @subpackage MPC Themes
 * @since 1.0
 */

get_header();

global $page_id;
global $paged;
global $wp_query;

$query = $wp_query;

$pagination_type = get_field('mpc_pagination_type');

$layout = 'small';
if (isset($mpcth_options['mpcth_enable_large_archive_thumbs']) && $mpcth_options['mpcth_enable_large_archive_thumbs']) $layout = 'full';

// Get the Current Author Info
$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author')); 

?>

<div id="mpcth_main">
	<div id="mpcth_main_container">
		<?php get_sidebar(); ?>
		<div id="mpcth_content_wrap">
			<header id="mpcth_archive_header">
				
				<h3 id="mpcth_archive_title" class="mpcth-deco-header"><span>
					<?php echo __('', 'mpcth') . '<em class="mpcth-color-main-color">' . $curauth->display_name . '</em>'; ?>
				</span></h3>
				
				<div class="author-info">
					<?php 
						// Author Thumbnail
						echo '<div class="author-pic">' .get_avatar($curauth->ID, 256). '</div>'; 

						// Author Description
						echo $curauth->description; 
					?>
				</div>	

				<div class="clear"></div>	

			</header>
			<div id="mpcth_content" class="author-products mpcth-blog-layout-<?php echo $layout; ?>">
				<h4 class="mpcth-deco-header">
					<?php echo __('Products by ', 'mpcth') .  $curauth->display_name; ?>
				</h4>
				<?php 

					// Author Product Loop Arguments
					$args = array(
						'author' => $curauth->ID, 
						'post_type' => 'product',
						'posts_per_page' => 12,
						'paged' => get_query_var('paged')
					);

					// The Loop
					$loop = new WP_Query( $args );

					if ($loop->have_posts()) : ?>
					<?php woocommerce_product_loop_start(); ?>
						
						<?php while ($loop->have_posts()) : $loop->the_post();
							global $more;
							$more = 0;

							$post_meta = get_post_custom($post->ID);
							$post_format = get_post_format();

							if($post_format === false)
								$post_format = 'standard';

							$url = get_permalink();
							$link = get_field('mpc_link_url');
							if($post_format == 'link' && isset($link))
								$url = $link;

						?>

							

								<?php wc_get_template_part( 'content', 'product' ); ?>

							

						<?php endwhile; ?>

					<?php woocommerce_product_loop_end(); ?>

				<?php else : ?>
					<article id="post-0" class="mpcth-post mpcth-post-not-found">
						<header class="mpcth-post-header">
							<h3 class="mpcth-post-title">
								<?php _e('Nothing Found', 'mpcth'); ?>
							</h3>
							<div class="mpcth-post-thumbnail">

							</div>
							<div class="mpcth-post-meta">

							</div>
						</header>
						<section class="mpcth-post-content">
							<?php _e('Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'mpcth'); ?>
						</section>
						<footer class="mpcth-post-footer">

						</footer>
					</article>
				<?php 
					endif; 
					wp_reset_postdata();
				?>
			</div><!-- end #mpcth_content -->
			<?php if ($query->max_num_pages > 1) { ?>
			<div id="mpcth_pagination">
				<?php
					if ($pagination_type == 'loadmore')
						mpcth_display_load_more($query);
					else
						mpcth_display_pagination($query);
				?>
			</div>
			<?php } ?>
		</div><!-- end #mpcth_content_wrap -->
	</div><!-- end #mpcth_main_container -->
</div><!-- end #mpcth_main -->

<?php get_footer();