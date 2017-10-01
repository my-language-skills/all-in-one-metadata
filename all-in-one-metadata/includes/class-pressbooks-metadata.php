<?php

//Defining all namespaces to be used in the define_admin_hooks function etc

use adminFunctions\Pressbooks_Metadata_Site_Cpt as siteMeta;
use adminFunctions\Pressbooks_Metadata_Importing as importing;
use adminFunctions\Pressbooks_Metadata_Options as options;
use adminFunctions\Pressbooks_Metadata_Ajax as ajax;
use schemaFunctions\Pressbooks_Metadata_Output as output;
use schemaFunctions\Pressbooks_Metadata_Engine as engine;
use requiredPlugins\Pressbooks_Metadata_Required_Plugins as required;
use networkFunctions\Pressbooks_Metadata_Network_Admin as netadmin;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.1
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */
class Pressbooks_Metadata {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.1
	 * @access   protected
	 * @var      Pressbooks_Metadata_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.1
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.1
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    0.1
	 */
	public function __construct() {

		$this->plugin_name = 'pressbooks-metadata';
		$this->version = '0.1';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Pressbooks_Metadata_Loader. Orchestrates the hooks of the plugin.
	 * - Pressbooks_Metadata_i18n. Defines internationalization functionality.
	 * - Pressbooks_Metadata_Admin. Defines all hooks for the admin area.
	 * - Pressbooks_Metadata_Public. Defines all hooks for the public side of the site.
	 *
	 * - Pressbooks_Metadata_General_Book_Information. Defines metadata of this plugin.
	 * - Pressbooks_Metadata_Educational_Information. Defines metadata of this plugin.
	 * - Pressbooks_Metadata_Chapter_Metadata. Defines metadata of this plugin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.1
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The autoload file for using our namespaces - this comes from composer
		 */
		require_once plugin_dir_path( __FILE__ ) . '../vendor/autoload.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pressbooks-metadata-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pressbooks-metadata-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-pressbooks-metadata-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-pressbooks-metadata-public.php';

		$this->loader = new Pressbooks_Metadata_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Pressbooks_Metadata_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.1
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Pressbooks_Metadata_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    0.1
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Pressbooks_Metadata_Admin( $this->get_plugin_name(), $this->get_version() );

		//Handling ajax requests for overwrite_prop_clean overwrite_prop_disable
		$this->loader->add_action( 'wp_ajax_overwrite_prop_clean', new ajax(), 'adminFunctions\Pressbooks_Metadata_Ajax::overwrite_prop_clean' );
		$this->loader->add_action( 'wp_ajax_overwrite_prop_disable', new ajax(), 'adminFunctions\Pressbooks_Metadata_Ajax::overwrite_prop_disable' );

		//Installing required plugins
		$this->loader->add_action( 'admin_init', new required(), 'requiredPlugins\Pressbooks_Metadata_Required_Plugins::check' );

		//Load styles and scripts
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		//Load the options page
		$this->loader->add_action( 'admin_menu', new options(), 'adminFunctions\Pressbooks_Metadata_Options::add_options_page' );

		//Network admin settings page
		$this->loader->add_action( 'network_admin_menu', new netadmin(), 'networkFunctions\Pressbooks_Metadata_Network_Admin::add_settings' );
		$this->loader->add_action( 'network_admin_edit_update_network_options', new netadmin(), 'networkFunctions\Pressbooks_Metadata_Network_Admin::update_network_options' );

		//Header and footer functions that output metadata
		$this->loader->add_action( 'wp_head', new output(), 'schemaFunctions\Pressbooks_Metadata_Output::header_run' );
		$this->loader->add_action( 'wp_footer', new output(), 'schemaFunctions\Pressbooks_Metadata_Output::footer_run');

		//Creating a custom post for site level metadata - only when pressbooks is not present
		$this->loader->add_action( 'init', new siteMeta(), 'adminFunctions\Pressbooks_Metadata_Site_Cpt::init' );
		$this->loader->add_action( 'post_updated_messages', new siteMeta(), 'adminFunctions\Pressbooks_Metadata_Site_Cpt::change_custom_post_mess' );

		//This filter is needed for importing to pressbooks, all new metafields are added here, this is a pressbooks filter
		//Needed only for chapter level fields
		$this->loader->add_filter( 'pb_import_metakeys', new importing(), 'adminFunctions\Pressbooks_Metadata_Importing::import_fix');

		//Register the settings section
		$this->loader->add_action( 'admin_init', new engine(), 'schemaFunctions\Pressbooks_Metadata_Engine::register_settings' );

		//This is the code that will produce the metaboxes in the desired places
		$this->loader->add_action( 'custom_metadata_manager_init_metadata', new engine(), 'schemaFunctions\Pressbooks_Metadata_Engine::place_metaboxes',31 );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    0.1
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Pressbooks_Metadata_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.1
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     0.1
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.1
	 * @return    Pressbooks_Metadata_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     0.1
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
