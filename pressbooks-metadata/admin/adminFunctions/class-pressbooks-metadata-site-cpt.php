<?php

namespace adminFunctions;

/**
 * The functions of the plugin that handle the creation of the new custom post type.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/adminFunctions
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Site_Cpt {

	function __construct() {

	}

	function init(){
		//TODO remember to add a not !
		if($this->pressbooks_identify()){
			$this->run_custom_post();
		}
	}

	/**
	 * A function used to create a custom post type
	 * @since    0.x
	 */
	private function run_custom_post(){
		$labels = [
			'name' => 'Site Metadata',
			'singular_name' => 'Site Metadata',
			'add_new' => 'Add New Site Metadata',
			'add_new_item' => 'Edit Site Meta Information',
			'edit_item' => 'Edit Site Meta Information',
			'new_item' => 'New Site Metadata',
			'view_item' => 'View Site Metadata',
			'search_items' => 'Search Site Metadata',
			'not_found' => 'No site metadata found',
			'not_found_in_trash' => 'No site metadata found in Trash',
			'parent_item_colon' => '',
			'menu_name' => 'Site Metadata',
		];
		$args = [
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_position' => 5,
			'query_var' => true,
			'rewrite' => false,
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
			'supports' => [ '' ],
		];
		register_post_type('site-meta',$args);
	}

	/**
	 * A function used for changing the custom post type messages
	 * @since    0.x
	 */
	public function change_custom_post_mess($messages){
		$messages['site-meta'] = [
			0 => '', // Unused. Messages start at index 1.
			1 => 'Site Metadata updated.',
			2 => 'Custom field updated.',
			3 => 'Custom field deleted.',
			4 => 'Site Metadata updated.',
			/* translators: %s: date and time of the revision */
			5 => isset( $_GET['revision'] ) ? sprintf( 'Site Metadata restored to revision from %s', wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => 'Site Metadata updated.',
			7 => 'Site Metadata saved.',
			8 => 'Site Metadata submitted'
		];
		return $messages;
	}

	/**
	 * A function used to identify whether pressbooks is installed or not
	 * @since    0.x
	 */
	public static function pressbooks_identify() {
		// Check for pressbooks files (this check - can be removed)
		if ((@include_once( WP_PLUGIN_DIR . '/pressbooks/pressbooks.php')) &&
		    //Checking if the plugin is active
		    is_plugin_active('pressbooks/pressbooks.php')) {
			return true;
		}
		else{
			return false;
		}
	}
}

