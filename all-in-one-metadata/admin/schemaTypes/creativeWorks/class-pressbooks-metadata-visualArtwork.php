<?php

namespace schemaTypes\cw;
use schemaTypes;
use schemaTypes\Pressbooks_Metadata_Type;

/**
 * The class for the visualArtwork
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

class Pressbooks_Metadata_VisualArtwork extends Pressbooks_Metadata_Type {

	/**
	 * The variable that holds the values for the settings for this schema type
	 *
	 * @since    0.x
	 * @access   public
	 */
	static $type_setting = array('visualArtwork_type' => array('VisualArtwork Type','http://schema.org/VisualArtwork'));

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
		'artEdition' => array(false,'Art Edition','The number of copies when multiple copies of a piece of artwork are produced - e.g. for a limited edition of 20 prints, "artEdition" refers to the total number of copies (in this example "20").'),
		'artMedium' => array(false,'Art Medium','The material used. (e.g. Oil, Watercolour, Acrylic, Linoprint, Marble, Cyanotype, Digital, Lithograph, DryPoint, Intaglio, Pastel, Woodcut, Pencil, Mixed Media, etc.)'),
		'artform' => array(false,'Art Form','e.g. Painting, Drawing, Sculpture, Print, Photograph, Assemblage, Collage, etc.'),
		'artist' => array(false,'Artist','The primary artist for a work in a medium other than pencils or digital line art--for example, if the primary artwork is done in watercolors or digital paints.'),
		'artworkSurface' => array(false,'Art Work Surface','The supporting materials for the artwork, e.g. Canvas, Paper, Wood, Board, etc. Supersedes surface.'),
		'colorist' => array(false,'Colorist','The individual who adds color to inked drawings.'),
		'depth' => array(false,'Depth','The depth of the item.'),
		'height' => array(false,'Height','The height of the item.'),
		'inker' => array(false,'Inker','The individual who traces over the pencil drawings in ink after pencils are complete.'),
		'letterer' => array(false,'Letterer','The individual who adds lettering, including speech balloons and sound effects, to artwork.'),
		'penciler' => array(false,'Penciler','The individual who draws the primary narrative artwork.'),
		'width' => array(false,'Width','The width of the item.')


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
