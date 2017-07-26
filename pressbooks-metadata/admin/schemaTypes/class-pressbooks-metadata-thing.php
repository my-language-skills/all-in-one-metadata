<?php

namespace schemaTypes;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;

/**
 * The class for the Thing type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Thing {

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
	 * The function which produces the metaboxes for the action type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position){
		//----------- metabox ----------- //
		x_add_metadata_group(  'Thing', $meta_position, array(
			'label'       => 'Thing Type Properties',
			'priority'        => 'high',
		) );
		//----------- metafields ----------- //
		// [schemaprop]
		
		// Additional Type
		x_add_metadata_field(  'pb_additionalType_'.$meta_position, $meta_position, array(
			'group'       =>     'Thing',
			'label'       =>     'Additional Type',
			'description' => 	'An additional type for the item, typically used for adding more specific types from external vocabularies in microdata syntax. This is a relationship between 						something and a class that the thing is in. In RDFa syntax, it is better to use the native RDFa syntax - the \'typeof\' attribute - for multiple types. 							Schema.org tools may have only weaker understanding of extra types, in particular those defined externally.'
		) );
		
		// Alternate Name
		x_add_metadata_field(  'pb_alternateName_'.$meta_position, $meta_position, array(
			'group'       =>     'Thing',
			'label'       =>     'Alternate Name',
			'description' => 	'An alias for the item.'
		) );
		
		
		// endTime Property
		x_add_metadata_field(  'pb_description_'.$meta_position, $meta_position, array(
			'group'       =>     'Thing',
			'label'       =>     'description',
			'description' => 	'A description of the item.'
		) );
		
		// Disambiguating Description
		x_add_metadata_field(  'pb_disambiguatingDescription_'.$meta_position, $meta_position, array(
			'group'       =>     'Thing',
			'label'       =>     'Disambiguating Description',
			'description' => 	'A sub property of description. A short description of the item used to disambiguate from other, similar items. Information from other properties (in 								particular, name) may be necessary for the description to be useful for disambiguation.'
		) );
		
		
		// Identifier
		x_add_metadata_field(  'pb_identifier_'.$meta_position, $meta_position, array(
			'group'       =>     'Thing',
			'label'       =>     'Identifier',
			'description' => 	'The identifier property represents any kind of identifier for any kind of Thing, such as ISBNs, GTIN codes, UUIDs etc. Schema.org provides dedicated properties 					for representing many of these, either as textual strings or as URL (URI) links. See background notes for more details.'
		) );
		
		// Image
		x_add_metadata_field(  'pb_image_'.$meta_position, $meta_position, array(
			'group'       =>     'Thing',
			'label'       =>     'Image',
			'description' => 	'An image of the item. This can be a URL or a fully described ImageObject.'
		) );
		
		
		// Main Entity Of Page
		x_add_metadata_field(  'pb_mainEntityOfPage_'.$meta_position, $meta_position, array(
			'group'       =>     'Thing',
			'label'       =>     'Main Entity Of Page',
			'description' => 	'Indicates a page (or other CreativeWork) for which this thing is the main entity being described. See background notes for details.
								<b>Inverse property: mainEntity.'
		) );
		
		
		// Name
		x_add_metadata_field(  'pb_name_'.$meta_position, $meta_position, array(
			'group'       =>     'Thing',
			'label'       =>     'Name',
			'description' => 	'The name of the item.'
		) );
		
		
		// Potential Action
		x_add_metadata_field(  'pb_potentialAction_'.$meta_position, $meta_position, array(
			'group'       =>     'Thing',
			'label'       =>     'Potential Action',
			'description' => 	'Indicates a potential Action, which describes an idealized action in which this thing would play an \'object\' role.'
		) );
		
		
		// Same As
		x_add_metadata_field(  'pb_sameAs_'.$meta_position, $meta_position, array(
			'group'       =>     'Thing',
			'label'       =>     'Same As',
			'description' => 	'URL of a reference Web page that unambiguously indicates the item\'s identity. E.g. the URL of the item\'s Wikipedia page, Wikidata entry, or official website.'
		) );
		
		
		// Url
		x_add_metadata_field(  'pb_url_'.$meta_position, $meta_position, array(
			'group'       =>     'Thing',
			'label'       =>     'Url',
			'description' => 	'URL of the item.'
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
	 * A function that creates the metadata for the action type.
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
		$Thing_data = array(

			'additionalType'			=> 	'pb_additionalType',
			'alternateName' 			=> 	'pb_alternateName',
			'description' 				=> 'pb_description',
			'disambiguatingDescription' => 'pb_disambiguatingDescription',
			'identifier' 				=> 'pb_identifier',
			'image' 					=> 'pb_image',
			'mainEntityOfPage' 			=> 'pb_mainEntityOfPage',
			'name' 						=> 'pb_name',
			'potentialAction' 			=> 'pb_potentialAction',
			'sameAs' 					=> 'pb_sameAs',
			'url' 						=> 'pb_url'
		);

		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/Thing">';

		foreach ( $Thing_data as $itemprop => $content ) {
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