<?php
/** Slider Block **/
	class AQ_Slider_Block_Nivo extends AQ_Block {
	
		function __construct() {
			$block_options = array(
				'name'			=> 'Nivo Slider',
				'size'			=> 'span12',
			);
			
			parent::__construct('aq_slider_block_nivo', $block_options);
			
			add_action('wp_ajax_aq_block_slider_add_new', array($this, 'add_slide'));
		}
		
	function form($instance) {
		$defaults = array(
			'slides'		=> array(
				1 => array(
					'title' => 'My New Slide',
					'url' => '',
					'description' => '',
					'link' => ''
				)
			),
			'effect'		=> 'random',
			'slices'		=> 15,
			'boxCols' 			=> 8,
			'boxRows'			=> 4,
			'animSpeed'			=> 500,
			'pauseTime'			=>5000,
			'useDefaultSlides' 			=> false
		);
	
		$autoslide_option = array(
			'true'  => 'True',
			'false'  => 'False',
			
		);		

		$effect_option = array(
			'sliceDown'			=> 'Slice Down',
			'sliceDownLeft'			=> 'Slice down left',
			'sliceUp'			=> 'Slice up',
			'sliceUpLeft'			=> 'Slice up left',
			'sliceUpDown'			=> 'Slice up down',
			'sliceUpDownLeft'			=> 'Slice up down left',
			'fold'			=> 'Fold',
			'fade'			=> 'Fade',
			'random'			=> 'Random',
			'slideInRight'			=> 'Slice in right',
			'slideInLeft'			=> 'Slice in left',
			'boxRandom'			=> 'Box random',
			'boxRain'			=> 'Box rain',
			'boxRainReverse'			=> 'Box rain reverse',
			'boxRainGrow'			=> 'Box rain grow',
			'boxRainGrowRevers'			=> 'Box rain Grow Reverse'
			
		);	
		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		if( function_exists( 'pmc_stripText' ) ){
			?>
			<div class="description cf">
				<ul id="sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
					<?php
					$slides = is_array($slides) ? $slides : $defaults['slides'];
					$count = 1;
					foreach($slides as $slide) {	
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
				<label for="<?php echo $this->get_field_id('useDefaultSlides') ?>">
					Select if you wish to use default slides defined via theme options<br/>
					<?php echo aq_field_select('useDefaultSlides', $block_id, $autoslide_option, $useDefaultSlides, $block_id); ?>
				</label>
			</p>		
			<p class="description half last">
				<label for="<?php echo $this->get_field_id('effect') ?>">
					Select if you wish to use default slides defined via theme options<br/>
					<?php echo aq_field_select('effect', $block_id, $effect_option, $effect, $block_id); ?>
				</label>
			</p>	
			<p class="description third">
				<label for="<?php echo $this->get_field_id('slices') ?>">
					Set slice for slice animations<br/><br/>
					<?php echo aq_field_input('slices', $block_id, $slices) ?>
				</label>
			</p>
			<p class="description third">
				<label for="<?php echo $this->get_field_id('boxCols') ?>">
					Set number of box cols for box animations<br/>
					<?php echo aq_field_input('boxCols', $block_id, $boxCols) ?>
				</label>
			</p>
			<p class="description third last">
				<label for="<?php echo $this->get_field_id('boxRows') ?>">
					Set number of box rows for box animations<br/>
					<?php echo aq_field_input('boxRows', $block_id, $boxRows) ?>
				</label>
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
		else {
			echo '<p class="description note">For this block you need to use PremiumCoding themes!</p>';
		}				
	}
		
		function slide($slide = array(), $count = 0) {
			
			$defaults = array (
				'title' => '',
				'url' => '',
				'description' => '',
				'link' => '',
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
						<label for="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-title">
							Slide Title<br/>
							<input type="text" id="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('slides') ?>[<?php echo $count ?>][title]" value="<?php echo $slide['title'] ?>" />
						</label>
					</p>
					<p class="description">
						<label for="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-url">
							Upload Image<br/>
							<input type="text" id="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-url" class="input-full input-url" value="<?php echo $slide['url'] ?>" name="<?php echo $this->get_field_name('slides') ?>[<?php echo $count ?>][url]">
							<a href="#" class="aq_upload_button button" rel="image">upload</a>
							<p></p>
						</label>
					</p>
					<p class="description">
						<label for="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-description">
							Slide description<br/>
							<textarea id="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-description" class="textarea-full" name="<?php echo $this->get_field_name('slides') ?>[<?php echo $count ?>][description]" rows="5"><?php echo $slide['description'] ?></textarea>
						</label>
					</p>
					<p class="description">
						<label for="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-link">
							link URL<br/>
							<input type="text" id="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-link" class="input-full" name="<?php echo $this->get_field_name('slides') ?>[<?php echo $count ?>][link]" value="<?php echo $slide['link'] ?>" />
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
				wp_enqueue_script('pmc_nivo'); 
				$rand = rand(0,99);
				?>
				<script type="text/javascript">
				jQuery(document).ready(function () {
					jQuery('.nivoSlider').nivoSlider({
							effect:'<?php echo $effect ?>', // Specify sets like: 'fold,fade,sliceDown'
							slices: <?php echo $slices ?>   , // For slice animations
							boxCols: <?php echo $boxCols ?>  , // For box animations
							boxRows: <?php echo $boxRows  ?>  , // For box animations
							animSpeed:<?php echo $animSpeed ?>, // Slide transition speed
							pauseTime:<?php echo $pauseTime ?>, // How long each slide will show)
							directionNav:true, // Next & Prev navigation
							directionNavHide:true, // Only show on hover
							pauseOnHover:false,
							controlNavThumbs: false,
							controlNavThumbsFromRel: false,
							controlNavThumbsSearch: '',
							controlNavThumbsReplace: ''
						});
				});	
				</script>


				<div id="nslider-wrapper">
					<div id="nslider" class="nivoSlider">
					
					<?php 
						if($useDefaultSlides == 'true'){
							global $pmc_data;
							$slides = $pmc_data['nivo_slider'];}
						if(!empty($slides)){
						foreach ($slides as $slide) { 
					
						  if($slide['url'] != '') :
								   
							 if($slide['link'] != '') : ?>
							   <a href="<?php echo $slide['link']; ?>"><img src="<?php echo $slide['url']; ?>" title="<?php echo pmc_stripText($slide['description']); ?>" alt="<?php echo pmc_stripText($slide['title']); ?>"/></a>
							<?php else: ?>
								<img src="<?php echo $slide['url']; ?>" title="<?php echo pmc_stripText($slide['description']); ?>" alt="<?php echo pmc_stripText($slide['title']); ?>"/>
							<?php endif; ?>
									
						<?php endif; ?>
					<?php } }?>
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
