<?php

/*
	Plugin Name: Restrict Page Parents
	Plugin URI: http://www.tommaitland.net/restrict-page-parents/
	Description: Restricts the page parent options available to specified users and roles to only the pages they own.
	Version: 1.0.0
	Author: Tom Maitland
	Author URI: http://www.tommaitland.net/
	License: GPL2

    Copyright 2013  THOMAS MAITLAND  (email : hello@tommaitland.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


$rpp = new RestrictPageParents();

class RestrictPageParents {

	public function __construct() {
		
		if ( !is_admin() ) return NULL;
		
		// vars
		$this->path = plugin_dir_path( __FILE__ );
		$this->dir = plugin_dir_url( __FILE__ );
						
		// actions
		add_action( 'add_meta_boxes', array($this, 'swap_boxes') );
		add_action( 'admin_menu', array($this, 'create_options_page') );
		add_action( 'admin_init', array($this, 'rpp_init') );
		add_action( 'admin_enqueue_scripts', array($this, 'rpp_scripts') );
		add_action( 'wp_print_scripts', array($this, 'modify_vars') );
		add_action( 'plugins_loaded', array($this, 'language_settings') );
		
		// filters
		add_filter( 'plugin_action_links', array($this, 'plugin_action_links'), 10, 2 );
						
		return true;
		
	}

	/**
	 * Plugin setup and configuration
	 *
	 * @package WordPress
	 * @since 1.0.0
	 *	 
	 */
	
	public function rpp_init() {
	
		register_setting( 'rpp_plugin_options', 'rpp_options' );
		
	}
		
	public function rpp_scripts( $hook_suffix ) {
       				
		if ( $hook_suffix = 'post.php' && $this->get_permissions('force_parent') )
			wp_enqueue_script( 'rpp_validate', plugin_dir_url( __FILE__ ) . 'js/rpp.js', array( 'jquery' ), '1.0', true );
		
		wp_localize_script( 'rpp_validate', 'objectL10n', array(
			'error_message' => __( 'Please select a page parent.', 'restrict-page-parents' ),
		) );

	}

	public function language_settings() {
		$plugin_dir = basename(dirname(__FILE__));
		load_plugin_textdomain( 'restrict-page-parents', false, $plugin_dir );
	}

	/**
	 * Registers the plugin options page
	 *
	 * @package WordPress
	 * @since 1.0.0
	 *	 
	 */
	
	public function create_options_page() {
				
		add_options_page(__('Restrict Page Parents','restrict-page-parents'), __('Restrict Page Parents','restrict-page-parents'), 'manage_options', 'rpp', array($this, 'options_page') );
			
	}
	
	public function options_page() { 
		
		require_once('rpp-options.php');
	
	}
	
	public function plugin_action_links( $links, $file ) { // displays the settings link on the main plugins page
	
		if ( $file == plugin_basename( __FILE__ ) ) {
			
			$posk_links = '<a href="' . get_admin_url() . 'options-general.php?page=rpp">' . __('Settings', 'restrict-page-parents') . '</a>';
			array_unshift( $links, $posk_links ); // make settings link appear first
		
		}
	
		return $links;
	
	}

	/**
	 * Gets data for jQuery manipulation of the 'quick edit' forms.
	 *
	 * @package WordPress
	 * @since 1.0.0
	 *
	 */

	public function get_pages() { // get pages owned by the current user

		global $current_user;
		get_currentuserinfo();

		$args = array(
			'authors' => $current_user->ID
		);
		$pages = get_pages( $args ); // gets pages owned by the current user
					
		$include_pages = NULL;
		foreach ( $pages as $page ) $include_pages .= $page->ID . ',';

		return $include_pages;

	}

	public function modify_vars() { 

	?>

		<script>
			
			var rpp_pages = [ <?php echo $this->get_pages(); ?> ];
			
			<?php if ($this->get_permissions('enable_restrictions')) : ?>
			function getOption_removePages() {
				return true;
			}
			<?php endif; ?>

			<?php if ($this->get_permissions('force_parent')) : ?>
			function getOption_forceParent() {
				return true;
			}
			<?php endif; ?>

		</script>

	<?php

	}

	/**
	 * Degregisters and reregisters the Page Attributes meta box
	 *
	 * @package WordPress
	 * @since 1.0.0
	 *
	 */
	
	public function swap_boxes( $post_type ) { // swap the meta boxes
		   
		    // remove the default page attributes meta box
		    remove_meta_box(
		        'pageparentdiv',
		        'page',
		        'side'
		    );
		   
		    // add the new meta box
		    add_meta_box(
		        'rpp_pageparentdiv',
		        'page' == $post_type ? __('Page Attributes', 'restrict-page-parents') : __('Attributes', 'restrict-page-parents'),
		         array($this, 'page_attributes_meta_box'), 
		        'page', 
		        'side', 
		        'low'
		    );
		    
	}

	/**
	 * Processes the plugin settings to create permissions to be used in plugin logic.
	 *
	 * @package WordPress
	 * @since 1.0.0
	 *	 
	 */
	
	public function get_permissions($slug) {
		
		$options = get_option('rpp_options');
		
		global $current_user;
		get_currentuserinfo();

		if (
				isset($options['override-' . $current_user->user_login]) &&
				$options['override-' . $current_user->user_login] == '1'
		) : // running the overridden options specific to this user

			if (
				isset($options[$slug . '-' . $current_user->user_login]) &&
				$options[$slug . '-' . $current_user->user_login] == '1'
			) :
				return true;
			else :
				return false;
			endif;

		else : // running the role options

			if (
				isset($options[$slug . '-' . $current_user->roles[0]]) &&
				$options[$slug . '-' . $current_user->roles[0]] == '1'
			) :
				return true;
			else :
				return false;
			endif;

		endif; // end override conditional
		
	}

	/**
	 * Rebuilds the Page Attributes meta box
	 *
	 * @package WordPress
	 * @since 1.0.0
	 *	 
	 */
	
	public function page_attributes_meta_box( $post ) { // replacement meta box
	
		//if ($this->get_permissions('enable_restrictions')) - check if parents should be restricted
		//if ($this->get_permissions('force_parent')) - check if parent needs to be forced
					
		global $current_user;
		get_currentuserinfo();
		
		
		$args = array(
			'child_of' => $post->ID,
		);
		$children = get_pages( $args ); // gets children pages of the current page to hide them from the dropdown
		
		
		foreach ( $children as $child ) $children_pages[] = $child->ID;
		$children_pages[] = $post->ID;
		
		
		$args = array(
			'authors' => $current_user->ID
		);
		$pages = get_pages( $args ); // gets pages owned by the current user
					
		$include_pages = NULL;
		foreach ( $pages as $page ) if ( !in_array( $page->ID, $children_pages ) ) $include_pages .= $page->ID . ','; // creates a string of page IDs to show
	
			
		$post_type_object = get_post_type_object( $post->post_type );
		
		if ( $post_type_object->hierarchical ) {
			
			$dropdown_args = array (
				'post_type'        => $post->post_type,
				'selected'         => $post->post_parent,
				'name'             => 'parent_id',
				'exclude_tree'	   => $post->ID,
				'show_option_none' => __('(no parent)'),
				'sort_column'      => 'menu_order, post_title',
				'echo'             => 0,
			);
			
			if ( $this->get_permissions('enable_restrictions') ) {
				$dropdown_args['include']  = $include_pages;
				unset($dropdown_args['exclude_tree']);
			}
			
			if ( $this->get_permissions('force_parent') ) {
				$dropdown_args['show_option_none']  = __('(select parent)');
			}
	
			$dropdown_args = apply_filters( 'page_attributes_dropdown_pages_args', $dropdown_args, $post );
			$pages = wp_dropdown_pages( $dropdown_args );
			
			if ( ! empty($pages) ) {
	?>
	
		<p><strong><?php _e('Parent') ?></strong></p>
		<label class="screen-reader-text" for="parent_id"><?php _e('Parent') ?></label>
	
		<?php echo $pages; ?>
	
	<?php
	
			} // end empty pages check
		} // end hierarchical check.
		
		if ( 'page' == $post->post_type && 0 != count( get_page_templates() ) ) {
		
			$template = !empty($post->page_template) ? $post->page_template : false;
	
	?>
	
		<p><strong><?php _e('Template') ?></strong></p>
		<label class="screen-reader-text" for="page_template"><?php _e('Page Template') ?></label>
		
		<select name="page_template" id="page_template">
		
			<option value='default'><?php _e('Default Template'); ?></option>
			<?php page_template_dropdown($template); ?>
			
		</select>
			
	<?php } // end if page templates exist check ?>
	
		<p><strong><?php _e('Order') ?></strong></p>
		<p><label class="screen-reader-text" for="menu_order"><?php _e('Order') ?></label><input name="menu_order" type="text" size="4" id="menu_order" value="<?php echo esc_attr($post->menu_order) ?>" /></p>
		<p><?php if ( 'page' == $post->post_type ) _e( 'Need help? Use the Help tab in the upper right of your screen.' ); ?></p>
	<?php 
	
	} // end replacement meta box function
	

} // end class