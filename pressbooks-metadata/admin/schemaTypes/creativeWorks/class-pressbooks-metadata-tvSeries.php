<?php

namespace schemaTypes\cw;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;


/**
 * The class for the Tv Series including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Tv_Series {

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

	/**
	 * The variable that holds the values for the settings for this schema type
	 *
	 * @since    0.x
	 * @access   public
	 */
	public static $type_settings = array('tvSeries_type' => array('Tv Series Type','http://schema.org/TvSeries'));

	public function __construct($type_level_input) {
		$this->type_level = $type_level_input;
		$this->pmdt_add_metabox($this->type_level);
		$this->class_name = __CLASS__ .'_'. $this->type_level;
	}

	/**
	 * The function which produces the metaboxes for the tv series type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position){
		//----------- metabox ----------- //
		x_add_metadata_group( 	'tv-series', $meta_position, array(
			'label' 		=>	'Tv Series Type Properties',
			'priority' 		=>	'high',
		) );
		//----------- metafields ----------- //
		// Actor
		x_add_metadata_field( 	'pb_actor_'.$meta_position, $meta_position, array(
			'group' 		=>	'tv-series',
			'label' 		=>	'Actor',
			'description'	=>	'An actor, e.g. in tv, radio, movie, video games etc., or in an event. Actors can be associated with individual items or with a series, episode, clip. Supersedes actors.',
		) );
		// Contains Season
		x_add_metadata_field( 	'pb_contains_season_'.$meta_position, $meta_position, array(
			'group' 		=>	'tv-series',
			'label' 		=>	'Contains Season',
			'description'	=>	'A season that is part of the media series. Supersedes season.',
		) );
		// Country of Origin
		x_add_metadata_field( 	'pb_country_of_origin_'.$meta_position, $meta_position, array(
			'group' 		=>	'tv-series',
			'label' 		=>	'Country of Origin',
			'description'	=>	'The country of the principal offices of the production company or individual responsible for the movie or program.',
		) );
		// Director
		x_add_metadata_field( 	'pb_director_'.$meta_position, $meta_position, array(
			'group' 		=>	'tv-series',
			'label' 		=>	'Director',
			'description'	=>	'A director of e.g. tv, radio, movie, video gaming etc. content, or of an event. Directors can be associated with individual items or with a series, episode, clip. Supersedes directors.',
		) );
		// Episode
		x_add_metadata_field( 	'pb_episode_'.$meta_position, $meta_position, array(
			'group' 		=>	'tv-series',
			'label' 		=>	'Episode',
			'description'	=>	'An episode of a tv, radio or game media within a series or season. Supersedes episodes.',
		) );
		// Music By
		x_add_metadata_field( 	'pb_music_by_'.$meta_position, $meta_position, array(
			'group' 		=>	'tv-series',
			'label' 		=>	'Music By',
			'description'	=>	'The composer of the soundtrack.',
		) );
		// Number of Episodes
		x_add_metadata_field( 	'pb_number_of_episodes_'.$meta_position, $meta_position, array(
			'group' 		=>	'tv-series',
			'label' 		=>	'Number of Episodes',
			'description'	=>	'The number of episodes in this season or series.',
		) );
		// Number of Seasons
		x_add_metadata_field( 	'pb_number_of_seasons_'.$meta_position, $meta_position, array(
			'group' 		=>	'tv-series',
			'label' 		=>	'Number of Seasons',
			'description'	=>	'The number of seasons in this series.',
		) );
		// Production Company
		x_add_metadata_field( 	'pb_production_company_'.$meta_position, $meta_position, array(
			'group' 		=>	'tv-series',
			'label' 		=>	'Production Company',
			'description'	=>	'The production company or studio responsible for the item e.g. series, video game, episode etc.',
		) );
		// Trailer
		x_add_metadata_field( 	'pb_trailer_'.$meta_position, $meta_position, array(
			'group' 		=>	'tv-series',
			'label' 		=>	'Trailer',
			'description'	=>	'The trailer of a movie or tv/radio series, season, episode, etc.',
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
	 * A function that creates the metadata for the Tv Series type.
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
		$tvSeries_data = array(

			'actor' => 'pb_actor',
			'containsSeason' => 'pb_contains_season',
			'countryOfOrigin' => 'pb_country_of_origin',
			'director' => 'pb_director',
			'episode' => 'pb_episode',
			'musicBy' => 'pb_music_by',
			'numberOfEpisodes' => 'pb_number_of_episodes',
			'numberOfSeasons' => 'pb_number_of_seasons',
			'productionCompany' => 'pb_production_company',
			'trailer' => 'pb_trailer'
		);

		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/TVSeries">';

		foreach ( $tvSeries_data as $itemprop => $content ) {
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