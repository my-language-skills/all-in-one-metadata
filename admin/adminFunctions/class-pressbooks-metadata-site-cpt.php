<?php

namespace adminFunctions;

/**
 * The functions of the plugin that handle the creation of the new custom post type.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.9
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/adminFunctions
 * @author     Christos Amyrotos @MashRoofa
 */

class Pressbooks_Metadata_Site_Cpt {

	function __construct() {

	}

	/**
	 * A function that signals the creation of the CPT
	 * @since    0.9
	 */
	function init(){
		if(!$this->pressbooks_identify()){
			$this->run_custom_post();
		}
	}

	/**
	 * A function used to create a custom post type
	 * @since    0.9
	 */
	private function run_custom_post(){
		$labels = array(
			'name' => __('Site Metadata', 'all-in-one-metadata'),
			'singular_name' => __('Site Metadata', 'all-in-one-metadata'),
			'add_new' => __('Add New Site Metadata', 'all-in-one-metadata'),
			'add_new_item' => __('Edit Site Meta Information', 'all-in-one-metadata'),
			'edit_item' => __('Edit Site Meta Information', 'all-in-one-metadata'),
			'new_item' => __('New Site Metadata', 'all-in-one-metadata'),
			'view_item' => __('View Site Metadata', 'all-in-one-metadata'),
			'search_items' => __('Search Site Metadata', 'all-in-one-metadata'),
			'not_found' => __('No site metadata found', 'all-in-one-metadata'),
			'not_found_in_trash' => __('No site metadata found in Trash', 'all-in-one-metadata'),
			'parent_item_colon' => '',
			'menu_name' => __('Site Metadata', 'all-in-one-metadata'),
		);
		$args = array(
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
			'supports' => array('')
		);
		register_post_type('site-meta',$args);
	}

	/**
	 * A function used for changing the custom post type messages
	 * @since    0.9
	 */
	public function change_custom_post_mess($messages){
		$messages['site-meta'] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => __('Site Metadata updated.', 'all-in-one-metadata'),
			2 => __('Custom field updated.', 'all-in-one-metadata'),
			3 => __('Custom field deleted.', 'all-in-one-metadata'),
			4 => __('Site Metadata updated.', 'all-in-one-metadata'),
			/* translators: %s: date and time of the revision */
			5 => isset( $_GET['revision'] ) ? sprintf( __('Site Metadata restored to revision from %s', 'all-in-one-metadata'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => __('Site Metadata updated.', 'all-in-one-metadata'),
			7 => __('Site Metadata saved.', 'all-in-one-metadata'),
			8 => __('Site Metadata submitted', 'all-in-one-metadata')
		);
		return $messages;
	}

	/**
	 * A function that returns all the metadata from the site_meta cpt
	 * This is like when we use pressbooks to gather all data from Book Info
	 * We are always working on a single post -- automatic
	 * This function will be mostly used when the plugin is on wordpress mode and not on pressbooks mode
	 * Also it will be called from classes inside schemaTypes
	 * @since    0.9
	 */
	public static function get_site_meta_metadata(){
		$args = array(
			'post_type' => 'site-meta',
			'posts_per_page' => 1,
			'post_status' => 'publish',
			'orderby' => 'modified',
			'no_found_rows' => true,
			'cache_results' => true,
		);

		$q = new \WP_Query();
		$results = $q->query( $args );

		if ( empty( $results ) ) {
			return false;
		}

		return get_post_meta( $results[0]->ID );
	}

	/**
	 * Function that returns always an object, in this object the single post for sete-meta is contained
	 * This function is used for creating the single site-meta post -> Pressbooks also uses the same technique for Book Info
	 * @since  0.9
	 */
	public static function get_site_meta_post() {

		$args = array(
			'post_type' => 'site-meta',
			'posts_per_page' => 1,
			'post_status' => 'publish',
			'orderby' => 'modified',
			'no_found_rows' => true,
			'cache_results' => true,
		);

		$q = new \WP_Query();
		$results = $q->query( $args );

		if ( empty( $results ) ) {
			return false;
		}

		return $results[0];
	}

	/**
	 * A function used to identify whether pressbooks is installed or not
	 * @since    0.9
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

