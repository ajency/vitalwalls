<?php
/** A simple media embed block **/
class AQ_Media_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Media',
			'size' => 'span6',
		);
		
		//create the block
		parent::__construct('aq_media_block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'text' => '',
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		?>
		<p>This block will attempt to display the video at the optimum width/height of the block<br/>
			Supported sites: Youtube, VimeoVimeo, Blip.tv, Viddler, Kickstarter</p>
		<p class="description">
			<label for="<?php echo $this->get_field_id('text') ?>">
				Embed code
				<?php echo aq_field_textarea('text', $block_id, $text, $size = 'full') ?>
			</label>
		</p>
		
		<?php
	}
	
	function block($instance) {
		extract($instance);
		
		wp_enqueue_script('fitvids');
		
		if($title) echo '<h4 class="aq-block-title">'.strip_tags($title).'</h4>';
		
		echo '<div class="aq-block-media fitvids">';
			echo htmlspecialchars_decode($text);
		echo '</div>';
	}
	
}