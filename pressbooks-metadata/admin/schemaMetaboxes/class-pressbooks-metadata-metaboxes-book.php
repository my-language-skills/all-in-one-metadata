<?php

/**
 * The metaboxes for the book type
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/metaboxes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */


class Pressbooks_Metadata_Metabox_Book {

	public function __construct($meta_position) {
		$this->add_metabox($meta_position);
	}

	/**
	 * The function which produces the metaboxes for the book type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	public function add_metabox($meta_position){

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
}
