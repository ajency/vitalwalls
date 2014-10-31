<?php

/* function for portfolio block*/
function pmc_portBlock($title,$number_post,$rowsB,$categories,$port_ajax){
	wp_enqueue_script('pmc_bxSlider');
	$rand = rand(0,99);	
	global $pmc_data,$sitepress;

		
	if($number_post){
		$showpost = $number_post  ;}		

	if($title) {
		$title = $title;
	}
	else {
		$title = pmc_translation('translation_port', 'Recent from Our portfolio');
	}
		
	if(isset($pmc_data['home_recent_number_display']))
		$rows = $pmc_data['home_recent_number_display'];
	else
		$rows = 3;
		
	if($rowsB){
		$rows = $rowsB;
	}	
	
	if(isset($categories) and count($categories) > 0){
		$categories = $categories;
		$pc = new WP_Query(array('post_type' => $pmc_data['port_slug'],
                'tax_query' => array( 
                     array (
                      'taxonomy' => 'portfoliocategory',
                      'field' => 'id',
                      'terms' => $categories
                     ), 
                 ),
                'posts_per_page' => $number_post)
             );		
		}
	else{
		$categories='';
		$pc = new WP_Query(array('post_type' => $pmc_data['port_slug'],'posts_per_page' => $number_post));			
	}	

?>

	<script type="text/javascript">


		jQuery(document).ready(function(){	  


		// Slider
		var $slider = jQuery('#sliderAdvertisePort').bxSlider({
			controls: true,
			displaySlideQty: 1,
			default: 1000,
			touchEnabled: false,
			easing : 'easeInOutQuint',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			pager :false
			
		});



		 });
	</script>
	
<?php 	if ($pc->have_posts()) :
	wp_enqueue_script('pmc_any');
	wp_enqueue_script('pmc_any_fx');
	wp_enqueue_script('pmc_any_video');	?>
<div class="homerecent">
	<div class="homerecentInner">
	<div id = "showpost-<?php echo $pmc_data['port_slug'] ?>-<?php echo $rand ?>">
		<div class="showpostload"><div class="loading"></div></div>
		<div class = "closehomeshow-<?php echo $pmc_data['port_slug'] ?> port closeajax"><i class="fa fa-times"></i></div>
		<div class="showpostpostcontent"></div>
	</div>	
	<div class="titlebordrtext"><h2 class="titleborderh2"><?php echo $title ?></h2></div>	
	<div class="titleborderOut"><div class="titleborder"></div></div>
	<ul id="sliderAdvertisePort" class="sliderAdvertisePort">
		<?php
		$currentindex = '';
		$count = 1;
		$countitem = 1;
		$type = $pmc_data['port_slug'];
		?>
		<?php  while ($pc->have_posts()) : $pc->the_post();
		$postmeta = get_post_custom(get_the_ID()); 
		if($countitem == 1){
			echo '<li>';}			
		$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'homePort', false);	
		$catType= 'portfoliocategory';
		
		//category
		$categoryIn = get_the_term_list( get_the_ID(), $catType, '', ', ', '' );	
		$category = explode(',',$categoryIn);	
		//end category			
		if ( has_post_thumbnail() ){
			$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'homePort', false);
			$image = $image[0];
			
			$imagefull = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full', false);
			$imagefull = $imagefull[0];			
			}
		else
			$image = get_template_directory_uri() .'/images/placeholder-portfolio-home.png'; 
	
		if(isset($postmeta['show_video'][0])){
			$linkport = $postmeta['video'][0];
		}
		else{
			$linkport = $imagefull;
		}		
		if($count != 3){
			echo '<div class="one_third" >';
		}
		else{
			echo '<div class="one_third last" >';
			$count = 0;
		}
		?>
				<?php if ($port_ajax == 'true'){ ?>
				<div class="click" id="<?php echo $type ?>_<?php echo get_the_id() ?>_<?php echo $rand ?>">
				<?php } ?>
					<?php if ($port_ajax != 'true'){ ?>
					<a href = "<?php echo $linkport ?>" title="<?php echo esc_attr(  get_the_title(get_the_id()) ) ?>" rel="lightbox" >
					<?php } ?>						
					<div class="recentimage">
							<div class="overdefult">
								<div class="portIcon"></div>
							</div>			
						<div class="image">
							<div class="loading"></div>						
							<img class="portfolio-home-image" src="<?php echo $image ?>" alt="<?php the_title(); ?>">							
						</div>
					</div>
					<?php if ($port_ajax != 'true'){ ?>
						</a>
					<?php } ?>	
					<div class="recentdescription">
						<?php if ($port_ajax != 'true'){ ?>
							<a href="<?php echo get_permalink( get_the_id() ) ?>">
						<?php } ?>
						<h3><?php $title = the_title('','',FALSE);  echo substr($title, 0, 23);  if(strlen($title) > 23) echo '...'?></h3>
						<?php if ($port_ajax != 'true'){ ?>
							</a>
						<?php } ?>						
						<div class="recentdescription-text"><?php echo shortcontent("[", "]", "", get_the_content() , 160) ?> ...</div>
						<?php if ($port_ajax != 'true'){ ?>
							<div class="recentdescription-text"><a href="<?php echo get_permalink( get_the_id() ) ?>"><?php echo pmc_translation('translation_morelinkblog', 'Read more about this...') ?></a></div>
						<?php } ?>
					</div>
				<?php if ($port_ajax == 'true'){ ?>	
				</div>
				<?php } ?>
			</div>
		<?php 
		$count++;
		
		 if($countitem == $rows){ 
			$countitem = 0; ?>
			</li>
		<?php } 
		$countitem++;
		endwhile; 
		wp_reset_query(); ?>
		</ul>
	</div>
