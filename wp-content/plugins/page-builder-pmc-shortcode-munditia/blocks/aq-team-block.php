<?php
/** A simple rich textarea block **/
class AQ_Team_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Team block',
			'size' => 'span3',
		);
			parent::__construct('aq_team_block', $block_options);
			
			add_action('wp_ajax_aq_block_team_add_new', array($this, 'add_team'));
	}
	
function form($instance) {
	
	// default key/values array
	$defaults = array(
		'title' 	=> '', // the name of the member
		'position'	=> '', // job position
		'avatar'	=> '', // profile picture
		'bio'		=> '', // a little info about the member
		'url'		=> '', // website URL
		'teams' => array(
			1 => array(
				'title' => 'My New Social Icon',
				'link' => 'My new social link',
				'hover_color' => '',
				'img' => '',				
			))	
	
	);

	// set default values (if not yet defined)
	$instance = wp_parse_args($instance, $defaults);

	// import each array key as variable with defined values
	extract($instance); ?>
	
	
	<p class="description half">
		<label for="<?php echo $this->get_field_id('title') ?>">
			Member Name (required)<br/>
			<?php echo aq_field_input('title', $block_id, $title) ?>
		</label>
	</p>

	<p class="description half last">
		<label for="<?php echo $this->get_field_id('position') ?>">
			Position(required)<br/>
			<?php echo aq_field_input('position', $block_id, $position) ?>
		</label>
	</p>

	<div class="description">
		<label for="<?php echo $this->get_field_id('avatar') ?>">
			Upload an image<br/>
			<?php echo aq_field_upload('avatar', $block_id, $avatar) ?>
		</label>
		<?php if($avatar) { ?>
		<div class="screenshot">
			<img src="<?php echo $avatar ?>" />
		</div>
		<?php } ?>
	</div>
	

	<p class="description">
		<label for="<?php echo $this->get_field_id('bio') ?>">
			Member info
			<?php echo aq_field_textarea('bio', $block_id, $bio, $size = 'full') ?>
		</label>
	</p>
	<div class="description cf">
		<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
			<?php
			$teams = is_array($teams) ? $teams : $defaults['teams'];
			$count = 1;
			foreach($teams as $team) {	
				$this->team($team, $count);
				$count++;
			}
			?>
		</ul>
		<p></p>
		<a href="#" rel="team" class="aq-sortable-add-new button">Add New</a>
		<p></p>
	</div>


	<?php

	
}

	function team($team = array(), $count = 0) {
			$defaults = array (
				'title' => 'My New Social Icon',
				'link' => 'My new social link',
				'img' => '',	
				'hover_color' => ''
			);
			$team = wp_parse_args($team, $defaults);	
			
		?>
		<li id="<?php echo $this->get_field_id('teams') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">
			
			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo $team['title'] ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#">Open / Close</a>
				</div>
			</div>
			
			<div class="sortable-body">
				<p class="teams-desc description">
					<label for="<?php echo $this->get_field_id('teams') ?>-<?php echo $count ?>-title">
						Team social Title (alt text)<br/>
						<input type="text" id="<?php echo $this->get_field_id('teams') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('teams') ?>[<?php echo $count ?>][title]" value="<?php echo $team['title'] ?>" />
					</label>
				</p>
				<p class="teams-desc description">
					<label for="<?php echo $this->get_field_id('teams') ?>-<?php echo $count ?>-link">
						Team social link<br/>
						<input type="text" id="<?php echo $this->get_field_id('teams') ?>-<?php echo $count ?>-link" class="input-full" name="<?php echo $this->get_field_name('teams') ?>[<?php echo $count ?>][link]" value="<?php echo $team['link'] ?>" />
					</label>
				</p>
				<p class="teams-desc description">
					<label for="<?php echo $this->get_field_id('teams') ?>-<?php echo $count ?>-img"">
						Upload an image<br/>
						<input type="text" id="<?php echo $this->get_field_id('teams') ?>-<?php echo $count ?>-img" class="input-full input-upload" name="<?php echo $this->get_field_name('teams') ?>[<?php echo $count ?>][img]" value="<?php echo $team['img'] ?>">
						<a href="#" class="aq_upload_button button" rel="<?php echo $media_type ?>">Upload</a><p></p>					
					</label>
					<?php if($img) { ?>
					<div class="screenshot">
						<img src="<?php echo $team['img'] ?>" />
					</div>
					<?php } ?>
				</p>	
				<p class="teams-desc description">
				<label for="<?php echo $this->get_field_id('hover_color') ?>">
					Hover background color<br/>
					<div class="aqpb-color-picker">
						<input type="text" id="<?php echo $this->get_field_id('teams') ?>-<?php echo $count ?>-hover_color" class="input-color-picker"  name="<?php echo $this->get_field_name('teams') ?>[<?php echo $count ?>][hover_color]" value="<?php echo $team['hover_color'] ?>" data-default-color="#fff"/>
					</div>						
				</label>	
				</p>
				<p class="teams-desc description"><a href="#" class="sortable-delete">Delete</a></p>
			</div>			
		</li>
		<?php
	}
		
	function add_team() {
		$nonce = $_POST['security'];	
		if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
		
		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
		
		//default key/value for the tab
		$team = array(
			'title' => 'My New Social Icon',
			'link' => 'My new social link',
			'img' => '',	
			'hover_color' => ''
		);
		
		if($count) {
			$this->team($team, $count);
		} else {
			die(-1);
		}
		
		die();
	}

		
	function block($instance) {
		
	
		// default key/values array
		$defaults = array(
			'title' 	=> '', // the name of the member
			'position'	=> '', // job position
			'avatar'	=> '', // profile picture
			'bio'		=> '', // a little info about the member
			'url'		=> '', // website URL	
			'teams' => array(
				1 => array(
					'title' => '',
					'link' => '',
					'img' => '',	
					'hover_color' => ''					
				))				
		);

		// set default values (if not yet defined)
		$instance = wp_parse_args($instance, $defaults);

		// import each array key as variable with defined values
		extract($instance); ?>




		<div class="team-wrapper">
			<div class="team">
				<div class="image">
					<img src="<?php echo $avatar  ?>">
				</div>	
				<div class="title"><?php echo $title  ?></div>
				<div class="role"><?php echo $position  ?></div>
				<p class="description"><?php echo $bio  ?></p>
				<div class="social">
					<?php foreach ($teams as $team) { ?>	
						<?php if($team['img'] != '') { ?>
							<div style="background:<?php echo $team['hover_color'] ?>">
							<a href = "<?php echo $team['link'] ?>" ><img src ="<?php echo $team['img'] ?>" alt = "<?php echo $team['title'] ?>" ></a>
							</div>
					<?php } } ?>	
				</div>
			</div>
		</div>
			
	<?php
	}
			
	function update($new_instance, $old_instance) {
		return $new_instance;
	}
}