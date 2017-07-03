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

//Constant for including files
define( 'MY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

//Including the settings
require_once plugin_dir_path( __FILE__ )
             . '../admin/settings/class-pressbooks-metadata-sections.php';

//These two foreach loops include all files that exist in a directory
//Types
foreach(glob(MY_PLUGIN_DIR . 'schemaTypes/*.php' ) as $file) {
	include_once $file;
}

//Other Functions
foreach(glob(MY_PLUGIN_DIR . 'schemaFunctions/*.php' ) as $file) {
	include_once $file;
}


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
	 * Stores values for creating the settings page.
	 *
	 * @since    0.x
	 *
	 */
	private $metaSettings;

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

		//Every setting you create can be accessed using the example here
		//book_type -> This is the id of a field in the array below
		//book_level -> This is the section id that this fields exists (we have 2 sections for now BOOK AND CHAPTER)
		//if you add them together with a '_' you have the setting -> book_type_book_level
		//Use get_option() to get the value from the database (Process is Automatic)
		$this->metaSettings =
			array(
				//For every new type we add we need to add the settings here, url can be empty
			'book_type'    => array( 'Book Type', 'http://schema.org/Book' ),
			'course_type'  => array( 'Course Type', 'http://schema.org/Course' ),
			'webpage_type' => array( 'Webpage Type', 'http://schema.org/WebPage' ),
			'educational_info' => array('Educational Information','')
		);

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

		$generalFunctions = new Pressbooks_Metadata_General_Functions();

		if ( is_home() ) {
			echo $generalFunctions->pmdt_get_root_level_metatags();
		} elseif ( is_front_page() ) {
			echo $generalFunctions->pmdt_get_googleScholar_metatags();
		}
	}

	/**
	 * Used in the footer of our site
	 *
	 * Here we populate all metadata for the activated types to the footer of our site
	 * @since    0.2
	 */
	public function pmdt_footer_function() {
		$instances = $this->pmdt_engine_run();
		if ( is_front_page() ) {
			//Here we get all the instances of metadata that have to be executed on the Book level - Site level
			foreach ( $instances as $class_instance ) {
				if($class_instance->pmdt_get_type_level() == 'metadata'){
					echo $class_instance->pmdt_get_metatags();
				}
			}
		} elseif ( ! is_home() ) {
			//Here we get all the instances of metadata that have to be executed on the Chapter level
			foreach ( $instances as $class_instance ) {
				if($class_instance->pmdt_get_type_level() == 'chapter'){
					echo $class_instance->pmdt_get_metatags();
				}
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

		//For every new level / custom post type we add we need modifications here

		new Pressbooks_Metadata_Sections(
			'book_level',
			'Book Level',
			$this->plugin_name . '_options_page',
			$this->metaSettings
		);

		new Pressbooks_Metadata_Sections(
			'chapter_level',
			'Chapter Level',
			$this->plugin_name . '_options_page',
			$this->metaSettings
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
		//All the instances created by the pmdt_engine_run function - automatically create their metaboxes
		$this->pmdt_engine_run();
	}

	/* ------------------------------------------------------------------- *
    * Function for Importing to pressbooks
    * ------------------------------------------------------------------- */

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

	/* ------------------------------------------------------------------- *
    * Function for the main engine (metaboxes,metadata) creation
    * ------------------------------------------------------------------- */

	/**
	 * Function used to return all instances for the selected types,
	 * Instances are used to create the metaboxes and the metadata
	 * For every new type that we add we need to make modifications here
	 *
	 * @since  0.x
	 */
	private function pmdt_engine_run(){
		$instances = array();
		$levels = array(
			//For every new level / custom post type we add we need modifications here
			'book_level' => 'metadata',
			'chapter_level' => 'chapter'
		);

		foreach ($levels as $level => $cpt) {
			foreach ($this->metaSettings as $type => $link){

				//Checking the settings for each level and we create instances for the active types
				if(get_option($type.'_'.$level)){
					switch($type){

						case 'book_type':
							$instances[] = new Pressbooks_Metadata_Book($cpt);
							break;

						case 'course_type':
							$instances[] = new Pressbooks_Metadata_Course($cpt);
							break;

						case 'webpage_type':
							$instances[] = new Pressbooks_Metadata_WebPage($cpt);
							break;

						case 'educational_info':
							//Preventing the Educational metadata being created or run on chapter level (for now)
							if($cpt != 'chapter'){
								$instances[] = new Pressbooks_Metadata_Educational($cpt);
							}
							break;
					}

				}

			}
		}
		$instances = $this->pmdt_handle_parent_types($instances);
		return $instances;
	}

	/**
	 * Function used to identify what parent needs to be initiated for the activated types in  each level / cpt
	 *
	 * @since  0.x
	 */
	private function pmdt_handle_parent_types($instances){

		//All classes that have creative work as a parent
		$creativeWorksParent = array(
			'Pressbooks_Metadata_WebPage',
			'Pressbooks_Metadata_Book',
			'Pressbooks_Metadata_Course'
		);

		//Splitting the instances into levels
		$metadata=array(); $chapter=array();

		foreach($instances as $instance){
			if($instance->pmdt_get_type_level() == 'chapter'){
				$chapter[]=$instance;
			}else{
				$metadata[]=$instance;
			}
		}

		//If we encounter any type instance in the metadata level that is associated with creative works we create one instance of creative works
		foreach($metadata as $class){
			if(in_array(get_class($class),$creativeWorksParent)){
				$instances[]=new Pressbooks_Metadata_Creative_Work('metadata');
				break;
			}
		}

		//If we encounter any type instance in the chapter level that is associated with creative works we create one instance of creative works
		foreach($chapter as $class){
			if(in_array(get_class($class),$creativeWorksParent)){
				$instances[]=new Pressbooks_Metadata_Creative_Work('chapter');
				break;
			}
		}

		//Returning the instances with their parents
		return $instances;
	}
}

