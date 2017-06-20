<?php

/**
 * The metaboxes for the course type
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/metaboxes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */


class Pressbooks_Metadata_Metabox_Course {

	public function __construct($meta_position) {
		$this->add_metabox($meta_position);
	}

	/**
	 * The function which produces the metaboxes for the course type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since x
	 */
	public function add_metabox($meta_position){

		//----------- metabox ----------- //

		x_add_metadata_group( 	'course-type', $meta_position, array(
			'label' 		=>	'Course Type Properties',
			'priority' 		=>	'high'
		) );

		//----------- metafields ----------- //

		// Course Code
		x_add_metadata_field( 	'pb_course_code_'.$meta_position, $meta_position, array(
			'group' 		=> 	'course-type',
			'label' 		=> 	'Course Code',
			'description'   =>  'The identifier for the Course used by the course provider (e.g. CS101 or 6.001).'
		) );

		// Course Prerequisites
		x_add_metadata_field( 	'pb_course_prerequisites_'.$meta_position, $meta_position, array(
			'group' 		=>	'course-type',
			'label' 		=>	'Course Prerequisites',
			'description'	=>	'Requirements for taking the Course.'
		) );

		// Course Name
		x_add_metadata_field( 	'pb_course_name_'.$meta_position, $meta_position, array(
			'group' 		=>	'course-type',
			'label' 		=>	'Course Name'
		) );

		// Course Decription
		x_add_metadata_field( 	'pb_course_description_'.$meta_position, $meta_position, array(
			'group' 		=>	'course-type',
			'label' 		=>	'Course Description'
		) );
	}
}
