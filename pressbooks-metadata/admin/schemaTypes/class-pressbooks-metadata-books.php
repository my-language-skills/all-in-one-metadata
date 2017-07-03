<?php
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

class Pressbooks_Metadata_Book {

	/**
	 * The type level where these metaboxes and their schema operations will go
	 *
	 * @since    0.x
	 * @access   private
	 */
	private $type_level;

	public function __construct($type_level_input) {
		$this->type_level = $type_level_input;
		$this->pmdt_add_metabox($this->type_level);
	}
	/**
	 * The function which produces the metaboxes for the book type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position){
		//----------- metabox ----------- //
		x_add_metadata_group( 	'book-type', $meta_position, array(
			'label' 		=>	'Book Type Properties',
			'priority' 		=>	'high',
		) );
		//----------- metafields ----------- //
		// Illustrator
		x_add_metadata_field( 	'pb_illustrator_'.$meta_position, $meta_position, array(
			'group' 		=> 	'book-type',
			'label' 		=> 	'Illustrator',
		) );
		// Book Edition
		x_add_metadata_field( 	'pb_edition_'.$meta_position, $meta_position, array(
			'group' 		=>	'book-type',
			'label' 		=>	'Book Edition',
			'description'	=>	'The edition of the book. Example: First Edition or 1 or 1.0.0',
		) );
	}

		/*FUNCTIONS FOR THIS TYPE START HERE*/

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
	 * A function that creates the metadata for the book type.
	 * @since 0.8.1
	 *
	 */
	public function pmdt_get_metatags() {
		//Distinguishing if we are working on a post --- chapter level or on the main site level
		//The type_level variable is the string we used to create the metabox

		if ( $this->type_level == 'chapter' ) { //loading the appropriate metadata depending on the type level
			$metadata = get_post_meta( get_the_ID() );
		} else {
			$metadata = \Pressbooks\Book::getBookInformation();
		}

		// array of the items needed to become microtags
		$book_data = array(

			'illustrator' => 'pb_illustrator',
			'bookEdition' => 'pb_edition'
		);

		$html = "<!-- Microtags --> \n";

		//This code is needed for the book type on chapter level because by default the chapter is a website
		$html .= ( $this->type_level == 'chapter' ? '<div itemscope itemtype="http://schema.org/Book">' : '' );

		foreach ( $book_data as $itemprop => $content ) {
			if ( isset( $metadata[ $content . '_' . $this->type_level ] ) ) {

				if ( $this->type_level == 'chapter' ) { //we are using the get_first function to get the value from the returned array
					$value = $this->pmdt_get_first( $metadata[ $content . '_' . $this->type_level ] );
				} else {
					$value = $metadata[ $content . '_' . $this->type_level ];
				}

				$html .= "<meta itemprop = '" . $itemprop . "' content = '" . $value . "'>\n";
			}
		}
		$html .= ( $this->type_level == 'chapter' ? '</div>' : '' );
		return $html;
	}
}