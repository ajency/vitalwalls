<?php


if(!class_exists('AQ_Portfolio_Block')) {
	class AQ_Portfolio_Block extends AQ_Block {
		
		//set and create block
		function __construct() {
			$block_options = array(
				'name' => 'Portfolio',
				'size' => 'span12',
				'port_categories' => array()	
			);
			
			//create the block
			parent::__construct('aq_portfolio_block', $block_options);
		}
		
		function form($instance) {
	
			$defaults = array(
				'column' => '2',
				'filter' => 1,				
				'numberofpost'	=> 12				
			);
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			
			$columns_options = array(
				'3' => 'Three Columns',
				'4' => 'Four Columns',
			);
			
		$categories_port = ($temp = get_terms('portfoliocategory')) ? $temp : array();
		$categories_options = array();
		foreach($categories_port as $cat) {
			$categories_options[$cat->term_id] = $cat->name;
		}		

			

			

			?>
			<p>Note: You should only use this block on a full-width template</p>

			<p class="description half">
				<label for="<?php echo $this->get_field_id('column') ?>">
					Number of Columns<br/>
					<?php echo aq_field_select('column', $block_id, $columns_options, $column); ?>
				</label>
			</p>
			<p class="description half last">
				<label for="<?php echo $this->get_field_id('port_categories') ?>">
					Portfolio Categories<br/>
				<?php echo aq_field_multiselect('port_categories', $block_id, $categories_options, $port_categories); ?>
				</label>
			</p>
			<p class="description half">
				<label for="<?php echo $this->get_field_id('numberofpost') ?>">
					Number of portfolio to show<br/>
				<?php echo aq_field_input('numberofpost', $block_id, $numberofpost) ?>
				</label>
			</p>			
			<p class="description half">
				<label for="<?php echo $this->get_field_id('filter') ?>">
					<?php echo aq_field_checkbox('filter', $block_id, $filter); ?>
					Show filter?
				</label>
			</p>			
			
			<?php
		}
		
		function block($instance) {
	
			$defaults = array(
				'column' => '2',
				'numberofpost'	=> 12,
				'filter'	=> 1					
			);
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			if( function_exists( 'pmc_portfolio' ) ){
			wp_enqueue_script('pmc_ba-bbq');	
	
				
		    if($filter && count($port_categories) > 0){ ?>				
		
				<div id="remove" class="portfolioremove">
					<h2>
					<a class="catlink" href="#filter=*" >Show All</a>
					<?php
					foreach ($port_categories as $category) {

					$find =     array("&", "/", " ","amp;","&#38;");
					$replace  = array("", "", "", "","");
					$entrycategory = str_replace($find , $replace, pmc_getcatname($category,'portfoliocategory'));
						echo '<a class="catlink" href="#filter=.'.$entrycategory .'" >'.pmc_getcatname($category,'portfoliocategory').'</a>';
					}
					?>
					</h2>
				</div>
			
			<?php } ?>		
			<div class="portfolio">		
			
				<div id="portitems<?php echo $column ?>">
							
					<?php 
						pmc_portfolio('port'.$column,$column,'port',$numberofpost,$port_categories); 
					
					?>
						
				</div>
				
				<?php 
				
				get_template_part('includes/wp-pagenavi');
				if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
		
		?>
			<?php wp_reset_query(); ?>			
			</div>		
			
			<script>

					jQuery(function(){
			  
				  var $container = jQuery('#portitems<?php echo $column ?>'),
					  // object that will keep track of options
					  isotopeOptions = {},
					  // defaults, used if not explicitly set in hash
					  defaultOptions = {
						filter: '*',
						sortBy: 'original-order',
						sortAscending: true,
						layoutMode: 'masonry'
					  };

				  
				 
			  
				  var setupOptions = jQuery.extend( {}, defaultOptions, {
					itemSelector : '.item<?php echo $column ?>',
				  });
			  
				  // set up Isotope
				  $container.isotope( setupOptions );
			  
				  var $optionSets = jQuery('#options').find('.option-set'),
					  isOptionLinkClicked = false;
			  
				  // switches selected class on buttons
				  function changeSelectedLink( $elem ) {
					// remove selected class on previous item
					$elem.parents('.option-set').find('.selected').removeClass('selected');
					// set selected class on new item
					$elem.addClass('selected');
				  }
			  
			  
				  $optionSets.find('a').click(function(){
					var $this = $(this);
					// don't proceed if already selected
					if ( $this.hasClass('selected') ) {
					  return;
					}
					changeSelectedLink( $this );
						// get href attr, remove leading #
					var href = $this.attr('href').replace( /^#/, '' ),
						// convert href into object
						// i.e. 'filter=.inner-transition' -> { filter: '.inner-transition' }
						option = $.deparam( href, true );
					// apply new option to previous
					jQuery.extend( isotopeOptions, option );
					// set hash, triggers hashchange on window
					jQuery.bbq.pushState( isotopeOptions );
					isOptionLinkClicked = true;
					return false;
				  });

				  var hashChanged = false;

				  jQuery(window).bind( 'hashchange', function( event ){
					// get options object from hash
					var hashOptions = window.location.hash ? jQuery.deparam.fragment( window.location.hash, true ) : {},
						// do not animate first call
						aniEngine = hashChanged ? 'best-available' : 'none',
						// apply defaults where no option was specified
						options = jQuery.extend( {}, defaultOptions, hashOptions, { animationEngine: aniEngine } );
					// apply options from hash
					$container.isotope( options );
					// save options
					isotopeOptions = hashOptions;
				
					// if option link was not clicked
					// then we'll need to update selected links
					if ( !isOptionLinkClicked ) {
					  // iterate over options
					  var hrefObj, hrefValue, $selectedLink;
					  for ( var key in options ) {
						hrefObj = {};
						hrefObj[ key ] = options[ key ];
						// convert object into parameter string
						// i.e. { filter: '.inner-transition' } -> 'filter=.inner-transition'
						hrefValue = jQuery.param( hrefObj );
						// get matching link
						$selectedLink = $optionSets.find('a[href="#' + hrefValue + '"]');
						changeSelectedLink( $selectedLink );
					  }
					}
				
					isOptionLinkClicked = false;
					hashChanged = true;
				  })
					// trigger hashchange to capture any hash data on init
					.trigger('hashchange');

				});

			</script>

			<?php
			}
		}
		
		function update($new_instance, $old_instance) {
			return $new_instance;
		}
		
	}
}