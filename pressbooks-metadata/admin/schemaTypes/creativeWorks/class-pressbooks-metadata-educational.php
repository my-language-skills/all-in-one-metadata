<?php

namespace schemaTypes\cw;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;
use schemaTypes\Pressbooks_Metadata_Type;

/**
 * The class for the educational info including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.9
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Educational extends Pressbooks_Metadata_Type {

	public function __construct($type_level_input) {
		parent::__construct($type_level_input);
		$this->class_name = __CLASS__ .'_'. $this->type_level;
		$this->type_settings = array('educational_info' => array('Educational Inforamtion',''));
		//$this->parent_type;
		$this->pmdt_add_metabox($this->type_level);
	}

	/**
	 * Function used for comparing the instances of the schema types
	 *
	 * @since    1.0
	 * @access   public
	 */
	public function __toString() {
		return $this->class_name;
	}

	/**
	 * The function which produces the metaboxes for educational information
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position){

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

		// Interactivity Type
		x_add_metadata_field( 	'pb_interactivity_type_ed', $meta_position, array(
			'group' 		=> 	'educational-information',
			'field_type' 	=> 	'select',
			'values' 		=> 	array(
				'expositive'=> 	'Expositive',
				'mixed' 	=> 	'Mixed',
				'active' 	=> 	'Active'

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
			'group' 		    => 	'educational-information',
			'field_type' 	    => 	'select',
			'values' 		    => 	array(
				'General'	    => 	'General',
				'Mobility'      => 	'Mobility',
				'Communication' =>'Communication',
				'Hearing'       =>'Hearing',
				'Vision'        =>'Vision'
			),
			'label' 		=> 	'Target Description',
			'description' 	=> 	'The description of a node in an established educational framework. <a href="https://ceds.ed.gov/element/001408">Find more here</a>'
		) );

		// Target Url
		x_add_metadata_field( 	'pb_trg_url_ed', $meta_position, array(
			'group' 		=> 	'educational-information',
			'label'			=> 	'Target Url',
			'description' 	=> 	'The URL of a node in an established educational framework. http://example.com'
		) );
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

		$metadata = gen_func::get_metadata();
		$html .= '<div itemscope itemtype="http://schema.org/WebPage">';
		foreach ($book_data as $itemprop => $content){
			$value;
			if($this->type_level == 'site-meta'){
				$value = $this->pmdt_get_first($metadata[$content]);
			}else{
				$value = $metadata[$content];
			}
			if ( isset( $value ) ) {
				//if the schema is timeRequired, we are using a specific format to display it,
				//like the example here: https://schema.org/timeRequired
				if ( 'timeRequired' == $itemprop ) {
					$value = 'PT'. $value.'H';
				}
				$html .= "<meta itemprop = '" . $itemprop . "' content = '" . $value . "'>\n";
			}
		}

		$html .= '</div>';

		if($this->type_level == 'metadata' ) { //loading the appropriate metadata depending on the level type
			$metadata = gen_func::get_metadata();
			$isced_field_value = $metadata[ 'pb_isced_field_ed' ];
			$isced_level_value = $metadata[ 'pb_isced_level_ed' ];
			$edu_level_value =$metadata[ 'pb_edu_level_ed' ];
			$edu_framework_value = $metadata[ 'pb_edu_framework_ed' ];
			$trgt_url = $metadata['pb_trg_url_ed'];
			$trgt_desc = $metadata['pb_trg_desc_ed'];
			$educ_role = $metadata['pb_educational_role_ed'];
		}else{
			$metadata = gen_func::get_metadata();
			$isced_field_value = $this->pmdt_get_first($metadata[ 'pb_isced_field_ed' ]);
			$isced_level_value = $this->pmdt_get_first($metadata[ 'pb_isced_level_ed']);
			$edu_level_value = $this->pmdt_get_first($metadata[ 'pb_edu_level_ed' ]);
			$edu_framework_value = $this->pmdt_get_first($metadata[ 'pb_edu_framework_ed']);
			$trgt_url = $this->pmdt_get_first($metadata['pb_trg_url_ed']);
			$trgt_desc = $this->pmdt_get_first($metadata['pb_trg_desc_ed']);
			$educ_role = $this->pmdt_get_first($metadata['pb_educational_role_ed']);
		}

		//Getting the corresponding isced level
		$level = $this->pmdt_get_isced_code($isced_level_value);


		if ( isset( $metadata['pb_title'] ) ) {
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
			         ."	<meta itemprop = 'alignmentType' content = 'educationalSubject'/>\n"
			         ."	<meta itemprop = 'targetName' content = '" .$metadata['pb_title']. "'>\n"
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


		if(isset($trgt_url) || isset($trgt_desc)){
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
			         ."	<meta itemprop = 'alignmentType' content = 'educationalLevel'/>\n";
			if(isset($trgt_url)){
				$html .= "	<link itemprop='targetUrl' href='".$trgt_url."' />\n";
			}
			if(isset($trgt_desc)){
				$html .= "	<link itemprop='targetDescription' content='".$trgt_desc."' />\n";
			}
			$html .= "</span>\n";
		}

		if(isset($educ_role)){
			$html .= "<span itemprop = 'audience' itemscope itemtype = 'http://schema.org/EducationalAudience'>\n"
			         ."	<meta itemprop = 'educationalRole' content = '$educ_role'/>\n"
			         ."</span>\n";
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