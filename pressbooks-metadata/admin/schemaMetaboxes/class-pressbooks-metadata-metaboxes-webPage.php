<?php

/**
 * The metaboxes for the webPage type
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaMetaboxes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */


class Pressbooks_Metadata_Metabox_WebPage {

	public function __construct($meta_position) {
		$this->add_metabox($meta_position);
	}

	/**
	 * The function which produces the metaboxes for the webpage type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since x
	 */
	public function add_metabox($meta_position){

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
}
