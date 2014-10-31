<?php
/** Features Block 
 * A simple block that output the "features" HTML */
if(!class_exists('AQ_Featured_Circles_Bloc')) {
	class AQ_Featured_Block extends AQ_Block {
		
		function __construct() {
			$block_options = array(
				'name' => 'Featured Block',
				'size' => 'span2'
			);
			
			parent::__construct('aq_featured_block', $block_options);
		}
		
		function form($instance) {
			$defaults = array(
				'title' => '',				
				'text' => '',
				'color' => '#F5F6F1',
				'link' => 'http://premiumcoding.com',
				'img' => '',
				'use_img' => 1
			
			);
			
			
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			
			?>
			<p class="description">
				<label for="<?php echo $this->get_field_id('title') ?>">
					Title<br/>
					<?php echo aq_field_input('title', $block_id, $title) ?>
				</label>
			</p>	
			<p class="color">
				<label for="<?php echo $this->get_field_id('color') ?>">
					Select background color color
					<?php echo aq_field_color_picker('color', $block_id, $color, $size = 'full') ?>
				</label>
			</p>	
			<p class="description">
				<label for="<?php echo $this->get_field_id('link') ?>">
					Link<br/>
					<?php echo aq_field_input('link', $block_id, $link) ?>
				</label>
			</p>				
			<p class="description">
				<label for="<?php echo $this->get_field_id('text') ?>">
					Feature text
					<?php echo aq_field_textarea('text', $block_id, $text, $size = 'full') ?>
				</label>
			</p>
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
			<p class="description half">
				<label for="<?php echo $this->get_field_id('use_img') ?>">
					<?php echo aq_field_checkbox('use_img', $block_id, $use_img); ?>
					Use Image for background?
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
			
			if($link != ''){?>
				<a href="<?php echo $link ?>">
			<?php } ?>
			<div class="featured-block" style="background:<?php echo $color; if($use_img) {?> url(<?php echo $img ?>) no-repeat !important; <?php }?>">
				
				<div class="featured-block-title"><?php if($title) {?> <h5 class="feature-title"><?php echo strip_tags($title) ?></h5> <?php } ?></div>
				
				<div class="featured-block-text"><?php echo wpautop(do_shortcode(htmlspecialchars_decode($text))); ?></div>
			
			</div>
			<?php if($link != ''){?>
				</a>
			<?php } ?>			
			<?php
			
		}
		
	}
}

