<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

get_header('shop'); ?>
<div class = "outerpagewrap">
	<div class="pagewrap">
		<div class="pagecontent">
			<div class="pagecontentContent">
				<p><?php woocommerce_breadcrumb(); ?></p>
			</div>
			<div class = "portnavigation">
					<span><?php previous_post_link('%link', '<div class="portprev"><i class="fa fa-angle-right"></i><div class="link-title-previous">%title</div></div>' ,false,''); ?> </span>				
					<span><?php next_post_link('%link','<div class="portnext"><i class="fa fa-angle-left"></i><div class="link-title-next">%title</div></div>',false,''); ?> </span>

			</div>
		</div>

	</div>
</div>

	<div class="mainwrap homewrap" >

		<div class="main clearfix" >		
			<div class="content fullwidth">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php woocommerce_get_template_part( 'content', 'single-product' ); ?>

				<?php endwhile; // end of the loop. ?>

			</div>
	

		</div>
	</div>
	<!-- bottom quote -->
	<div class="infotextwrap">
		<div class="infotext">
			<div class="infotext-title">
				<h2><?php echo pmc_translation('quote_big','CHECK OUR LATEST WORDPRESS THEME THAT IMPLEMENTS PAGE BUILDER') ?></h2>
				<div class="infotext-title-small"><?php echo pmc_translation('quote_small','- learn how to build Wordpress Themes with ease with a premium Page Builder which allows you to add new Pages in seconds.') ?></div>
			</div>
		</div>
	</div>
<?php get_footer('shop'); ?>