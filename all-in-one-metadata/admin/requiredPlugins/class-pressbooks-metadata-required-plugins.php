<?php

namespace requiredPlugins;
use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;

/**
 * The functions of the plugin that install other dependent plugins needed.
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
	 * A function that checks if third party required plugins are installed, if not it prompts the user to install them.
	 * @since    0.x
	 */
	public static function install() {
		// Check for custom-metadata install (Pressbooks includes custom-metadata plugin so we dont install it)
		if(!site_cpt::pressbooks_identify()){
					/*
					 * Array of plugin arrays. Required keys are name and slug.
					 * If the source is NOT from the .org repo, then source is also required.
					 */
			$plugins = array(
				// This is an example of how to include a plugin bundled with a theme.
				array(
					'name'               => 'Custom Metadata Manager', // The plugin name.
					'slug'               => 'custom-metadata', // The plugin slug (typically the folder name).
					'source'             => dirname( __FILE__ ) . '\plugins\custom-metadata.zip', // The plugin source.
					'required'           => true, // If false, the plugin is only 'recommended' instead of required.
					'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
					'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
					'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
					'external_url'       => '', // If set, overrides default API URL and points to an external URL.
					'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
				)
			);
			tgmpa( $plugins );
		}
	}
}