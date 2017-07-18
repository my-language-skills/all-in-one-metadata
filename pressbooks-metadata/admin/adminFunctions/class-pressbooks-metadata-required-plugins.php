<?php

namespace adminFunctions;
use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;

/**
 * The functions of the plugin that manage other dependent plugins needed.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/adminFunctions
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Required_Plugins {

	function __construct() {

	}

	public static function check() {
		// Check for custom-metadata install
		if(!site_cpt::pressbooks_identify()){
			if (!is_plugin_active('custom-metadata/custom_metadata.php')) {
				add_action( 'admin_notices', function () {
					echo '<div id="message" class="error fade"><p>Please make sure that the custom-metadata plugin is installed for the full PB Metadata Functionality -- <a href="https://wordpress.org/plugins/custom-metadata/">Get it Here</a></p></div>';
				} );
				return;
			}
		}
	}
}

