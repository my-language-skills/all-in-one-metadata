<?php

namespace schemaTypes\cw;
use schemaTypes;
use schemaTypes\Pressbooks_Metadata_Type;

/**
 * The class for the review
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

class Pressbooks_Metadata_Review extends Pressbooks_Metadata_Type {

    /**
     * The variable that holds all parent required properties
     *
     * @since    0.13
     * @access   public
     */
    static $required_parent_props = array(
		'author'
    );

	/**
	 * The variable that holds the values for the settings for this schema type
	 *
	 * @since    0.x
	 * @access   public
	 */
	static $type_setting = array('review_type' => array('Review Type','http://schema.org/Review'));

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
		'itemReviewed' => array(false,'Item Reviewed','The item that is being reviewed/rated.'),
		'reviewBody' => array(false,'Review Body','The actual body of the review.'),
		'reviewRating' => array(false,'Review Rating','	The rating given in this review. Note that reviews can themselves be rated. The reviewRating applies to rating given by the review. The aggregateRating property applies to the review itself, as a creative work.')
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
