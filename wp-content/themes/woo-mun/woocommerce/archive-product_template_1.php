<?php

get_header('shop'); 
global $pmc_data, $woocommerce, $wpdb;

?>
	<div class = "outerpagewrap">
		<div class="pagewrap">
			<div class="pagecontent">
				<div class="pagecontentContent">
					<p><?php woocommerce_breadcrumb(); ?></p>
				</div>
			</div>

		</div>
	</div> 
					
	<div class="mainwrap shop sidebarshop">

		<div class="main clearfix" >
		

		<?php do_action( 'woocommerce_archive_description' ); ?>

		<?php if ( is_tax() ) : ?>
			<?php do_action( 'woocommerce_taxonomy_archive_description' ); ?>
		<?php elseif ( ! empty( $shop_page ) && is_object( $shop_page ) ) : ?>
			<?php do_action( 'woocommerce_product_archive_description', $shop_page ); ?>
		<?php endif; ?>
		
		<?php 


			


		?>

		<?php if ( have_posts() ) : ?>

			<?php
			/**
			* Sorting
			*/
			?>
			<div class="categorytopbarWraper sidebarShop">
			<?php get_template_part('woocommerce/loop/sorting'); ?>
			
			</div>
			
			<div class="sidebar woosidebar">

				<?php dynamic_sidebar( 'sidebar_category' ); ?>

			</div>
			
			<div class="homeRacent homerecent shopSidebar">
			<div class="pmc-shop-sidebar">
				<div class="homerecent productRH productR">
					<?php
					$currentindex = '';
					$countPost = 1;
					$countitem = 1;
					while ( have_posts() ) : the_post(); global $product;
					$postmeta = get_post_custom(get_the_id());
					$count = $wpdb->get_var("
						SELECT COUNT(meta_value) FROM $wpdb->commentmeta
						LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
						WHERE meta_key = 'rating'
						AND comment_post_ID = ".get_the_id()."
						AND comment_approved = '1'
						AND meta_value > 0
					");
					$rating = $wpdb->get_var("
						SELECT SUM(meta_value) FROM $wpdb->commentmeta
						LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
						WHERE meta_key = 'rating'
						AND comment_post_ID = ".get_the_id()."
						AND comment_approved = '1'
					");							
					
					if($countPost != 3){
						echo '<div class="one_third" >';
					}
					else{
						echo '<div class="one_third last" >';
						$countPost = 0;
					}
					$attachments = $product->get_gallery_attachment_ids();
					$image_show = array();
					if ($attachments) {
						$i = 0;
						foreach ($attachments as $id) {
							$image =  wp_get_attachment_image_src( $id, 'shop-sidebar' ); 
							$image_show[$i] =  $image[0] ;
							$i++;
						}
					}
					else if ( has_post_thumbnail() && !$attachments){
						$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'shop-sidebar', false);
						$image_show[0] = $image[0];			
						}
					else
						$image_show[0] = get_template_directory_uri() .'/images/placeholder-272.png';					
					?>
						<div class="recentimage">
								<?php 
								if(shortcode_exists( 'yith_wcwl_add_to_wishlist' )){
									echo do_shortcode( '[yith_wcwl_add_to_wishlist]' ); }
								?>								
						
							<div class="image">									
								<div class="loading"></div>
								<a href="<?php echo get_permalink( get_the_id() ) ?>" title="<?php the_title() ?>">
									<img class = "image0" src = "<?php echo $image_show[0] ?>" alt = "<?php echo get_the_title() ?>"  > 
									<?php if(isset($image_show[1])) { ?>
										<img class = "image1" src = "<?php echo $image_show[1] ?>" alt = "<?php echo get_the_title() ?>"  > 
									<?php } ?>									
								</a>
							</div>
						</div>							
						<div class="recentdescription">
							<?php woocommerce_show_product_sale_flash( $post, $product ); ?>
							<h3><a href="<?php echo get_permalink( get_the_ID() ) ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h3>
							<div class="borderLine"><div class="borderLineLeft"></div><div class="borderLineRight"></div></div>			
						</div>
						<div class="product-price-cart">						
							<div class="recentPrice"><span class="price"><?php echo $product->get_price_html(); ?></span></div>	
							<div class="recentCart"><?php woocommerce_template_loop_add_to_cart( $post, $product ); ?></div>
						</div>	
						</div>
					<?php 
					$countPost++;
					
					$countitem++;

					 endwhile; // end of the loop. ?>

				</div>
				<?php
				
					get_template_part('/includes/wp-pagenavi');
					if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
				?>
				<?php do_action('woocommerce_after_shop_loop'); ?>
			</div>
		<?php else : ?>

			<?php if ( ! woocommerce_product_subcategories( array( 'before' => '<ul class="products">', 'after' => '</ul>' ) ) ) : ?>

				<p><?php _e( 'No products found which match your selection.', 'woocommerce' ); ?></p>

			<?php endif; ?>
		
		<?php endif; ?>
		

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