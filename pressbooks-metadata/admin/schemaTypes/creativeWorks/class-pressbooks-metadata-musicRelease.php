<?php

namespace schemaTypes\cw;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;

/**
 * The class for the music release type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_MusicRelease {

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
	public static $type_settings = array('musicRelease_type' => array('Music Release Type','http://schema.org/MusicRelease'));

	public function __construct($type_level_input) {
		$this->type_level = $type_level_input;
		$this->pmdt_add_metabox($this->type_level);
		$this->class_name = __CLASS__ .'_'. $this->type_level;
	}
	/**
	 * The function which produces the metaboxes for the book type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position){
		//The meta_position variable is the one that identifies where the metabox should go, on what level, like chapter / post or metadata / book
		//----------- metabox ----------- //
		x_add_metadata_group( 	'MusicRelease', $meta_position, array(
			'label' 		=>	'MusicRelease Type Properties',
			'priority' 		=>	'high',
		) );
		//----------- metafields ----------- //
		//All Metafields i.e pb_illustrator append the meta_position at the end of the string so we can distinguish when getting info from the database
		// Catalog Number
		x_add_metadata_field( 	'pb_catalogNumber_'.$meta_position, $meta_position, array(
			'group' 		=> 	'MusicRelease',
			'label' 		=> 	'Catalog Number',
			'description'   =>  'The catalog number for the release.'
		) );
		// Credited To
		x_add_metadata_field( 	'pb_creditedTo_'.$meta_position, $meta_position, array(
			'group' 		=>	'MusicRelease',
			'label' 		=>	'Credited To',
			'description'	=>	'The group the release is credited to if different than the byArtist. For example, Red and Blue is credited to "Stefani Germanotta Band", but by Lady Gaga.'
		) );
		// Duration
		x_add_metadata_field( 	'pb_duration_'.$meta_position, $meta_position, array(
			'group' 		=>	'MusicRelease',
			'label' 		=>	'Duration',
			'description'	=>	'The duration of the item (movie, audio recording, event, etc.) in ISO 8601 date format.'
		) );
		// Music Release Format
		x_add_metadata_field( 	'pb_musicReleaseFormat_'.$meta_position, $meta_position, array(
			'group' 		=>	'MusicRelease',
			'label' 		=>	'Music Release Format',
			'description'	=>	'Format of this release (the type of recording media used, ie. compact disc, digital media, LP, etc.).'
		) );
		
		// Record Label
		x_add_metadata_field( 	'pb_recordLabel_'.$meta_position, $meta_position, array(
			'group' 		=>	'MusicRelease',
			'label' 		=>	'Record Label',
			'description'	=>	'The label that issued the release.'
		) );
		
		// Release Of
		x_add_metadata_field( 	'pb_releaseOf_'.$meta_position, $meta_position, array(
			'group' 		=>	'MusicRelease',
			'label' 		=>	'Release Of',
			'description'	=>	'The album this is a release of.
								<br>Inverse property: albumRelease.'
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
		return new Pressbooks_Metadata_Music_Playlist($this->type_level);
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
	 * A function that creates the metadata for the book type.
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
		$MusicRelease_data = array(

			'catalogNumber' => 'pb_catalogNumber',
			'creditedTo' => 'pb_creditedTo',
			'duration' => 'pb_duration',
			'musicReleaseFormat' => 'pb_musicReleaseFormat',
			'recordLabel' => 'pb_recordLabel',
			'releaseOf' => 'pb_releaseOf'
		);

		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/MusicRelease">';

		foreach ( $MusicRelease_data as $itemprop => $content ) {
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