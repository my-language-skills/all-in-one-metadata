<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.16
 *
 * @package    Pressbooks_Metadata
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

//declaring global DB connection variable
global $wpdb;

//get all the sites for multisite, if not a multisite, set blog id to 1
if (is_multisite()) {
	$blogs_ids = get_sites();
} else {
	$blogs_ids = [1];
}

//delete plugin options and posts/chapter related metadata from every site
foreach( $blogs_ids as $b ){
	//if multisite, each iteration changes site
	if (is_multisite()) {
		switch_to_blog( $b->blog_id );
	}

	//get all the options from database
	$all_options = wp_load_alloptions();
	$plugin_options = [];
	$related_meta = [];

	//check if PressBooks plugin is used
	if ((@include_once( WP_PLUGIN_DIR . '/pressbooks/pressbooks.php')) &&
	    //Checking if the plugin is active
	    is_plugin_active('pressbooks/pressbooks.php')) {
		$pb = true;
	}
	else{
		$pb = false;
	}

	//gather all post types, including built-in of without PressBooks
	if($pb){
		$allPostTypes = get_post_types( array( 'public' => true, '_builtin' => false )) ;
	}else{
		$allPostTypes = get_post_types( array( 'public' => true)) ;
	}

	$allPostTypes['site-meta'] = 'site-meta';
	$allPostTypes['metadata'] = 'metadata';


	//extract plugin options from all options
	foreach ( $all_options as $name => $value ) {
		foreach ($allPostTypes as $postType) {
			if ( stristr( $name, '_type_' . $postType ) || stristr( $name, '_type_' . $postType . '_level' ) 
				|| stristr( $name, '_type_overwrite' ) || stristr($name, 'saoverwr') || stristr($name, $postType.'_checkbox')
				|| stristr( $name, 'dublin_checkbox' ) || stristr($name, 'coins_checkbox') || stristr($name, 'educational_checkbox')
			    || $name == 'property_network_value' || $name == 'property_network_value_freeze' || $name == 'schema_locations') {
				$plugin_options[ $name ] = $value;

			}
		}
	}


	//delete plugin options
	foreach ( $plugin_options as $key => $value ) {
		if ( get_option( $key ) || get_option($key, 'nonex') !== 'nonex') {
			delete_option( $key );
		}
	}

	// Delete plugin related posts' meta
	//if blog is root, do not add blog number to table name
	$blog_id = $b->blog_id == 1 || $b = 1 ? '' : $b->blog_id.'_';
	//DELETE query to postmeta database
	$wpdb->query( "DELETE FROM `".$wpdb->prefix.$blog_id."postmeta` WHERE `meta_key` LIKE 'pb%type%'");
	$wpdb->query( "DELETE FROM `".$wpdb->prefix.$blog_id."postmeta` WHERE `meta_key` LIKE 'pb%vocab%'");
}



