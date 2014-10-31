<?php
/** "Buttons" block 
 * 
 * Optional to use horizontal lines/images
**/
class AQ_Buttons_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Buttons',
			'size' => 'span1',
		);
		
		//create the block
		parent::__construct('aq_buttons_block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'buttons' => 'buttondark',
			'button_title' => 'Button',
			'url' => '',
			'icon' => '',
			'custom_style' => ''			
		);
		
		$buttons_option = array(
			'buttondark'  => 'Modern Dark Button',

			'buttonblue'  => 'Modern Blue Button',

			'buttonorange'  => 'Modern Orange Button',

			'buttongreen'  => 'Modern Green Button',  

			'buttonyellow'  => 'Modern Yellow Button',

			'buttonpink'  => 'Modern Pink Button',

			'buttonred'  => 'Modern Red Button',
			
		);
		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		
		?>
		<p class="description note">
			<?php _e('Use this block to create buttons.', 'framework') ?>
		</p>
		<p class="description fourth">
			<label for="<?php echo $this->get_field_id('buttons') ?>">
				Pick a button design<br/>
				<?php echo aq_field_select('buttons', $block_id, $buttons_option, $buttons, $block_id); ?>
			</label>
		</p>
		
		<p class="description half last">
			<label for="<?php echo $this->get_field_id('button_title') ?>">
				Button_title(required)<br/>
				<?php echo aq_field_input('button_title', $block_id, $button_title) ?>
			</label>
		</p>
		
		<p class="description half last">
			<label for="<?php echo $this->get_field_id('url') ?>">
				Url<br/>
				<?php echo aq_field_input('url', $block_id, $url) ?>
			</label>
		</p>		

		<div class="description">
			<label for="<?php echo $this->get_field_id('icon') ?>">
				Upload an image for icon<br/>
				<?php echo aq_field_upload('icon', $block_id, $icon) ?>
			</label>
			<?php if($icon) { ?>
			<div class="screenshot">
				<img src="<?php echo $icon ?>" />
			</div>
			<?php } ?>
		</div>
		
		<p class="description half last">
			<label for="<?php echo $this->get_field_id('custom_style') ?>">
				Custom Style(required)<br/>
				<?php echo aq_field_input('custom_style', $block_id, $custom_style) ?>
			</label>
		</p>		
		<?php
		
	}
	
	function block($instance) {
		extract($instance);
		
	$image = '';
	if($icon == '')
		$image = '';
	else
		$image = '<div class="iconbutton"><img src="'.$icon.'" /></div>';
		
	$text =  '<div class="builderButtonshort" style="'.$custom_style.'"><div class="'.$buttons.' buttonbuilder">'.$image.'<div class="buttonleft"><a href="'.$url.'">'.$button_title.'</a></div></div></div>';
	
	echo wpautop(do_shortcode(htmlspecialchars_decode($text)));
	
}}