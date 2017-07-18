<?php

namespace schemaFunctions;
use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;
use settings\Pressbooks_Metadata_Post_Type_Fields as post_type_fields;
use settings\Pressbooks_Metadata_Sections as sections;

/**
 * Function used to return all instances for the selected schema types in the settings,
 * Instances are used to create the metaboxes and the metadata. Here we also create the
 * sections and fields for the settings page of the plugin
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaFunctions
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Engine {

	/**
	 * Variable for creating settings
	 * Variable also used when creating type instances.
	 * @since    0.9
	 *
	 */
	private $metaSettings;

	function __construct() {
		//Use this array to create new settings for new types that you add
		//Every setting you create can be accessed using the example here
		//book_type -> This is the id of a field in the array below
		//book_level -> This is the section id that this fields exists
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
	 * Adding metaboxes with fields in the desired pages.
	 *
	 * @since  0.8.1
	 */
	public function place_metaboxes() {
		//All the instances created by the engine_run function - automatically create their metaboxes
		$this->engine_run();
	}

	/**
	 * Returning available post types. The post types we receive are different depending
	 * whether pressbooks is installed or not
	 *
	 * @since  0.9
	 */
	public static function get_all_post_types(){
		//Gathering the post types that are public including the wordpress ones if pressbooks is disabled
		if(!site_cpt::pressbooks_identify()){
			$postTypes = array_keys( get_post_types( array( 'public' => true )) );
		}else{
			$postTypes = array_keys( get_post_types( array( 'public' => true,'_builtin' => false )) );
		}
		return $postTypes;
	}

	/**
	 * Adding sections with fields in the options page using the class section.
	 *
	 * @since  0.8.1
	 */
	public function register_settings() {

		//Setting section name and page
		$section = "postTypeSection";
		$page = "post_options_page";

		//Creating the section
		add_settings_section($section, "Choose Post Types For Metadata Manipulation", null, $page);

		//Gathering post types
		$postTypes = $this->get_all_post_types();

		//Creating fields for the section
		foreach($postTypes as $post_type){
			new post_type_fields($post_type.'_checkbox',ucfirst($post_type),$page,$section);
		}

		//Creating another section with the fields automatically created for the schema types
		foreach($postTypes as $post_type){
			if(get_option($post_type.'_checkbox')){
				new sections(
					$post_type.'_level',
					ucfirst($post_type.' Level'),
					'meta_options_page',
					$this->metaSettings
				);
			}
		}
	}

	/**
	 * Function used to return all post types or 'levels' that are active from the settings
	 * Under the Post Levels Tab
	 * @since  0.9
	 */
	public static function get_enabled_levels(){

		//Getting all the post types
		$postTypes = self::get_all_post_types();

		//This array is needed for the levels that we show different schema types, like chapter and metadata
		$schemaPostLevels = array();

		//The loop checks if the setting is enabled and then stores the activated post in the level array
		foreach($postTypes as $post_type){
			if(get_option($post_type.'_checkbox')) {
				$schemaPostLevels []= $post_type.'_level';
			}
		}
		return $schemaPostLevels;
	}

	/**
	 * Function used to return all instances for the selected types,
	 * Instances are used to create the metaboxes and the metadata
	 * For every new type that we add we need to make modifications here
	 *
	 * @since  0.9
	 */
	public function engine_run(){

		//Getting all active post levels
		$schemaPostLevels = $this->get_enabled_levels();

		//This array will be filled up with instances of the active types, then it will be returned for processing
		$instances = array();

		foreach ($schemaPostLevels as $level) {
			foreach ($this->metaSettings as $type => $link){

				//Checking the settings for each level and we create instances for the active types
				if(get_option($type.'_'.$level)){
					//We use the name of the post excluding the _level part so we can create instances for each post type and its enabled schema types
					$cpt = str_replace("_level","",$level);
					switch($type){

						case 'book_type':
							$instances[] = new \schemaTypes\Pressbooks_Metadata_Book($cpt);
							break;

						case 'course_type':
							$instances[] = new \schemaTypes\Pressbooks_Metadata_Course($cpt);
							break;

						case 'webpage_type':
							$instances[] = new \schemaTypes\Pressbooks_Metadata_WebPage($cpt);
							break;

						case 'educational_info':
							//Educational information only appears on the site level schema
							if($cpt == 'metadata' || $cpt == 'site-meta'){
								$instances[] = new \schemaTypes\Pressbooks_Metadata_Educational($cpt);
							}
							break;
					}

				}
			}
		}
		//Here we create a parent for each type if one exists
		foreach($instances as $instance){
			$instances []= $instance->pmdt_parent_init();
		}

		//Then we clear duplicates from the instances
		//For example book and webpage have both creative works as parent, so we keep only one
		$instances = array_unique($instances);

		//Removing Null Values in case we spot any
		$cleanInstances = array();
		foreach($instances as $instance){
			if($instance != NULL){
				$cleanInstances[]=$instance;
			}
		}
		return $cleanInstances;
	}
}