</div>
<?php  endif; ?>

<div class="clear"></div>

<?php

}

/* function for advertise block */
function pmc_advertiseBlock($title){

	global $pmc_data,$sitepress; 
	wp_enqueue_script('pmc_bxSlider');		
	if($title) {
		$title = $title;
	}
	else {
		$title = '';
	}	
	?>
	<script type="text/javascript">


		jQuery(document).ready(function(){	  


		<?php if(count($pmc_data['advertiseimage'])> 5) { ?>
		// Slider
		var $slider = jQuery('.sliderAdvertise').bxSlider({
			maxSlides:5,
			minSlides:1,
			moveSlides:1,
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			auto : true,
			easing : 'easeInOutQuint',
			pause : 4000,
			pager :false,
			controls: true,
		});

		<?php } ?> 

		 });
	</script>
	
	<div class="advertise">
		<div class="advertiseInner">
			<?php if($title != '') { ?>
			<div class="titlebordrtext"><h2 class="titleborderh2"><?php echo $title ?></h2></div>	
			<div class="titleborderOut"><div class="titleborder"></div></div>
			<?php } ?>
			<?php 
			if(isset($pmc_data['advertiseimage'])){
				$slides = $pmc_data['advertiseimage']; ?>
				<ul class="sliderAdvertise">
				<?php foreach ($slides as $slide) {  ?>
					<li>
					<?php
					  if($slide['url'] != '') :
							   
						 if($slide['link'] != '') : ?>
						   <a href="<?php echo $slide['link']; ?>"><img src="<?php echo $slide['url']; ?>" alt="<?php echo $slide['title'] ?>" /></a>
						<?php else: ?>
							<img src="<?php echo $slide['url']; ?>" alt="<?php echo $slide['title'] ?>"/>
						<?php endif; ?>
								
					<?php endif; ?>
					</li>
				<?php } ?>
				</ul>
			<?php } ?>	
		</div>
	</div>
	<?php
}

