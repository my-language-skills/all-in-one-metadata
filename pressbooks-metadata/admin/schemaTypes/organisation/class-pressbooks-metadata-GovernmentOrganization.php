<?php

namespace schemaTypes\organisation;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;

/**
 * The class for the organisation type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_GovernmentOrganization {

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
	 * @since    0.x
	 * @access   public
	 */
	public $class_name;

	public function __construct($type_level_input) {
		$this->type_level = $type_level_input;
		$this->pmdt_add_metabox($this->type_level);
		$this->class_name = __CLASS__ .'_'. $this->type_level;
	}
	/**
	 * The function which produces the metaboxes for the organisation type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position){
		//----------- metabox ----------- //
		x_add_metadata_group(  'GovernmentOrganization', $meta_position, array(
			'label'       => 'Government Organization Type Properties',
			'priority'        => 'high',
		) );
		//----------- metafields ----------- //
		// [schemaprop]
		
		// Area Served
		x_add_metadata_field(  'pb_areaServed_'.$meta_position, $meta_position, array(
			'group'       =>     'GovernmentOrganization',
			'label'       =>     'Area Served',
			'description' => 	'The geographic area where a service or offered item is provided. Supersedes serviceArea.'
		) );
		
		// Duns
		x_add_metadata_field(  'pb_duns_'.$meta_position, $meta_position, array(
			'group'       =>     'GovernmentOrganization',
			'label'       =>     'Duns',
			'description' => 	'The Dun & Bradstreet DUNS number for identifying an organization or business person.'
		) );
		
		// Founding Date
		x_add_metadata_field(  'pb_foundingDate_'.$meta_position, $meta_position, array(
			'group'       =>     'GovernmentOrganization',
			'label'       =>     'Founding Date',
			'description' => 	'The date that this organization was founded.'
		) );
		
		// Global Location Number
		x_add_metadata_field(  'pb_globalLocationNumber_'.$meta_position, $meta_position, array(
			'group'       =>     'GovernmentOrganization',
			'label'       =>     'Global Location Number',
			'description' => 	'The Global Location Number (GLN, sometimes also referred to as International Location Number or ILN) of the respective organization, person, or place. The GLN 					is a 13-digit number used to identify parties and physical locations.'
		) );
		
		// Lei Code
		x_add_metadata_field(  'pb_leiCode_'.$meta_position, $meta_position, array(
			'group'       =>     'GovernmentOrganization',
			'label'       =>     'Lei Code',
			'description' => 	'An organization identifier that uniquely identifies a legal entity as defined in ISO 17442.'
		) );
		
		// Location
		x_add_metadata_field(  'pb_location_'.$meta_position, $meta_position, array(
			'group'       =>     'GovernmentOrganization',
			'label'       =>     'Location',
			'description' => 	'The location of for example where the event is happening, an organization is located, or where an action takes place.'
		) );
		
		// Logo
		x_add_metadata_field(  'pb_logo_'.$meta_position, $meta_position, array(
			'group'       =>     'GovernmentOrganization',
			'label'       =>     'Logo',
			'description' => 	'An associated logo.'
		) );
		
		// Naics
		x_add_metadata_field(  'pb_naics_'.$meta_position, $meta_position, array(
			'group'       =>     'GovernmentOrganization',
			'label'       =>     'Naics',
			'description' => 	'The North American Industry Classification System (NAICS) code for a particular organization or business person.'
		) );
		
		
		// Parent Organization
		x_add_metadata_field(  'pb_parentOrganization_'.$meta_position, $meta_position, array(
			'group'       =>     'GovernmentOrganization',
			'label'       =>     'Parent Organization',
			'description' => 	'The larger organization that this organization is a subOrganization of, if any. Supersedes branchOf.
								<br>Inverse property: subOrganization.'
		) );
		
		
		// Review
		x_add_metadata_field(  'pb_review_'.$meta_position, $meta_position, array(
			'group'       =>     'GovernmentOrganization',
			'label'       =>     'Review',
			'description' => 	'A review of the item. Supersedes reviews.'
		) );
		
		// Sponsor
		x_add_metadata_field(  'pb_sponsor_'.$meta_position, $meta_position, array(
			'group'       =>     'GovernmentOrganization',
			'label'       =>     'Sponsor',
			'description' => 	'A person or organization that supports a thing through a pledge, promise, or financial contribution. e.g. a sponsor of a Medical Study or a corporate sponsor 						of an event.'
		) );
		
		// Sub Organization
		x_add_metadata_field(  'pb_subOrganization_'.$meta_position, $meta_position, array(
			'group'       =>     'GovernmentOrganization',
			'label'       =>     'Sub Organization',
			'description' => 	'A relationship between two organizations where the first includes the second, e.g., as a subsidiary. See also: the more specific \'department\' property.
								<br>Inverse property: parentOrganization.'
		) );
			
		// Sub Organization
		x_add_metadata_field(  'pb_taxID_'.$meta_position, $meta_position, array(
			'group'       =>     'GovernmentOrganization',
			'label'       =>     'Tax ID',
			'description' => 	'The Tax / Fiscal ID of the organization or person, e.g. the TIN in the US or the CIF/NIF in Spain.'
		) );
	
	}

	/* FUNCTIONS FOR THIS TYPE START HERE */

	/**
	 * Function used for comparing the instances of the schema types
	 *
	 * @since    0.x
	 * @access   public
	 */
	public function __toString() {
		return $this->class_name;
	}

	/**
	 * Returns the father for the type.
	 *
	 * @since    0.x
	 * @access   public
	 */
	public function pmdt_parent_init(){
		return new Pressbooks_Metadata_Organization($this->type_level);
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
	 * A function needed for the array of metadata that comes from each post site-meta cpt or chapter
	 * It automatically returns the first item in the array.
	 * @since 0.8.1
	 *
	 */
	private function pmdt_get_first($my_array){
		return $my_array[0];
	}

	/**
	 * A function that creates the metadata for the organisation type.
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
		$GovernmentOrganization_data = array(

			'areaServed' 			=> 'pb_areaServed',
			'duns' 					=> 'pb_duns',
			'foundingDate' 			=> 'pb_foundingDate',
			'globalLocationNumber' 	=> 'pb_globalLocationNumber',
			'leiCode' 				=> 'pb_leiCode',
			'location' 				=> 'pb_location',
			'logo' 					=> 'pb_logo',
			'naics' 				=> 'pb_naics',
			'parentOrganization' 	=> 'pb_parentOrganization',
			'review' 				=> 'pb_review',
			'sponsor' 				=> 'pb_sponsor',
			'subOrganization' 		=> 'pb_subOrganization',
			'taxID' 				=> 'pb_taxID'
		);

		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/EducationOrganization">';

		foreach ( $GovernmentOrganization_data as $itemprop => $content ) {
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