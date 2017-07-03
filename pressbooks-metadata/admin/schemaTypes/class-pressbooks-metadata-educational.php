<?php
//learning object metadata
//lom
/**
 * The class for the educational info including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Educational {

	/**
	 * The type level where these metaboxes and their schema operations will go
	 *
	 * @since    0.x
	 * @access   private
	 */
	private $type_level;

	public function __construct($type_level_input) {
		$this->type_level = $type_level_input;
		$this->add_metabox($this->type_level);
	}

	/**
	 * The function which produces the metaboxes for educational information
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function add_metabox($meta_position){

		//----------- metabox ----------- //

		// A new metabox called "Educational Information"
		x_add_metadata_group( 	'educational-information',$meta_position, array(
			'label' 		=>	'Educational Information',
			'priority' 		=>	'high'
		) );

		//----------- metafields ----------- //

		// ISCED field of education
		x_add_metadata_field( 	'pb_isced_field_ed', $meta_position, array(
			'group' 		=>	'educational-information',
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
			'description' 	=> 	'Broad field of education according to ISCED-F 2013.'. '<br><a target="_blank" href="http://alliance4universities.eu/wp-content/uploads/2017/03/ISCED-2013-Fields-of-education.pdf">Click Here for more information</a>'
		) );

		// ISCED level of education
		x_add_metadata_field( 	'pb_isced_level_ed', $meta_position, array(
			'group' 		=> 	'educational-information',
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
			'description' 	=> 'Level of education according to ISCED-P 2011'.'<br><a target="_blank" href="http://www.uis.unesco.org/Education/Documents/isced-2011-en.pdf">Click Here for more information</a>'
		) );

		// Age Range
		x_add_metadata_field( 	'pb_age_range_ed', $meta_position, array(
			'group' 		=> 	'educational-information',
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
			'description'	 	=> 	'The target age of this book'
		) );

		// Educational Level
		x_add_metadata_field( 	'pb_edu_level_ed', $meta_position, array(
			'group' 		=> 	'educational-information',
			'label'			=> 	'Educational Level',
			'description' 	=> 	'The level of this subject. For ex. B1 for an English Course, or Grade 2 for a Physics Course.'
		) );

		// Educational Framework
		x_add_metadata_field( 	'pb_edu_framework_ed', $meta_position, array(
			'group' 		=> 	'educational-information',
			'label'			=> 	'Educational Framework',
			'description' 	=> 	'The Framework that the educational level belongs to. Example: CEFR, Common Core, European Baccalaureate'
		) );

		// Learning Resource Type
		x_add_metadata_field( 	'pb_learning_resource_type_ed', $meta_position, array(
			'group' 		=> 	'educational-information',
			'field_type' 	=> 	'select',
			'values' 		=> 	array(
				'course'	=> 	'Course',
				'exam'		=> 	'Examination',
				'exercise'	=> 	'Exercise'
			),
			'label' 		=> 	'Learning Resource Type',
			'description' 	=> 	'The kind of resource this book represents'
		) );

		// Learning Resource Type
		x_add_metadata_field( 	'pb_interactivity_type_ed', $meta_position, array(
			'group' 		=> 	'educational-information',
			'field_type' 	=> 	'select',
			'values' 		=> 	array(
				'active' 	=> 	'Active',
				'expositive'=> 	'Expositive',
				'mixed' 	=> 	'Mixed'
			),
			'label' 		=> 	'Interactivity Type',
			'description' 	=> 	'The interactivity type of this book'
		) );

		// Class Learning Time
		x_add_metadata_field( 	'pb_time_required_ed', $meta_position, array(
			'group' 		=> 	'educational-information',
			'field_type'	=> 	'number',
			'label' 		=> 	'Class Learning Time (hours)',
			'description' 	=> 	'The study time required for the book'
		) );

		// Educational Role
		x_add_metadata_field( 	'pb_educational_role_ed', $meta_position, array(
			'group' 		=> 	'educational-information',
			'field_type' 	=> 	'select',
			'values' 		=> 	array(
				'Students'	=> 	'Students',
				'Teachers'  => 	'Teachers'
			),
			'label' 		=> 	'Educational Role',
			'description' 	=> 	'An educationalRole of an EducationalAudience.'
		) );

		// Educational Use
		x_add_metadata_field( 	'pb_edu_use_ed', $meta_position, array(
			'group' 		=> 	'educational-information',
			'label'			=> 	'Educational Use',
			'description' 	=> 	'The purpose of a work in the context of education; for example, \'assignment\', \'group work\'.'
		) );

		// Target Description
		x_add_metadata_field( 	'pb_trg_desc_ed', $meta_position, array(
			'group' 		=> 	'educational-information',
			'label'			=> 	'Target Description',
			'description' 	=> 	'The description of a node in an established educational framework. <a href="https://ceds.ed.gov/element/001408">Find more here</a>'
		) );

		// Target Url
		x_add_metadata_field( 	'pb_trg_url_ed', $meta_position, array(
			'group' 		=> 	'educational-information',
			'label'			=> 	'Target Url',
			'description' 	=> 	'The URL of a node in an established educational framework. http://example.com'
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
	 * A function for generating the educational metatags
	 *
	 * @since 0.8.1
	 */
	public function pmdt_get_metatags(){
		$book_data = array(
			//	Here are the fields from Educational Information metabox.
			'typicalAgeRange'		=>	'pb_age_range_ed',
			'learningResourceType'	=>	'pb_learning_resource_type_ed',
			'interactivityType'		=>	'pb_interactivity_type_ed',
			'timeRequired'			=>	'pb_time_required_ed',
			'educationalUse'        =>  'pb_edu_use_ed'
		);

		$html  = "<!-- Educational Microtags -->\n";

		$metadata = \Pressbooks\Book::getBookInformation();

		foreach ($book_data as $itemprop => $content){
			if ( isset( $metadata[$content] ) ) {
				//if the schema is timeRequired, we are using a specific format to display it,
				//like the example here: https://schema.org/timeRequired
				if ( 'timeRequired' == $itemprop ) {
					$metadata[ $content ] = 'PT'. $metadata[ $content ].'H';
				}
				$html .= "<meta itemprop = '" . $itemprop . "' content = '" . $metadata[ $content ] . "'>\n";
			}
		}

		//Getting the corresponding isced level
		$level = $this->pmdt_get_isced_code($metadata['pb_isced_level_ed']);


		if ( isset( $metadata['pb_title'] ) ) {
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
			         ."	<meta itemprop = 'alignmentType' content = 'educationalSubject'/>\n"
			         ."	<meta itemprop = 'targetName' content = '" .$metadata['pb_title']. "'>\n"
			         ."</span>\n";
		}
		if ( $metadata['pb_isced_field_ed'] != '--Select--' ) {
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
			         ."	<meta itemprop = 'alignmentType' content = 'educationalSubject'/>\n"
			         ."	<meta itemprop = 'educationalFramework' content = 'ISCED-2013'/>\n"
			         ."	<meta itemprop = 'targetName' content = '" .$metadata['pb_isced_field_ed']. "'>\n"
			         ."</span>\n";
		}
		if ( $metadata['pb_isced_level_ed'] != '--Select--' ) {
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
			         ."	<meta itemprop = 'alignmentType' content = 'educationalLevel'/>\n"
			         ."	<meta itemprop = 'educationalFramework' content = 'ISCED-2011'/>\n"
			         ."	<meta itemprop = 'targetName' content = '" .$metadata['pb_isced_level_ed']. "'>\n"
			         ."	<meta itemprop = 'alternateName' content = 'ISCED 2011, Level  " .$level. "' />"
			         ."</span>\n";
		}
		if ( isset( $metadata['pb_edu_level_ed'] ) && isset( $metadata['pb_edu_framework_ed'] )) {
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
			         ."	<meta itemprop = 'alignmentType' content = 'educationalSubject'/>\n"
			         ."	<meta itemprop = 'educationalFramework' content = '" .$metadata['pb_edu_framework_ed']. "'>\n"
			         ."	<meta itemprop = 'targetName' content = '" .$metadata['pb_edu_level_ed']. "'>\n"
			         ."</span>\n";

		} elseif ( isset( $metadata['pb_edu_level_ed'] ) && !isset( $metadata['pb_edu_framework_ed'] )) {
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
			         ."	<meta itemprop = 'alignmentType' content = 'educationalLevel'/>\n"
			         ."	<meta itemprop = 'targetName' content = '" .$metadata['pb_edu_level_ed']. "'>\n"
			         ."</span>\n";
		}

		if(isset($metadata['pb_trg_url_ed']) || isset($metadata['pb_trg_desc_ed'])){
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
			         ."	<meta itemprop = 'alignmentType' content = 'educationalLevel'/>\n";
			if(isset($metadata['pb_trg_url_ed'])){
				$html .= "	<link itemprop='targetUrl' href='".$metadata['pb_trg_url_ed']."' />\n";
			}
			if(isset($metadata['pb_trg_desc_ed'])){
				$html .= "	<link itemprop='targetDescription' content='".$metadata['pb_trg_desc_ed']."' />\n";
			}
			$html .= "</span>\n";
		}

		if(isset($metadata['pb_educational_role_ed'])){
			$html .= "<span itemprop='audience' itemscope itemtype='http://schema.org/EducationalAudience'>
       		 <span itemprop='educationalRole'>".$metadata['pb_educational_role_ed']."</span></span>s.";
		}
		return $html;
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
}