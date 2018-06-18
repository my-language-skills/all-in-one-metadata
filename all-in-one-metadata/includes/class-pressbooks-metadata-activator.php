<?php

use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.16
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      0.16
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes
 * @author     Daniil Zhitnitskii @danzhik
 */
class Pressbooks_Metadata_Activator {

	/**
	 * Class responsible for activation process
	 *
	 * During activation this class enables some predefined values of plugin options for user demonstration.
	 *
	 * @since    0.16
	 */
	public static function activate() {

		//get all the sites for multisite, if not a multisite, set blog id to 1
		if (is_multisite()) {
			$blogs_ids = get_sites();
		} else {
			$blogs_ids = ['blog_id' => 1];
		}
		foreach( $blogs_ids as $b ) {
			//if multisite, each iteration changes site
			if (is_multisite()) {
				switch_to_blog( $b->blog_id );
			}
			//activate post/chapter level meta for demonstration (these are gonna be created anyway)
			if ( site_cpt::pressbooks_identify() ) {
				update_option( 'schema_locations', ['chapter' => '1'] );
			} else {
				update_option( 'schema_locations', ['post' => '1'] );
			}

			//activate site-level meta for demonstration (these are gonna be created anyway)
			if ( site_cpt::pressbooks_identify() ) {
				update_option( 'metadata_checkbox', '1' );
			} else {
				update_option( 'site-meta_checkbox', '1' );
			}

			// set book type schema active for demonstration for posts/chapters (these are gonna be created anyway)
			if ( site_cpt::pressbooks_identify() ) {
				update_option( 'metadata_schemaTypes\Pressbooks_Metadata_CreativeWork', ['book_type' => '1'] );
			} else {
				update_option( 'site-meta_schemaTypes\Pressbooks_Metadata_Organization', ['corporation_type' => '1'] );
			}


		}
		//if multisite is active, restore the blog which was used before updating options
		if (is_multisite()) {
			restore_current_blog();
		}
	}

}
