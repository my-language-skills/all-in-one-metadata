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
 * @author     Christos Amyrotos <christosv2@hotmail.com>
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
		add_settings_section($generalSettSection, "Metadata Output Type", null, $generalSettPage);
		new post_type_fields('jsonld_output','Enable Jsonld',$generalSettPage,$generalSettSection);

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
		add_settings_section($multiLevelSection, "Choose If You Want To Provide Control to Superadmin ", null, $multiLevelPage);

		//Gathering post types
		$allPostTypes = $this->get_all_post_types();

		//registring locations option
		register_setting($postLevelPage, 'schema_locations');

		//Creating fields for each section of locations
		foreach($allPostTypes as $post_type){
			if($post_type == 'metadata' || $post_type == 'site-meta'){
				new post_type_fields($post_type.'_checkbox',ucfirst($post_type),$siteLevelPage,$siteLevelSection);

				if(is_multisite()) {
                    new post_type_fields($post_type . '_saoverwr', 'Allow Overwrite', $multiLevelPage, $multiLevelSection);
                }
			}else{
				new location_fields($post_type.'_checkbox',ucfirst($post_type),$postLevelPage,$postLevelSection);

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

		//Creating prefixes for fields for external vocabularies
        $postLevel = site_cpt::pressbooks_identify() ? 'chapter' : 'post';
        $siteLevel = site_cpt::pressbooks_identify() ? 'metadata' : 'site-meta';


		//Vocabularies for Book Info and Site Meta
		new post_type_fields('coins_checkbox','Coins Metadata',$coinsLevelPage,$coinsLevelSection);
		new post_type_fields('dublin_checkbox','Dublin Core Metadata',$dublinLevelPage,$dublinLevelSection);
		new post_type_fields('educational_checkbox_'.$siteLevel,'Educational Metadata Site Level',$educationalLevelPage,$educationalLevelSection);

		//Educational Vocabulary for Chapters and Posts
        new post_type_fields('educational_checkbox_'.$postLevel,'Educational Metadata '.ucfirst($postLevel),$educationalLevelPage,$educationalLevelSection);

		//Registering a setting for the parents filtering
		register_setting('parent_filter_group', 'parent_filter_settings');

		//Getting type settings
		$typeSettings = $this->get_type_settings();

		//get general option for locations
		$option = get_option('schema_locations');

		//Creating another section with the fields automatically created for the schema types
		foreach($allPostTypes as $post_type){
			if((isset($option[$post_type.'_checkbox']) && $option[$post_type.'_checkbox'] == 1) || get_option($post_type.'_checkbox') ){
				//registering accumulated setting for schema types activated per parent type and per post type
				register_setting($post_type.'_tab', 'schema_types_'.$post_type.'_level_'.genFunc::get_active_parent());
				$accumulatedOption = get_option('schema_types_'.$post_type.'_level_'.genFunc::get_active_parent());
				sections::types(
					$post_type.'_level',
					ucfirst($post_type.' Level'),
					$post_type.'_tab',
					$typeSettings
				);
				foreach(structure::$allSchemaTypes as $type){
					$type_id = genFunc::get_type_id($type);
					$sectionId = $type_id.'_'.$post_type.'_level';
					register_setting($sectionId.'_properties', 'schema_properties_'.$sectionId);
					//Here we are proceeding to the next loop iteration if the type is not active
					//With this we are only registering properties for active types
					if(!(isset($accumulatedOption[$type_id.'_'.$post_type.'_level']) ? ($accumulatedOption[$type_id.'_'.$post_type.'_level'] == 1 ? 1 : 0): 0)){
						continue;
					}
					$type_properties = $type::$type_properties;
					sections::properties(
						$sectionId,
						'',
						$sectionId.'_properties',
						$type_properties,
                        false
				);

					//Getting parent information and creating the parent properties
					//For each type on each level
					foreach($type::$type_parents as $parent){
						sections::properties(
							$sectionId,
							str_replace('Thing','General',$parent::type_name[0]),
							$sectionId.'_'.$parent::type_name[1].'_dis',
							$parent::type_properties,
                            $type::$required_parent_props
						);
					}
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
			if((isset($option[$post_type.'_checkbox']) && $option[$post_type.'_checkbox'] == 1) || get_option($post_type.'_checkbox')) {
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
			//getting general option for schema types
			$optionsSchemaTypesOrganization = get_option('schema_types_'.$level.'_'.'schemaTypes\Pressbooks_Metadata_Organization');
			$optionsSchemaTypesCreative = get_option('schema_types_'.$level.'_'.'schemaTypes\Pressbooks_Metadata_CreativeWork');
			$optionsSchemaTypes = array_merge($optionsSchemaTypesOrganization, $optionsSchemaTypesCreative);

			//Getting the setting for a type - book etc.
			foreach (structure::$allSchemaTypes as $type){
				$typeId = genFunc::get_type_id($type);
					//Checking the settings for each level and type together and we create instances for the active types on each level
					if(isset($optionsSchemaTypes[$typeId.'_'.$level]) && $optionsSchemaTypes[$typeId.'_'.$level] == 1){
						//We use the name of the post excluding the _level part so we can create instances for each post type and its enabled schema types
						$cpt = str_replace("_level","",$level);
						$instances []= new $type($cpt);
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

