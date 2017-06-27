<?php

/**
 * The functions of the plugin that handle metadata for educational information.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaFunctions
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Edu_Functions {

	function __construct() {

	}

	/**
	 * A function for generating the educational metatags
	 *
	 * @since 0.x
	 */
	public function pmdt_get_educational_metatags(){
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
	 * @since 0.x
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