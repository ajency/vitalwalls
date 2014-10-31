<?php
/** Slider Block **/
	class AQ_Slider_Block_AnythingSlider extends AQ_Block {
	
		function __construct() {
			$block_options = array(
				'name'			=> 'AnythingSlider',
				'size'			=> 'span12',
			);
			
			parent::__construct('aq_slider_block_anythingslider', $block_options);
			
			add_action('wp_ajax_aq_block_slider_add_new', array($this, 'add_slide'));
		}
		
		function form($instance) {
			$defaults = array(
				'slides_anythingslider'		=> array(
					1 => array(
						'title' => 'My New Slide',
						'url' => '',
						'description' => '',
						'link' => '',
						'top' => '',
						'left' => '',
						'video' => ''							
					)
				),
				'animSpeed'			=> 500,
				'pauseTime'			=>5000,
				'useDefaultslides_anythingslider' 			=> false
			);
		
			$autoslide_option = array(
				'true'  => 'True',
				'false'  => 'False',
				
			);		


			
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			
			?>
			<div class="description cf">
				<ul id="sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
					<?php
					$slides_anythingslider = is_array($slides_anythingslider) ? $slides_anythingslider : $defaults['slides_anythingslider'];
					$count = 1;
					foreach($slides_anythingslider as $slide) {	
						$this->slide($slide, $count);
						$count++;
					}
					?>
				</ul>
				<p></p>
				<a href="#" rel="slider" class="aq-sortable-add-new button">Add New</a>
				<p></p>
			</div>
			<p class="description half">
				<label for="<?php echo $this->get_field_id('useDefaultslides_anythingslider') ?>">
					Select if you wish to use default slides defined via theme options<br/>
					<?php echo aq_field_select('useDefaultslides_anythingslider', $block_id, $autoslide_option, $useDefaultslides_anythingslider, $block_id); ?>
				</label>
			</p>	
			<p class="description half last"><br/><br/><br/><br/>
			</p>			
			<p class="description third">
				<label for="<?php echo $this->get_field_id('animSpeed') ?>">
					Set slide transition speed<br/>
					<?php echo aq_field_input('animSpeed', $block_id, $animSpeed) ?>
				</label>
			</p>
			<p class="description third">
				<label for="<?php echo $this->get_field_id('pauseTime') ?>">
					Set how long each slide will show<br/>
					<?php echo aq_field_input('pauseTime', $block_id, $pauseTime) ?>
				</label>
			</p>
	
			<?php
		}
		
		function slide($slide = array(), $count = 0) {
			
			$defaults = array (
				'title' => '',
				'url' => '',
				'description' => '',
				'link' => '',
				'top' => '',
				'left' => '',
				'video' => ''					
			);
			$slide = wp_parse_args($slide, $defaults);
			
			?>
			<li id="<?php echo $this->get_field_id('testimonials') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">
				
				<div class="sortable-head cf">
					<div class="sortable-title">
						<strong><?php echo $slide['title'] ?></strong>
					</div>
					<div class="sortable-handle">
						<a href="#">Open / Close</a>
					</div>
				</div>
				
				<div class="sortable-body">
					<p class="description">
						<label for="<?php echo $this->get_field_id('slides_anythingslider') ?>-<?php echo $count ?>-title">
							Slide Title<br/>
							<input type="text" id="<?php echo $this->get_field_id('slides_anythingslider') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('slides_anythingslider') ?>[<?php echo $count ?>][title]" value="<?php echo $slide['title'] ?>" />
						</label>
					</p>
					<p class="description">
						<label for="<?php echo $this->get_field_id('slides_anythingslider') ?>-<?php echo $count ?>-url">
							Upload Image<br/>
							<input type="text" id="<?php echo $this->get_field_id('slides_anythingslider') ?>-<?php echo $count ?>-url" class="input-full input-url" value="<?php echo $slide['url'] ?>" name="<?php echo $this->get_field_name('slides_anythingslider') ?>[<?php echo $count ?>][url]">
							<a href="#" class="aq_upload_button button" rel="image">upload</a>
							<p></p>
						</label>
					</p>
					<p class="description">
						<label for="<?php echo $this->get_field_id('slides_anythingslider') ?>-<?php echo $count ?>-description">
							Slide description<br/>
							<textarea id="<?php echo $this->get_field_id('slides_anythingslider') ?>-<?php echo $count ?>-description" class="textarea-full" name="<?php echo $this->get_field_name('slides_anythingslider') ?>[<?php echo $count ?>][description]" rows="5"><?php echo $slide['description'] ?></textarea>
						</label>
					</p>
					<p class="description">
						<label for="<?php echo $this->get_field_id('slides_anythingslider') ?>-<?php echo $count ?>-link">
							link URL<br/>
							<input type="text" id="<?php echo $this->get_field_id('slides_anythingslider') ?>-<?php echo $count ?>-link" class="input-full" name="<?php echo $this->get_field_name('slides_anythingslider') ?>[<?php echo $count ?>][link]" value="<?php echo $slide['link'] ?>" />
						</label>
					</p>					
					<p class="description half">
						<label for="<?php echo $this->get_field_id('slides_anythingslider') ?>-<?php echo $count ?>-top">
							Text position from top in % (dont add % only number)<br/>
							<input type="text" id="<?php echo $this->get_field_id('slides_anythingslider') ?>-<?php echo $count ?>-top" class="input-full" name="<?php echo $this->get_field_name('slides_anythingslider') ?>[<?php echo $count ?>][top]" value="<?php echo $slide['top'] ?>" />
						</label>
					</p>
					<p class="description half last">
						<label for="<?php echo $this->get_field_id('slides_anythingslider') ?>-<?php echo $count ?>-left">
							Text position from left in % (dont add % only number)<br/>
							<input type="text" id="<?php echo $this->get_field_id('slides_anythingslider') ?>-<?php echo $count ?>-left" class="input-full" name="<?php echo $this->get_field_name('slides_anythingslider') ?>[<?php echo $count ?>][left]" value="<?php echo $slide['left'] ?>" />
						</label>
					</p>
					<p class="description">
						<label for="<?php echo $this->get_field_id('slides_anythingslider') ?>-<?php echo $count ?>-video">
							Video URL (leave empty if this is image slide)<br/>
							<input type="text" id="<?php echo $this->get_field_id('slides_anythingslider') ?>-<?php echo $count ?>-video" class="input-full" name="<?php echo $this->get_field_name('slides_anythingslider') ?>[<?php echo $count ?>][video]" value="<?php echo $slide['video'] ?>" />
						</label>
					</p>					
					<p class="description"><a href="#" class="sortable-delete">Delete</a></p>
				</div>
				
			</li>
			<?php
			
		}
		
		function add_slide() {
			$nonce = $_POST['security'];	
			if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
			
			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
			
			//default key/value for the tab
			$slide = array(
				'title' => 'New Slide',
				'url' => '',
				'description' => '',
				'link' => '',
				'top' => '',
				'left' => '',
				'video' => ''				
			);
			
			if($count) {
				$this->slide($slide, $count);
			} else {
				die(-1);
			}
			
			die();
		}
		
		function block($instance) {

			extract($instance);
			wp_enqueue_script('pmc_any');
			wp_enqueue_script('pmc_any_fx');
			wp_enqueue_script('pmc_any_video');	
			$rand = rand(0,99);
			?>
			
			<script type="text/javascript">
			jQuery(document).ready(function($){
			if ($.browser.msie && $.browser.version.substr(0,1)<9 && $.browser.version.substr(0,2)!=10) {

					$('#slider').anythingSlider({
					hashTags : false,
					expand		: true,
					autoPlay	: true,
					resizeContents  : false,
					pauseOnHover    : true,
					buildArrows     : false,
					buildNavigation : false,
					delay		: <?php  echo $pauseTime  ?>,
					resumeDelay	: 0,
					animationTime	: <?php echo $animSpeed ?>,
					delayBeforeAnimate:0,	
					easing : 'easeInOutQuint'
					
				
					})
					
			 }
			  else{
					$('#slider').anythingSlider({
					hashTags : false,
					expand		: true,
					autoPlay	: true,
					resizeContents  : false,
					pauseOnHover    : true,
					buildArrows     : false,
					buildNavigation : false,
					delay		: <?php  echo $pauseTime  ?>,
					resumeDelay	: 0,
					animationTime	: <?php echo $animSpeed ?>,
					delayBeforeAnimate:0,	
					easing : 'easeInOutQuint',		
					onBeforeInitialize   : function(e, slider) {
						$('.textSlide h1, .textSlide li, .textSlide img, .textSlide h2, .textSlide li.button').css('opacity','0'); 
						
					},
					
					onSlideBegin    : function(e, slider) {
					
					},
					onSlideComplete    : function(slider) {

						 $('.textSlide li.top,.textSlide li.top1,.textSlide li.top2,.textSlide li.top3,.textSlide li.bounceBall1, .textSlide li.bounceBall2, .textSlide li.bounceBall3, .textSlide li.bounceBall4,.textSlide li.bounceBall5,.textSlide li.bounceBall6').css('top','-900px');
					}
					
				
					})
					
			  .anythingSliderFx({ 
			  
			   // base FX definitions can be mixed and matched in here too. 
			   '.fade' : [ 'fade' ], 

			   // for more precise control, use the "inFx" and "outFx" definitions 
			   // inFx = the animation that occurs when you slide "in" to a panel 
			   inFx : { 
				'.textSlide h1'  : { opacity: 1, top  : 0, duration: 500, easing : 'linear' }, 
				'.textSlide h2'  : { opacity: 1, top  : 0, duration: 500, easing : 'linear' },
				'.textSlide li.object1'  : { opacity: 1, top  : 0, duration: 500, easing : 'linear' }, 
				'.textSlide li.left, .textSlide li.right'  : { opacity: 1, left : 0,  duration: 2000 ,easing : 'easeOutQuint'},
				'.textSlide li.top' : { opacity: 1,  top : 0,  duration: 1500 ,easing : 'easeOutQuint'}	,
				'.textSlide li.top1' : { opacity: 1,  top : 0, duration: 1500 ,  easing : 'easeOutQuint'}	,
				'.textSlide li.top2' : { opacity: 1,  top : 0, duration: 1500 ,easing : 'easeOutQuint'}	,
				'.textSlide li.top3' : { opacity: 1,  top : 0, duration: 1500 ,easing : 'easeOutQuint'}	,	
				'.textSlide li.top4' : { opacity: 1,  top : 0, duration: 1500 ,easing : 'easeOutQuint'}	,
				'.textSlide li.bottom'  : { opacity: 1,  bottom : 0, duration: 3000 ,easing : 'easeOutQuint'}	,	
				'.textSlide li.bottom2'  : { opacity: 1,  top : 0, duration: 2500 ,easing : 'easeOutQuint'}	,
				'.textSlide li.button'  : { opacity: 1,  top : 0, duration: 0,easing : 'easeOutQuint'}	,
				'.textSlide li.salePrice1'  : { opacity: 1,  top : 0, duration: 500,easing : 'easeOutQuint'}	,
				'.textSlide li.salePrice2'  : { opacity: 1,  top : 0, duration: 500,easing : 'easeOutQuint'}	,
				'.textSlide li.salePrice3'  : { opacity: 1,  top : 0, duration: 500,easing : 'easeOutQuint'}	,
				'.textSlide li.bounceBall1'  : { opacity: 1,  top : 0, duration: 3100,easing : 'easeOutBounce'}	,
				'.textSlide li.bounceBall2'  : { opacity: 1,  top : 0, duration: 2800,easing : 'easeOutBounce'}	,
				'.textSlide li.bounceBall3'  : { opacity: 1,  top : 0, duration: 3500,easing : 'easeOutBounce'}	,
				'.textSlide li.bounceBall4'  : { opacity: 1,  top : 0, duration: 2200,easing : 'easeOutBounce'}	,
				'.textSlide li.bounceBall5'  : { opacity: 1,  top : 0, duration: 1900,easing : 'easeOutBounce'}	,
				'.textSlide li.bounceBall6'  : { opacity: 1,  top : 0, duration: 2700,easing : 'easeOutBounce'}	,
				'.textSlide li.quote'  : { opacity: 1,  top : 0, duration: 5600 ,easing : 'easeOutQuad'}
			   }, 
			   // out = the animation that occurs when you slide "out" of a panel 
			   // (it also occurs before the "in" animation) 
			   outFx : { 
				'.textSlide h1'      : { opacity: 0, top  : '0px', duration: 500 }, 
				'.textSlide li.object1'      : { opacity: 0, top  : '0px', duration: 500 }, 
				'.textSlide li.right'  : { opacity: 0, left : '0px', duration: 0 }, 
				'.textSlide li.left' : { opacity: 0, left : '0px',  duration: 0 },
				'.textSlide li.bottom' : { opacity: 0, top : '0px',  duration: 0 },
				'.textSlide li.bottom2' : { opacity: 0, top : '0px',  duration: 0 },
				'.textSlide li.top1' : { opacity: 0, top : '-900px',  duration: 1000},
				'.textSlide li.top2' : { opacity: 0, top : '-900px',  duration: 2200},
				'.textSlide li.top3' : { opacity: 0, top : '-900px',  duration: 3400},
				'.textSlide li.top4' : { opacity: 0, top : '-900px',  duration: 4600},
				 '.textSlide li.button' : { opacity: 0, top : '0px',  duration: 0 },
				 '.textSlide li.salePrice1' : { opacity: 0, top : '500px',  duration: 5000 },
				 '.textSlide li.salePrice2' : { opacity: 0, top : '500px',  duration: 5250 },
				 '.textSlide li.salePrice3' : { opacity: 0, top : '500px',  duration: 5500 },
				  '.textSlide li.quote' : { opacity: 0, top : '700px',  duration: 350 },
				'.textSlide img' : { opacity: 1, top : '0px',  duration: 600 },
			   
			   }
			  
			  }); 
			  
			  }
			 
					$(".slideforward").click(function(){
					$('#slider').data('AnythingSlider').goForward();
					});
					$(".slidebackward").click(function(){
					$('#slider').data('AnythingSlider').goBack();
					});  
			});	
			</script>	

			<div id="slider-wrapper" class="slider-wrapper">
				<div class="loading"></div>	
				<div id="slider">
					<?php 
					$i = 0;
					if($useDefaultslides_anythingslider == 'true'){
						global $pmc_data;
						$slides_anythingslider = $pmc_data['demo_slider'];}					
					if(!empty($slides_anythingslider)){
						foreach ($slides_anythingslider as $slide) { ?>
							<div>
								<div class="panel-<?php echo $i ?>">		
									<?php if (empty ($slide['video'])) { ?>
										<?php if(!empty($slide['url'])){ ?>
											<div class="images">
												<?php if (!empty ($slide['link'])) { ?>

													<a href="<?php echo $slide['link']; ?>" title="">
														
														<img class="check"  src="<?php echo $slide['url']; ?>" alt="<?php echo pmc_stripText($slide['title']); ?>" >
													</a>
												
												<?php } else { ?>
													<img class="check" src="<?php echo $slide['url']; ?>"  alt="<?php echo pmc_stripText($slide['title']); ?>">	

												<?php } ?>

													<div class="textSlide" style="top:<?php echo $slide['top']?>%; left:<?php echo $slide['left']; ?>%">

													<?php echo do_shortcode(htmlspecialchars_decode(stripslashes($slide['description'])));  ?>	
													<div class="prevbutton slidebackward"></div>
													<div class="nextbutton slideforward"></div>											
													
													</div>
											</div>
										<?php } else { ?>
											<div class="images">
												<div class="textSlide" style="top:<?php echo $slide['top']?>%; left:<?php echo $slide['left']; ?>%">

													<?php echo do_shortcode(htmlspecialchars_decode(stripslashes($slide['description'])));  ?>	
													<div class="prevbutton slidebackward"></div>
													<div class="nextbutton slideforward"></div>											
													
												</div>
											</div>
										<?php } ?>
										<?php } else {?>
											<div id="slider-wrapper-iframe">
												<?php if(strpos($slide['video'], 'vimeo')){	?>
													<div class="iframes">
														<iframe src="<?php echo $slide['video'] ?>" width="940" height="445" ></iframe>


															<div class="textSlide" style="top:<?php echo $slide['top']?>%; left:<?php echo $slide['left']; ?>%">
															
															<?php echo do_shortcode(htmlspecialchars_decode(stripslashes($slide['description']))); ?>	

															<div class="prevbutton slidebackward"></div>
															<div class="nextbutton slideforward"></div>												
															
														</div>
													</div>
												<?php } else { ?>
													<div class="iframes">
														<iframe src="<?php echo $slide['video'] ?>" width="940" height="445" rel="youtube" ></iframe>


															<div class="textSlide" style="top:<?php echo $slide['top']?>%; left:<?php echo $slide['left']; ?>%">
															
															<?php echo do_shortcode(htmlspecialchars_decode(stripslashes($slide['description']))); ?>	

															<div class="prevbutton slidebackward"></div>
															<div class="nextbutton slideforward"></div>												
															
												
														
														</div>
													</div>								
												<?php } ?>
											</div>
										<?php } ?>		
								</div>
							</div>
						<?php 
						$i++;
						} 
					}?>
				</div>
			</div>				
		<?php
		}
		
		function update($new_instance, $old_instance) {
			$new_instance = aq_recursive_sanitize($new_instance);
			return $new_instance;
		}
		

	
	}
