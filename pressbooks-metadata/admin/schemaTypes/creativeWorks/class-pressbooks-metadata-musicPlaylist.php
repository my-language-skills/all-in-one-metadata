<?php

namespace schemaTypes\cw;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;
use schemaTypes\Pressbooks_Metadata_Type;

/**
 * The class for the music playlist  type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Music_Playlist extends Pressbooks_Metadata_Type {

	public function __construct($type_level_input) {
		parent::__construct($type_level_input);
		$this->class_name = __CLASS__ .'_'. $this->type_level;
		$this->type_settings = array('musicPlaylist_type'=> array('Music Playlist Type','http://schema.org/MusicPlaylist'));
		$this->parent_type = new Pressbooks_Metadata_Creative_Work($this->type_level);
		$this->pmdt_add_metabox($this->type_level);
	}

	/**
	 * Function used for comparing the instances of the schema types
	 *
	 * @since    0.x
	 * @access   public
	 */
	public function __toString() {
		return $this->class_name;
	}

	/**
	 * The function which produces the metaboxes for the music playlist type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position){
		//----------- metabox ----------- //
		x_add_metadata_group( 	'music-playlist', $meta_position, array(
			'label' 		=>	'Music Playlist Type Properties',
			'priority' 		=>	'high',
		) );
		//----------- metafields ----------- //
		// Num Tracks
		x_add_metadata_field( 	'pb_numtracks_'.$meta_position, $meta_position, array(
			'group' 		=>	'music-playlist',
			'label' 		=>	'Num Tracks',
			'description' 	=>	'The number of tracks in this album or playlist.'
		) );
		// Track
		x_add_metadata_field( 	'pb_track_'.$meta_position, $meta_position, array(
			'group' 		=>	'music-playlist',
			'label' 		=>	'Track',
			'description' 	=>	'A music recording (track)—usually a single song. If an ItemList is given, the list should contain items of type MusicRecording. Supersedes tracks.'
		) );
	}

	/**
	 * A function that creates the metadata for the Music Playlist type.
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
		$musicPlaylist_data = array(

			'numTracks' => 'pb_numtracks',
			'track' => 'pb_track'

		);

		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/MusicPlaylist">';

		foreach ( $musicPlaylist_data as $itemprop => $content ) {
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