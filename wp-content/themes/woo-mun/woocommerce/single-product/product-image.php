<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     99.99
 */

global $post, $woocommerce, $pmc_data, $product;
wp_enqueue_script('pmc_any');
$postmeta = get_post_custom($post->ID);


?>
	<script type="text/javascript">
	jQuery(document).ready(function($){
	<?php if($pmc_data['showresponsive'] ) { ?>
		if($( window ).width()>1180){
	<?php } ?>
			<?php if(isset($pmc_data['woo_zoom'])){ ?>
			$(".zoom").elevateZoom({
			  zoomType				: "lens",
			  lensShape : "window",
			  lensSize    : 200
			  
			   });	
			<?php }?>	
			$('#slider').anythingSlider({
			hashTags : false,
			expand		: true,
			autoPlay	: true,
			resizeContents  : false,
			pauseOnHover    : true,
			buildArrows     : false,
			buildNavigation : false,
			delay		: 9000,
			resumeDelay	: 0,
			animationTime	: 1000,
			delayBeforeAnimate:0,	
			easing : 'easeInOutQuint',
			 onShowStart       : function(e, slider) {	$('.nextbutton').fadeIn();
				$('.prevbutton').fadeIn();
				$('.activePage img').addClass('zoom');
				<?php if(isset($pmc_data['woo_zoom'])){ ?>
				$(".zoom").elevateZoom({
				  zoomType				: "lens",
				  lensShape : "window",
				  lensSize    : 200
				  
				   });	
				<?php }?>			

				},
			onSlideBegin    : function(e, slider) {
					$('.nextbutton').fadeOut();
					$('.prevbutton').fadeOut();
					var image = $('.zoom');
					$.removeData(image, 'elevateZoom');//remove zoom instance from image
					$('img').removeClass('zoom');
					$('.zoomContainer').remove();// remove zoom container from DOM
			
			},
			onSlideComplete    : function(slider) {
				
				$('.nextbutton').fadeIn();
				$('.prevbutton').fadeIn();
				$('.activePage img').addClass('zoom');
				<?php if(isset($pmc_data['woo_zoom'])){ ?>
				$(".zoom").elevateZoom({
				  zoomType				: "lens",
				  lensShape : "window",
				  lensSize    : 200
				  
				   });	
				<?php }?>
			}		
			})

			
			$('.blogsingleimage').hover(function() {
			$(".slideforward").stop(true, true).fadeIn();
			$(".slidebackward").stop(true, true).fadeIn();
			}, function() {
			$(".slideforward").fadeOut();
			$(".slidebackward").fadeOut();
			});
			$(".pauseButton").toggle(function(){
			$(this).attr("class", "playButton");
			$('#slider').data('AnythingSlider').startStop(false); // stops the slideshow
			},function(){
			$(this).attr("class", "pauseButton");
			$('#slider').data('AnythingSlider').startStop(true);  // start the slideshow
			});
			$(".slideforward").click(function(){
			$('#slider').data('AnythingSlider').goForward();
			});
			$(".slidebackward").click(function(){
			$('#slider').data('AnythingSlider').goBack();
			}); 
			<?php if($pmc_data['showresponsive'] ) { ?>
			}
			<?php } ?>
		});
		
		
		
	</script>			

<div class="imagesSPAll">

	<div class="images imagesSP">		
		<?php
		$attachments = $product->get_gallery_attachment_ids();

		
		if ($attachments) {?>
			
			<div class="loading"></div>
			<div id="slider" class="slider product">
					<?php 
					$i = 0;
					$zoom = '';
					if(count($attachments) == 1){
						$zoom = 'zoom';
					}
						foreach ($attachments as $id) {
						
							//echo apply_filters('the_title', get_the_title($id));
							$image =  wp_get_attachment_image_src( $id, 'productBig' ); 
							$imagefull =  wp_get_attachment_image_src( $id, 'full' );
							?>	
								<div>
									<a href = "<?php echo $image[0] ?>" title="<?php echo esc_attr(  get_the_title($id) ) ?>" rel="lightbox" ><img class="check <?php echo $zoom ?>" src="<?php echo $image[0] ?>" alt = "<?php echo esc_attr(  get_the_title($id) ) ?>" data-zoom-image="<?php echo $imagefull[0] ?>"/></a>				
											
								</div>
								
								<?php 
								$i++;
								} ?>
		
				
			</div>

			<?php if($i > 1 && !isset($pmc_data['woo_zoom']) ) { ?>
			<div class="navigationSP">
				<div class="prevbutton slidebackward port"><i class="fa fa-chevron-left"></i></div>
				<div class="nextbutton slideforward port"><i class="fa fa-chevron-right"></i></div>
			</div>	
			<?php } ?>
			<?php } else if ( has_post_thumbnail() ) { 
				$zoom = 'zoom';
				$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full'); ?>
				<a href = "<?php echo $large_image_url[0] ?>" title="<?php echo esc_attr( get_the_title(get_the_id()) ) ?>" rel ="lightbox[product]" ><img class="check <?php echo $zoom ?>" src="<?php echo $large_image_url[0] ?>" alt="<?php echo esc_attr( get_the_title(get_the_id()) ) ?>" data-zoom-image="<?php echo $large_image_url[0] ?>"/></a>				
				<?php
			} ?>
	</div>
	<div class="thumbnails">
			<?php if(isset($postmeta["video_active"][0]) && $postmeta["video_active"][0] == 1) { ?>
				<?php
					if ($postmeta["selectv"][0] == 'vimeo')  
					{  
						echo '<a class="thumbSP" href="http://vimeo.com/'.$postmeta["video_post_url"][0].'" rel="lightbox[productLightBox]" title="'.esc_attr( get_the_title(get_the_id()) ).'"><img class="videoImage" src="'. getVimeoThumb($postmeta["video_post_url"][0]) .'" alt="Video" /></a>';  
					}  
					else if ($postmeta["selectv"][0] == 'youtube')  
					{  
						echo '<a  class="thumbSP" href="http://www.youtube.com/watch?v='.$postmeta["video_post_url"][0].'" rel="lightbox[productLightBox]" title="'.esc_attr( get_the_title(get_the_id()) ).'"><img class="videoImage"  src="http://img.youtube.com/vi/'. $postmeta["video_post_url"][0] .'/0.jpg" alt="Video" /></a>';  					
					}  
					else  
					{  
						//echo 'Please select a Video Site via the WordPress Admin';  
					} 				
				?>

			<?php } ?>
		<?php if ($attachments) {

			foreach ( $attachments as $id ) {
			
				$image =  wp_get_attachment_image_src( $id, 'productSmall' ); 

				
				printf( '<a href="%s" title="%s" rel="lightbox[productLightBox]" class="thumbSP"><img src="%s" alt="%s"></a>', wp_get_attachment_url( $id ), esc_attr( get_the_title($id) ), $image[0] , esc_attr( get_the_title($id) ));

			}

		}
	?></div>
</div>	
