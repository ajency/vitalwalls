<?php
/*
 * working behind the seen
 */
class NM_PersonalizedProduct_Admin extends NM_PersonalizedProduct {
	var $menu_pages, $plugin_scripts_admin, $plugin_settings;
	function __construct() {
		
		// setting plugin meta saved in config.php
		$this->plugin_meta = get_plugin_meta_productmeta();
		
		// getting saved settings
		$this->plugin_settings = get_option ( $this->plugin_meta ['shortname'] . '_settings' );
		
		// file upload dir name
		$this->contact_files = 'contact_files';
		
		/*
		 * [1] TODO: change this for plugin admin pages
		 */
		$this->menu_pages = array (
				array (
						'page_title' => $this->plugin_meta ['name'],
						'menu_title' => $this->plugin_meta ['name'],
						'cap' => 'manage_options',
						'slug' => $this->plugin_meta ['shortname'],
						'callback' => 'product_meta',
						'parent_slug' => '' 
				),
		);
		
		/*
		 * [2] TODO: Change this for admin related scripts JS scripts and styles to loaded ADMIN
		 */
		$this->plugin_scripts_admin = array (
				array (
						'script_name' => 'scripts-global',
						'script_source' => '/js/nm-global.js',
						'localized' => false,
						'type' => 'js',
						'page_slug' => $this->plugin_meta ['shortname'] 
				),
				array (
						'script_name' => 'scripts-admin',
						'script_source' => '/js/admin.js',
						'localized' => true,
						'type' => 'js',
						'page_slug' => array (
								$this->plugin_meta ['shortname'],
						),
						'depends' => array (
								'jquery',
								'jquery-ui-accordion',
								'jquery-ui-draggable',
								'jquery-ui-droppable',
								'jquery-ui-sortable',
								'jquery-ui-slider',
								'jquery-ui-dialog',
								'jquery-ui-tabs',
								'media-upload',
								'thickbox'
						) 
				),
				array (
						'script_name' => 'ui-style',
						'script_source' => '/js/ui/css/smoothness/jquery-ui-1.10.3.custom.min.css',
						'localized' => false,
						'type' => 'style',
						'page_slug' => array (
								'nm-new-form' 
						) 
				),
				array (
						'script_name' => 'thickbox',
						'script_source' => 'shipped',
						'localized' => false,
						'type' => 'style',
						'page_slug' => array (
								'nm-new-form'
						)
				),				
				array (
						'script_name' => 'plugin-css',
						'script_source' => '/templates/admin/style.css',
						'localized' => false,
						'type' => 'style',
						'page_slug' => array (
								$this->plugin_meta ['shortname'],
								'nm-new-form' 
						) 
				) 
		);
		
		add_action ( 'admin_menu', array (
				$this,
				'add_menu_pages' 
		) );
		add_action ( 'admin_init', array (
				$this,
				'init_admin' 
		) );
	}
	
	function load_scripts_admin() {
		
		// localized vars in js
		$arrLocalizedVars = array (
				'plugin_url' => $this->plugin_meta ['url'],
				'doing' => $this->plugin_meta ['url'] . '/images/loading.gif',
				'plugin_admin_page' => admin_url ( 'admin.php?page=nm_personalizedproduct' ) 
		);
		
		// admin end scripts
		
		if ($this->plugin_scripts_admin) {
			foreach ( $this->plugin_scripts_admin as $script ) {
				
				// checking if it is style
				if ($script ['type'] == 'js') {
					
					$depends = (isset($script['depends']) ? $script['depends'] : NULL);
					wp_enqueue_script ( $this->plugin_meta ['shortname'] . '-' . $script ['script_name'], $this->plugin_meta ['url'] . $script ['script_source'], $depends );
					
					// if localized
					if ($script ['localized'])
						wp_localize_script ( $this->plugin_meta ['shortname'] . '-' . $script ['script_name'], $this->plugin_meta ['shortname'] . '_vars', $arrLocalizedVars );
				} else {
					
					if ($script ['script_source'] == 'shipped')
						wp_enqueue_style ( $script ['script_name'] );
					else
						wp_enqueue_style ( $this->plugin_meta ['shortname'] . '-' . $script ['script_name'], $this->plugin_meta ['url'] . $script ['script_source'] );
				}
			}
		}
	}
	
