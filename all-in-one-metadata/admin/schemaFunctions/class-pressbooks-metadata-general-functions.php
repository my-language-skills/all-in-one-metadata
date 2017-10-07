<?php

namespace schemaFunctions;
use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;
use schemaTypes\Pressbooks_Metadata_Type_Structure as structure;

/**
 * The functions of the plugin that handle general metadata.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaFunctions
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_General_Functions {

	function __construct() {

	}

	/**
	 * A function that returns the active parent from the parent filter
	 * @since 0.x
	 */
	public static function get_active_parent(){
		$enabledParent = get_option('parent_filter_settings');
		$enabledParent = $enabledParent['radio1'];
		$parentNamespaces = structure::$allParents;
		foreach($parentNamespaces as $parent){
			if($parent::type_name[1] == $enabledParent){
				return $parent;
			}
		}
	}

	/**
	 * Function used to remove null values from an array
	 * @since  0.10
	 */
	public static function remove_null($array) {
		$cleanArray = array();
		foreach($array as $item){
			if($item != NULL){
				$cleanArray[]=$item;
			}
		}
		return $cleanArray;
	}

	/**
	 * Function used to extract the name of the type from its settings
	 * @since  0.10
	 */
	static public function get_type_id($type) {
		foreach($type::$type_setting as $typeId => $details) {
			return $typeId;
		}
	}

	/**
	 * A function that returns the correct metadata for the schemaTypes classes
	 * If pressbooks is installed we return the metadata for the Book Info information
	 * If pressbooks is not installed we return the Site Meta metadata
	 * @since 0.9
	 */
	public static function get_metadata(){
		if(!site_cpt::pressbooks_identify()){
			return site_cpt::get_site_meta_metadata();
		}else{
			return \Pressbooks\Book::getBookInformation();
		}
	}

	/**
	 * A function to retrieve the metatags we need for the Root level
	 * of the website. In Pressbooks this is the catalog of the books.
	 *
	 * @since 0.8
	 */
	public function get_root_level_metatags(){

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
	 * A function to retrieve the data we need from the custom fields of PressBooks
	 * for Google Scholar use.
	 *
	 * @since 0.7
	 */
	public function get_googleScholar_metatags(){

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

