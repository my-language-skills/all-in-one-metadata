<?php

namespace schemaTypes\cw;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;

/**
 * The class for the music recording type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Music_Recording{

	/**
	 * The type level where these metaboxes and their schema operations will go
	 *
	 * @since    0.x
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
		$this->pmdt_add_metabox($this->type_level);
		$this->class_name = __CLASS__ .'_'. $this->type_level;
	}

	/**
	 * The function which produces the metaboxes for the music recording type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position){
		//----------- metabox ----------- //
		x_add_metadata_group( 	'music-recording', $meta_position, array(
			'label' 		=>	'Music Recording Type Properties',
			'priority' 		=>	'high',
		) );
		//----------- metafields ----------- //
		// By Artist
		x_add_metadata_field( 	'pb_by_artist_'.$meta_position, $meta_position, array(
			'group' 		=>	'music-recording',
			'label' 		=>	'By Artist',
			'description' 	=>	'The artist that performed this album or recording.'
		) );
		// Duration
		x_add_metadata_field( 	'pb_duration_'.$meta_position, $meta_position, array(
			'group' 		=>	'music-recording',
			'label' 		=>	'Duration',
			'description' 	=>	'The duration of the item (movie, audio recording, event, etc.) in ISO 8601 date format.'
		) );
		// In Album
		x_add_metadata_field( 	'pb_in_album_'.$meta_position, $meta_position, array(
			'group' 		=>	'music-recording',
			'label' 		=>	'In Album',
			'description' 	=>	'The album to which this recording belongs.'
		) );
		// In Playlist
		x_add_metadata_field( 	'pb_in_playlist_'.$meta_position, $meta_position, array(
			'group' 		=>	'music-recording',
			'label' 		=>	'In Playlist',
			'description' 	=>	'The playlist to which this recording belongs.'
		) );
		// Isrc Code
		x_add_metadata_field( 	'pb_isrc_code_'.$meta_position, $meta_position, array(
			'group' 		=>	'music-recording',
			'label' 		=>	'Isrc Code',
			'description' 	=>	'The International Standard Recording Code for the recording.'
		) );
		// Recording Of
		x_add_metadata_field( 	'pb_recording_of_'.$meta_position, $meta_position, array(
			'group' 		=>	'music-recording',
			'label' 		=>	'Recording Of',
			'description' 	=>	'The composition this track is a recording of. Inverse property: recordedAs.'
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
	 * A function that creates the metadata for the Music Recording type.
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
		$musicRec_data = array(

			'byArtist' => 'pb_by_artist',
			'duration' => 'pb_duration',
			'inAlbum' => 'pb_in_album',
			'inPlaylist' => 'pb_in_playlist',
			'isrcCode' => 'pb_isrc_code',
			'recordingOf' => 'pb_recording_of'
		);

		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/MusicRecording">';

		foreach ( $musicRec_data as $itemprop => $content ) {
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