<?php

namespace schemaTypes\cw;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;

/**
 * The class for the article type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Article {

	/**
	 * The type level where these metaboxes and their schema operations will go
	 *
	 * @since    0.9
	 * @access   private
	 */
	private $type_level;

	/**
	 * The name of the class along with the type_level
	 * Used to identify each type differently so we can eliminate parent types not needed
	 *
	 * @since    0.9
	 * @access   public
	 */
	public $class_name;

	/**
	 * The variable that holds the values for the settings for this schema type
	 *
	 * @since    0.x
	 * @access   public
	 */
	public static $type_settings = array('article_type' => array('Article Type','http://schema.org/Article'));

	public function __construct($type_level_input) {
		$this->type_level = $type_level_input;
		$this->pmdt_add_metabox($this->type_level);
		$this->class_name = __CLASS__ .'_'. $this->type_level;
	}

	/**
	 * The function which produces the metaboxes for the article type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position){
		//----------- metabox ----------- //
		x_add_metadata_group( 	'article-type', $meta_position, array(
			'label' 		=>	'Article Type Properties',
			'priority' 		=>	'high',
		) );
		//----------- metafields ----------- //
		// Article Body
		x_add_metadata_field( 	'pb_articlebody_'.$meta_position, $meta_position, array(
			'group' 		=> 	'article-type',
			'label' 		=> 	'Article Body',
		) );
		// Article Section
		x_add_metadata_field( 	'pb_articlesection_'.$meta_position, $meta_position, array(
			'group' 		=>	'article-type',
			'label' 		=>	'Article Section',
			'description'	=>	'The section of the article. Example: First Section or 1 or 1.0.0',
		) );
		x_add_metadata_field( 	'pb_pageend_'.$meta_position, $meta_position, array(
			'group' 		=>	'article-type',
			'label' 		=>	'Article Page End',
			'description'	=>	'The page on which the work ends. Example: 138 or xvi.',
		) );
		x_add_metadata_field( 	'pb_pagestart_'.$meta_position, $meta_position, array(
			'group' 		=>	'article-type',
			'label' 		=>	'Article Page Start',
			'description'	=>	'The page on which the work starts. Example: 135 or xiii.',
		) );
		x_add_metadata_field( 	'pb_pagination_'.$meta_position, $meta_position, array(
			'group' 		=>	'article-type',
			'label' 		=>	'Article Paginaton',
			'description'	=>	'Any description of pages that is not separated into pageStart and pageEnd. Example, 1-6, 9, 55 or 10-12, 46-49.',
		) );
		x_add_metadata_field( 	'pb_wordcount_'.$meta_position, $meta_position, array(
			'group' 		=>	'article-type',
			'label' 		=>	'Article Word Count',
			'description'	=>	'The number of words in the text of the Article.',
		) );
	}

		/*FUNCTIONS FOR THIS TYPE START HERE*/

	/**
	 * Function used for comparing the instances of the schema types
	 *
	 * @since    0.9
	 * @access   public
	 */
	public function __toString() {
		return $this->class_name;
	}

	/**
	 * Returns the father for the type.
	 *
	 * @since    0.9
	 * @access   public
	 */
	public function pmdt_parent_init(){
		return new Pressbooks_Metadata_Creative_Work($this->type_level);
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
	 * A function that creates the metadata for the article type.
	 * @since 0.8.1
	 *
	 */
	public function pmdt_get_metatags() {
		//Distinguishing if we are working on a post --- chapter level or on the main site level
		//The type_level variable is the string we used to create the metabox

		$is_site; // This bool var is used to identify if the level is site level or any other post level
		if ( $this->type_level == 'metadata' || $this->type_level == 'site-meta' ) { //loading the appropriate metadata depending on the type level
			$metadata = gen_func::get_metadata();
			$is_site = true;
		} else {
			$is_site = false;
			$metadata = get_post_meta( get_the_ID() );
		}

		// array of the items needed to become microtags
		$article_data = array(

			'articleBody' => 'pb_articlebody',
			'articleSection' => 'pb_articlesection',
			'pageEnd' => 'pb_pageend',
			'pageStart' => 'pb_pagestart',
			'paginaton' => 'pb_pagination',
			'wordCount' => 'pb_wordcount'

		);

		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/Article">';

		foreach ( $article_data as $itemprop => $content ) {
			if ( isset( $metadata[ $content . '_' . $this->type_level ] ) ) {

				if ( !$is_site ) { //we are using the get_first function to get the value from the returned array
					$value = $this->pmdt_get_first( $metadata[ $content . '_' . $this->type_level ] );
				} else {
					if($this->type_level == 'site-meta'){
						$value = $this->pmdt_get_first($metadata[ $content . '_' . $this->type_level ]);
					}else{//We always use the get_first function except if our level is metadata coming from pressbooks
						$value = $metadata[ $content . '_' . $this->type_level ];
					}
				}
				$html .= "<meta itemprop = '" . $itemprop . "' content = '" . $value . "'>\n";
			}
		}
		$html .= '</div>';
		return $html;
	}
}