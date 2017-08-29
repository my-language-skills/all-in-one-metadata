<?php

namespace adminFunctions;
use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;

/**
 * The functions of the plugin that manage other dependent plugins needed.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.9
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/adminFunctions
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Required_Plugins {

	function __construct() {

	}

	/**
	 * A function that checks if third party required plugins are installed
	 * @since    0.9
	 */
	public static function check() {
		// Check for custom-metadata install
		if(!site_cpt::pressbooks_identify()){
			if (!is_plugin_active('custom-metadata/custom_metadata.php')) {
				if(is_multisite()){
					$link = network_admin_url( 'plugin-install.php?tab=plugin-information&plugin=custom-metadata&TB_iframe=true&width=600&height=550' );
				}else{
					$link = admin_url( 'plugin-install.php?tab=plugin-information&plugin=custom-metadata&TB_iframe=true&width=600&height=550' );
				}
				add_action( 'admin_notices', function () {
					echo '<div id="message" class="error fade"><p>Please make sure that the Custom Metadata Manager plugin is installed for the full plugin functionality -- <a href="'.$link.'">Get it Here</a></p></div>';
				} );
				add_action( 'network_admin_notices', function () {
					echo '<div id="message" class="error fade"><p>Please make sure that the Custom Metadata Manager plugin is installed for the full plugin functionality -- <a href="'.$link.'">Get it Here</a></p></div>';
				} );
				return;
			}
		}
	}
}