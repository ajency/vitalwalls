<?php
/** 
 * Posts Block
 * List posts by category/tags/post_format
 * Orderby latest
 * @todo - allow featured images, layout options, post formats(currently post tags offer similar functionality)
*/
if(!class_exists('AQ_Posts_Full_Width_Block')) {
	class AQ_Posts_Full_Width_Block extends AQ_Block {
		
		function __construct() {
			$block_options = array(
				'name' => 'Blog Posts full width',
				'size' => 'span12',
				'resizable' => '0',
				'categories' => array(),
				'tags' => array(),
				'postnum' => 5,
				'page' => false,
				'excerpt' => '',
				'post_ajax' => 'false'
			);
			
			parent::__construct('aq_posts_full_width_block', $block_options);
			add_filter('excerpt_more', array(&$this, 'excerpt_more'));

						
		}
		
		function form($instance) {
		
			$defaults = array(
				'name' => 'Blog Posts full width',
				'size' => 'span12',
				'resizable' => '0',
				'categories' => array(),
				'tags' => array(),
				'postnum' => 5,
				'page' => false,
				'excerpt' => '',
				'post_ajax' => 'false'
			);
			
			$ajax_options = array(
				'true' => 'True',
				'false' => 'False',
			);
			
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);

			
			$post_categories = ($temp = get_terms('category')) ? $temp : array();
			$categories_options = array();
			foreach($post_categories as $cat) {
				$categories_options[$cat->term_id] = $cat->name;
			}
			
			$post_tags = ($temp = get_terms('post_tag')) ? $temp : array();
			$tags_options = array();
			foreach($post_tags as $tag) {
				$tags_options[$tag->term_id] = $tag->name;
			}
			
			$page_options = array(0 => "Select a page:");
			$pages_obj = get_pages('sort_column=post_parent,menu_order');    
			foreach ($pages_obj as $page_obj) {
				$page_options[$page_obj->ID] = $page_obj->post_title; 
			}
			
			?>
			<p class="description half">
				<label for="<?php echo $this->get_field_id('categories') ?>">
				Posts Categories (leave empty to display all)<br/>
				<?php echo aq_field_multiselect('categories', $block_id, $categories_options, $categories); ?>
				</label>
			</p>
			<p class="description half last">
				<label for="<?php echo $this->get_field_id('types') ?>">
				Posts Tags (leave empty to display all)<br/>
				<?php echo aq_field_multiselect('tags', $block_id, $tags_options, $tags); ?>
				</label>
			</p>
			<p class="description half">
				<label for="<?php echo $this->get_field_id('postnum') ?>">
				Maximum number of posts to display<br/>
				<?php echo aq_field_input('postnum', $block_id, $postnum, 'min', 'number') ?> &nbsp; posts
				</label>
			</p>
		<p class="description half last">
			<label for="<?php echo $this->get_field_id('post_ajax') ?>">
				Use ajax<br/>
				<?php echo aq_field_select('post_ajax', $block_id, $ajax_options, $post_ajax); ?>
			</label>
		</p>				

			<?php
			
		}
		
		function block($instance) {
			extract($instance);
			wp_enqueue_script('pmc_bxSlider');
			global $pmc_data;
			$args = array();
			function postBlock($data,$rand,$post_ajax,$category) {
				$count_posts = 0;
				$count = 1;
				$countitem = 1;
				echo '<ul class="sliderPostBlock-'.$category.' post-block">';
					if ($data -> have_posts()) : while ($data -> have_posts()) : $data -> the_post();
					$count_posts++;
					if(!has_post_format( 'link' , get_the_id())){
						global $post;
						if ( has_post_thumbnail() ){
							$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'postBlock', false);
							$image = $image[0];}
						if($countitem == 1)	
						echo '<li class="fa '.implode(' ', get_post_class()).' cf">';
							if($count != 3){
								echo '<div class="one_third" >';
							}
							else{
								echo '<div class="one_third last" >';
								$count = 0;
							}
							if($post_ajax == 'true')
								echo '<div class="click" id="post_'. get_the_id() .'_'. $rand .'">';
							if($post_ajax != 'true')
								echo '<a href="'.get_permalink( get_the_id() ) .'">';										
							echo '<div class="imgholder">';
							echo '<div class="recentimage">
									
									<div class="image">
										<div class="loading"></div>';
										if (has_post_thumbnail( get_the_ID() )) 
											echo '<img src = "'.$image.'" alt = "'.esc_attr(get_the_title() ? get_the_title() : get_the_ID()).'"  > ' ;									

							echo '	</div>
								</div>';
							echo '</div>';
							if($post_ajax != 'true')
									echo '</a>';									
							$title = substr(the_title('','',FALSE), 0, 35);  
							if(strlen(the_title('','',FALSE)) > 35)
								$title = substr(the_title('','',FALSE), 0, 35).'...';
							echo '<div class="recentdescription"><h3 class="the-title">';	
							if($post_ajax != 'true')
								echo '<a href="'.get_permalink( get_the_id() ) .'">';									
							echo  $title;
							if($post_ajax != 'true')
								echo '</a>';	
							echo '</h3>';
							echo '<div class="aq-posts-block-meta">'. get_the_date() .' '.translation_builder('translation_by','By: ').' '.get_the_author_link().' - <a href="'.get_permalink( get_the_id() ) .'">'.translation_builder('translation_leave_comment','Leave the comment').'</a></div>';								
							echo '<div class="the_excerpt">'. substr(strip_tags(get_the_content()), 0, 115) .' ...</div>';
							if($post_ajax != 'true')
								echo '<div class="recentdescription-text"><a href="'.get_permalink( get_the_id() ) .'">'. translation_builder('translation_morelinkblog', 'Read more about this...') .'</a></div>';
						echo '</div>';
						if($post_ajax == 'true')
							echo '</div>';
						$count++;
						if($countitem == 3) {
							$countitem = 0;
							echo '</div></li>';
						}
						else{
							echo '</div>';
						}
						$countitem++;
						}
					endwhile; endif; wp_reset_query();
					
				echo '</ul>';
				if($count_posts > 3) { ?>
				<script type="text/javascript">
					jQuery(document).ready(function(){	  
					// Slider
					var $slider = jQuery(".sliderPostBlock-<?php echo $category ?>").bxSlider({
						controls: true,
						displaySlideQty: 1,
						default: 1000,
						easing : "easeInOutQuint",
						prevText : '<i class="fa fa-chevron-left"></i>',
						nextText : '<i class="fa fa-chevron-right"></i>',
						pager :false,
						infiniteLoop: false,
						hideControlOnEnd : true,	
						touchEnabled: false					
					});
					 });
				</script>	
				<?php }
				
			}			 ?>
			
			
			
			<div class="products-both post-all">	
				<div class="titleborderOut"><div class="titleborder"></div></div>	
				<div class="tabwrap tabsonly">	
					<ul class="tabsshort post">
					<li>
						<a href="#fragment-all"><?php echo translation_builder('translation_all', 'Show all:'); ?></a>
					</li>					
					<?php foreach($categories as $category){ ?>					
						<li>
							<a href="#fragment-<?php echo get_cat_name( $category ); ?>"><?php echo get_cat_name( $category ); ?></a>
						</li>
					<?php } ?>
					</ul>	
					<div class="panes">
						<div class="panel entry-content" id="tab-all">
						<?php $rand = rand(0,99) ?>
							<div class="pane" id="fragment-all">			
								<div class="aq-posts-block">
									<div class="post-full-width">
										<div class="post-full-width-inner">
											<div id = "showpost-post-<?php echo $rand ?>" class="showpost">
												<div class="showpostload"><div class="loading"></div></div>
												<div class = "closehomeshow-post closeajax"><i class="fa fa-times"></i></div>
												<div class="showpostpostcontent"></div>
											</div>											
											<?php 
											if($postnum) $args['posts_per_page'] = $postnum;
											if($categories) $args['category__in'] = $categories;
											if($tags) $args['tag__in'] = $tags;
											$data = new WP_Query($args); 												
											postBlock($data,$rand,$post_ajax,'all'); ?>
										</div>
									</div>
								</div>
							</div>
						</div>					
						<?php foreach($categories as $category){ ?>
						<?php $rand = rand(0,99) ?>
							<div class="panel entry-content" id="tab-<?php echo get_cat_name( $category ); ?>">
								<div class="pane" id="fragment-<?php echo get_cat_name( $category ); ?>">			
									<div class="aq-posts-block">
										<div class="post-full-width">
											<div class="post-full-width-inner">
												<div id = "showpost-post-<?php echo $rand ?>">
													<div class="showpostload"><div class="loading"></div></div>
													<div class = "closehomeshow-post closeajax"><i class="fa fa-times"></i></div>
													<div class="showpostpostcontent"></div>
												</div>											
												<?php 
												if($postnum) $args['posts_per_page'] = $postnum;
												if($categories) $args['category__in'] = $category;
												if($tags) $args['tag__in'] = $tags;
												$data = new WP_Query($args); 												
												postBlock($data,$rand,$post_ajax,$category); ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php
		

		
		}


		
		function update($new_instance, $old_instance) {
			$new_instance = aq_recursive_sanitize($new_instance);
			return $new_instance;
		}
		
		function excerpt_more($more) {
			global $post;
			return ' <a href="'. get_permalink($post->ID) . '">Continue Reading &rarr;</a>';
		}
		
		
		

	}
}