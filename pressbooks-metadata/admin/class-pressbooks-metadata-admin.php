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
	. '../admin/schemaFunctions/class-pressbooks-metadata-functions.php';

//The functions for the educational info will become one file with the schema functions
require_once plugin_dir_path( __FILE__ )
             . '../admin/schemaFunctions/class-pressbooks-metadata-edu-functions.php';

require_once plugin_dir_path( __FILE__ )
             . '../admin/settings/class-pressbooks-metadata-sections.php';

require_once plugin_dir_path( __FILE__ )
             . '../admin/schemaMetaboxes/class-pressbooks-metadata-metaboxes-book.php';

require_once plugin_dir_path( __FILE__ )
             . '../admin/schemaMetaboxes/class-pressbooks-metadata-metaboxes-course.php';

require_once plugin_dir_path( __FILE__ )
             . '../admin/schemaMetaboxes/class-pressbooks-metadata-metaboxes-creativeWork.php';

require_once plugin_dir_path( __FILE__ )
             . '../admin/schemaMetaboxes/class-pressbooks-metadata-metaboxes-webPage.php';

require_once plugin_dir_path( __FILE__ )
             . '../admin/schemaMetaboxes/class-pressbooks-metadata-metaboxes-educational.php';

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */
class Pressbooks_Metadata_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1
	 *
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

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
	public function pmdt_init() {
		// Check for Pressbooks install
		if ( ! @include_once( WP_PLUGIN_DIR . '/pressbooks/compatibility.php' ) ) {
			add_action( 'admin_notices', function () {
				echo '<div id="message" class="error fade"><p>' . __( 'PB metadata cannot find a Pressbooks install.', 'pressbooks-metadata' ) . '</p></div>';
			} );

			return;
			// Must meet miniumum requirements
		} elseif ( ! version_compare( PB_PLUGIN_VERSION, '3.9.8.2', '>=' ) ) {
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

		$pmdt_GS = new Pressbooks_Metadata_Functions();
		if ( is_home() ) {
			echo $pmdt_GS->pmdt_get_root_level_metatags();
		} elseif ( is_front_page() ) {
			echo $pmdt_GS->pmdt_get_googleScholar_metatags();
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

		$pmdt_GS = new Pressbooks_Metadata_Functions();

		if ( is_front_page() ) {
			//If the type is enabled for the book level we run the meta data functions below
			if ( get_option( 'book_type_book_level' ) || get_option( 'course_type_book_level' ) || get_option( 'webpage_type_book_level' ) ) {
				echo $pmdt_GS->pmdt_get_book_cw_metatags( "metadata" );
			}
			if ( get_option( 'course_type_book_level' ) ) {
				echo $pmdt_GS->pmdt_get_course_metatags( "metadata" );
			}
			if ( get_option( 'webpage_type_book_level' ) ) {
				echo $pmdt_GS->pmdt_get_webpage_metatags( "metadata" );
			}
			if(get_option('educational_info_book_level')){
				$test_var = new Pressbooks_Metadata_Edu_Functions();
				echo $test_var->pmdt_get_educational_metatags();
			}
		} elseif ( ! is_home() ) {
			//If the type is enabled for the chapter level we run the meta data functions below
			if ( get_option( 'book_type_chapter_level' ) || get_option( 'course_type_chapter_level' ) || get_option( 'webpage_type_chapter_level' ) ) {
				echo $pmdt_GS->pmdt_get_book_cw_metatags( "chapter" );
			}
			if ( get_option( 'course_type_chapter_level' ) ) {
				echo $pmdt_GS->pmdt_get_course_metatags( "chapter" );
			}
			if ( get_option( 'webpage_type_chapter_level' ) ) {
				echo $pmdt_GS->pmdt_get_webpage_metatags( "chapter" );
			}
		}
	}

	/* ------------------------------------------------------------------- *
	 * Functions for the Settings Page
	 * ------------------------------------------------------------------- */

	/**
	 * Render the options page for plugin.
	 *
	 * @since  0.8.1
	 */
	public function pmdt_display_options_page() {
		include_once 'partials/pressbooks-metadata-admin-display.php';
	}

	/**
	 * Add an options page under the Settings submenu.
	 *
	 * @since  0.8.1
	 */
	public function pmdt_add_options_page() {

		$this->plugin_screen_hook_suffix =
			add_options_page(
				__( 'Pressbooks Metadata Settings', 'pressbooks-metadata' ),
				__( 'PB Metadata', 'pressbooks-metadata' ),
				'manage_options',
				$this->plugin_name . '_options_page',
				array( $this, 'pmdt_display_options_page' )
			);
	}

	/**
	 * Adding sections with fields in the options page using the class section.
	 *
	 * @since  0.8.1
	 */
	public function pmdt_register_setting() {

		//Every setting you create can be accesed using the example here
		//book_type -> This is the id of a field in the array below
		//book_level -> This is the section id that this fields exists
		//if you add them together with a '_' you have the setting -> book_type_book_level
		$metaValues = array(
			'book_type'    => array( 'Book Type', 'http://schema.org/Book' ),
			'course_type'  => array( 'Course Type', 'http://schema.org/Course' ),
			'webpage_type' => array( 'Webpage Type', 'http://schema.org/WebPage' ),
			'educational_info' => array('Educational Information','')
		);

		new Pressbooks_Metadata_Sections(
			'book_level',
			'Book Level',
			$this->plugin_name . '_options_page',
			$metaValues
		);

		new Pressbooks_Metadata_Sections(
			'chapter_level',
			'Chapter Level',
			$this->plugin_name . '_options_page',
			$metaValues
		);
	}

	/* ------------------------------------------------------------------- *
    * Metaboxes for the schema types in certain pages
    * ------------------------------------------------------------------- */

	/**
	 * Adding metaboxes with fields in the desired pages.
	 *
	 * @since  0.8.1
	 */
	public function pmdt_place_metaboxes() {
		//Use the string parameter 'metabox' ->PB BOOK INFO LEVEL or 'chapter' -> PB CHAPTER LEVEL to make the metaboxes appear

		if ( get_option( 'book_type_book_level' ) ) {
			new Pressbooks_Metadata_Metabox_Book( 'metadata' );
			new Pressbooks_Metadata_Metabox_Creative_Work( 'metadata' );
		}

		if ( get_option( 'book_type_chapter_level' ) ) {
			new Pressbooks_Metadata_Metabox_Book( 'chapter' );
			new Pressbooks_Metadata_Metabox_Creative_Work( 'chapter' );
		}

		if ( get_option( 'webpage_type_book_level' ) ) {
			new Pressbooks_Metadata_Metabox_WebPage( 'metadata' );
			new Pressbooks_Metadata_Metabox_Creative_Work( 'metadata' );
		}

		if ( get_option( 'webpage_type_chapter_level' ) ) {
			new Pressbooks_Metadata_Metabox_WebPage( 'chapter' );
			new Pressbooks_Metadata_Metabox_Creative_Work( 'chapter' );
		}

		if ( get_option( 'course_type_book_level' ) ) {
			new Pressbooks_Metadata_Metabox_Course( 'metadata' );
			new Pressbooks_Metadata_Metabox_Creative_Work( 'metadata' );
		}

		if ( get_option( 'course_type_chapter_level' ) ) {
			new Pressbooks_Metadata_Metabox_Course( 'chapter' );
			new Pressbooks_Metadata_Metabox_Creative_Work( 'chapter' );
		}

		if(get_option('educational_info_book_level')){
			new Pressbooks_Metadata_Metabox_Educational('metadata');
		}
	}

	/**
	 * Passing all the new custom metafields of the CPT chapter to pressbooks so they can be exported and imported normally
	 *
	 * @since  0.x
	 */
	function pmdt_import_fields($additionalFields){

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