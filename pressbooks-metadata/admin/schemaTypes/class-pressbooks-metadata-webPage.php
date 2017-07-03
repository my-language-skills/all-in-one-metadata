<?php
/**
 * The class for the webPage type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_WebPage {

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
	 * The function which produces the metaboxes for the webpage type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position){

		//----------- metabox ----------- //

		x_add_metadata_group( 	'webpage-type', $meta_position, array(
			'label' 		=>	'WebPage Type Properties',
			'priority' 		=>	'high',
		) );

		//----------- metafields ----------- //

		// Main Content Of Page
		x_add_metadata_field( 	'pb_main_content_'.$meta_position, $meta_position, array(
			'group' 		=> 	'webpage-type',
			'label' 		=> 	'Main Content Of Page',
			'description'   =>  'Indicates if this web page element is the main subject of the page.'
		) );

		// Primary Image Of Page
		x_add_metadata_field( 	'pb_primary_image_'.$meta_position, $meta_position, array(
			'group' 		=>	'webpage-type',
			'label' 		=>	'Primary Image Of Page',
			'description'	=>	'Indicates the main image on the page.'
		) );

		// Related Link
		x_add_metadata_field( 	'pb_related_link_'.$meta_position, $meta_position, array(
			'group' 		=>	'webpage-type',
			'label' 		=>	'Related Link',
			'description'	=>	'A link related to this web page, for example to other related web pages.'
		) );

		// Significant Link
		x_add_metadata_field( 	'pb_significant_link_'.$meta_position, $meta_position, array(
			'group' 		=>	'webpage-type',
			'label' 		=>	'Significant Link',
			'description'	=>	'One of the more significant URLs on the page.'
		) );

		// Specialty
		x_add_metadata_field( 	'pb_specialty_'.$meta_position, $meta_position, array(
			'group' 		=>	'webpage-type',
			'label' 		=>	'Specialty',
			'description'	=>	'One of the domain specialities to which this web page\'s content applies.'
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
	 * A function that creates the metadata for webpage type.
	 * @since 0.8.1
	 *
	 */
	public function pmdt_get_metatags() {
		
		//Distinguishing if we are working on a post --- chapter level or on the main site level
		//The type_level variable is the string we used to create the metabox

		if ( $this->type_level == 'chapter' ) { //loading the appropriate metadata depending on the level type
			$metadata = get_post_meta( get_the_ID() );
		} else {
			$metadata = \Pressbooks\Book::getBookInformation();
		}

		// array of the items needed to become microtags
		$book_data = array(
			'mainContentOfPage'     => 'pb_main_content',
			'primaryImageOfPage'    => 'pb_primary_image',
			'relatedLink'           => 'pb_related_link',
			'significantLink'       => 'pb_significant_link',
			'specialty'             => 'pb_specialty'
		);

		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/WebPage">';

		if($this->type_level == 'chapter'){
			$html .= "<meta itemprop = 'lastReviewed' content = '" .get_the_modified_date(). "'>\n";
			$html .= "<meta itemprop = 'reviewedBy' content = '" .get_the_modified_author(). "'>\n";
		}

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
		$html .= '</div>';
		return $html;
	}
}
