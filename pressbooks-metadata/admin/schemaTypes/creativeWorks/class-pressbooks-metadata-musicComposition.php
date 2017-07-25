<?php

namespace schemaTypes\cw;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;

/**
 * The class for the music composition  type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Music_Composition{

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
	 * The function which produces the metaboxes for the music composition type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position){
		//----------- metabox ----------- //
		x_add_metadata_group( 	'music-composition', $meta_position, array(
			'label' 		=>	'Music Composition Type Properties',
			'priority' 		=>	'high',
		) );
		//----------- metafields ----------- //
		// Composer
		x_add_metadata_field( 	'pb_composer_'.$meta_position, $meta_position, array(
			'group' 		=>	'music-composition',
			'label' 		=>	'Composer',
			'description' 	=>	'The person or organization who wrote a composition, or who is the composer of a work performed at some event.'
		) );
		// First Performance
		x_add_metadata_field( 	'pb_first_performance_'.$meta_position, $meta_position, array(
			'group' 		=>	'music-composition',
			'label' 		=>	'First Performance',
			'description' 	=>	'The date and place the work was first performed.'
		) );
		// Included Composition
		x_add_metadata_field( 	'pb_included_composition_'.$meta_position, $meta_position, array(
			'group' 		=>	'music-composition',
			'label' 		=>	'Included Composition',
			'description' 	=>	'Smaller compositions included in this work (e.g. a movement in a symphony).'
		) );
		// Iswc Code
		x_add_metadata_field( 	'pb_iswc_code_'.$meta_position, $meta_position, array(
			'group' 		=>	'music-composition',
			'label' 		=>	'Iswc Code',
			'description' 	=>	'The International Standard Musical Work Code for the composition.'
		) );
		// Lyricist
		x_add_metadata_field( 	'pb_lyricist_'.$meta_position, $meta_position, array(
			'group' 		=>	'music-composition',
			'label' 		=>	'Lyricist',
			'description' 	=>	'The person who wrote the words.'
		) );
		// Lyrics
		x_add_metadata_field( 	'pb_lyrics_'.$meta_position, $meta_position, array(
			'group' 		=>	'music-composition',
			'label' 		=>	'Lyrics',
			'description' 	=>	'The words in the song.'
		) );
		// Music Arrangement
		x_add_metadata_field( 	'pb_music_arrangement_'.$meta_position, $meta_position, array(
			'group' 		=>	'music-composition',
			'label' 		=>	'Music Arrangement',
			'description' 	=>	'An arrangement derived from the composition.'
		) );
		// Music Composition Form
		x_add_metadata_field( 	'pb_music_composition_form_'.$meta_position, $meta_position, array(
			'group' 		=>	'music-composition',
			'label' 		=>	'Music Composition Form',
			'description' 	=>	'The type of composition (e.g. overture, sonata, symphony, etc.).'
		) );
		// Musical Key
		x_add_metadata_field( 	'pb_musical_key_'.$meta_position, $meta_position, array(
			'group' 		=>	'music-composition',
			'label' 		=>	'Musical Key',
			'description' 	=>	'The key, mode, or scale this composition uses.'
		) );
		// Recorded As
		x_add_metadata_field( 	'pb_recorded_as_'.$meta_position, $meta_position, array(
			'group' 		=>	'music-composition',
			'label' 		=>	'Recorded As',
			'description' 	=>	'An audio recording of the work. Inverse property: recordingOf.'
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
	 * A function that creates the metadata for the Music Compositon type.
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
		$musicComp_data = array(

			'composer' => 'pb_composer',
			'firstPerformance' => 'pb_first_performance',
			'includedComposition' => 'pb_included_composition',
			'iswcCode' => 'pb_iswc_code',
			'lyricist' => 'pb_lyricist',
			'lyrics' => 'pb_lyrics',
			'musicArrangement' => 'pb_music_arrangement',
			'musicCompositionForm' => 'pb_music_composition_form',
			'musicalKey' => 'pb_musical_key',
			'recordedAs' => 'pb_recorded_as'
		);

		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/MusicComposition">';

		foreach ( $musicComp_data as $itemprop => $content ) {
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