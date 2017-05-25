<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin
 */

require_once plugin_dir_path( __FILE__ )
	. '../includes/class-pressbooks-metadata-functions.php';

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */
class Pressbooks_Metadata_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.1
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pressbooks_Metadata_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pressbooks_Metadata_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pressbooks-metadata-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.1
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pressbooks_Metadata_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pressbooks_Metadata_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pressbooks-metadata-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * A function to echo an error if the latest version of pressbooks is not installed, and
	 * if there is no Pressbooks installation.
	 * 
	 * @since    0.6
	 */
	function pmdt_init() {
		// Check for Pressbooks install
		if ( ! @include_once( WP_PLUGIN_DIR . '/pressbooks/compatibility.php' ) ) {
			add_action( 'admin_notices', function () {
				echo '<div id="message" class="error fade"><p>' . __( 'PB metadata cannot find a Pressbooks install.', 'pressbooks-metadata' ) . '</p></div>';
			} );
			return;
		// Must meet miniumum requirements
		} elseif( ! version_compare( PB_PLUGIN_VERSION, '3.9.8.2', '>=' ) ) {
			add_action( 'admin_notices', function () {
				echo '<div id="message" class="error fade"><p>' . __( 'PB metadata requires Pressbooks 3.9.8.2 or greater.', 'pressbooks-metadata' ) . '</p></div>';
			} );
			return;
		}
	}

	/**
	 * Used in the header of our site
	 * 
	 * We can create a new Structured Data Type by adding a new type here. Check the link for an example
	 * https://search.google.com/structured-data/testing-tool/u/0/#url=pressbooks.com
	 * @since    0.6
	 */
	public function pmdt_header_function() {

		global $post;

		$pmdt_GS = new Pressbooks_Metadata_Functions();

		if ( is_home() ) {
			echo $pmdt_GS->pmdt_get_Root_level_metatags();
		} elseif ( is_front_page() ) {
			echo $pmdt_GS->pmdt_get_GoogleScolar_metatags();
		}
	}

	/**
	 * Used in the footer of our site
	 * 
	 * We can create a new Structured Data Type by adding a new type here. Check the link for an example
	 * https://search.google.com/structured-data/testing-tool/u/0/#url=pressbooks.com
	 * @since    0.2
	 */
	public function pmdt_footer_function() {

		global $post;

		$pmdt_GS = new Pressbooks_Metadata_Functions();

		if ( is_home() ) {
			//Do nothing. 
			//The metatags of the Root page are printed in the header function
		}
		elseif ( is_front_page() ) { 
			echo $pmdt_GS->pmdt_get_Site_level_metatags();
			echo $pmdt_GS->pmdt_get_educationalAlignment_metatags();
		}
		else{
			echo $pmdt_GS->pmdt_get_Post_level_metatags($post);
		}
		
	}

}
