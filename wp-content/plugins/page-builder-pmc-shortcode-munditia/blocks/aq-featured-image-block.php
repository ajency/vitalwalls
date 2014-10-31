<?php
/** Features Block 
 * A simple block that output the "features" HTML */

	class AQ_Featured_Image_Block extends AQ_Block {
		
		function __construct() {
			$block_options = array(
				'name' => 'Featured Image Block',
				'size' => 'span2'
			);
			
			parent::__construct('aq_featured_image_block', $block_options);
		}
		
		function form($instance) {
			$defaults = array(
				'title' => '',	
				'img' => '',
				'text' => '',
				'color' => '#F5F6F1',
				'link' => 'http://premiumcoding.com',
				'link_text' => 'View the Category'
			
			);
			
			$textcolor_option = array(
				'light'  => 'Light (white)',
				'dark'  => 'Theme main color',
				
			);				
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			
			?>
			<p class="description half">
				<label for="<?php echo $this->get_field_id('img') ?>">
					Upload an image<br/>
					<?php echo aq_field_upload('img', $block_id, $img) ?>
				</label>
				<?php if($img) { ?>
				<div class="screenshot">
					<img src="<?php echo $img ?>" />
				</div>
				<?php } ?>
			</p>			
			<p class="description">
				<label for="<?php echo $this->get_field_id('title') ?>">
					Title<br/>
					<?php echo aq_field_input('title', $block_id, $title) ?>
				</label>
			</p>	
			<p class="color">
				<label for="<?php echo $this->get_field_id('color') ?>">
					Select circle color
					<?php echo aq_field_color_picker('color', $block_id, $color, $size = 'half') ?>
				</label>
			</p>	
			<p class="description">
				<label for="<?php echo $this->get_field_id('link') ?>">
					Link<br/>
					<?php echo aq_field_input('link', $block_id, $link) ?>
				</label>
			</p>		
			<p class="description">
				<label for="<?php echo $this->get_field_id('link_text') ?>">
					Link text<br/>
					<?php echo aq_field_input('link_text', $block_id, $link_text) ?>
				</label>
			</p>				
			<p class="description">
				<label for="<?php echo $this->get_field_id('text') ?>">
					Feature text
					<?php echo aq_field_textarea('text', $block_id, $text, $size = 'full pmc-editor') ?>
				</label>
			</p>
			
			<?php
			
		}
		
		function block($instance) {
			$defaults = array(
				'title' => '',				
				'text' => '',
				'color' => '#F5F6F1',
				'link' => 'http://premiumcoding.com'
			
			);
						
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			?>
			<div class="featured-block-image" style="background:<?php echo $color;?>; ">
			
				<div class="featured-block-image-img">
					<?php if($link != ''){?>
						<a href="<?php echo $link ?>">
					<?php } ?>
					<?php if($img) {?> <img src = "<?php echo $img; ?>" alt = "<?php if($title) {  echo strip_tags($title); } ?>"> <?php } ?>
					<?php if($link != ''){?>
						</a>
					<?php } ?>							
				</div>
				<?php if($link != ''){?>
					<a href="<?php echo $link ?>">
				<?php } ?>
				<div class="featured-block-title"><?php if($title) {?> <h5 class="feature-title"><?php echo strip_tags($title) ?></h5> <?php } ?></div>
				<?php if($link != ''){?>
					</a>
				<?php } ?>					
				<div class="featured-block-text"><?php echo wpautop(do_shortcode(htmlspecialchars_decode($text))); ?></div>
				<div class="featured-block-link"><?php if($link_text) {?>
				<?php if($link != ''){?>
					<a href="<?php echo $link ?>">
				<?php } ?>
				<?php echo $link_text ?>
				<?php if($link != ''){?>
					</a>
				<?php } ?>					
				<?php } ?></div>
			</div>		
			<?php
			
		}
		
	}


