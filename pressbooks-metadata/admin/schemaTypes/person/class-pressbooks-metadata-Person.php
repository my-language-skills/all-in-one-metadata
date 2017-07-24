<?php

namespace schemaTypes\person;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;

/**
 * The class for the person type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Person {

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
	 * The function which produces the metaboxes for the person type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position){
		//----------- metabox ----------- //
		x_add_metadata_group(  'Person', $meta_position, array(
			'label'       => 'Person Type Properties',
			'priority'        => 'high',
		) );
		//----------- metafields ----------- //
		// [schemaprop]
		
		// actionStatus Property
		x_add_metadata_field(  'pb_additionalName_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'additionalName',
			'description' => 	'	An additional name for a Person, can be used for a middle name.'
		) );
		
		// agent Property
		x_add_metadata_field(  'pb_address_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'address',
			'description' => 	'Physical address of the item.'
		) );
		
		
		// endTime Property
		x_add_metadata_field(  'pb_affiliation_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'affiliation',
			'description' => 	'An organization that this person is affiliated with. For example, a school/university, a club, or a team.'
		) );
		
		// error Property
		x_add_metadata_field(  'pb_alumniOf_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'alumniOf',
			'description' => 	'An organization that the person is an alumni of.
			Inverse property: alumni.'
		) );
		
		
		// instrument Property
		x_add_metadata_field(  'pb_award_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'award',
			'description' => 	'An award won by or for this item. Supersedes awards.'
		) );
		
		// location Property
		x_add_metadata_field(  'pb_birthDate_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'birthDate',
			'description' => 	'Date of birth.'
		) );
		
		
		// object Property
		x_add_metadata_field(  'pb_birthPlace_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'birthPlace',
			'description' => 	'The place where the person was born.'
		) );
		
		
		// participant Property
		x_add_metadata_field(  'pb_brand_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'brand',
			'description' => 	'The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.'
		) );
		
		
		// result Property
		x_add_metadata_field(  'pb_children_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'children',
			'description' => 	'A child of the person.'
		) );
		
		
		// startTime Property
		x_add_metadata_field(  'pb_colleague_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'colleague',
			'description' => 	'A colleague of the person. Supersedes colleagues.'
		) );
		
		
		// target Property
		x_add_metadata_field(  'pb_contactPoint_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'contactPoint',
			'description' => 	'A contact point for a person or organization. Supersedes contactPoints.'
		) );
		
		
			// target Property
		x_add_metadata_field(  'pb_deathDate_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'deathDate',
			'description' => 	'Date of death.'
		) );
		
		
			// target Property
		x_add_metadata_field(  'pb_deathPlace_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'deathPlace',
			'description' => 	'The place where the person died.'
		) );
		
		
			// target Property
		x_add_metadata_field(  'pb_duns_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'duns',
			'description' => 	'The Dun & Bradstreet DUNS number for identifying an organization or business person.'
		) );
		
		
		// target Property
		x_add_metadata_field(  'pb_email_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'email',
			'description' => 	'Email address.'
		) );
		
		
		
		// target Property
		x_add_metadata_field(  'pb_familyName_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'familyName',
			'description' => 	 'Family name. In the U.S., the last name of an Person. This can be used along with givenName instead of the name property.'
		) );
		
		
		// target Property
		x_add_metadata_field(  'pb_faxNumber_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'faxNumber',
			'description' => 	'The fax number.'
		) );
		
		
		// target Property
		x_add_metadata_field(  'pb_follows_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'follows',
			'description' => 	'The most generic uni-directional social relation.'
		) );
		
		
		// target Property
		x_add_metadata_field(  'pb_funder_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'funder',
			'description' => 	'A person or organization that supports (sponsors) something through some kind of financial contribution.'
		) );
		
		
		// target Property
		x_add_metadata_field(  'pb_gender_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'gender',
			'description' => 	'Gender of the person. While http://schema.org/Male and http://schema.org/Female may be used, text strings are also acceptable for people who do not identify as a binary gender.'
		) );
		
		
			// target Property
		x_add_metadata_field(  'pb_givenName_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'givenName',
			'description' => 	'Given name. In the U.S., the first name of a Person. This can be used along with familyName instead of the name property.'
		) );
		
		
			// target Property
		x_add_metadata_field(  'pb_globalLocationNumber_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'globalLocationNumber',
			'description' => 	'The Global Location Number (GLN, sometimes also referred to as International Location Number or ILN) of the respective organization, person, or place. The GLN is a 13-digit number used to identify parties and physical locations.'
		) );
		
		
			// target Property
		x_add_metadata_field(  'pb_hasOfferCatalog_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'hasOfferCatalog',
			'description' => 	'Indicates an OfferCatalog listing for this Organization, Person, or Service.'
		) );
		
		
			// target Property
		x_add_metadata_field(  'pb_hasPOS_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'hasPOS',
			'description' => 	'Points-of-Sales operated by the organization or person.'
		) );
		
		
				// target Property
		x_add_metadata_field(  'pb_height_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'height',
			'description' => 	'The height of the item.'
		) );
		
		
				// target Property
		x_add_metadata_field(  'pb_homeLocation_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'homeLocation',
			'description' => 	'A contact location for a person\'s residence.'
		) );
		
		
				// target Property
		x_add_metadata_field(  'pb_honorificPrefix_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'honorificPrefix',
			'description' => 	'An honorific prefix preceding a Person\'s name such as Dr/Mrs/Mr.'
		) );
		
		
				// target Property
		x_add_metadata_field(  'pb_honorificSuffix_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'honorificSuffix',
			'description' => 	'An honorific suffix preceding a Person\'s name such as M.D. /PhD/MSCSW.'
		) );
		
		
					// target Property
		x_add_metadata_field(  'pb_isicV4_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'isicV4',
			'description' => 	'The International Standard of Industrial Classification of All Economic Activities (ISIC), Revision 4 code for a particular organization, business person, or place.'
		) );
		
		
					// target Property
		x_add_metadata_field(  'pb_jobTitle_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'jobTitle',
			'description' => 	'The job title of the person (for example, Financial Manager).'
		) );
		
					// target Property
		x_add_metadata_field(  'pb_knows_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'knows',
			'description' => 	'The most generic bi-directional social/work relation.'
		) );
		
						// target Property
		x_add_metadata_field(  'pb_makesOffer_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'makesOffer',
			'description' => 	'A pointer to products or services offered by the organization or person.
			Inverse property: offeredBy.'
		) );
		
						// target Property
		x_add_metadata_field(  'pb_memberOf_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'memberOf',
			'description' => 	'An Organization (or ProgramMembership) to which this Person or Organization belongs.
			Inverse property: member.'
		) );
		
						// target Property
		x_add_metadata_field(  'pb_naics_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'naics',
			'description' => 	'The North American Industry Classification System (NAICS) code for a particular organization or business person.'
		) );
		
						// target Property
		x_add_metadata_field(  'pb_nationality_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'nationality',
			'description' => 	'Nationality of the person.'
		) );
		
						// target Property
		x_add_metadata_field(  'pb_netWorth_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'netWorth',
			'description' => 	'The total financial value of the person as calculated by subtracting assets from liabilities.'
		) );
		
						// target Property
		x_add_metadata_field(  'pb_owns_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'owns',
			'description' => 	'Products owned by the organization or person.'
		) );
		
						// target Property
		x_add_metadata_field(  'pb_parent_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'parent',
			'description' => 	'A parent of this person. Supersedes parents.'
		) );
		
						// target Property
		x_add_metadata_field(  'pb_performerIn_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'performerIn',
			'description' => 	'Event that this person is a performer or participant in.'
		) );
		
						// target Property
		x_add_metadata_field(  'pb_relatedTo_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'relatedTo',
			'description' => 	'The most generic familial relation.'
		) );
		
		
							// target Property
		x_add_metadata_field(  'pb_seeks_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'seeks',
			'description' => 	'A pointer to products or services sought by the organization or person (demand).'
		) );
		
		
							// target Property
		x_add_metadata_field(  'pb_sibling_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'sibling',
			'description' => 	'A sibling of the person. Supersedes siblings.'
		) );
		
		
							// target Property
		x_add_metadata_field(  'pb_sponsor_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'sponsor',
			'description' => 	'A person or organization that supports a thing through a pledge, promise, or financial contribution. e.g. a sponsor of a Medical Study or a corporate sponsor of an event.'
		) );
		
							// target Property
		x_add_metadata_field(  'pb_spouse_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'spouse',
			'description' => 	'The person\'s spouse.'
		) );
		
		
							// target Property
		x_add_metadata_field(  'pb_taxID_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'taxID',
			'description' => 	'The Tax / Fiscal ID of the organization or person, e.g. the TIN in the US or the CIF/NIF in Spain.'
		) );
		
		
							// target Property
		x_add_metadata_field(  'pb_telephone_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'telephone',
			'description' => 	'The telephone number.'
		) );
		
		
							// target Property
		x_add_metadata_field(  'pb_vatID_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'vatID',
			'description' => 	'The Value-added Tax ID of the organization or person.'
		) );
		
							// target Property
		x_add_metadata_field(  'pb_weight_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'weight',
			'description' => 	'The weight of the product or person.'
		) );
		
							// target Property
		x_add_metadata_field(  'pb_workLocation_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'workLocation',
			'description' => 	'A contact location for a person\'s place of work.'
		) );
		
							// target Property
		x_add_metadata_field(  'pb_worksFor_'.$meta_position, $meta_position, array(
			'group'       =>     'Person',
			'label'       =>     'worksFor',
			'description' => 	'Organizations that the person works for.'
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
		// We don't need this function because we are not dealing with the parents of the types right now.
		//return new Pressbooks_Metadata_[schema-parent-type]($this->type_level);
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
	 * A function that creates the metadata for the person type.
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
		$Person_data = array(

			'additionalName' => 'pb_additionalName',
			'address' => 'pb_address',
			'affiliation' => 'pb_affiliation',
			'alumniOf' => 'pb_alumniOf',
			'award' => 'pb_award',
			'birthDate' => 'pb_birthDate',
			'birthPlace	' => 'pb_birthPlace	',
			'brand' => 'pb_brand',
			'children' => 'pb_children',
			'colleague' => 'pb_colleague',
			'contactPoint' => 'pb_contactPoint',
			'deathDate' => 'pb_deathDate',
			'deathPlace' => 'pb_deathPlace',
			'duns' => 'pb_duns',
			'email' => 'pb_email',
			'familyName' => 'pb_familyName',
			'faxNumber' => 'pb_faxNumber',
			'follows' => 'pb_follows',
			'funder' => 'pb_funder',
			'gender' => 'pb_gender',
			'givenName' => 'pb_givenName',
			'globalLocationNumber' => 'pb_globalLocationNumber',
			'hasOfferCatalog' => 'pb_hasOfferCatalog',
			'hasPOS' => 'pb_hasPOS',
			'height' => 'pb_height',
			'homeLocation' => 'pb_homeLocation',
			'honorificPrefix' => 'pb_honorificPrefix',
			'honorificSuffix' => 'pb_honorificSuffix',
			'isicV4' => 'pb_isicV4',
			'jobTitle' => 'pb_jobTitle',
			'knows' => 'pb_knows',
			'makesOffer' => 'pb_makesOffer',
			'memberOf' => 'pb_memberOf',
			'naics' => 'pb_naics',
			'nationality' => 'pb_nationality',
			'netWorth' => 'pb_netWorth',
			'owns' => 'pb_owns',
			'parent' => 'pb_parent',
			'performerIn' => 'pb_performerIn',
			'relatedTo' => 'pb_relatedTo',
			'seeks' => 'pb_seeks',
			'sibling' => 'pb_sibling',
			'sponsor' => 'pb_sponsor',
			'spouse' => 'pb_spouse',
			'taxID' => 'pb_taxID',
			'telephone' => 'pb_telephone',
			'vatID' => 'pb_vatID',
			'weight' => 'pb_weight',
			'workLocation' => 'pb_workLocation',
			'worksFor' => 'pb_worksFor'
		);

		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/Person">';

		foreach ( $Person_data as $itemprop => $content ) {
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