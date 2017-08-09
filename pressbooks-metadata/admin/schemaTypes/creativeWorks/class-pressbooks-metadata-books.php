<?php

namespace schemaTypes\cw;
use schemaTypes;
use schemaFunctions\Pressbooks_Metadata_Create_Metabox as create_metabox;
use schemaTypes\Pressbooks_Metadata_Type;

/**
 * The class for the book type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Book extends Pressbooks_Metadata_Type {

	/**
	 * The variable that holds the values for the settings for this schema type
	 *
	 * @since    0.x
	 * @access   public
	 */
	static $type_setting = array('book_type' => array('Book Type','http://schema.org/Book'));

	/**
	 * The variable that holds the parents for the type
	 *
	 * @since    0.x
	 * @access   public
	 */
	static $type_parents = array('schemaTypes\Pressbooks_Metadata_Thing');

	/**
	 * The variable that holds the properties of this schema type
	 *
	 * @since    0.x
	 * @access   public
	 */
	static $type_properties = array(
		'illustrator' => array(true,'Illustrator','This is the Description of Illustrator'),
		'bookEdition' => array(false,'Book Edition','This is the Description of Book Edition'),
		'bookFormat' => array(false,'Book Format','This is the Description of Book Format'),
		'isbn' => array(false,'ISBN','The ISBN of the book'),
		'numberOfPages' => array(false,'Number Of Pages','The number of pages in the book')
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

	/**
	 * The function which produces the metaboxes for the book type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position) {
		new create_metabox($this->typeName,$this->typeDisplayName,$meta_position,$this->type_fields);
	}

	/**
	 * A function that creates the metadata for the book type.
	 * @since 0.8.1
	 *
	 */
	public function pmdt_get_metatags() {
		//Creating microtags
		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/Book">';

		foreach ( $this->type_fields as $itemprop => $details ) {
			$propName = strtolower('pb_' . $itemprop . '_' . $this->type_level);
			if ($this->pmdt_prop_run($itemprop)) {
				$value = $this->pmdt_get_value($propName);
				if(!empty($value)){$html .= "<meta itemprop = '" . $itemprop . "' content = '" . $value . "'>\n";}
			}
		}
		$html .= '</div>';
		return $html;
	}
}