function pmc_productBlock($title,$number_post,$rowsB,$categories,$port_text,$type,$product_ajax){
	wp_enqueue_script('pmc_bxSlider');		
	$rand = rand(0,99);
    global $pmc_data, $sitepress, $wpdb;
	if(isset($number_post))
		$showpost = $number_post;
	else
		$showpost = 8;
		
	if(isset($rowsB))
		$rows = $rowsB;
	else
		$rows = 4;
		
	if(isset($productShow)){
		$rows = $productShow;
	}

	if($type == 'recent'){	
		$args = array( 'post_type' => 'product', 'posts_per_page' => $showpost , 'tax_query' => array( 
                     array (
                      'taxonomy' => 'product_cat',
                      'field' => 'id',
                      'terms' => $categories
                     ), 
                 ));
		$pc = new WP_Query( $args );
		
	}
	
	if($type == 'feautured'){
		$args = array( 'post_type' => 'product', 'orderby'=>'rand', 'posts_per_page' => $showpost ,'meta_query' => array(
			array(
				'key' => '_visibility',
				'value' => array('catalog', 'visible'),
				'compare' => 'IN'
			),
			array(
				'key' => '_featured',
				'value' => 'yes'
			) ), 'tax_query' => array( 
                     array (
                      'taxonomy' => 'product_cat',
                      'field' => 'id',
                      'terms' => $categories
                     ), 
                 ) );


		$pc = new WP_Query( $args );
	
	}
	
?>

	<script type="text/javascript">


		jQuery(document).ready(function(){	  


		// Slider
		var $slider = jQuery('#productR-<?php echo $rand ?>').bxSlider({
					controls: true,
					displaySlideQty: 1,
					default: 1000,
					touchEnabled: false,
					easing : 'easeInOutQuint',
					prevText : '<i class="fa fa-chevron-left"></i>',
					nextText : '<i class="fa fa-chevron-right"></i>',
					pager :false

					
				});
  

		 });
	</script>




		

<div class="homerecent <?php echo $type ?>">
	<div class="wocategoryFull">

		<div class="productR <?php echo $type ?>">
			<div class="homerecentInner">
			<div id = "showpost-<?php echo $type ?>-<?php echo $rand ?>">
				<div class="showpostload"><div class="loading"></div></div>
				<div class = "closehomeshow-<?php echo $type ?> product closeajax"><i class="fa fa-times"></i></div>
				<div class="showpostpostcontent"></div>
			</div>	
			<div class="titlebordrtext"><h2 class="titleborderh2"><?php echo $title ?></h2></div>	
			<div class="titleborderOut"><div class="titleborder"></div></div>	
			<div class="homerecent productRH" >
		
				<ul id="productR-<?php echo $rand ?>" class="productR">
					<?php
					printProduct ($number_post,$rowsB,$type,$product_ajax,$pc,$rand );
					?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php
}


function pmc_productBothBlock($title,$number_post,$rowsB,$categories,$port_text,$type,$product_ajax){
	wp_enqueue_script('pmc_bxSlider');		
	
    global $pmc_data, $sitepress, $wpdb;
	if(isset($number_post))
		$showpost = $number_post;
	else
		$showpost = 8;
		
	if(isset($rowsB))
		$rows = $rowsB;
	else
		$rows = 4;
		
	if(isset($productShow)){
		$rows = $productShow;
	}

	$args_recent = array( 'post_type' => 'product', 'posts_per_page' => $showpost , 'tax_query' => array( 
				 array (
				  'taxonomy' => 'product_cat',
				  'field' => 'id',
				  'terms' => $categories
				 ), 
			 ));
	$pc_recent = new WP_Query( $args_recent );
		
	
	$args_feautured = array( 'post_type' => 'product', 'orderby'=>'rand', 'posts_per_page' => $showpost ,'meta_query' => array(
		array(
			'key' => '_visibility',
			'value' => array('catalog', 'visible'),
			'compare' => 'IN'
		),
		array(
			'key' => '_featured',
			'value' => 'yes'
		) ), 'tax_query' => array( 
				 array (
				  'taxonomy' => 'product_cat',
				  'field' => 'id',
				  'terms' => $categories
				 ), 
			 ) );


	$pc_feautured = new WP_Query( $args_feautured );

	
?>



<div class="products-both">	
	<div class="titleborderOut"><div class="titleborder"></div></div>	
	<div class="tabwrap tabsonly">	
		<ul class="tabsshort recent feautured">
			<li>
				<a href="#fragment-recent"><?php echo pmc_translation('translation_recent_pruduct_title', 'Recent Products'); ?></a>
			</li>
			<li>
				<a href="#fragment-feautured"><?php echo pmc_translation('translation_featured', 'Our Futured Products'); ?></a>
			</li>		
		</ul>	
		<div class="panes">
			<div class="panel entry-content" id="tab-recent">
				<div class="pane" id="fragment-recent">
					<?php $rand = rand(0,99); ?>
					<script type="text/javascript">


						jQuery(document).ready(function(){	  


						// Slider
						var $slider = jQuery('#productR-<?php echo $rand ?>').bxSlider({
									controls: true,
									displaySlideQty: 1,
									default: 1000,
									easing : 'easeInOutQuint',
									touchEnabled: false,
									prevText : '<i class="fa fa-chevron-left"></i>',
									nextText : '<i class="fa fa-chevron-right"></i>',
									pager :false,
									infiniteLoop: false,
									hideControlOnEnd : true									

									
								});
				  

						 });
					</script>				
					<div class="homerecent recent">
						<div class="wocategoryFull">
							<div class="productR recent">
								<div class="homerecentInner">
									<div id = "showpost-recent-<?php echo $rand ?>">
										<div class="showpostload"><div class="loading"></div></div>
										<div class = "closehomeshow-recent product closeajax"><i class="fa fa-times"></i></div>
										<div class="showpostpostcontent"></div>
									</div>	
									<div class="homerecent productRH" >
										<ul id="productR-<?php echo $rand ?>" class="productR">
											<?php
											printProduct ($number_post,$rowsB,'recent',$product_ajax,$pc_recent,$rand );
											?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>	
				</div>
				<div class="pane" id="fragment-feautured">
					<?php $rand = rand(0,99); ?>
					<script type="text/javascript">


						jQuery(document).ready(function(){	  


						// Slider
						var $slider = jQuery('#productR-<?php echo $rand ?>').bxSlider({
									controls: true,
									displaySlideQty: 1,
									default: 1000,
									touchEnabled: false,
									easing : 'easeInOutQuint',
									prevText : '<i class="fa fa-chevron-left"></i>',
									nextText : '<i class="fa fa-chevron-right"></i>',
									pager :false,
									infiniteLoop: false,
									hideControlOnEnd : true

									
								});
				  

						 });
					</script>					
					<div class="homerecent feautured">
						<div class="wocategoryFull">
							<div class="productR feautured">
								<div class="homerecentInner">
									<div id = "showpost-feautured-<?php echo $rand ?>">
										<div class="showpostload"><div class="loading"></div></div>
										<div class = "closehomeshow-feautured product closeajax"><i class="fa fa-times"></i></div>
										<div class="showpostpostcontent"></div>
									</div>	
									<div class="homerecent productRH" >
										<ul id="productR-<?php echo $rand ?>" class="productR">
											<?php
											printProduct ($number_post,$rowsB,'feautured',$product_ajax,$pc_feautured,$rand );
											?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>	
				</div>	
			</div>
		</div>
	</div>
</div>
<?php
}


