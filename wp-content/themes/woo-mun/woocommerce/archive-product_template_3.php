<?php

get_header('shop'); 
global $pmc_data,$wpdb;

?>
	<div class = "outerpagewrap">
		<div class="pagewrap">
			<div class="pagecontent">
				<div class="pagecontentContent">
					<p><?php woocommerce_breadcrumb(); ?></p>
				</div>
			</div>

		</div>
	</div>	<div class="mainwrap shop">

		<div class="main clearfix" >
		
		<?php do_action( 'woocommerce_archive_description' ); ?>

		<?php if ( is_tax() ) : ?>
			<?php do_action( 'woocommerce_taxonomy_archive_description' ); ?>
		<?php elseif ( ! empty( $shop_page ) && is_object( $shop_page ) ) : ?>
			<?php do_action( 'woocommerce_product_archive_description', $shop_page ); ?>
		<?php endif; ?>
		
		<?php 

		get_template_part('/includes/wp-pagenavi');
		$product_categories = ($temp = get_terms('product_cat')) ? $temp : array();
		$categories_options = array();
		foreach($product_categories as $cat) {
			$categories_options[$cat->term_id] = $cat->name;
		}		


		?>

		<div class="homerecent">
			<div class="wocategoryFull">
				<div class="homerecent productRH productR products-both">
					<div class="categorytopbarWraper">
						<?php get_template_part('woocommerce/loop/sorting'); ?>
						<div class="categorytopbar">
							<?php dynamic_sidebar( 'sidebar_category_top' ); ?>
						</div>
					</div>
					<div class="titleborderOut"><div class="titleborder"></div></div>	
					<div class="tabwrap">	
						<ul class="tabsshort">
						<?php 
						$product_categories = ($temp = get_terms('product_cat')) ? $temp : array();
						$i = 0;
						foreach($product_categories as $cat) { 
						$i++;
						?>
							<li>
								<a href="#fragment-<?php echo  $i ?>"><?php echo  $cat->name ?></a>
							</li>
						<?php } ?>		
						</ul>
						<div class="panes shop-categories">						
							<?php
						
							$product_categories = ($temp = get_terms('product_cat')) ? $temp : array();
							$i = 0;
							foreach($product_categories as $cat) {
								$i++;
								if (isset($_GET['orderby'])) {
									switch ($_GET['orderby']) :
										case 'date' :
											$args['orderby'] = 'date';
											$args['order'] = 'asc';
											$args['meta_key'] = '';
										break;
										case 'price_desc' :
											$args['orderby'] = 'meta_value_num';
											$args['order'] = 'desc';
											$args['meta_key'] = '_price';
										break;
										case 'title_desc' :
											$args['orderby'] = 'title';
											$args['order'] = 'desc';
											$args['meta_key'] = '';
										break;
										case 'menu_order' :
											$args['orderby'] = '';
											$args['order'] = '';
											$args['meta_key'] = '';
										break;
										case 'price' :
											$args['orderby'] = 'meta_value_num';
											$args['order'] = 'asc';
											$args['meta_key'] = '_price';
										break;
										case 'title_asc' :
											$args['orderby'] = 'title';
											$args['order'] = 'asc';
											$args['meta_key'] = '';
										break;	
										case 'select' :
											$args['orderby'] = '';
											$args['order'] = '';
											$args['meta_key'] = '';
										break;					
									endswitch;
								}
								else{
									$args['orderby'] = '';
									$args['order'] = '';
									$args['meta_key'] = '';								
								}
								$matched_products = array();
								if (isset($_GET['min_price'])) {
									$min = $_GET['min_price'];
									$max = $_GET['max_price'];		
									$matched_products = array();
									$matched_products_query = $wpdb->get_results( $wpdb->prepare("
										SELECT DISTINCT ID, post_parent, post_type FROM $wpdb->posts
										INNER JOIN $wpdb->postmeta ON ID = post_id
										WHERE post_type IN ( 'product', 'product_variation' ) AND post_status = 'publish' AND meta_key = %s AND meta_value BETWEEN %d AND %d
									", '_price', $min, $max ), OBJECT_K );
			
									if ( $matched_products_query ) {
										foreach ( $matched_products_query as $product ) {
											if ( $product->post_type == 'product' )
												$matched_products[] = $product->ID;
											if ( $product->post_parent > 0 && ! in_array( $product->post_parent, $matched_products ) )
												$matched_products[] = $product->post_parent;
										}
									}	
									
								}
								

								$args_recent = array( 'post_type' => 'product', 'post__in' => $matched_products ,'orderby' => $args['orderby'] , 'order' => $args['order'] , 'meta_key' => $args['meta_key'] ,'posts_per_page' => -1,'nopaging' => true, 'tax_query' => array( 
										 array (
										  'taxonomy' => 'product_cat',
										  'field' => 'id',
										  'terms' => $cat->term_id
										 ), 
										 
									 ));
								$product_query = new WP_Query( $args_recent ); 			
								wp_enqueue_script('pmc_bxSlider');		
								if ($product_query -> have_posts() ) {?>
									<?php 
									$rand = rand(0,99); 
									$cont_all_post = 0;		
									?>							
									<div class="panel entry-content" id="tab-<?php echo  $i ?>">
										<div class="pane" id="fragment-<?php echo  $i ?>">						
											<ul class="pane-slider-<?php echo $rand ?> shop-categories">
											<?php
											
											add_action('woocommerce_after_shop_loop_item_title','woocommerce_template_single_excerpt', 5); ?>
												<?php
												$currentindex = '';
												$countPost = 1;
												$countitem = 1;
												while ( $product_query -> have_posts() ) : $product_query -> the_post(); 
												if($countitem == 1){
													echo '<li>';}	
												global $product;
												$postmeta = get_post_custom(get_the_id());						
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
													$j = 0;
													foreach ($attachments as $id) {
														$image =  wp_get_attachment_image_src( $id, 'shop' ); 
														$image_show[$j] =  $image[0] ;
														$j++;
													}
												}
												else if ( has_post_thumbnail() && !$attachments){
													$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'shop', false);
													$image_show[0] = $image[0];			
													}
												else
													$image_show[0] = get_template_directory_uri() .'/images/placeholder-280.png';  						
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
													</div>
													<div class="product-price-cart">						
														<div class="recentPrice"><span class="price"><?php echo $product->get_price_html(); ?></span></div>	
														<div class="recentCart"><?php woocommerce_template_loop_add_to_cart( $post, $product ); ?></div>
													</div>		
													</div>
												<?php 
												$countPost++;
												$cont_all_post++;
												 if($countitem == 8){ 
													$countitem = 0; ?>
													</li>
												<?php } 												
												$countitem++;

												 endwhile; // end of the loop. ?>
										</ul>
										<script type="text/javascript">
											jQuery(document).ready(function(){	  


											// Slider
											var $slider = jQuery('.pane-slider-<?php echo $rand ?>').bxSlider({
														controls: false,
														displaySlideQty: 1,
														default: 1000,
														touchEnabled: false,
														easing : 'easeInOutQuint',
														<?php if($cont_all_post > 8){ ?>
														controls: true,
														prevText : '<i class="fa fa-chevron-left"></i>',
														nextText : '<i class="fa fa-chevron-right"></i>',
														<?php } ?>
														pager :false,
														infiniteLoop: false,
														hideControlOnEnd : true
														
													});
									  

											 });
										</script>											
										</div>

										<?php do_action('woocommerce_after_shop_loop'); ?>
									</div>
									
			
								<?php } else { ?>

									<?php if ( ! woocommerce_product_subcategories( array( 'before' => '<ul class="products">', 'after' => '</ul>' ) ) ) { ?>

										<p><?php _e( 'No products found which match your selection.', 'woocommerce' ); ?></p>
									<?php } ?>
								<?php } ?>
								
							<?php } ?>
							</div>
						</div>	
					</div>
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