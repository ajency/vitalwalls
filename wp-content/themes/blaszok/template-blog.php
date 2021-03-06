<?php
/**
 * Template Name: Blog
 * The Blog base for MPC Themes
 *
 * Displays all blog posts.
 *
 * @package WordPress
 * @subpackage MPC Themes
 * @since 1.0
 */

get_header();

global $page_id;
global $paged;

$query = new WP_Query();

$query->query(array(
	'post_type' => 'post',
	'paged' 	=> $paged
));

global $blog_layout;

$blog_layout = 'full';
if (get_field('mpc_blog_layout'))
	$blog_layout = get_field('mpc_blog_layout');

$blog_columns = 3;
if (get_field('mpc_blog_columns'))
	$blog_columns = get_field('mpc_blog_columns');

if ($blog_layout == 'small') {
	function mpcth_excerpt_length($length) {
		return 125;
	}
	add_filter('excerpt_length', 'mpcth_excerpt_length', 999);
}

$blog_load_more = false;
if ($blog_layout == 'masonry_load_more') {
	$blog_layout = 'masonry';
	$blog_load_more = true;
}

?>

<div id="mpcth_main">
	<div id="mpcth_main_container">
		<?php get_sidebar(); ?>
		<div id="mpcth_content_wrap" class="<?php if ($blog_layout == 'masonry') echo 'mpcth-masonry-blog' ?> <?php if ($blog_load_more) echo 'mpcth-load-more' ?>">
			<div id="mpcth_page_content">
				<?php //the_content(); ?>
			</div>
			<div id="mpcth_content" class="mpcth-blog-layout-<?php echo $blog_layout; ?><?php if ($blog_layout == 'masonry') echo ' mpcth-blog-columns-' . $blog_columns; ?>">
				<?php if ($query->have_posts()) : ?>
					<?php while ($query->have_posts()) : $query->the_post();
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
						<article id="post-<?php the_ID(); ?>" <?php post_class('mpcth-post mpcth-waypoint'); ?> >
							<div class="mpcth-post-wrap">
								<header class="mpcth-post-header">
									<?php if ($blog_layout == 'masonry') { ?>
										<div class="mpcth-post-thumbnail">
											<?php get_template_part('post-format', $post_format); ?>
											<?php mpcth_add_lightbox(); ?>
										</div>
									<?php } ?>
									<h4 class="mpcth-post-title">
										<a href="<?php echo $url; ?>" class="mpcth-color-main-color-hover mpcth-color-main-border" title="<?php the_title(); ?>"><?php the_title(); ?><?php echo $post_format == 'link' ? '<i class="fa fa-external-link"></i>' : ''; ?></a>
									</h4>
									<?php if ($blog_layout != 'masonry') { ?>
										<div class="mpcth-post-thumbnail">
											<?php get_template_part('post-format', $post_format); ?>
											<?php mpcth_add_lightbox(); ?>
										</div>
									<?php } ?>
								</header>
								<section class="mpcth-post-content">
									<?php the_excerpt(); ?>
								</section>
								<footer class="mpcth-post-footer">
									<span class="mpcth-post-meta">
										<?php mpcth_add_meta(); ?>
									</span>
									<a class="mpcth-read-more mpcth-color-main-background-hover" href="<?php the_permalink(); ?>"><?php _e('Continue Reading', 'mpcth'); ?><i class="fa fa-angle-<?php echo is_rtl() ? 'left' : 'right'; ?>"></i></a>
								</footer>
							</div>
						</article>
					<?php endwhile; ?>
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
				<?php endif; ?>
			</div><!-- end #mpcth_content -->
			<?php if ($query->max_num_pages > 1) { ?>
			<div id="mpcth_pagination">
				<?php
					if ($blog_load_more)
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