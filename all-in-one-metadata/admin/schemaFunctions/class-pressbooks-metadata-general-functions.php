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
	 * A function used to retrieve all children types of a parent
	 *
	 * @since 0.10
	 */
	private static function get_parent_children($parent){
		$childrenNamespaces = structure::$allSchemaTypes;
		$foundChildren = array();
		foreach($childrenNamespaces as $children){
			$currentChildrenParents = $children::$type_parents;
			if(in_array($parent,$currentChildrenParents)){
				$foundChildren []= $children;
			}
		}
		return $foundChildren;
	}

	/**
	 * A function used to retrieve all parent types along with their children
	 *
	 * @since 0.10
	 */
	public static function get_all_parents(){
		$parentNamespaces = structure::$allParents;
		$childStore = array();
		foreach($parentNamespaces as $parent){
			$childStore []= self::get_parent_children($parent);
		}
		return array_combine($parentNamespaces,$childStore);
	}

	/**
	 * A function that returns activated parents
	 * @since 0.10
	 */
	public static function get_activated_parents($name = false){
		$parentNamespaces = structure::$allParents;
		$activeParentsStore = array();
		foreach($parentNamespaces as $parent){
			if(get_option($parent::type_name[1].'_filter_setting')){
				$activeParentsStore []= $name == false ? $parent : $parent::type_name;
			}
		}
		return $activeParentsStore;
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

