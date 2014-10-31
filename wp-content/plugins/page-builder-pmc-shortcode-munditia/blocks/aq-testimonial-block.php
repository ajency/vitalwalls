<?php
/** Testimonial Block **/
if(!class_exists('AQ_Testimonial_Block')) {
	class AQ_Testimonial_Block extends AQ_Block {
		function __construct() {
			$block_options = array(
				'name'			=> 'Testimonials',
				'size'			=> 'span6',
			);
			
			parent::__construct('aq_testimonial_block', $block_options);
			
			add_action('wp_ajax_aq_block_testimonial_add_new', array($this, 'add_testimonial'));
		}
		
		function form($instance) {
			$defaults = array(
				'testimonials'		=> array(
					1 => array(
						'author' => 'My New Testimonial Author',
						'link' => '',
						'position' => '',
						'text' => ''
					)
				)
			);
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			
			?>
			<div class="description cf">
				<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
					<?php
					$testimonials = is_array($testimonials) ? $testimonials : $defaults['testimonials'];
					$count = 1;
					foreach($testimonials as $testimonial) {	
						$this->testimonial($testimonial, $count);
						$count++;
					}
					?>
				</ul>
				<p></p>
				<a href="#" rel="testimonial" class="aq-sortable-add-new button">Add New</a>
				<p></p>
			</div>
			<?php
		}
		
		function testimonial($testimonial = array(), $count = 0) {
			
			$defaults = array (
				'author' => '',
				'link' => '',
				'position' => '',
				'text' => '',
				'avatar' => ''			
			);
			$testimonial = wp_parse_args($testimonial, $defaults);
			
			?>
			<li id="<?php echo $this->get_field_id('testimonials') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">
				
				<div class="sortable-head cf">
					<div class="sortable-title">
						<strong><?php echo $testimonial['author'] ?></strong>
					</div>
					<div class="sortable-handle">
						<a href="#">Open / Close</a>
					</div>
				</div>
				
				<div class="sortable-body">
					<p class="description">
						<label for="<?php echo $this->get_field_id('testimonials') ?>-<?php echo $count ?>-author">
							Author<br/>
							<input type="text" id="<?php echo $this->get_field_id('testimonials') ?>-<?php echo $count ?>-author" class="input-full" name="<?php echo $this->get_field_name('testimonials') ?>[<?php echo $count ?>][author]" value="<?php echo $testimonial['author'] ?>" />
						</label>
					</p>
					<p class="description">
						<label for="<?php echo $this->get_field_id('testimonials') ?>-<?php echo $count ?>-avatar">
							Upload Image for avatar<br/>
							<input type="text" id="<?php echo $this->get_field_id('testimonials') ?>-<?php echo $count ?>-avatar" class="input-full input-avatar" value="<?php echo $testimonial['avatar'] ?>" name="<?php echo $this->get_field_name('testimonials') ?>[<?php echo $count ?>][avatar]">
							<a href="#" class="aq_upload_button button" rel="image">Upload</a>
							<p></p>
						</label>
					</p>					
					<p class="description">
						<label for="<?php echo $this->get_field_id('testimonials') ?>-<?php echo $count ?>-link">
							Link<br/>
							<input type="text" id="<?php echo $this->get_field_id('testimonials') ?>-<?php echo $count ?>-link" class="input-full" name="<?php echo $this->get_field_name('testimonials') ?>[<?php echo $count ?>][link]" value="<?php echo $testimonial['link'] ?>" />
						</label>
					</p>
					<p class="description">
						<label for="<?php echo $this->get_field_id('testimonials') ?>-<?php echo $count ?>-position">
							Position<br/>
							<input type="text" id="<?php echo $this->get_field_id('testimonials') ?>-<?php echo $count ?>-position" class="input-full" name="<?php echo $this->get_field_name('testimonials') ?>[<?php echo $count ?>][position]" value="<?php echo $testimonial['position'] ?>" />
						</label>
					</p>
					<p class="description">
						<label for="<?php echo $this->get_field_id('testimonials') ?>-<?php echo $count ?>-text">
							Testimonial Text<br/>
							<textarea id="<?php echo $this->get_field_id('testimonials') ?>-<?php echo $count ?>-text" class="textarea-full" name="<?php echo $this->get_field_name('testimonials') ?>[<?php echo $count ?>][text]" rows="5"><?php echo $testimonial['text'] ?></textarea>
						</label>
					</p>
					<p class="description"><a href="#" class="sortable-delete">Delete</a></p>
				</div>
				
			</li>
			<?php
		}
		
		function add_testimonial() {
			$nonce = $_POST['security'];	
			if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
			
			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
			
			//default key/value for the tab
			$testimonial = array(
				'author' => 'My New Testimonial Author',
				'link' => '',
				'position' => '',
				'text' => ''
			);
			
			if($count) {
				$this->testimonial($testimonial, $count);
			} else {
				die(-1);
			}
			
			die();
		}
		
		function block($instance) {
		
			wp_enqueue_script('flexslider');
			wp_enqueue_script('testimonials');
			extract($instance);
			
			$count = count($testimonials);
			$i = 1;
			
			if($title) echo '<h4 class="aq-block-title">'.strip_tags($title).'</h4>';
			?>
				
			<div id="testimonials_<?php echo rand(1,100) ?>" class="testimonials cf">
				<ul class="slides">
				
				<?php foreach ($testimonials as $testimonial) {	
					
					$defaults = array (
						'author' => '',
						'link' => '',
						'position' => '',
						'text' => '',
						'avatar' => ''							
					);
					$testimonial = wp_parse_args($testimonial, $defaults);
					
					$hide = $i > 1 ? 'hide' : ''; $i++;
					
					if(!empty($testimonial['author']) && !empty($testimonial['text'])) {
						
						if(!empty($testimonial['link'])) {
							$author = '<a href="'.$testimonial['link'].'"><span class="author">'.htmlspecialchars(stripslashes($testimonial['author'])).'</span></a>';
						} else {
							$author = '<span class="author">'.htmlspecialchars(stripslashes($testimonial['author'])).'</span>';
						}
					
					
						?>
					
						<li class="testimonial <?php echo $hide ?>">
						
							<div class="testimonial-avatar">
								<?php $image = aq_resize($testimonial['avatar'], 100, 100 , true); 
								if($image ==''){
									$image = $testimonial['avatar'];
								}
								
								?>
								<img class="aq-block-img" src="<?php echo $image ?>"  alt="<?php echo htmlspecialchars(stripslashes($testimonial['position'])) ?>" />
							</div>						
						
							<div class="testimonial-description">
								<div class="testimonial-texts">
									<?php echo wpautop($testimonial['text']) ?>
								</div>
								
								<div class="testimonial-author">
									<?php echo $author ?>, <?php echo htmlspecialchars(stripslashes($testimonial['position'])) ?>
								</div>
							</div>
						<?php if($i < $count+1) {?>
							<div class="testimonial-borderLine"><div class="left"></div><div class="right"></div></div>
						<?php } ?>							
						</li>

						<?php
					}
				} ?>
				
				</ul>
				
				<?php if ($count > 1) { ?>
				
				<div class="testimonial-nav">
				</div>
				
				<?php } ?>
				
			</div>
			
			<?php
			
		}
		
		function update($new_instance, $old_instance) {
			return $new_instance;
		}
		
	}
}