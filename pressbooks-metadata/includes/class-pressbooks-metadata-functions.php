<?php

/**
 * The functions of the plugin.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
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
	public function pmdt_get_Root_level_metatags(){

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
	 * A function to retrieve the metatags we need for the Site level
	 * of the website. In Pressbooks this is the book.
	 *
	 * @since 0.8
	 */
	public function pmdt_get_Site_level_metatags(){
		// array of the items that we need for the Book
		$book_data = array(
		// Here are the fields from General Book Information metabox.
			'illustrator' 			=>	'pb_illustrator',
			'bookEdition'			=>	'pb_edition',
		//	Here are the fields from Educational Information metabox.
			'provider'				=> 	'pb_provider',
			'typicalAgeRange'		=>	'pb_age_range',
			'learningResourceType'	=>	'pb_learning_resource_type',
			'interactivityType'		=>	'pb_interactivity_type',
			'timeRequired'			=>	'pb_time_required',
			'license'				=>	'pb_license_url',
			'isBasedOnUrl'			=>	'pb_bibliography_url'
		);

		$html  = "<!-- Book additional microtags -->\n";

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

		return $html;		
	}

	/**
	 * A function to retrieve the metatags we need for the Post level
	 * of the website. In Pressbooks this is the chapter of the book.
	 *
	 * @since 0.8
	 */
	public function pmdt_get_Post_level_metatags($post){

		$id = $post->ID; 
	// array of the items that we need for the Chapter
		$chapter_data = array(
		// Here we take data from the default fields of wordpress 
			'headline'				=>	$post->post_title,
			'datePublished'			=>	$post->post_date,
			'dateModified'			=>	$post->post_modified,
		// Here are the fields from General Book Information metabox.
			'audience' 				=>	'pb_audience',
			'editor'				=>	'pb_editor',
			'translator'			=>	'pb_translator',
			'locationCreated'		=>	'pb_publisher_city',
		//	Here are the fields from Educational Information metabox.
			'citation'				=> 	'pb_bibliography_url',
			'license'				=>	'pb_license_url',
			'typicalAgeRange'		=>	'pb_age_range',
		// Here are the fields from Chapter Metadata metabox
			'author'				=> 	'pb_section_author',
			'alternativeHeadline'	=>	'pb_subtitle',
		// This plugin's fields in Chapter Metadata metabox
			'discussionUrl'			=>	'pb_questions_and_answers',
			'timeRequired'			=>	'pb_class_learning_time'
		);

		//For the fields from Book Info post type
		$bookinfo = \Pressbooks\Book::getBookInformation();
		//For the fields of Chapter Metadata metabox
		$post_meta = get_post_meta( $id );

		$html 	= "<!-- WebPage additional microtags -->\n";

		foreach ($chapter_data as $itemprop => $content){
			if ( isset( $bookinfo[ $content ] ) ) {
				$html .= "<meta itemprop = '" . $itemprop . "' content = '" . $bookinfo[ $content ] . "'>\n";
			} 
			elseif ( isset( $post_meta[$content] ) ) {
				//if the schema is timeRequired, we are using a specific format to display it,
				//like the example here: https://schema.org/timeRequired
				if ( 'timeRequired' == $itemprop ) {
					$post_meta[ $content ][0] = 'PT'. $post_meta[ $content ][0].'M';
				}
				$html .= "<meta itemprop = '" . $itemprop . "' content = '" . $post_meta[ $content ][0] . "'>\n";
			}
			else{
				$html .= "<meta itemprop = '" . $itemprop . "' content = '" . $content . "'>\n";
			}
		}
		
		return $html;

	}

	/**
	 * A function to retrieve the data we need from the custom fields of PressBooks
	 * for Google Scholar use.
	 *
	 * @since 0.7
	 */
	public function pmdt_get_GoogleScolar_metatags(){

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

		$html  = "<!-- Google Scolar metatags -->\n";

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

	/**
	 * Returns the ISCED level code according to what is
	 * chosen in the 'pb_isced_level' field.
	 *
	 * @since  0.3
	 * @return string 
	 */
	public function pmdt_get_isced_level_code() {

		$meta = \Pressbooks\Book::getBookInformation();

		if ($meta['pb_isced_level'] == 'Early Childhood Education'){
			$level_code = '0';
		}
		elseif ($meta['pb_isced_level'] == 'Primary education') {
			$level_code = '1';
		}
		elseif ($meta['pb_isced_level'] == 'Lower secondary education') {
			$level_code = '2';
		}
		elseif ($meta['pb_isced_level'] == 'Upper secondary education') {
			$level_code = '3';
		}
		elseif ($meta['pb_isced_level'] == 'Post-secondary non-tertiary education') {
			$level_code = '4';
		}
		elseif ($meta['pb_isced_level'] == 'Short-cycle tertiary education') {
			$level_code = '5';
		}
		elseif ($meta['pb_isced_level'] == 'Bachelor’s or equivalent level') {
			$level_code = '6';
		}
		elseif ($meta['pb_isced_level'] == 'Master’s or equivalent level') {
			$level_code = '7';
		}
		elseif ($meta['pb_isced_level'] == 'Doctoral or equivalent level') {
			$level_code = '8';
		}
		else{
			$level_code = '9';
		}

		return $level_code;

	}

	/**
	 * Prints the HTML educationalAlignment meta tags containing microdata information of
	 * metadata contained in this object, for the public part of the book.
	 *
	 * The educationalAlignment properties are not just one line of code but they are more complicated
	 * than the normal ones. So the print_microdata_meta_tags() functions will not work.
	 * Here, if some specific fields are set (subject, isced_field, isced_level...), the code is 
	 * being produced.
	 * 
	 * @since 0.2
	 */
	public function pmdt_get_educationalAlignment_metatags() {

		$meta = \Pressbooks\Book::getBookInformation();
		$level = $this->pmdt_get_isced_level_code();

		$html = '' ;

		if ( isset( $meta['pb_title'] ) ) {
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
				    ."	<meta itemprop = 'alignmentType' content = 'educationalSubject'/>\n"
				    ."	<meta itemprop = 'targetName' content = '" .$meta['pb_title']. "'>\n"
				    ."</span>\n";
		}
		if ( $meta['pb_isced_field'] != '--Select--' ) {
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
				    ."	<meta itemprop = 'alignmentType' content = 'educationalSubject'/>\n"
				    ."	<meta itemprop = 'educationalFramework' content = 'ISCED-2013'/>\n"
				    ."	<meta itemprop = 'targetName' content = '" .$meta['pb_isced_field']. "'>\n"
				    ."</span>\n";
		}
		if ( $meta['pb_isced_level'] != '--Select--' ) {
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
				    ."	<meta itemprop = 'alignmentType' content = 'educationalLevel'/>\n"
				    ."	<meta itemprop = 'educationalFramework' content = 'ISCED-2011'/>\n"
				    ."	<meta itemprop = 'targetName' content = '" .$meta['pb_isced_level']. "'>\n"
				    ."	<meta itemprop = 'alternateName' content = 'ISCED 2011, Level  " .$level. "' />"
				    ."</span>\n";
		}
		if ( isset( $meta['pb_edu_level'] ) && isset( $meta['pb_edu_framework'] )) {
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
				    ."	<meta itemprop = 'alignmentType' content = 'educationalSubject'/>\n"
				    ."	<meta itemprop = 'educationalFramework' content = '" .$meta['pb_edu_framework']. "'>\n"
				    ."	<meta itemprop = 'targetName' content = '" .$meta['pb_edu_level']. "'>\n"
				    ."</span>\n";

		} elseif ( isset( $meta['pb_edu_level'] ) && !isset( $meta['pb_edu_framework'] )) {
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
				    ."	<meta itemprop = 'alignmentType' content = 'educationalLevel'/>\n"
				    ."	<meta itemprop = 'targetName' content = '" .$meta['pb_edu_level']. "'>\n"
				    ."</span>\n";
		}

		return $html;
		
	}
	

}