<?php

namespace vocabularyFunctions;
use adminFunctions\Pressbooks_Metadata_Site_Cpt as siteCpt;
use schemaFunctions\Pressbooks_Metadata_Create_Metabox as create_metabox;
use schemaFunctions\Pressbooks_Metadata_General_Functions as genFunc;

/**
 * The class for the dublin vocabulary including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Nicole Acuña      <@nicoleacuna>
 */

class Pressbooks_Metadata_Dublin {

	/**
	 * The type level that identifies where these metaboxes will be created
	 *
	 * @since    0.x
	 * @access   public
	 */
	public $type_level;

	/**
	 * The variable that holds the values from the database for the vocabulary output
	 *
	 * @since    0.x
	 * @access   public
	 */
	public $metadata;

	/**
	 * The variable that holds the properties of this vocabulary
	 *
	 * @since    0.x
	 * @access   public
	 */
	static $type_properties = array(
		//For all the properties on external vocabularies we use the true paramenter
		//We do this because we dont select properties for other vocabularies except from schema
		//Without the true parameter the fields will not render
		'dublin_illustrator' => array( true, 'Illustrator', '' ),
		'dublin_edition' => array( true, 'Edition', '' ),
		'dublin_provider' => array( true, 'Provider', '' ),
		'dublin_age_range' => array( true, 'Audience Age Range', '', array(
			'18-' 		=> 	'Adults',
			'17-18'		=> 	'17-18 years',
			'16-17' 	=> 	'16-17 years',
			'15-16' 	=> 	'15-16 years',
			'14-15' 	=> 	'14-15 years',
			'13-14' 	=> 	'13-14 years',
			'12-13' 	=> 	'12-13 years',
			'11-12' 	=> 	'11-12 years',
			'10-11' 	=> 	'10-11 years',
			'9-10'  	=> 	 '9-10 years',
			'8-9'  		=> 	  '8-9 years',
			'7-8'  		=> 	  '7-8 years',
			'6-7'  		=> 	  '6-7 years',
			'3-5'	  	=> 	  '3-5 years'
		)),
		'dublin_learning_resource' => array( true, 'Learning Resource', '', array(
			'course'	=> 	'Course',
			'exam'		=> 	'Examination',
			'exercise'	=> 	'Exercise'
		)),
		'dublin_interactivity_type' => array( true, 'Interactivity Type', '', array(
			'expositive'=> 	'Expositive',
			'mixed' 	=> 	'Mixed',
			'active' 	=> 	'Active'
		)),
		'dublin_time_required' => array( true, 'Required Time', '', 'number' ),
		'dublin_license_url' => array( true, 'License Url', '' ),
		'dublin_bibliography_url' => array( true, 'Bibliography Url', '' ),
		'dublin_questions_answers' => array( true, 'Questions and Answers', '' ),
	);

	public function __construct() {
		$this->type_level = siteCpt::pressbooks_identify() ? 'metadata' : 'site-meta';
		$this->pmdt_add_metabox( $this->type_level );
	}

	/**
	 * The function which produces the metaboxes for the vocabulary
	 *
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 *
	 * @since 0.x
	 */
	public function pmdt_add_metabox( $meta_position ) {
		new create_metabox( 'dublin_vocab', 'Dublin Metadata', $meta_position, self::$type_properties );
	}

	/**
	 * A function needed for the array of metadata that comes from each post site-meta cpt or chapter
	 * It automatically returns the first item in the array.
	 * @since 0.x
	 *
	 */
	private function pmdt_get_first( $my_array ) {
		if ( $my_array == '' ) {
			return '';
		} else {
			return $my_array[0];
		}
	}

	/**
	 * Gets the value for the microtags from $this->metadata.
	 *
	 * @since    0.x
	 * @access   public
	 */
	private function pmdt_get_value( $propName ) {
		$array = isset( $this->metadata[ $propName ] ) ? $this->metadata[ $propName ] : '';
		if ( $this->type_level == 'site-meta' ) {
			$value = $this->pmdt_get_first( $array );
		} else {//We always use the get_first function except if our level is metadata coming from pressbooks
			$value = $array;
		}

		return $value;
	}

	/**
	 * Function that creates the vocabulary metatags
	 *
	 * @since    0.x
	 * @access   public
	 */
	public function pmdt_get_metatags() {
		//Getting the information from the database
		$this->metadata = genFunc::get_metadata();
		// title
		$html = "<!-- Dublin Core metatags -->\n";
		// link to DC schema
		$html .= "<link rel='schema.DC' href='http://purl.org/dc/elements/1.1/' />";
		//We walk the array and for each element we see if it matches the fields that we want to visualize
		foreach ( self::$type_properties as $key => $desc ) {
			//Constructing the key for the data
			$dataKey = 'pb_' . $key . '_' . $this->type_level;
			//Getting the data
			$val = $this->pmdt_get_value($dataKey);
			//Checking if the value exists
			if(!isset($val) || empty($val)){
				continue;
			}
			//contributor
			if ( $key == 'dublin_illustrator' ) {
				$html .= "<meta name='DC.contributor' content='" . $val . "'/>";
			}
			//coverage
			if ( $key == 'dublin_edition' ) {
				$html .= "<meta name='DC.coverage' content='" . $val . "'/>";
			}
			//provider
			if ( $key == 'dublin_provider' ) {
				$html .= "<meta name='DC.publisher' content='" . $val . "' />";
			}
			//audience
			if ( $key == 'dublin_age_range' ) {
				$html .= "<meta name='DC.audience' content='" . $val . "'/>";
			}
			//relation
			if ( $key == 'dublin_learning_resource' ) {
				$html .= "<meta name='DC.relation' content='" . $val . "'/>";
			}
			//relation
			if ( $key == 'dublin_interactivity_type' ) {
				$html .= "<meta name='DC.relation' content='" . $val . "'/>";
			}
			//coverage
			if ( $key == 'dublin_time_required' ) {
				$html .= "<meta name='DC.coverage' content='" . $val . "'/>";
			}
			//rights
			if ( $key == 'dublin_license_url' ) {
				$html .= "<meta name='DC.rights' content='" . $val . "' />";
			}
			//identifier
			if ( $key == 'dublin_bibliography_url' ) {
				$html .= "<meta name='DC.identifier' content='" . $val . "' />";
			}
			//identifier
			if ( $key == 'dublin_questions_answers' ) {
				$html .= "<meta name='DC.identifier' content='" . $val . "' />";
			}
		}
		return $html;
	}
}