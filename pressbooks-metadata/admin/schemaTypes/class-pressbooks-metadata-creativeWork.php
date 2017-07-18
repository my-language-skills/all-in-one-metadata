<?php

namespace schemaTypes;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;
use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;

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
	 * @since    0.9
	 * @access   public
	 */
	public function __toString() {
		return $this->class_name;
	}

	/**
	 * Returns type level.
	 *
	 * @since    0.9
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
	 * A function that creates the metadata for creative works.
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
		$book_data = array(
			'provider'             => 'pb_provider',
			'typicalAgeRange'      => 'pb_age_range',
			'timeRequired'         => 'pb_time_required',
			'license'              => 'pb_license_url',
			'isBasedOnUrl'         => 'pb_bibliography_url',
			'discussionUrl'        => 'pb_questions_and_answers'
		);

		$html = "<!-- Microtags --> \n";
		$html .= '<body itemscope itemtype="http://schema.org/WebPage">';
		foreach ($book_data as $itemprop => $content){
			if ( isset( $metadata[$content.'_'.$this->type_level] ) ) {

				if(!$is_site){ //we are using the get_first function to get the value from the returned array
					$value = $this->pmdt_get_first($metadata[ $content.'_'.$this->type_level ]);
				}else{
					if($this->type_level == 'site-meta'){
						$value = $this->pmdt_get_first($metadata[ $content . '_' . $this->type_level ]);
					}else{ //We always use the get_first function except if our level is metadata coming from pressbooks
						$value = $metadata[ $content . '_' . $this->type_level ];
					}
				}
				if ( 'timeRequired' == $itemprop ) { //using a special type for showing time
					$value = 'PT'. $value.'H';
				}
				$html .= "<meta itemprop = '" . $itemprop . "' content = '" . $value . "'>\n";
			}
		}

		$id = get_the_ID();

		$html 	.= "<!-- WebPage additional microtags -->\n";
		$html .= '<meta itemprop = "headline" content = "'.get_the_title($id).'">';
		$html .= '<meta itemprop = "datePublished" content = "'.get_the_date($id).'">';
		$html .= '<meta itemprop = "dateModified" content = "'.get_the_modified_date().'">';

		if(site_cpt::pressbooks_identify()){
			//For the fields from Book Info post type
			$bookinfo = \Pressbooks\Book::getBookInformation();

			$book_data = array(
				'audience'=>'pb_audience',
				'editor'=>'pb_editor',
				'translator'=>'pb_translator',
				'author'=>'pb_section_author',
				'alternativeHeadline'=>'pb_subtitle'
			);

			foreach($book_data as $itemprop => $content){
				if(isset($bookinfo[$content])){
					$html .= '<meta itemprop = "'.$bookinfo[$itemprop].'" content = "'.$bookinfo[$content].'">\n';
				}
			}
		}
		$html .= '</div>';
		return $html;
	}
}