	/*
	 * creating menu page for this plugin
	 */
	function add_menu_pages() {
		foreach ( $this->menu_pages as $page ) {
			
			if ($page ['parent_slug'] == '') {
				
				$menu = add_options_page ( __ ( $page ['page_title'] . ' Settings', $this->plugin_meta ['shortname'] ), __ ( $page ['menu_title'] . ' Settings', $this->plugin_meta ['shortname'] ), $page ['cap'], $page ['slug'], array (
						$this,
						$page ['callback'] 
				), $this->plugin_meta ['logo'], $this->plugin_meta ['menu_position'] );
			} else {
				
				$menu = add_submenu_page ( $page ['parent_slug'], __ ( $page ['page_title'] . ' Settings', $this->plugin_meta ['shortname'] ), __ ( $page ['menu_title'] . ' Settings', $this->plugin_meta ['shortname'] ), $page ['cap'], $page ['slug'], array (
						$this,
						$page ['callback'] 
				) );
			}
			
			// loading script for only plugin optios pages
			// page_slug is key in $plugin_scripts_admin which determine the page
			foreach ( $this->plugin_scripts_admin as $script ) {
				
				if (is_array ( $script ['page_slug'] )) {
					
					if (in_array ( $page ['slug'], $script ['page_slug'] ))
						add_action ( 'admin_print_scripts-' . $menu, array (
								$this,
								'load_scripts_admin' 
						) );
				} else if ($script ['page_slug'] == $page ['slug']) {
					add_action ( 'admin_print_scripts-' . $menu, array (
							$this,
							'load_scripts_admin' 
					) );
				}
			}
		}
	}
	
	/*
	 * after init admin
	 */
	function init_admin() {
		add_meta_box ( 'contact_forms_meta_box', 'Uploaded file', array (
				$this,
				'display_contact_form_meta_box' 
		), 'nm-forms', 'normal', 'high' );
	}
	function display_contact_form_meta_box($form) {
		echo '<p>' . __ ( 'Following files are uploaded:', $this->plugin_meta ['shortname'] ) . '</p>';
		
		$uploaded_files = get_post_meta ( $form->ID, 'uploaded_files', true );
		$uploaded_files = json_decode ( $uploaded_files );
		
		echo '<table>';
		
		if ($uploaded_files) {
			foreach ( $uploaded_files as $file ) {
				
				$file_url = $this->get_file_dir_url () . $file;
				
				$type = strtolower ( substr ( strrchr ( $new_filename, '.' ), 1 ) );
				if (($type == "gif") || ($type == "jpeg") || ($type == "png") || ($type == "pjpeg") || ($type == "jpg"))
					$thumb_url = $this->get_file_dir_url ( true ) . $file;
				else
					$thumb_url = $this->plugin_meta ['url'] . '/images/file.png';
				
				echo '<tr>';
				echo '<td style="width: 20%"><img src="' . $thumb_url . '" /></td>';
				echo '<td><a href="' . $file_url . '" target="_blank">' . __ ( 'Download file', $this->plugin_meta ['shortname'] ) . '</a></td>';
				echo '</tr>';
			}
		}
		echo '</table>';
	}
	
	// ====================== CALLBACKS =================================
	function main_settings() {
		$this->load_template ( 'admin/create-form.php' );
	}
	
	
	function product_meta() {
		echo '<div class="wrap">';
		
		if ((!isset ( $_REQUEST ['productmeta_id']))){
			echo '<h2>' . __ ( 'N-Media WooCommerce Personalized Product Option Manager', $this -> plugin_meta['shortname'] ) . '</h2>';
			echo '<p>' . __ ( 'Create different meta groups for different products', $this -> plugin_meta['shortname'] ) . '</p>';
			
			echo '<h2>' . __ ( 'How it works?', $this -> plugin_meta['shortname'] ) . '</h2>';
			echo '<p>' . __ ( 'Once you create meta groups it will be displayed on product edit page on right side panel.', $this -> plugin_meta['shortname'] ) . '</p>';
		}
		
		$action = (isset($_REQUEST ['action']) ? $_REQUEST ['action'] : '');
		if ((isset ( $_REQUEST ['productmeta_id'] ) && $_REQUEST ['do_meta'] == 'edit') || $action == 'new') {
			$this->load_template ( 'admin/create-form.php' );
		} elseif ($_REQUEST ['do_meta'] == 'clone') {
			$this -> clone_product_meta($_REQUEST ['productmeta_id']);
		}else{
			$url_add = $this->nm_plugin_fix_request_uri ( array (
					'action' => 'new'
			) );
			echo '<a class="button button-primary" href="' . $url_add . '">' . __ ( 'Add Product Meta Group', $this -> plugin_meta['shortname'] ) . '</a>';
		}
		
		$this->load_template ( 'admin/existing-meta.php' );
		
		echo '</div>';
	}
}