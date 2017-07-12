<?php

namespace schemaTypes;

/**
 * The class for the creativeWork type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Creative_Work {

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
	 * @since    0.x
	 * @access   public
	 */
	public $class_name;

	public function __construct($type_level_input) {
		$this->type_level = $type_level_input;
		$this->add_metabox($this->type_level);
		$this->class_name = __CLASS__ .'_'. $this->type_level;
	}

	/**
	 * The function which produces the metaboxes for creative work
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function add_metabox($meta_position){

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

	/*FUNCTIONS FOR THIS TYPE START HERE*/

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
	 * A function needed for returning the correct level when a user selects isced.
	 * @since 0.8.1
	 *
	 */
	private function pmdt_get_isced_code($isced_value) {

		switch($isced_value){
			case 'Early Childhood Education':
				$level_code = '0';
				break;
			case 'Primary education':
				$level_code = '1';
				break;
			case 'Lower secondary education':
				$level_code = '2';
				break;
			case 'Upper secondary education':
				$level_code = '3';
				break;
			case 'Post-secondary non-tertiary education':
				$level_code = '4';
				break;
			case 'Short-cycle tertiary education':
				$level_code = '5';
				break;
			case 'Bachelor’s or equivalent level':
				$level_code = '6';
				break;
			case 'Master’s or equivalent level':
				$level_code = '7';
				break;
			case 'Doctoral or equivalent level':
				$level_code = '8';
				break;
			default:
				$level_code = '9';
		}
		return $level_code;
	}

	/**
	 * A function that creates the metadata for creative works.
	 * @since 0.8.1
	 *
	 */
	public function pmdt_get_metatags() {

		//Distinguishing if we are working on a post --- chapter level or on the main site level
		//The type_level variable is the string we used to create the metabox

		if($this->type_level == 'chapter') { //loading the appropriate metadata depending on the level type
			$metadata = get_post_meta( get_the_ID());
			$isced_field_value = $this->pmdt_get_first($metadata[ 'pb_isced_field_'.$this->type_level ]);
			$isced_level_value = $this->pmdt_get_first($metadata[ 'pb_isced_level_'.$this->type_level ]);
			$edu_level_value = $this->pmdt_get_first($metadata[ 'pb_edu_level_'.$this->type_level ]);
			$edu_framework_value = $this->pmdt_get_first($metadata[ 'pb_edu_framework_'.$this->type_level ]);
		}else{
			$metadata =  \Pressbooks\Book::getBookInformation();
			$isced_field_value = $metadata['pb_isced_field_'.$this->type_level];
			$isced_level_value = $metadata['pb_isced_level_'.$this->type_level];
			$edu_level_value = $metadata['pb_edu_level_'.$this->type_level];
			$edu_framework_value = $metadata['pb_edu_framework_'.$this->type_level];
		}

		// array of the items needed to become microtags
		$book_data = array(
			'provider'             => 'pb_provider',
			'typicalAgeRange'      => 'pb_age_range',
			'learningResourceType' => 'pb_learning_resource_type',
			'interactivityType'    => 'pb_interactivity_type',
			'timeRequired'         => 'pb_time_required',
			'license'              => 'pb_license_url',
			'isBasedOnUrl'         => 'pb_bibliography_url',
			'discussionUrl'        => 'pb_questions_and_answers'
		);

		$html = "<!-- Microtags --> \n";

		//This code is needed for the book type on chapter level because by default the chapter is a website
		$html .= ($this->type_level == 'chapter' ? '<div itemscope itemtype="http://schema.org/Book">' : '');

		foreach ($book_data as $itemprop => $content){
			if ( isset( $metadata[$content.'_'.$this->type_level] ) ) {

				if($this->type_level == 'chapter'){ //we are using the get_first function to get the value from the returned array
					$value = $this->pmdt_get_first($metadata[ $content.'_'.$this->type_level ]);
				}else{
					$value = $metadata[ $content.'_'.$this->type_level ];
				}

				if ( 'timeRequired' == $itemprop ) { //using a special type for showing time
					$value = 'PT'. $value.'H';
				}
				$html .= "<meta itemprop = '" . $itemprop . "' content = '" . $value . "'>\n";
			}
		}

		$html .= "<!-- Microtags Educational -->\n";
		$pb_meta =  \Pressbooks\Book::getBookInformation(); //Using the default pressbooks fields for some data
		$level = $this->pmdt_get_isced_code($isced_level_value);

		if ( isset( $pb_meta['pb_title'] ) ) {
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
			         ."	<meta itemprop = 'alignmentType' content = 'educationalSubject'/>\n"
			         ."	<meta itemprop = 'targetName' content = '" .$pb_meta['pb_title']. "'>\n"
			         ."</span>\n";
		}
		if ( $isced_field_value != '--Select--' ) {
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
			         ."	<meta itemprop = 'alignmentType' content = 'educationalSubject'/>\n"
			         ."	<meta itemprop = 'educationalFramework' content = 'ISCED-2013'/>\n"
			         ."	<meta itemprop = 'targetName' content = '" .$isced_field_value. "'>\n"
			         ."</span>\n";
		}
		if ( $isced_level_value != '--Select--' ) {
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
			         ."	<meta itemprop = 'alignmentType' content = 'educationalLevel'/>\n"
			         ."	<meta itemprop = 'educationalFramework' content = 'ISCED-2011'/>\n"
			         ."	<meta itemprop = 'targetName' content = '" .$isced_level_value. "'>\n"
			         ."	<meta itemprop = 'alternateName' content = 'ISCED 2011, Level  " .$level. "' />"
			         ."</span>\n";
		}
		if ( isset( $edu_level_value ) && isset( $edu_framework_value )) {
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
			         ."	<meta itemprop = 'alignmentType' content = 'educationalSubject'/>\n"
			         ."	<meta itemprop = 'educationalFramework' content = '" .$edu_framework_value. "'>\n"
			         ."	<meta itemprop = 'targetName' content = '" .$edu_level_value. "'>\n"
			         ."</span>\n";

		} elseif ( isset( $edu_level_value ) && !isset( $edu_framework_value )) {
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
			         ."	<meta itemprop = 'alignmentType' content = 'educationalLevel'/>\n"
			         ."	<meta itemprop = 'targetName' content = '" .$edu_level_value. "'>\n"
			         ."</span>\n";
		}

		//Adding additional data if the type is chapter or post
		$html = ($this->type_level == 'chapter' ? $this->pmdt_additional_info($html) : $html);

		//We close the DIV if the level is of type chapter -> see above the div was opened for chapters and posts
		$html .= ($this->type_level == 'chapter' ? '</div>' : '');

		return $html;
	}

	/**
	 * A function that creates extra metadata for chapters or posts.
	 * @since 0.8.1
	 *
	 */
	private function pmdt_additional_info($html){
		$id = get_the_ID();

		//For the fields from Book Info post type
		$bookinfo = \Pressbooks\Book::getBookInformation();

		$html 	.= "<!-- WebPage additional microtags -->\n";

		$html .= '<meta itemprop = "headline" content = "'.get_the_title($id).'">\n';
		$html .= '<meta itemprop = "datePublished" content = "'.get_the_date($id).'">\n';
		$html .= '<meta itemprop = "dateModified" content = "'.get_the_modified_date().'">\n';
		$html .= '<meta itemprop = "audience" content = "'.$bookinfo['pb_audience'].'">\n';
		$html .= '<meta itemprop = "editor" content = "'.$bookinfo['pb_editor'].'">\n';
		$html .= '<meta itemprop = "translator" content = "'.$bookinfo['pb_translator'].'">\n';
		$html .= '<meta itemprop = "author" content = "'.$bookinfo['pb_section_author'].'">\n';
		$html .= '<meta itemprop = "alternativeHeadline" content = "'.$bookinfo['pb_subtitle'].'">\n';

		return $html;
	}
}
