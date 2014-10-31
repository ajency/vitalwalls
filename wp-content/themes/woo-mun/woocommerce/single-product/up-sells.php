<?php
/**
 * Single Product Up-Sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     99.99
 */

global $product, $woocommerce_loop ,$pmc_data ,$sitepress,$wpdb;
wp_enqueue_script('pmc_bxSlider');		
$upsells = $product->get_upsells();

if ( sizeof( $upsells ) == 0 ) return;

$args = array(
	'post_type'				=> 'product',
	'ignore_sticky_posts'	=> 1,
	'posts_per_page' 		=> 99,
	'no_found_rows' 		=> 1,
	'orderby' 				=> 'rand',
	'post__in' 				=> $upsells
);

$pc = new WP_Query( $args ); ?>

<?php if($pc->post_count > 4) { ?>
	<script type="text/javascript">


		jQuery(document).ready(function(){	  


		// Slider
		var $slider = jQuery('#relatedSP').bxSlider({
			controls: true,
			displaySlideQty: 1,
			default: 1000,
			easing : 'easeInOutQuint',
			prevText : '',
			nextText : '',
			pager :false
			
		});

 

		 });
	</script>


<?php } ?>
		

<div class="homerecent SP">
		<?php
		$currentindex = '';
		if ($pc->have_posts()) :
		$count = 1;
		$countitem = 1;
		$countPost= 1;
		?>
	<div class="titleborderOut"><div class="titleborder"></div></div>	
	<h3 class="h3border"><?php echo pmc_translation('translation_also_like', '<span>Also</span> like'); ?></h3>
	<div id="homerecent">
	<ul  id="relatedSP" class="productR">
		<?php  while ($pc->have_posts()) : $pc->the_post(); global $product;	
		if($countitem == 1){
			echo '<li>';}				
		if ( has_post_thumbnail() ){
			$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'homeProduct', false);
			$image = $image[0];}
		else
			$image = get_template_directory_uri() .'/images/placeholder-580.png'; 
			if( has_post_format( 'link' , get_the_ID()))
			add_filter( 'the_excerpt', 'filter_content_link' );	
		
			if($countPost != 4){
				echo '<div class="one_fourth" >';
			}
			else{
				echo '<div class="one_fourth last" >';
				$countPost = 0;
			}
			$attachments = $product->get_gallery_attachment_ids();
			$image_show = array();
			if ($attachments) {
				$i = 0;
				foreach ($attachments as $id) {
					$image =  wp_get_attachment_image_src( $id, 'shop' ); 
					$image_show[$i] =  $image[0] ;
					$i++;
				}
			}
			else if ( has_post_thumbnail() && !$attachments){
				$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'shop', false);
				$image_show[0] = $image[0];			
				}
			else
				$image_show[0] = get_template_directory_uri() .'/images/placeholder-280.png'; 					
			?>
				<div class="click">
				
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
					<?php woocommerce_show_product_sale_flash( $product ); ?>
					<a href="<?php echo get_permalink( get_the_id() ) ?>" title="<?php the_title() ?>"><h3><?php the_title() ?></h3></a>				
				</div>
				</div>	
					<div class="product-price-cart">						
						<div class="recentPrice"><span class="price"><?php echo $product->get_price_html(); ?></span></div>	
						<div class="recentCart"><?php woocommerce_template_loop_add_to_cart(  $product ); ?></div>
					</div>	
					
			</div>
		<?php 
		$count++;
		
		 if($countitem == 4){ 
			$countitem = 0; ?>
			</li>
		<?php } 
		$countitem++;
		$countPost++;
		endwhile; endif;
		wp_reset_query(); ?>
		</ul>
	</div>
</div>
<?php
wp_reset_postdata(); ?>