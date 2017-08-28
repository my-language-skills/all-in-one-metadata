<?php

namespace schemaTypes\organization;
use schemaTypes;
use schemaTypes\Pressbooks_Metadata_Type;

/**
 * The class for the airline
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.12
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 * @author    Corentin Perrot <perrotcore@gmail.com>
 */

class Pressbooks_Metadata_Airline extends Pressbooks_Metadata_Type {

	/**
	 * The variable that holds the values for the settings for this schema type
	 *
	 * @since    0.12
	 * @access   public
	 */
	static $type_setting = array('airline_type' => array('Airline Type','http://schema.org/Airline'));

	/**
	 * The variable that holds the parents for the type
	 *
	 * @since    0.12
	 * @access   public
	 */
	static $type_parents = array(
		'schemaTypes\Pressbooks_Metadata_Thing',
		'schemaTypes\Pressbooks_Metadata_Organization'
	);

	/**
	 * The variable that holds the properties of this schema type
	 *
	 * @since    0.12
	 * @access   public
	 */
	static $type_properties = array(
		'boardingPolicy' => array(false,'Boarding Policy','The type of boarding policy used by the airline (e.g. zone-based or group-based).'),
		'iataCode' => array(false,'IATA Code','IATA identifier for an airline or airport.')
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
	 * @since    0.12
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
	 * @since    0.12
	 * @access   public
	 */
	public function __toString() {
		return $this->class_name;
	}
}
