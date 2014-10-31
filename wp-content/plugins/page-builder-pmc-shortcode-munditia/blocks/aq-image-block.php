<?php
/* Image Block */
if(!class_exists('AQ_Image_Block')) {
	class AQ_Image_Block extends AQ_Block {
		
		function __construct() {
			$block_options = array(
				'name' => 'Image',
				'size' => 'span6',
			);
			
			//create the widget
			parent::__construct('AQ_Image_Block', $block_options);
		}
		
		function form($instance) {
			$defaults = array(
				'img' => '',
				'height' => '',
				'crop' => 0,
			);
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			
			?>
			<p class="description half">
				<label for="<?php echo $this->get_field_id('title') ?>">
					Title (optional)<br/>
					<?php echo aq_field_input('title', $block_id, $title) ?>
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
			<p class="description fourth">
				<label for="<?php echo $this->get_field_id('height') ?>">
					Height (optional)<br/>
					<?php echo aq_field_input('height', $block_id, $height, 'min', 'number') ?> px
				</label>
			</p>
			<p class="description half">
				<label for="<?php echo $this->get_field_id('crop') ?>">
					<?php echo aq_field_checkbox('crop', $block_id, $crop); ?>
					Crop Image?
				</label>
			</p>
			<?php
		}
		
		function block($instance) {
			extract($instance);
			$width = aq_get_column_width($size);
			$crop = $crop ? true : false;
			$image = aq_resize($img, $width, $height, $crop);
			if($image ==''){
				$image = $img;
			}
			if($title) echo '<h4 class="aq-block-title">'.strip_tags($title).'</h4>';
			echo '<img class="aq-block-img" src="'.$image.'" />';
		}
		
		
	}
}