function printProduct ($number_post,$rows,$type,$product_ajax,$data,$rand){
	$average = 0;
	$currentindex = '';
	if ($data->have_posts()) :
	$countPost = 1;
	$countitem = 1;
	?>
	<?php  while ($data->have_posts()) : $data->the_post();
			global $product, $post, $woocommerce;
			if($countitem == 1){
				echo '<li>';}		
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
				$image_show[0] = get_template_directory_uri() .'/images/placeholder-580.png'; 						
			?>
	
					<div class="recentimage">
						<?php 
						if(shortcode_exists( 'yith_wcwl_add_to_wishlist' )){
							echo do_shortcode( '[yith_wcwl_add_to_wishlist]' ); }
						?>
						<div class="image">
							<div class="loading"></div>
								<?php if ($product_ajax != 'true'){ ?>
								<a href="<?php echo get_permalink( get_the_id() ) ?>">
								<?php } ?>							
									<img class = "image0" src = "<?php echo $image_show[0] ?>" alt = "<?php echo get_the_title() ?>"  > 
									<?php if(isset($image_show[1])) { ?>
									
										<img class = "image1" src = "<?php echo $image_show[1] ?>" alt = "<?php echo get_the_title() ?>"  > 										
									<?php } ?>
								<?php if ($product_ajax != 'true'){ ?>
								</a>
								<?php } ?>								
						</div>
					</div>	
				<?php if ($product_ajax == 'true'){ ?>
				<div class="click" id="<?php echo $type ?>_<?php echo get_the_id() ?>_<?php echo $rand ?>">
				<?php } ?>				
					<div class="recentdescription">
						<?php woocommerce_show_product_sale_flash( $product ); ?>
						<?php if ($product_ajax != 'true'){ ?>
						<a href="<?php echo get_permalink( get_the_id() ) ?>">
						<?php } ?>
						<h3><?php the_title() ?></h3>	
						<?php if ($product_ajax != 'true'){ ?>
						</a>
						<?php } ?>										
					</div>
				<?php if ($product_ajax == 'true'){ ?>	
				</div>	
				<?php } ?>
					<div class="product-price-cart">						
						<div class="recentPrice"><span class="price"><?php echo $product->get_price_html(); ?></span></div>	
						<div class="recentCart"><?php woocommerce_template_loop_add_to_cart(  $product ); ?></div>
					</div>	
					
			</div>
	<?php 
	$countPost++;
	
	 if($countitem == $rows){ 
		$countitem = 0; ?>
		</li>
	<?php } 
	$countitem++;
	endwhile; endif;
	wp_reset_query(); 

}
?>