<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://books4languages.com
 * @since             0.1
 * @package           Pressbooks_Metadata
 *
 * @wordpress-plugin
 * Plugin Name:       Pressbooks Metadata
 * Plugin URI:        http://books4languages.com
 * Description:       Extended metadata features for Pressbooks
 * Version:           0.7
 * Author:            My Language Skills
 * Author URI:        http://books4languages.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pressbooks-metadata
 * Domain Path:       /languages
 * Network: 		  True
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pressbooks-metadata-activator.php
 */
function activate_pressbooks_metadata() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pressbooks-metadata-activator.php';
	Pressbooks_Metadata_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pressbooks-metadata-deactivator.php
 */
function deactivate_pressbooks_metadata() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pressbooks-metadata-deactivator.php';
	Pressbooks_Metadata_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pressbooks_metadata' );
register_deactivation_hook( __FILE__, 'deactivate_pressbooks_metadata' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pressbooks-metadata.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1
 */
function run_pressbooks_metadata() {

	$plugin = new Pressbooks_Metadata();
	$plugin->run();

}
run_pressbooks_metadata();
