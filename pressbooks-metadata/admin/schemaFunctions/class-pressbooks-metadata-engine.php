<?php

namespace schemaFunctions;
use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;
use settings\Pressbooks_Metadata_Post_Type_Fields as post_type_fields;
use settings\Pressbooks_Metadata_Sections as sections;
use schemaTypes\Pressbooks_Metadata_Type_Structure as structure;

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
	private $typeSettings;

	function __construct() {
		$this->get_type_settings();
	}

	/**
	 * A function for gathering all the type settings.
	 *
	 * @since  0.x
	 */
	public function get_type_settings() {
		$this->typeSettings = array();
		foreach(structure::$allSchemaTypes as $type){
			$this->typeSettings = array_merge($this->typeSettings,$type::type_setting);
		}
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
	 * Adding sections with fields in the options page using the settings classes.
	 *
	 * @since  0.8.1
	 */
	public function register_settings() {
		//Post Level
		$postLevelSection = "postLevelSection";
		$postLevelPage = "post_level_tab";

		//Site Level
		$siteLevelSection = "siteLevelSection";
		$siteLevelPage = "site_level_tab";

		//Multisite Level
		$multiLevelSection = "multiLevelSection";
		$multiLevelPage = "multi_level_tab";

		//Creating the sections
		add_settings_section($postLevelSection, "Choose On Which Post Types You Want to Display Schemas", null, $postLevelPage);
		add_settings_section($siteLevelSection, "Choose If You Want To Display Schemas On The Site Level", null, $siteLevelPage);
		add_settings_section($multiLevelSection, "-------MULTISITE-------", null, $multiLevelPage);

		//Gathering post types
		$allPostTypes = $this->get_all_post_types();

		//Creating fields for each section (multisite comming soon)
		foreach($allPostTypes as $post_type){
			if($post_type == 'metadata' || $post_type == 'site-meta'){
				new post_type_fields($post_type.'_checkbox',ucfirst($post_type),$siteLevelPage,$siteLevelSection);
			}else{
				new post_type_fields($post_type.'_checkbox',ucfirst($post_type),$postLevelPage,$postLevelSection);
			}
		}

		//Creating another section with the fields automatically created for the schema types
		foreach($allPostTypes as $post_type){
			if(get_option($post_type.'_checkbox')){
				sections::types(
					$post_type.'_level',
					ucfirst($post_type.' Level'),
					$post_type.'_tab',
					$this->typeSettings
				);

				foreach(structure::$allSchemaTypes as $type){
					$type_id = $this->get_type_id($type);
					$type_name = ucfirst(str_replace('_type','',$type_id));
					$sectionId = $type_id.'_'.$post_type.'_level';
					$type_properties = $type::type_properties;
					sections::properties(
						$sectionId,
						'',
						$sectionId.'_properties',
						$type_properties
				);
				}
			}
		}
	}

	/**
	 * Function used to extract the name of the type from its settings
	 * @since  0.x
	 */
	private function get_type_id($type) {
		foreach($type::type_setting as $typeId => $details) {
			return $typeId;
		}
	}

	/**
	 * Function used to remove null values from an array
	 * @since  0.x
	 */
	private function remove_null($array) {
		$cleanArray = array();
		foreach($array as $item){
			if($item != NULL){
				$cleanArray[]=$item;
			}
		}
		return $cleanArray;
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
		//Getting the level - post etc.
		foreach ($schemaPostLevels as $level) {
			//Getting the setting for a type - book etc.
			foreach (structure::$allSchemaTypes as $type){
				$typeId = $this->get_type_id($type);
					//Checking the settings for each level and type together and we create instances for the active types on each level
					if(get_option($typeId.'_'.$level)){
						//We use the name of the post excluding the _level part so we can create instances for each post type and its enabled schema types
						$cpt = str_replace("_level","",$level);
						$instances []= new $type($cpt);
					}
			}
		}
		//Here we create a parent for each type if one exists
		foreach($instances as $instance){
			$instances []= $instance->pmdt_parent_init();
		}

		//Removing null instances
		$instances = $this->remove_null($instances);

		//We duplicated this so grand children can have their grand parent, TODO we can/have to improve this
		foreach($instances as $instance){
			$instances []= $instance->pmdt_parent_init();
		}

		//Then we clear duplicates from the instances
		//For example book and webpage have both creative works as parent, so we keep only one
		$instances = array_unique($instances);

		//Removing null instances again
		$instances = $this->remove_null($instances);

		return $instances;
	}
}

