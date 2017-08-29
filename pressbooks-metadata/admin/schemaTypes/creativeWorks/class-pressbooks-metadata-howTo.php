<?php

namespace schemaTypes\cw;
use schemaTypes;
use schemaTypes\Pressbooks_Metadata_Type;

/**
 * The class for the howTo
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

class Pressbooks_Metadata_HowTo extends Pressbooks_Metadata_Type {

	/**
	 * The variable that holds the values for the settings for this schema type
	 *
	 * @since    0.x
	 * @access   public
	 */
	static $type_setting = array('howTo_type' => array('HowTo Type','http://schema.org/HowTo'));

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
		'estimatedCost' => array(false,'Estimated Cost','The estimated cost of the supply or supplies consumed when performing instructions.'),
		'performTime' => array(false,'Perform Time','The length of time it takes to perform instructions or a direction (not including time to prepare the supplies), in ISO 8601 duration format.'),
		'prepTime' => array(false,'Preparing Time','The length of time it takes to prepare the items to be used in instructions or a direction, in ISO 8601 duration format.'),
		'steps' => array(false,'Steps','The steps in the form of a single item (text, document, video, etc.) or an ordered list with HowToStep and/or HowToSection items.'),
		'supply' => array(false,'Supply','A sub-property of instrument. A supply consumed when performing instructions or a direction.'),
		'tool' => array(false,'Tool','A sub property of instrument. An object used (but not consumed) when performing instructions or a direction.'),
		'totalTime' => array(false,'Total Time','The total time required to perform instructions or a direction (including time to prepare the supplies), in ISO 8601 duration format.'),
		'yield' => array(false,'Yield','The quantity that results by performing instructions. For example, a paper airplane, 10 personalized candles.')
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
