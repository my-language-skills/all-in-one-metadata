<?php

/**
 * The metaboxes for the creative work type
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/metaboxes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Metabox_Creative_Work {

	public function __construct($meta_position) {
		$this->add_metabox($meta_position);
	}

	/**
	 * The function which produces the metaboxes for creative work
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.x
	 */
	public function add_metabox($meta_position){

		//----------- metabox ----------- //

		x_add_metadata_group( 	'creative-work', $meta_position, array(
			'label' 		=>	'Creative Work Properties',
			'priority' 		=>	'high',
		) );

		//----------- metafields ----------- //

		// Provider
		x_add_metadata_field( 	'pb_provider_'.$meta_position, $meta_position, array(
			'group' 		=>	'creative-work',
			'label' 		=>	'Provider',
			'description' 	=>	'The Organization, University or Person who provides this subject.'
		) );

		// ISCED field of education
		x_add_metadata_field( 	'pb_isced_field_'.$meta_position, $meta_position, array(
			'group' 		=>	'creative-work',
			'field_type' 	=>	'select',
			'values' 		=>	array(
				'--Select--'										=>	'--Select--',
				'Generic programmes and qualifications' 			=>	'Generic programmes and qualifications',
				'Education' 										=>	'Education',
				'Arts and humanities' 								=> 	'Arts and humanities',
				'Social sciences, journalism and information' 		=> 	'Social sciences, journalism and information',
				'Business, administration and law' 					=> 	'Business, administration and law',
				'Natural sciences, mathematics and statistics' 		=> 	'Natural sciences, mathematics and statistics',
				'Information and Communication Technologies' 		=> 	'Information and Communication Technologies',
				'Engineering, manufacturing and construction' 		=> 	'Engineering, manufacturing and construction',
				'Agriculture, forestry, fisheries and veterinary' 	=> 	'Agriculture, forestry, fisheries and veterinary',
				'Health and welfare' 								=> 	'Health and welfare',
				'Services' 											=> 	'Services',
			),
			'label' 		=> 	'ISCED field of education',
			'description' 	=> 	'Broad field of education according to ISCED-F 2013.'. '<br><a target="_blank" href="http://alliance4universities.eu/wp-content/uploads/2017/03/ISCED-2013-Fields-of-education.pdf">Click Here for more information</a>',
		) );

		// ISCED level of education
		x_add_metadata_field( 	'pb_isced_level_'.$meta_position, $meta_position, array(
			'group' 		=> 	'creative-work',
			'field_type' 	=> 	'select',
			'values' 		=> 	array(
				'--Select--'								=> 	'--Select--',
				'Early Childhood Education' 				=> 	'Early Childhood Education',
				'Primary education' 						=> 	'Primary education',
				'Lower secondary education' 				=> 	'Lower secondary education',
				'Upper secondary education' 				=> 	'Upper secondary education',
				'Post-secondary non-tertiary education' 	=> 	'Post-secondary non-tertiary education',
				'Short-cycle tertiary education' 			=> 	'Short-cycle tertiary education',
				'Bachelor’s or equivalent level' 			=> 	'Bachelor’s or equivalent level',
				'Master’s or equivalent level' 				=> 	'Master’s or equivalent level',
				'Doctoral or equivalent level' 				=> 	'Doctoral or equivalent level',
				'Not elsewhere classified' 					=> 	'Not elsewhere classified',
			),
			'label' 		=> 'ISCED level of education',
			'description' 	=> 'Level of education according to ISCED-P 2011'.'<br><a target="_blank" href="http://www.uis.unesco.org/Education/Documents/isced-2011-en.pdf">Click Here for more information</a>',
		) );

		// Age Range
		x_add_metadata_field( 	'pb_age_range_'.$meta_position, $meta_position, array(
			'group' 		=> 	'creative-work',
			'field_type' 	=> 	'select',
			'values' 		=> 	array(
				'18-' 		=> 	'Adults',
				'17-18'		=> 	'17-18 years',
				'16-17' 	=> 	'16-17 years',
				'15-16' 	=> 	'15-16 years',
				'14-15' 	=> 	'14-15 years',
				'13-14' 	=> 	'13-14 years',
				'12-13' 	=> 	'12-13 years',
				'11-12' 	=> 	'11-12 years',
				'10-11' 	=> 	'10-11 years',
				'9-10'  	=> 	 '9-10 years',
				'8-9'  		=> 	  '8-9 years',
				'7-8'  		=> 	  '7-8 years',
				'6-7'  		=> 	  '6-7 years',
				'3-5'	  	=> 	  '3-5 years'
			),
			'label'	 			=> 	'Age Range',
			'description'	 	=> 	'The target age of this book',
		) );

		// Educational Level
		x_add_metadata_field( 	'pb_edu_level_'.$meta_position, $meta_position, array(
			'group' 		=> 	'creative-work',
			'label'			=> 	'Educational Level',
			'description' 	=> 	'The level of this subject. For ex. B1 for an English Course, or Grade 2 for a Physics Course.',
		) );

		// Educational Framework
		x_add_metadata_field( 	'pb_edu_framework_'.$meta_position, $meta_position, array(
			'group' 		=> 	'creative-work',
			'label'			=> 	'Educational Framework',
			'description' 	=> 	'The Framework that the educational level belongs to. Example: CEFR, Common Core, European Baccalaureate',
		) );

		// Learning Resource Type
		x_add_metadata_field( 	'pb_learning_resource_type_'.$meta_position, $meta_position, array(
			'group' 		=> 	'creative-work',
			'field_type' 	=> 	'select',
			'values' 		=> 	array(
				'course'	=> 	'Course',
				'exam'		=> 	'Examination',
				'exercise'	=> 	'Exercise'
			),
			'label' 		=> 	'Learning Resource Type',
			'description' 	=> 	'The kind of resource this book represents',
		) );

		// Learning Resource Type
		x_add_metadata_field( 	'pb_interactivity_type_'.$meta_position, $meta_position, array(
			'group' 		=> 	'creative-work',
			'field_type' 	=> 	'select',
			'values' 		=> 	array(
				'active' 	=> 	'Active',
				'expositive'=> 	'Expositive',
				'mixed' 	=> 	'Mixed'
			),
			'label' 		=> 	'Interactivity Type',
			'description' 	=> 	'The interactivity type of this book',
		) );

		// Class Learning Time
		x_add_metadata_field( 	'pb_time_required_'.$meta_position, $meta_position, array(
			'group' 		=> 	'creative-work',
			'field_type'	=> 	'number',
			'label' 		=> 	'Class Learning Time (hours)',
			'description' 	=> 	'The study time required for the book'
		) );

		// License URL
		x_add_metadata_field( 	'pb_license_url_'.$meta_position, $meta_position, array(
			'group' 		=> 	'creative-work',
			'label' 		=> 	'License URL',
			'description' 	=> 	'The url of the website with the license of this book.',
			'placeholder' 	=>	'http://site.com/'
		) );

		// Bibliography URL
		x_add_metadata_field( 	'pb_bibliography_url_'.$meta_position, $meta_position, array(
			'group' 		=> 	'creative-work',
			'label' 		=> 	'Bibliography URL',
			'description' 	=> 	'The URL of a website/book this book is inspirated of.',
			'placeholder' 	=>	'http://site.com/'
		) );

		// Questions and answers
		x_add_metadata_field( 	'pb_questions_and_answers_'.$meta_position, $meta_position , array(
			'group' 		=>	'creative-work',
			'label' 		=>	'Questions and answers',
			'description'	=>	'The URL of a forum/discussion about this page.',
			'placeholder' 	=>	'http://site.com/'
		) );
	}
}
