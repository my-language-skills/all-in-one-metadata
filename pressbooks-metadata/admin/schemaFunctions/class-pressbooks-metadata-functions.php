<?php

/**
 * The functions of the plugin that handle metadata.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Functions {

	function __construct() {

	}

	/**
	 * A function to retrieve the metatags we need for the Root level
	 * of the website. In Pressbooks this is the catalog of the books.
	 *
	 * @since 0.8
	 */
	public function pmdt_get_root_level_metatags(){

		$html  = "<!-- WebSite microtags -->\n"
		         ."<div itemscope itemtype='http://schema.org/Website'>\n"
		         ."	<meta itemprop = 'name' content = '" . get_bloginfo( 'name' ) . "'>\n"
		         ."	<meta itemprop = 'description' content = '" . get_bloginfo( 'description' ) . "'>\n"
		         ."	<meta itemprop = 'url' content = '" . get_bloginfo( 'url' ) . "'>\n"
		         ."	<meta itemprop = 'inLanguage' content = '" . get_bloginfo( 'language' ) . "'>\n"
		         ."</div>\n";

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

	/**
	 * A function needed for the array of metadata that comes from each post or chapter
	 * It automatically returns the first item in the array.
	 * @since 0.x
	 *
	 */
	private function pmdt_get_first($my_array){
		return $my_array[0];
	}

	/**
	 * A function that creates the metadata for book type and creative works.
	 * @since 0.x
	 *
	 */
	public function pmdt_get_book_metatags($level_type) {

		//Distinguishing if we are working on a post --- chapter level or on the main site level
		//The level_type variable is the string we used to create the metabox using the Pressbooks_Metadata_Metabox_Book Class

		if($level_type == 'chapter') { //loading the appropriate metadata depending on the level type
			$metadata = get_post_meta( get_the_ID());
			$isced_field_value = $this->pmdt_get_first($metadata[ 'pb_isced_field_'.$level_type ]);
			$isced_level_value = $this->pmdt_get_first($metadata[ 'pb_isced_level_'.$level_type ]);
			$edu_level_value = $this->pmdt_get_first($metadata[ 'pb_edu_level_'.$level_type ]);
			$edu_framework_value = $this->pmdt_get_first($metadata[ 'pb_edu_framework_'.$level_type ]);
		}else{
			$metadata =  \Pressbooks\Book::getBookInformation();
			$isced_field_value = $metadata['pb_isced_field_'.$level_type];
			$isced_level_value = $metadata['pb_isced_level_'.$level_type];
			$edu_level_value = $metadata['pb_edu_level_'.$level_type];
			$edu_framework_value = $metadata['pb_edu_framework_'.$level_type];
		}

		// array of the items needed to become microtags
		$book_data = array(

			'illustrator'          => 'pb_illustrator',
			'bookEdition'          => 'pb_edition',
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
		$html .= ($level_type == 'chapter' ? '<div itemscope itemtype="http://schema.org/Book">' : '');

		foreach ($book_data as $itemprop => $content){
			if ( isset( $metadata[$content.'_'.$level_type] ) ) {

				if($level_type == 'chapter'){ //we are using the get_first function to get the value from the returned array
					$value = $this->pmdt_get_first($metadata[ $content.'_'.$level_type ]);
				}else{
					$value = $metadata[ $content.'_'.$level_type ];
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
		$html = ($level_type == 'chapter' ? $this->pmdt_additional_info($html) : $html);

		//We close the DIV if the level is of type chapter -> see above the div was opened for chapters and posts
		$html .= ($level_type == 'chapter' ? '</div>' : '');

		return $html;
	}

	/**
	 * A function that creates extra metadata for chapters or posts.
	 * @since 0.x
	 *
	 */
	private function pmdt_additional_info($html){
		$id = get_the_ID();

		//For the fields from Book Info post type
		$bookinfo = \Pressbooks\Book::getBookInformation();

		$html 	.= "<!-- WebPage additional microtags -->\n";

		$html .= '<meta itemprop = "headline" content = "'.get_the_title($id).'">\n';
		$html .= '<meta itemprop = "datePublished" content = "'.get_the_date($id).'">\n';
		$html .= '<meta itemprop = "dateModified" content = "'.the_modified_date('F j, Y').'">\n';
		$html .= '<meta itemprop = "audience" content = "'.$bookinfo['pb_audience'].'">\n';
		$html .= '<meta itemprop = "editor" content = "'.$bookinfo['pb_editor'].'">\n';
		$html .= '<meta itemprop = "translator" content = "'.$bookinfo['pb_translator'].'">\n';
		$html .= '<meta itemprop = "author" content = "'.$bookinfo['pb_section_author'].'">\n';
		$html .= '<meta itemprop = "alternativeHeadline" content = "'.$bookinfo['pb_subtitle'].'">\n';

		return $html;
	}

	/**
	 * A function to retrieve the data we need from the custom fields of PressBooks
	 * for Google Scholar use.
	 *
	 * @since 0.7
	 */
	public function pmdt_get_googleScholar_metatags(){

		// array of the items that we need from the General Book Information metabox
		$book_info_data = array(
			'citation_journal_title'	=>	'pb_title',
			'citation_author' 			=>	'pb_author',
			'citation_language'         => 	'pb_language',
			'citation_keywords'         =>	'pb_keywords_tags',
			'citation_isbn' 			=>	'pb_ebook_isbn',
			'citation_publisher'		=>	'pb_publisher',
			'citation_publication_date'	=>	'pb_publication_date'
		);

		$html  = "<!-- Google Scholar metatags -->\n";

		//For the fields of General Book Information Metabox
		$metadata = \Pressbooks\Book::getBookInformation();

		foreach ($book_info_data as $name => $content){
			if ( isset( $metadata[$content] ) ) {
				// the date must be in a specific format (Y/m/d)
				if ( 'pb_publication_date' == $content ) {
					$metadata[$content] = date( 'Y/m/d', (int) $metadata[ $content ] );
				}
				$html .= "<meta name = '" . $name . "' content = '" . $metadata[ $content ] . "'>\n";
			}
		}
		return $html;
	}
}
			
