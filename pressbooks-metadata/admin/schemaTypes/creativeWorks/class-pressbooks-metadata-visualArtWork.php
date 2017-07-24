<?php

namespace schemaTypes\cw;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;

/**
 * The class for the Visual Art Work including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Visual_Art_Work{

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
	 * @since    0.9
	 * @access   public
	 */
	public $class_name;

	public function __construct($type_level_input) {
		$this->type_level = $type_level_input;
		$this->pmdt_add_metabox($this->type_level);
		$this->class_name = __CLASS__ .'_'. $this->type_level;
	}

	/**
	 * The function which produces the metaboxes for the visual art work
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position){
		//----------- metabox ----------- //
		x_add_metadata_group( 	'visual-art-work', $meta_position, array(
			'label' 		=>	'Visual Art Work Properties',
			'priority' 		=>	'high',
		) );
		//----------- metafields ----------- //
		// Art Edition
		x_add_metadata_field( 	'pb_art_edition_'.$meta_position, $meta_position, array(
			'group' 		=>	'visual-art-work',
			'label' 		=>	'Art Edition',
			'description'	=>	'The number of copies when multiple copies of a piece of artwork are produced - e.g. for a limited edition of 20 prints, artEdition refers to the total number of copies (in this example "20").',
		) );
		// Art Medium
		x_add_metadata_field( 	'pb_art_medium_'.$meta_position, $meta_position, array(
			'group' 		=>	'visual-art-work',
			'label' 		=>	'Art Medium',
			'description'	=>	'The material used. (e.g. Oil, Watercolour, Acrylic, Linoprint, Marble, Cyanotype, Digital, Lithograph, DryPoint, Intaglio, Pastel, Woodcut, Pencil, Mixed Media, etc.)',
		) );
		// Art Form
		x_add_metadata_field( 	'pb_art_form_'.$meta_position, $meta_position, array(
			'group' 		=>	'visual-art-work',
			'label' 		=>	'Art Form',
			'description'	=>	'e.g. Painting, Drawing, Sculpture, Print, Photograph, Assemblage, Collage, etc.',
		) );
		// Art Work Surface
		x_add_metadata_field( 	'pb_art_work_surface_'.$meta_position, $meta_position, array(
			'group' 		=>	'visual-art-work',
			'label' 		=>	'Art Work Surface',
			'description'	=>	'The supporting materials for the artwork, e.g. Canvas, Paper, Wood, Board, etc. Supersedes surface.',
		) );
		// Depth
		x_add_metadata_field( 	'pb_depth_'.$meta_position, $meta_position, array(
			'group' 		=>	'visual-art-work',
			'label' 		=>	'Depth',
			'description'	=>	'The depth of the item.',
		) );
		// Height
		x_add_metadata_field( 	'pb_height_'.$meta_position, $meta_position, array(
			'group' 		=>	'visual-art-work',
			'label' 		=>	'Height',
			'description'	=>	'The height of the item..',
		) );
		// Width
		x_add_metadata_field( 	'pb_width_'.$meta_position, $meta_position, array(
			'group' 		=>	'visual-art-work',
			'label' 		=>	'Width',
			'description'	=>	'The width of the item.',
		) );
		
	}

		/*FUNCTIONS FOR THIS TYPE START HERE*/

	/**
	 * Function used for comparing the instances of the schema types
	 *
	 * @since    0.9
	 * @access   public
	 */
	public function __toString() {
		return $this->class_name;
	}

	/**
	 * Returns the father for the type.
	 *
	 * @since    0.9
	 * @access   public
	 */
	public function pmdt_parent_init(){
		return new Pressbooks_Metadata_Creative_Work($this->type_level);
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
	 * A function needed for the array of metadata that comes from each post or chapter
	 * It automatically returns the first item in the array.
	 * @since 0.8.1
	 *
	 */
	private function pmdt_get_first($my_array){
		return $my_array[0];
	}

	/**
	 * A function that creates the metadata for the Visual Art Work type.
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
		$visualArtWork_data = array(

			'artEdition' => 'pb_art_edition',
			'artMedium' => 'pb_art_medium',
			'artform' => 'pb_art_form',
			'artworkSurface' => 'pb_art_work_surface',
			'depth' => 'pb_depth',
			'height' => 'pb_height',
			'width' => 'pb_width'

		);

		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/VisualArtwork">';

		foreach ( $visualArtWork_data as $itemprop => $content ) {
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