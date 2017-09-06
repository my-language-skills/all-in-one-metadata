<?php

namespace schemaTypes\cw;
use schemaTypes;
use schemaTypes\Pressbooks_Metadata_Type;

/**
 * The class for the softwareApplication
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 * @author    Corentin Perrot <perrotcore@gmail.com>
 */

class Pressbooks_Metadata_SoftwareApplication extends Pressbooks_Metadata_Type {

    /**
     * The variable that holds all parent required properties
     *
     * @since    0.x
     * @access   public
     */
    static $required_parent_props = array(

    );

	/**
	 * The variable that holds the values for the settings for this schema type
	 *
	 * @since    0.x
	 * @access   public
	 */
	static $type_setting = array('softwareApplication_type' => array('SoftwareApplication Type','http://schema.org/SoftwareApplication'));

	/**
	 * The variable that holds the parents for the type
	 *
	 * @since    0.x
	 * @access   public
	 */
	static $type_parents = array(
		'schemaTypes\Pressbooks_Metadata_Thing',
		'schemaTypes\Pressbooks_Metadata_CreativeWork'
	);

	/**
	 * The variable that holds the properties of this schema type
	 *
	 * @since    0.x
	 * @access   public
	 */
	static $type_properties = array(
		'applicationCategory' => array(false,'Application Category','Type of software application, e.g. \'Game, Multimedia\'.'),
		'applicationSubCategory' => array(false,'Application SubCategory','Subcategory of the application, e.g. \'Arcade Game\'.'),
		'applicationSuite' => array(false,'Application Suite','The name of the application suite to which the application belongs (e.g. Excel belongs to Office).'),
		'availableOnDevice' => array(false,'Available On Device','Device required to run the application. Used in cases where a specific make/model is required to run the application. Supersedes device.'),
		'countriesNotSupported' => array(false,'Countries Not Supported','Countries for which the application is not supported. You can also provide the two-letter ISO 3166-1 alpha-2 country code.'),
		'countriesSupported' => array(false,'Countries Supported','Countries for which the application is supported. You can also provide the two-letter ISO 3166-1 alpha-2 country code.'),
		'downloadUrl' => array(false,'Download URL','If the file can be downloaded, URL to download the binary.'),
		'featureList' => array(false,'Feature List','Features or modules provided by this application (and possibly required by other applications).'),
		'fileSize' => array(false,'File Size','Size of the application / package (e.g. 18MB). In the absence of a unit (MB, KB etc.), KB will be assumed.'),
		'installUrl' => array(false,'Install URL','URL at which the app may be installed, if different from the URL of the item.'),
		'memoryRequirements' => array(false,'Memory Requirements','Minimum memory requirements.'),
		'operatingSystem' => array(false,'Operating System','Operating systems supported (Windows 7, OSX 10.6, Android 1.6).'),
		'permissions' => array(false,'Permissions','	Permission(s) required to run the app (for example, a mobile app may require full internet access or may run only on wifi).'),
		'processorRequirements' => array(false,'Processor Requirements','Processor architecture required to run the application (e.g. IA64).'),
		'releaseNotes' => array(false,'Release Notes','Description of what changed in this version.'),
		'screenshot' => array(false,'Screenshot','A link to a screenshot image of the app.'),
		'softwareAddOn' => array(false,'Software Add On','Additional content for a software application.'),
		'softwareHelp' => array(false,'Software Help','Software application help.'),
		'softwareRequirements' => array(false,'Software Requirements','Component dependency requirements for application. This includes runtime environments and shared libraries that are not included in the application distribution package, but required to run the application (Examples: DirectX, Java or .NET runtime). Supersedes requirements.'),
		'softwareVersion' => array(false,'Software Version','Version of the software instance.'),
		'storageRequirements' => array(false,'Storage Requirements','Storage requirements (free space required).'),
		'supportingData' => array(false,'Supporting Data','	Supporting data for a SoftwareApplication.')
	);

	public function __construct($type_level_input) {
		parent::__construct($type_level_input);
		$this->type_fields = $this->get_all_properties();
		$this->class_name = __CLASS__ .'_'. $this->type_level;
		$this->pmdt_populate_names(self::$type_setting);
		$this->pmdt_add_metabox($this->type_level);
	}

	/**
	 * Function used for combining the current types properties with its parents fields
	 *
	 * @since    0.x
	 * @access   public
	 */
	public function get_all_properties() {
		$properties = self::$type_properties;
		foreach(self::$type_parents as $parentType){
			$properties = array_merge($properties,$parentType::type_properties);
		}
		return $properties;
	}

	/**
	 * Function used for comparing the instances of the schema types
	 *
	 * @since    0.x
	 * @access   public
	 */
	public function __toString() {
		return $this->class_name;
	}
}
