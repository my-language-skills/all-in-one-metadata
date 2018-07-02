<?php

namespace schemaFunctions;
use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;
use settings\Pressbooks_Metadata_Post_Type_Fields as post_type_fields;
use settings\Pressbooks_Metadata_Sections as sections;
use schemaTypes\Pressbooks_Metadata_Type_Structure as structure;
use schemaFunctions\Pressbooks_Metadata_General_Functions as genFunc;
use settings\Pressbooks_Metadata_Location_Fields as location_fields;
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
 * @author     Christos Amyrotos @MashRoofa
 * @author     Daniil Zhitnitskii @danzhik
 */

class Pressbooks_Metadata_Engine {

	function __construct() {
	}

	/**
	 * A function for gathering all the schema type settings from types that are filtered through their parent.
	 *
	 * @since  0.13
	 */
	public function get_type_settings() {
		$activeParent = genFunc::get_active_parent();
		$typeSettings = array();
		foreach(structure::$allSchemaTypes as $type){
			if(in_array($activeParent,$type::$type_parents)){
				$typeSettings = array_merge($typeSettings,$type::$type_setting);
			}
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

        //Creating prefixes for fields for external vocabularies options
        $postLevel = site_cpt::pressbooks_identify() ? 'chapter' : 'post';
        $siteLevel = site_cpt::pressbooks_identify() ? 'metadata' : 'site-meta';

        //Here we generate metaboxes for the other vocabularies
		$vocabularySettings = array(
			'coins_checkbox' => 'vocabularyFunctions\Pressbooks_Metadata_Coins',
			'dublin_checkbox' => 'vocabularyFunctions\Pressbooks_Metadata_Dublin'
		);

		foreach($vocabularySettings as $setting => $class){
			if(get_option($setting)){
				new $class;
			}
		}

		//Enabling Educational Vocabulary on each level
		if(get_option('educational_checkbox_'.$siteLevel)){
		    new vocabularyFunctions\Pressbooks_Metadata_Educational($siteLevel);
        }

        if(get_option('educational_checkbox_'.$postLevel)){
            new vocabularyFunctions\Pressbooks_Metadata_Educational($postLevel);
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

		//General settings
		$generalSettSection = "generalSettingsSection";
		$generalSettPage = "general_settings_page";

		//Registering the general settings for the general settings metabox
		//add_settings_section($generalSettSection, "Metadata Output Type", null, $generalSettPage);
		//new post_type_fields('jsonld_output','Enable Jsonld',$generalSettPage,$generalSettSection);

		//Post Level
		$postLevelSection = "locationLevelsSection";
		$postLevelPage = "location_levels_tab";
		$siteLevelSection = "siteLevelSection";

		add_settings_section($postLevelSection, __("Choose On Which Post Types You Want to Display Schemas", 'all-in-one-metadata'), null, $postLevelPage);
		add_settings_section($siteLevelSection, __("Choose If You Want To Display Schemas On The Site Level", 'all-in-one-metadata'), null, $postLevelPage);


		//Gathering post types
		$allPostTypes = $this->get_all_post_types();

		$post_type = site_cpt::pressbooks_identify() ? 'metadata' : 'site-meta';

		if(is_multisite()) {
			//Network Control Section
			$networkFreezeSection = "networkFreezeSection";

			//Creating the section for network freezing option
			add_settings_section($networkFreezeSection, __("Network Administrator right to rewrite Site-Meta", 'all-in-one-metadata'), null, $generalSettPage);
			//Create checkbox for option
			new post_type_fields($post_type . '_saoverwr', __('Allow', 'all-in-one-metadata'), $generalSettPage, $networkFreezeSection);
		}

		//Gathering post types
		$allPostTypes = $this->get_all_post_types();

		//Registering locations option
		register_setting($postLevelPage, 'schema_locations');
		//Creating fields for each section of locations
		foreach($allPostTypes as $post_type){
			if($post_type == 'metadata' || $post_type == 'site-meta'){
				new post_type_fields($post_type.'_checkbox',ucfirst($post_type),$postLevelPage,$siteLevelSection);
			}else{
				new location_fields($post_type,ucfirst($post_type),$postLevelPage,$postLevelSection);
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
		add_settings_section($coinsLevelSection, __("Enable Coins Metadata", 'all-in-one-metadata'), null, $coinsLevelPage);
		add_settings_section($dublinLevelSection, __("Enable Dublin Core Metadata", 'all-in-one-metadata'), null, $dublinLevelPage);
		add_settings_section($educationalLevelSection, __("Enable Educational Metadata", 'all-in-one-metadata'), null, $educationalLevelPage);

		//Creating prefixes for fields for external vocabularies
        $postLevel = site_cpt::pressbooks_identify() ? 'chapter' : 'post';
        $siteLevel = site_cpt::pressbooks_identify() ? 'metadata' : 'site-meta';


		//Vocabularies for Book Info and Site Meta
		new post_type_fields('coins_checkbox',__('Coins Metadata', 'all-in-one-metadata'),$coinsLevelPage,$coinsLevelSection);
		new post_type_fields('dublin_checkbox',__('Dublin Core Metadata', 'all-in-one-metadata'),$dublinLevelPage,$dublinLevelSection);
		new post_type_fields('educational_checkbox_'.$siteLevel,__('Educational Metadata Site Level', 'all-in-one-metadata'),$educationalLevelPage,$educationalLevelSection);

		//Educational Vocabulary for Chapters and Posts
        new post_type_fields('educational_checkbox_'.$postLevel,__('Educational Metadata ', 'all-in-one-metadata').ucfirst($postLevel),$educationalLevelPage,$educationalLevelSection);

		//Registering a setting for the parents filtering
		register_setting('parent_filter_group', 'parent_filter_settings');

		//Getting type settings
		$typeSettings = $this->get_type_settings();


		//Creating another section with the fields automatically created for the schema types
		foreach($this->get_enabled_levels() as $post_type){

			//registering accumulated setting for schema types activated per parent type and per post type
			register_setting($post_type.'_type_tab', $post_type.'_'.genFunc::get_active_parent());
			$accumulatedOption = get_option($post_type.'_'.genFunc::get_active_parent());
			sections::types(
				'types_settings',
				__('Manage Schema Types', 'all-in-one-metadata'),
				$post_type.'_type_tab',
				$typeSettings
			);

			foreach(structure::$allSchemaTypes as $type){
				//register setting for native properties
				$type_id = genFunc::get_type_id($type);
				$sectionId = $type_id.'_'.$post_type.'_level';
				register_setting($sectionId.'_properties', 'schema_properties_'.$sectionId);
				//Here we are proceeding to the next loop iteration if the type is not active
				//With this we are only registering properties for active types
				if(!(isset($accumulatedOption[$type_id]) ? ($accumulatedOption[$type_id] == 1 ? 1 : 0): 0)){
					continue;}$type_properties = $type::$type_properties;
				sections::properties(
					$sectionId,
					'',
					$sectionId.'_properties',
					$type_properties,
					false );
				//Getting parent information and creating the parent properties
				//For each type on each level
				foreach($type::$type_parents as $parent){
					//register setting for parent properties of a type
					register_setting($sectionId.'_'.$parent::type_name[1].'_dis', $sectionId.'_'.$parent::type_name[1].'_dis');
					sections::properties(
						$sectionId,
						'',
						$sectionId.'_'.$parent::type_name[1].'_dis',
						$parent::type_properties,
						$type::$required_parent_props
					);
				}
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

		//get general option for locations
		$option = get_option('schema_locations');

		//The loop checks if the setting is enabled and then stores the activated post in the level array
		foreach($postTypes as $post_type){
			if((isset($option[$post_type]) && $option[$post_type] == 1) || get_option($post_type.'_checkbox')) {
				$schemaPostLevels []= $post_type;
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
			//getting general option for schema types
			$optionsSchemaTypesOrganization = get_option( $level.'_schemaTypes\Pressbooks_Metadata_Organization') ?: [];
			$optionsSchemaTypesCreative = get_option($level.'_schemaTypes\Pressbooks_Metadata_CreativeWork') ?: [];
			$optionsSchemaTypes = array_merge($optionsSchemaTypesOrganization, $optionsSchemaTypesCreative);

			//Getting the setting for a type - book etc.
			foreach (structure::$allSchemaTypes as $type){
				$typeId = genFunc::get_type_id($type);
					//Checking the settings for each level and type together and we create instances for the active types on each level
					if(isset($optionsSchemaTypes[$typeId]) && $optionsSchemaTypes[$typeId] == 1){
						//We use the name of the post excluding the _level part so we can create instances for each post type and its enabled schema types
						$instances []= new $type($level);
					}
			}
		}

		//Removing null instances
		$instances = genFunc::remove_null($instances);

		//Then we clear duplicates from the instances, this is older code from a different implementation but we keep it just in case something goes wrong
		$instances = array_unique($instances);
		return $instances;

	}
}

