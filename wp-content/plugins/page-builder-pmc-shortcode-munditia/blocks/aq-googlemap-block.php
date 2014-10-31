<?php
/** Googlemap block **/

if(!class_exists('AQ_Googlemap_Block')) {
	class AQ_Googlemap_Block extends AQ_Block {
		
		//set and create block
		function __construct() {
			$block_options = array(
				'name' => 'Googlemap',
				'size' => 'span6',
			);
			
			//create the block
			parent::__construct('aq_googlemap_block', $block_options);
		}
		
		function form($instance) {
			
			$defaults = array(
				'text' => '',
				'address' => '',
				'height' => '',

				'zoom' => 8,
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
			<p class="description half last">
				<label for="<?php echo $this->get_field_id('address') ?>">
					Address (required)<br/>
					<?php echo aq_field_input('address', $block_id, $address) ?>
				</label>
			</p>
			<p class="description fourth">
				<label for="<?php echo $this->get_field_id('zoom') ?>">
					Zoom Level<br/>
					<?php echo aq_field_input('zoom', $block_id, $zoom, 'min', 'number') ?>
				</label>
			</p>
			<p class="description fourth last">
				<label for="<?php echo $this->get_field_id('height') ?>">
					Map height, in pixels.<br/>
					<?php echo aq_field_input('height', $block_id, $height, 'min', 'number') ?> &nbsp; px
				</label>
			</p>
			
			<?php
			
		}
		
		function block($instance) {
			$defaults = array(
				'text' => '',
				'address' => '',
				'height' => 350,
				'zoom' => 8,
			);
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);

			
			if(!$address) {
				_e('Address was not specified', 'framework');
				return false;
			}

		
		wp_print_scripts( 'googlemap' );

		$coordinates = get_map_coordinates( $address );

		if( !is_array( $coordinates ) )
			return;

		$map_id = uniqid( 'pw_map_' ); // generate a unique ID for this map

		ob_start(); ?>
		<div class="pw_map_canvas" id="<?php echo esc_attr( $map_id ); ?>" style="height: <?php echo $height ?>px; width: 100%"></div>
	    <script type="text/javascript">
			var map_<?php echo $map_id; ?>;
			function pw_run_map_<?php echo $map_id ; ?>(){
				var location = new google.maps.LatLng("<?php echo $coordinates['lat']; ?>", "<?php echo $coordinates['lng']; ?>");
				var map_options = {
					zoom: <?php echo $zoom ?>,
					center: location,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				}
				map_<?php echo $map_id ; ?> = new google.maps.Map(document.getElementById("<?php echo $map_id ; ?>"), map_options);
				var marker = new google.maps.Marker({
				position: location,
				map: map_<?php echo $map_id ; ?>
				});
			}
			pw_run_map_<?php echo $map_id ; ?>();
		</script>
		<?php
		
	}
	}
}