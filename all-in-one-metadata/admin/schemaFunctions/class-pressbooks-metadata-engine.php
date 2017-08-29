<?php

namespace schemaFunctions;
use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;
use settings\Pressbooks_Metadata_Post_Type_Fields as post_type_fields;
use settings\Pressbooks_Metadata_Sections as sections;
use schemaTypes\Pressbooks_Metadata_Type_Structure as structure;
use schemaFunctions\Pressbooks_Metadata_General_Functions as genFunc;
use vocabularyFunctions;


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

	function __construct() {
	}

	/**
	 * A function for gathering all the schema type settings from types that are filtered through their parent.
	 *
	 * @since  0.10
	 */
	public function get_type_settings() {
		$typeSettings = array();
		$foundChildren = array();
		$allParentsWithChild = genFunc::get_all_parents();
		foreach(genFunc::get_activated_parents() as $parent){
			//TODO IF WITH MANY TYPES THE PERFORMANCE IS DROPPING WE CAN IMPROVE THESE FUNCTIONS (get_all_parents,get_parent_children) from general_functions class
			//This is more complex than it had to be, now we are filtering one parent per time, but this supports filtering with many parents
			//to do this we need to change the front end interface, checkboxes are being used so its easier to modify for multiple parent selection
			if(isset($allParentsWithChild[$parent])){
				$foundChildren = array_merge($foundChildren,$allParentsWithChild[$parent]);
			}
		}
		$foundChildren = array_unique($foundChildren);
		foreach($foundChildren as $child){
			$typeSettings = array_merge($typeSettings,$child::$type_setting);
		}
		return $typeSettings;
	}

	/**
	 * Adding metaboxes with fields in the desired pages.
	 *
	 * @since  0.8.1
	 */
	public function place_metaboxes() {
		//All the instances created by the engine_run function - automatically create their metaboxes
		//This is for the schema types
		$this->engine_run();

		//Here we generate metaboxes for the other vocabularies
		$vocabularySettings = array(
			'coins_checkbox' => 'vocabularyFunctions\Pressbooks_Metadata_Coins',
			'dublin_checkbox' => 'vocabularyFunctions\Pressbooks_Metadata_Dublin',
			//'educational_checkbox' => 'vocabularyFunctions\Pressbooks_Metadata_Educational'
		);

		foreach($vocabularySettings as $setting => $class){
			if(get_option($setting)){
				new $class;
			}
		}

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

		//Coins Level
		$coinsLevelSection = "coinsLevelSection";
		$coinsLevelPage = "coins_level_tab";

		//Dublin Level
		$dublinLevelSection = "dublinLevelSection";
		$dublinLevelPage = "dublin_level_tab";

		//Educational Level
		$educationalLevelSection = "educationalLevelSection";
		$educationalLevelPage = "educational_level_tab";

		//Creating sections for the external vocabularies
		add_settings_section($coinsLevelSection, "Enable Coins Metadata", null, $coinsLevelPage);
		add_settings_section($dublinLevelSection, "Enable Dublin Core Metadata", null, $dublinLevelPage);
		add_settings_section($educationalLevelSection, "Enable Educational Metadata", null, $educationalLevelPage);


		new post_type_fields('coins_checkbox','Coins Metadata',$coinsLevelPage,$coinsLevelSection);
		new post_type_fields('dublin_checkbox','Dublin Core Metadata',$dublinLevelPage,$dublinLevelSection);
		new post_type_fields('educational_checkbox','Educational Metadata',$educationalLevelPage,$educationalLevelSection);

		//Creating settings for filtering the schemaTypes that show
		$parentsSection = 'parents_section';
		$parentsDisplayPage = 'parents_display_page';

		add_settings_section(
			$parentsSection,
			'',
			function(){},
			$parentsDisplayPage
		);

		foreach(structure::$allParents as $parent){
			$parentDetails = $parent::type_name;
			//Not allowing the thing filter to show
			if($parentDetails[1] == 'thing_properties')
				continue;
			add_settings_field(
				$parentDetails[1].'_filter_setting',
				'',
				function() use ($parentDetails) {
					//TODO IN THE FUTURE RADIO BUTTONS CAN BE USED -> LESS JAVASCRIPT
					$fieldId = $parentDetails[1].'_filter_setting';
					$selectedColor = get_option($fieldId)?'style="color:blue"':'';
					$html = '<input class="parent-filters-settings" style="display:none" type="checkbox" id="'.$fieldId.'" name="'.$fieldId.'" value="1" ' . checked(1, get_option($fieldId), false) . '/>';
					$html .= '<span> | </span><a class="parent-filters" '.$selectedColor.' href="#" id="'.$fieldId.'">'.str_replace('Properties','',$parentDetails[0]).'</a><span> | </span>';
					echo $html;
					},
				$parentsDisplayPage,
				$parentsSection
			);
			register_setting( $parentsDisplayPage, $parentDetails[1].'_filter_setting');
		}

		//Creating another section with the fields automatically created for the schema types
		foreach($allPostTypes as $post_type){
			if(get_option($post_type.'_checkbox')){
				sections::types(
					$post_type.'_level',
					ucfirst($post_type.' Level'),
					$post_type.'_tab',
					$this->get_type_settings()
				);

				foreach(structure::$allSchemaTypes as $type){
					$type_id = $this->get_type_id($type);
					$sectionId = $type_id.'_'.$post_type.'_level';
					$type_properties = $type::$type_properties;
					sections::properties(
						$sectionId,
						'',
						$sectionId.'_properties',
						$type_properties
				);

					//Getting parent information and creating the parent properties
					//For each type on each level
					foreach($type::$type_parents as $parent){
						sections::properties(
							$sectionId,
							$parent::type_name[0],
							$sectionId.'_'.$parent::type_name[1].'_dis',
							$parent::type_properties
						);
					}
				}
			}
		}
	}

	/**
	 * Function used to extract the name of the type from its settings
	 * @since  0.10
	 */
	private function get_type_id($type) {
		foreach($type::$type_setting as $typeId => $details) {
			return $typeId;
		}
	}

	/**
	 * Function used to remove null values from an array
	 * @since  0.10
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
		//Overwriting all selected values to chapter or post
		$overwriteEngine = new Pressbooks_Metadata_Property_Overwrite();
		$overwriteEngine->do_overwrite();

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

		//Removing null instances
		$instances = $this->remove_null($instances);

		//Then we clear duplicates from the instances, this is older code from a different implementation but we keep it just in case something goes wrong
		$instances = array_unique($instances);

		return $instances;
	}
}

