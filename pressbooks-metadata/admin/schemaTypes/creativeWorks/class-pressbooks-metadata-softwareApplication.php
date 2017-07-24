<?php

namespace schemaTypes\cw;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;

/**
 * The class for the Software Application type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Software_Application{

	/**
	 * The type level where these metaboxes and their schema operations will go
	 *
	 * @since    0.x
	 * @access   private
	 */
	private $type_level;

	/**
	 * The name of the class along with the type_level
	 * Used to identify each type differently so we can eliminate parent types not needed
	 *
	 * @since    0.9
	 * @access   public
	 */
	public $class_name;

	public function __construct($type_level_input) {
		$this->type_level = $type_level_input;
		$this->pmdt_add_metabox($this->type_level);
		$this->class_name = __CLASS__ .'_'. $this->type_level;
	}

	/**
	 * The function which produces the metaboxes for the software application type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position){
		//----------- metabox ----------- //
		x_add_metadata_group( 	'software-application', $meta_position, array(
			'label' 		=>	'Software Application Properties',
			'priority' 		=>	'high',
		) );
		//----------- metafields ----------- //
		// Application Category
		x_add_metadata_field( 	'pb_application_category_'.$meta_position, $meta_position, array(
			'group' 		=>	'software-application',
			'label' 		=>	'Application Category',
			'description'	=>	'Type of software application, e.g. Game, Multimedia.',
		) );
		// Application Sub Category
		x_add_metadata_field( 	'pb_application_subcategory_'.$meta_position, $meta_position, array(
			'group' 		=>	'software-application',
			'label' 		=>	'Application Subcategory',
			'description'	=>	'Subcategory of the application, e.g. Arcade Game.',
		) );
		// Application Suite
		x_add_metadata_field( 	'pb_application_suite_'.$meta_position, $meta_position, array(
			'group' 		=>	'software-application',
			'label' 		=>	'Application Suite',
			'description'	=>	'The name of the application suite to which the application belongs (e.g. Excel belongs to Office).',
		) );
		// Available On Device
		x_add_metadata_field( 	'pb_available_on_device_'.$meta_position, $meta_position, array(
			'group' 		=>	'software-application',
			'label' 		=>	'Available on Device',
			'description'	=>	'Device required to run the application. Used in cases where a specific make/model is required to run the application. Supersedes device.',
		) );
		// Countries Not Supported
		x_add_metadata_field( 	'pb_countries_not_supported_'.$meta_position, $meta_position, array(
			'group' 		=>	'software-application',
			'label' 		=>	'Countries Not Supported',
			'description'	=>	'Countries for which the application is not supported. You can also provide the two-letter ISO 3166-1 alpha-2 country code.',
		) );
		// Countries Supported
		x_add_metadata_field( 	'pb_countries_supported_'.$meta_position, $meta_position, array(
			'group' 		=>	'software-application',
			'label' 		=>	'Countries Supported',
			'description'	=>	'Countries for which the application is supported. You can also provide the two-letter ISO 3166-1 alpha-2 country code.',
		) );
		// Download Url
		x_add_metadata_field( 	'pb_download_url_'.$meta_position, $meta_position, array(
			'group' 		=>	'software-application',
			'label' 		=>	'Download Url',
			'description'	=>	'If the file can be downloaded, URL to download the binary.',
		) );
		// Feature List
		x_add_metadata_field( 	'pb_feature_list_'.$meta_position, $meta_position, array(
			'group' 		=>	'software-application',
			'label' 		=>	'Feature List',
			'description'	=>	'Features or modules provided by this application (and possibly required by other applications).',
		) );
		// File Size
		x_add_metadata_field( 	'pb_file_size_'.$meta_position, $meta_position, array(
			'group' 		=>	'software-application',
			'label' 		=>	'File Size',
			'description'	=>	'Size of the application / package (e.g. 18MB). In the absence of a unit (MB, KB etc.), KB will be assumed.',
		) );
		// Install Url
		x_add_metadata_field( 	'pb_install_url_'.$meta_position, $meta_position, array(
			'group' 		=>	'software-application',
			'label' 		=>	'Install Url',
			'description'	=>	'URL at which the app may be installed, if different from the URL of the item.',
		) );
		// Memory Requirements
		x_add_metadata_field( 	'pb_memory_requirements_'.$meta_position, $meta_position, array(
			'group' 		=>	'software-application',
			'label' 		=>	'Memory Requirements',
			'description'	=>	'Minimum memory requirements.',
		) );
		// Operating System
		x_add_metadata_field( 	'pb_operating_system_'.$meta_position, $meta_position, array(
			'group' 		=>	'software-application',
			'label' 		=>	'Operating System',
			'description'	=>	'Operating systems supported (Windows 7, OSX 10.6, Android 1.6).',
		) );
		// Permissions
		x_add_metadata_field( 	'pb_permissions_'.$meta_position, $meta_position, array(
			'group' 		=>	'software-application',
			'label' 		=>	'Permissions',
			'description'	=>	'Permission(s) required to run the app (for example, a mobile app may require full internet access or may run only on wifi).',
		) );
		// Processor Requirements
		x_add_metadata_field( 	'pb_application_category_'.$meta_position, $meta_position, array(
			'group' 		=>	'software-application',
			'label' 		=>	'Processor Requirements',
			'description'	=>	'Processor architecture required to run the application (e.g. IA64).',
		) );
		// Release Notes
		x_add_metadata_field( 	'pb_release_notes_'.$meta_position, $meta_position, array(
			'group' 		=>	'software-application',
			'label' 		=>	'Release Notes',
			'description'	=>	'Description of what changed in this version.',
		) );
		// Screen Shot
		x_add_metadata_field( 	'pb_screen_shot_'.$meta_position, $meta_position, array(
			'group' 		=>	'software-application',
			'label' 		=>	'Screen Shot',
			'description'	=>	'A link to a screenshot image of the app.',
		) );
		// Software AddOn
		x_add_metadata_field( 	'pb_software_addon_'.$meta_position, $meta_position, array(
			'group' 		=>	'software-application',
			'label' 		=>	'Software AddOn',
			'description'	=>	'Additional content for a software application.',
		) );
		// Software Help
		x_add_metadata_field( 	'pb_software_help'.$meta_position, $meta_position, array(
			'group' 		=>	'software-application',
			'label' 		=>	'Software Help',
			'description'	=>	'Software application help.',
		) );
		// Software Requirements 
		x_add_metadata_field( 	'pb_software_requirements_'.$meta_position, $meta_position, array(
			'group' 		=>	'software-application',
			'label' 		=>	'Software Requirements',
			'description'	=>	'Component dependency requirements for application. This includes runtime environments and shared libraries that are not included in the application distribution package, but required to run the application (Examples: DirectX, Java or .NET runtime). Supersedes requirements.',
		) );
		// Software Version 
		x_add_metadata_field( 	'pb_software_version_'.$meta_position, $meta_position, array(
			'group' 		=>	'software-application',
			'label' 		=>	'Software Version',
			'description'	=>	'Version of the software instance.',
		) );
		// Storage Requirements 
		x_add_metadata_field( 	'pb_storage_requirements_'.$meta_position, $meta_position, array(
			'group' 		=>	'software-application',
			'label' 		=>	'Storage Requirements',
			'description'	=>	'Storage requirements (free space required).',
		) );
		// Supporting Data 
		x_add_metadata_field( 	'pb_supporting_data_'.$meta_position, $meta_position, array(
			'group' 		=>	'software-application',
			'label' 		=>	'Supporting Data',
			'description'	=>	'Supporting data for a SoftwareApplication.',
		) );
	}

		/*FUNCTIONS FOR THIS TYPE START HERE*/

	/**
	 * Function used for comparing the instances of the schema types
	 *
	 * @since    0.9
	 * @access   public
	 */
	public function __toString() {
		return $this->class_name;
	}

	/**
	 * Returns the father for the type.
	 *
	 * @since    0.9
	 * @access   public
	 */
	public function pmdt_parent_init(){
		return new Pressbooks_Metadata_Creative_Work($this->type_level);
	}

	/**
	 * Returns type level.
	 *
	 * @since    0.x
	 * @access   public
	 */
	public function pmdt_get_type_level(){
			return $this->type_level;
		}

	/**
	 * A function needed for the array of metadata that comes from each post or chapter
	 * It automatically returns the first item in the array.
	 * @since 0.8.1
	 *
	 */
	private function pmdt_get_first($my_array){
		return $my_array[0];
	}

	/**
	 * A function that creates the metadata for the Software Application type.
	 * @since 0.8.1
	 *
	 */
	public function pmdt_get_metatags() {
		//Distinguishing if we are working on a post --- chapter level or on the main site level
		//The type_level variable is the string we used to create the metabox

		$is_site; // This bool var is used to identify if the level is site level or any other post level
		if ( $this->type_level == 'metadata' || $this->type_level == 'site-meta' ) { //loading the appropriate metadata depending on the type level
			$metadata = gen_func::get_metadata();
			$is_site = true;
		} else {
			$is_site = false;
			$metadata = get_post_meta( get_the_ID() );
		}

		// array of the items needed to become microtags
		$softApp_data = array(

			'applicationCategory' => 'pb_application_category',
			'applicationSubCategory' => 'pb_application_subcategory',
			'applicationSuite' => 'pb_application_suite',
			'availableOnDevice' => 'pb_available_on_device',
			'countriesNotSupported' => 'pb_countries_not_supported',
			'countriesSupported' => 'pb_countries_supported',
			'downloadUrl' => 'pb_download_url',
			'featureList' => 'pb_feature_list',
			'fileSize' => 'pb_file_size',
			'installUrl' => 'pb_install_url',
			'memoryRequirements' => 'pb_memory_requirements',
			'operatingSystem' => 'pb_operating_system',
			'permissions' => 'pb_permissions',
			'processorRequirements' => 'pb_processor_requirements',
			'releaseNotes' => 'pb_release_notes',
			'screenshot' => 'pb_screen_shot',
			'softwareAddOn' => 'pb_software_addon',
			'softwareHelp' => 'pb_software_help',
			'softwareRequirements' => 'pb_software_requirements',
			'softwareVersion' => 'pb_software_version',
			'storageRequirements' => 'pb_storage_requirements',
			'supportingData' => 'pb_supporting_data'
		);

		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/SoftwareApplication">';

		foreach ( $softApp_data as $itemprop => $content ) {
			if ( isset( $metadata[ $content . '_' . $this->type_level ] ) ) {

				if ( !$is_site ) { //we are using the get_first function to get the value from the returned array
					$value = $this->pmdt_get_first( $metadata[ $content . '_' . $this->type_level ] );
				} else {
					if($this->type_level == 'site-meta'){
						$value = $this->pmdt_get_first($metadata[ $content . '_' . $this->type_level ]);
					}else{//We always use the get_first function except if our level is metadata coming from pressbooks
						$value = $metadata[ $content . '_' . $this->type_level ];
					}
				}
				$html .= "<meta itemprop = '" . $itemprop . "' content = '" . $value . "'>\n";
			}
		}
		$html .= '</div>';
		return $html;
	}
}