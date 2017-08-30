<?php

namespace requiredPlugins;
use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;

/**
 * The functions of the plugin prompting the user to install other dependent plugins needed.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/requiredPlugins
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Required_Plugins {

	function __construct() {

	}

	/**
	 * A function that checks if third party required plugins are installed, if not it prompts the user to download/install them.
	 * @since    0.x
	 */
	public static function check() {
		if ( ! site_cpt::pressbooks_identify() ) {
			//This is the error message for the network admin, it will pop up if the custom-metadata plugin is missing
			if ( ! is_plugin_active( 'custom-metadata/custom_metadata.php' ) ) {
				$link =  plugin_dir_url('') . 'all-in-one-metadata\admin\requiredPlugins\plugins\custom-metadata.zip';
				add_action( 'network_admin_notices', function () use ( $link ) {
					echo '<div id="message" class="error fade"><p>Please make sure that the custom-metadata plugin is installed and activated for the full All In One Metadata Plugin Functionality -- <a href="' . $link . '">Get it Here</a></p></div>';
				} );
				add_action( 'admin_notices', function () use ( $link ) {
					echo '<div id="message" class="error fade"><p>Please make sure that the custom-metadata plugin is installed and activated for the full All In One Metadata Plugin Functionality -- <a href="' . $link . '">Get it Here</a></p></div>';
				} );
			}
		}
	}
}