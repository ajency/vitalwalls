<?php
/** Slider Block **/
	class AQ_Slider_Block_iosSlider extends AQ_Block {
	
		function __construct() {
			$block_options = array(
				'name'			=> 'iosSlider',
				'size'			=> 'span12',
			);
			
			parent::__construct('aq_slider_block_iosSlider', $block_options);
			
			add_action('wp_ajax_aq_block_slider_add_new', array($this, 'add_slide'));
		}
		
		function form($instance) {
			$defaults = array(
				'slides_iosSlider'		=> array(
					1 => array(
						'title' => 'My New Slide',
						'url' => '',
						'description' => '',
						'link' => ''
					)
				),
				'autoSlideTransTimer'		=> 1250,
				'autoSlide'		=> false,
				'autoSlideTimer' 			=> 5000,
				'useDefaultslides_iosSlider' 			=> false
			);
			
			$autoslide_option = array(
				'true'  => 'True',
				'false'  => 'False',
				
			);		
			
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			if( function_exists( 'pmc_stripText' ) ){				
			?>
			<div class="description cf">
				<ul id="sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
					<?php
					$slides_iosSlider = is_array($slides_iosSlider) ? $slides_iosSlider : $defaults['slides_iosSlider'];
					$count = 1;
					foreach($slides_iosSlider as $slide) {	
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
				<label for="<?php echo $this->get_field_id('useDefaultslides_iosSlider') ?>">
					Select if you wish to use default slides defined via theme options<br/>
					<?php echo aq_field_select('useDefaultslides_iosSlider', $block_id, $autoslide_option, $useDefaultslides_iosSlider, $block_id); ?>
				</label>
			</p>			
			<p class="description half last">
				<label for="<?php echo $this->get_field_id('autoSlide') ?>">
					Select if you wish to have auto slide<br/><br/>
					<?php echo aq_field_select('autoSlide', $block_id, $autoslide_option, $autoSlide, $block_id); ?>
				</label>
			</p>
			<p class="description third">
				<label for="<?php echo $this->get_field_id('autoSlideTransTimer') ?>">
					Set auto slide transmition timer<br/>
					<?php echo aq_field_input('autoSlideTransTimer', $block_id, $autoSlideTransTimer) ?>
				</label>
			</p>
			<p class="description third ">
				<label for="<?php echo $this->get_field_id('autoSlideTimer') ?>">
					Set auto slide timer<br/>
					<?php echo aq_field_input('autoSlideTimer', $block_id, $autoSlideTimer) ?>
				</label>
			</p>
		
			<?php
		}else {
			echo '<p class="description note">For this block you need to use PremiumCoding themes!</p>';
		}				
		}
		
		function slide($slide = array(), $count = 0) {
			
			$defaults = array (
				'title' => '',
				'url' => '',
				'description' => '',
				'link' => '',
				'html' => ''
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
						<label for="<?php echo $this->get_field_id('slides_iosSlider') ?>-<?php echo $count ?>-title">
							Slide Title<br/>
							<input type="text" id="<?php echo $this->get_field_id('slides_iosSlider') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('slides_iosSlider') ?>[<?php echo $count ?>][title]" value="<?php echo $slide['title'] ?>" />
						</label>
					</p>
					<p class="description">
						<label for="<?php echo $this->get_field_id('slides_iosSlider') ?>-<?php echo $count ?>-url">
							Upload Image<br/>
							<input type="text" id="<?php echo $this->get_field_id('slides_iosSlider') ?>-<?php echo $count ?>-url" class="input-full input-url" value="<?php echo $slide['url'] ?>" name="<?php echo $this->get_field_name('slides_iosSlider') ?>[<?php echo $count ?>][url]">
							<a href="#" class="aq_upload_button button" rel="image">upload</a>
							<p></p>
						</label>
					</p>
					<p class="description">
						<label for="<?php echo $this->get_field_id('slides_iosSlider') ?>-<?php echo $count ?>-description">
							Slide description<br/>
							<textarea id="<?php echo $this->get_field_id('slides_iosSlider') ?>-<?php echo $count ?>-description" class="textarea-full" name="<?php echo $this->get_field_name('slides_iosSlider') ?>[<?php echo $count ?>][description]" rows="5"><?php echo $slide['description'] ?></textarea>
						</label>
					</p>
					<p class="description">
						<label for="<?php echo $this->get_field_id('slides_iosSlider') ?>-<?php echo $count ?>-link">
							link URL<br/>
							<input type="text" id="<?php echo $this->get_field_id('slides_iosSlider') ?>-<?php echo $count ?>-link" class="input-full" name="<?php echo $this->get_field_name('slides_iosSlider') ?>[<?php echo $count ?>][link]" value="<?php echo $slide['link'] ?>" />
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
				'link' => ''
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
			if( function_exists( 'pmc_stripText' ) ){				
			wp_enqueue_script('pmc_iosslider');	 ?>
			<script type="text/javascript">

				jQuery(document).ready(function() {
					
					jQuery('.iosSlider').iosSlider({
						snapToChildren: true,
						desktopClickDrag: true,
						infiniteSlider: true,
						snapSlideCenter: true,
						onSlideChange: slideChange,
						onSliderLoaded : SliderLoaded,
						autoSlideTransTimer: <?php echo $autoSlideTransTimer ?>,
						autoSlide: <?php echo $autoSlide ?>,
						autoSlideTimer: <?php echo $autoSlideTimer ?>,
						stageCSS: {
							overflow: 'visible'
						},

						navPrevSelector: jQuery('.prevButton'),
						navNextSelector: jQuery('.nextButton')	
					});
					
				});
				
				function slideChange(args) {
				
					
					jQuery('.item').removeClass('selected');
					jQuery('.item:eq(' + (args.currentSlideNumber - 1) + ')').addClass('selected');
				
						}
				function SliderLoaded(args) {
				
					
					jQuery('.item').removeClass('selected');
					jQuery('.item:eq(' + (args.currentSlideNumber - 1) + ')').addClass('selected');
				
						}						
				
			</script>	


			<div id="slider-wrapper" class="ios">
			<div class="loading"></div>	

			<div id="slider">
					<div class = 'containerOuter'>
					
						<div class = 'container'>
							
							<div class = 'iosSliderContainer'>
								
								<div class = 'iosSlider'>
								
									<div class = 'slider'>
									<?php 
									$i = 0;
									if($useDefaultslides_iosSlider == 'true'){
										global $pmc_data;
										$slides_iosSlider = $pmc_data['iosslider'];}
									if(!empty($slides_iosSlider)){
									foreach ($slides_iosSlider as $i=>$slide) {  ?>
											<?php 
											$hover = '';
											if(isset($slide['description']) ){ 
												if($slide['description'] !='' ){ 	
													$hover='hover';
												}
											}?>
											<?php if($i==0) { ?>
												<div class = 'item item-<?php echo $i ?> selected <?php echo $hover ?>'>  
											<?php } else { ?>
											<div class = 'item item-<?php echo $i ?> <?php echo $hover ?>'> 
											<?php }  ?>		
												<div class="sliderHolder">
													<?php if($slide['url'] != '') :
									   
														 if($slide['link'] != '') : ?>
														   <a href="<?php echo $slide['link']; ?>"><img src="<?php echo $slide['url']; ?>"  alt="<?php echo pmc_stripText($slide['title']); ?>"/></a>
														<?php else: ?>
															<img src="<?php echo $slide['url']; ?>" alt="<?php echo pmc_stripText($slide['title']); ?>" />
														<?php endif; ?>
																
													
													<div class = 'showtext textBottom'>
														<div class = 'bgBottom'></div>

													
													<?php if(isset($slide['description']) ){ ?>
														<?php if($slide['description'] !='' ){ ?>
														<div class = 'iosDescription'>
															<div class = 'desc'>
																<?php echo do_shortcode(htmlspecialchars_decode(stripslashes($slide['description']))); ?>
															</div>
														</div>
														<?php }}?>
													</div>
													<?php endif; ?>										
												</div>
											</div>
									<?php 
									$i++;
									}} ?>	
									</div>
									<div class = 'prevButton'></div>
					
									<div class = 'nextButton'></div>
								</div>
								
							</div>
						
						</div>
								
					</div>
					
			</div>
				
			</div>			
			<?php
		 }
		}
		
		function update($new_instance, $old_instance) {
			$new_instance = aq_recursive_sanitize($new_instance);
			return $new_instance;
		}
		

	
	}
