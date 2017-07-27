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

class Pressbooks_Metadata_LocalBusiness {

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
		x_add_metadata_group(  'LocalBusiness', $meta_position, array(
			'label'       => 'Local Business Type Properties',
			'priority'        => 'high',
		) );
		//----------- metafields ----------- //
		// [schemaprop]
		
		// Currencies Accepted
		x_add_metadata_field(  'pb_currenciesAccepted_'.$meta_position, $meta_position, array(
			'group'       =>     'LocalBusiness',
			'label'       =>     'Currencies Accepted',
			'description' => 	'The currency accepted (in ISO 4217 currency format).'
		) );
		
		// openingHours
		x_add_metadata_field(  'pb_openingHours_'.$meta_position, $meta_position, array(
			'group'       =>     'LocalBusiness',
			'label'       =>     'openingHours',
			'description' => 	'The general opening hours for a business. Opening hours can be specified as a weekly time range, starting with days, then times per day. Multiple days can be 						listed with commas \',\' separating each day. Day or time ranges are specified using a hyphen '-'.
								Days are specified using the following two-letter combinations: Mo, Tu, We, Th, Fr, Sa, Su.
								Times are specified using 24:00 time. For example, 3pm is specified as 15:00.
								Here is an example: <time itemprop="openingHours" datetime="Tu,Th 16:00-20:00">Tuesdays and Thursdays 4-8pm</time>.
								If a business is open 7 days a week, then it can be specified as <time itemprop="openingHours" datetime="Mo-Su">Monday through Sunday, all day</time>.'
		) );
		
		// Payment Accepted
		x_add_metadata_field(  'pb_paymentAccepted_'.$meta_position, $meta_position, array(
			'group'       =>     'LocalBusiness',
			'label'       =>     'Cash, credit card, etc.'
		) );
		
		// Price Range
		x_add_metadata_field(  'pb_priceRange_'.$meta_position, $meta_position, array(
			'group'       =>     'LocalBusiness',
			'label'       =>     'Price Range',
			'description' => 	'The price range of the business, for example $$$.'
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
		$LocalBusiness_data = array(

			'currenciesAccepted' => 'pb_currenciesAccepted',
			'openingHours' => 'pb_openingHours',
			'paymentAccepted' => 'pb_paymentAccepted',
			'priceRange' => 'pb_priceRange'
		);

		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/LocalBusiness">';

		foreach ( $LocalBusiness_data as $itemprop => $content ) {
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