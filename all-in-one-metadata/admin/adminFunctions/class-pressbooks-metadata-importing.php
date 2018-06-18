<?php

namespace adminFunctions;

/**
 * The functions of the plugin that handle the the importing and exporting of metafields.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.9
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/adminFunctions
 * @author     Christos Amyrotos @MashRoofa
 */

class Pressbooks_Metadata_Importing {

	function __construct() {

	}

	/**
	 * Passing all the new custom metafields of the CPT chapter to pressbooks so they can be exported and imported normally
	 *
	 * @since  0.9
	 */
	function import_fix($additionalFields){

		//Wordpress Database variable for database operations
		global $wpdb;

		//Variable that keeps data being collected
		$storage = array();

		//Grabbing all the site IDs
		$siteids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

		//Grabbing all the meta_keys from each site
		foreach ($siteids as $site_id) {

			//Switching site
			switch_to_blog($site_id);

			//Get the tables names for the current site
			$postMeta = $wpdb->prefix . "postmeta";
			$posts = $wpdb->prefix . "posts";

			//Our query that chooses only fields (meta_keys) that their post is of type chapter
			$chapterFields = $wpdb->get_results(' 
		    SELECT meta.meta_key
		    FROM '.$postMeta.' AS meta
		    INNER JOIN '.$posts.' AS post
		    ON meta.post_id =  post.ID
		    WHERE post.post_type LIKE "chapter"',ARRAY_A);

			//Picking only the fields (meta_keys) that contain "_chapter" -> these are the custom ones we added
			foreach($chapterFields as $field){
				if(strpos($field['meta_key'],'_chapter')){
					$storage[]=$field['meta_key'];
				}
			}
		}

		//Array_Unique removes duplicate values that may existed in two sites
		$storage = array_unique($storage);

		//Merging our results to the Pressbooks import fields data
		$additionalFields = array_merge($additionalFields, $storage);

		//Returning the new values for importing
		return $additionalFields;
	}
}

