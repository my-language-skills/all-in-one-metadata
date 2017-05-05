<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       http://on-lingua.com
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.1
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes
 * @author     julienCXX <software@chmodplusx.eu>
 * @author 	   Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
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
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    0.1
	 */
	public function __construct() {

		$this->plugin_name = 'pressbooks-metadata';
		$this->version = '0.1';

		$this->load_dependencies();
		$this->set_locale();
		$this->set_themes();
		$this->define_admin_hooks();
		$this->define_metadata_changes();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Pressbooks_Metadata_Loader. Orchestrates the hooks of the plugin.
	 * - Pressbooks_Metadata_i18n. Defines internationalization functionality.
	 * - Pressbooks_Metadata_Admin. Defines all hooks for the dashboard.
	 * - Pressbooks_Metadata_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.1
	 * @access   private
	 */
	private function load_dependencies() {

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
		 * The class responsible for registering and setting all the themes used by the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pressbooks-metadata-themes.php';

		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-pressbooks-metadata-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-pressbooks-metadata-public.php';

		/**
		 * Includes all the existing concrete metadata actually used/provided
		 * by this plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/metadata/actual-metadata/include-concrete-plugin-metadata.php';

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
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Set the plugin's specific themes and removes useless ones.
	 *
	 * @since    0.1
	 * @access   private
	 */
	private function set_themes() {

		$plugin_themes = new Pressbooks_Metadata_Themes( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_themes, 'register_directory' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_themes, 'enqueue_custom_themes' );
		$this->loader->add_filter( 'allowed_themes', $plugin_themes, 'add_themes_to_filter', 11 );

		// Export fix
		$this->loader->add_filter( 'pb_epub_css_override', $plugin_themes, 'add_epub_export_styles' );

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    0.1
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Pressbooks_Metadata_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_footer', $plugin_admin, 'footer_function' );
		$this->loader->add_action( 'wp_head', $plugin_admin, 'header_function' );
		$this->loader->add_action( 'init', $plugin_admin, 's_md_init' ); // Meet miniumum requirements


	}

	/**
	 * Register all of the metadata customization.
	 *
	 *
	 *
	 * @since    0.1
	 * @access   private
	 */
	private function define_metadata_changes() {

		$plugin_educational_information = Pressbooks_Metadata_Educational_Information::get_instance();
		$plugin_chapter_metadata = Pressbooks_Metadata_Chapter_Metadata::get_instance();
		$plugin_related_books = Pressbooks_Metadata_Related_Books::get_instance();
		$plugin_general_book_information = Pressbooks_Metadata_General_Book_Information::get_instance();


		$this->loader->add_action(
			'custom_metadata_manager_init_metadata',
			$plugin_educational_information,
			'add_to_current_post_metadata', 31 );
		$this->loader->add_action(
			'custom_metadata_manager_init_metadata',
			$plugin_chapter_metadata,
			'add_to_current_post_metadata', 31 );
		$this->loader->add_action(
			'custom_metadata_manager_init_metadata',
			$plugin_related_books,
			'add_to_current_post_metadata', 31 );
		$this->loader->add_action(
			'custom_metadata_manager_init_metadata',
			$plugin_general_book_information,
			'add_to_current_post_metadata', 31 );
		
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
