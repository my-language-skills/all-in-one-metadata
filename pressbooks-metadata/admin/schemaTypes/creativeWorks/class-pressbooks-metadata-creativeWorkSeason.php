<?php

namespace schemaTypes\cw;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;
use schemaTypes\Pressbooks_Metadata_Type;

/**
 * The class for the creativeWorkSeason type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Creative_Work_Season extends Pressbooks_Metadata_Type {

	public function __construct($type_level_input) {
		parent::__construct($type_level_input);
		$this->class_name = __CLASS__ .'_'. $this->type_level;
		$this->type_settings = array('creativeWorkSeason_type' => array('Creative Work Season Type','http://schema.org/CreativeWorkSeason'));
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
	 * The function which produces the metaboxes for the creative work season type
	 *
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 *
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox( $meta_position ) {
		//----------- metabox ----------- //
		x_add_metadata_group( 'creative-work-season', $meta_position, array(
			'label'    => 'Creative Work Season Type Properties',
			'priority' => 'high',
		) );
		//----------- metafields ----------- //
		// Actor
		x_add_metadata_field( 'pb_actor_' . $meta_position, $meta_position, array(
			'group'       => 'creative-work-season',
			'label'       => 'Actor',
			'description' => 'An actor, e.g. in tv, radio, movie, video games etc., or in an event. Actors can be associated with individual items or with a series, episode, clip. Supersedes actors.'
		) );
		// Director
		x_add_metadata_field( 'pb_director_' . $meta_position, $meta_position, array(
			'group'       => 'creative-work-season',
			'label'       => 'Director',
			'description' => 'A director of e.g. tv, radio, movie, video gaming etc. content, or of an event. Directors can be associated with individual items or with a series, episode, clip. Supersedes directors.'
		) );
		// End Date
		x_add_metadata_field( 'pb_enddate_' . $meta_position, $meta_position, array(
			'group'       => 'creative-work-season',
			'label'       => 'End Date',
			'description' => 'The end date and time of the item (in ISO 8601 date format).'
		) );
		// Episode
		x_add_metadata_field( 'pb_episode_' . $meta_position, $meta_position, array(
			'group'       => 'creative-work-season',
			'label'       => 'Episode',
			'description' => 'An episode of a tv, radio or game media within a series or season. Supersedes episodes.'
		) );
		// Number of Episodes
		x_add_metadata_field( 'pb_number_of_episodes_' . $meta_position, $meta_position, array(
			'group'       => 'creative-work-season',
			'label'       => 'Number of Episodes',
			'description' => 'The number of episodes in this season or series.'
		) );
		// Part of Series
		x_add_metadata_field( 'pb_part_of_series_' . $meta_position, $meta_position, array(
			'group'       => 'creative-work-season',
			'label'       => 'Part of Series',
			'description' => 'The series to which this episode or season belongs. Supersedes partOfTVSeries.'
		) );
		// Production Company
		x_add_metadata_field( 'pb_production_company_' . $meta_position, $meta_position, array(
			'group'       => 'creative-work-season',
			'label'       => 'Production Company',
			'description' => 'The production company or studio responsible for the item e.g. series, video game, episode etc.'
		) );
		// Season Number
		x_add_metadata_field( 'pb_season_number_' . $meta_position, $meta_position, array(
			'group'       => 'creative-work-season',
			'label'       => 'Season Number',
			'description' => 'Position of the season within an ordered group of seasons.'
		) );
		// Start Date
		x_add_metadata_field( 'pb_start_date' . $meta_position, $meta_position, array(
			'group'       => 'creative-work-season',
			'label'       => 'Start Date',
			'description' => 'The start date and time of the item (in ISO 8601 date format).'
		) );
		// Trailer
		x_add_metadata_field( 'pb_trailer_' . $meta_position, $meta_position, array(
			'group'       => 'creative-work-season',
			'label'       => 'Trailer',
			'description' => 'The trailer of a movie or tv/radio series, season, episode, etc.'
		) );

	}

	/**
	 * A function that creates the metadata for the Creative Work Season type.
	 * @since 0.8.1
	 *
	 */
	public function pmdt_get_metatags() {
		//Distinguishing if we are working on a post --- chapter level or on the main site level
		//The type_level variable is the string we used to create the metabox

		$is_site; // This bool var is used to identify if the level is site level or any other post level
		if ( $this->type_level == 'metadata' || $this->type_level == 'site-meta' ) { //loading the appropriate metadata depending on the type level
			$metadata = gen_func::get_metadata();
			$is_site  = true;
		} else {
			$is_site  = false;
			$metadata = get_post_meta( get_the_ID() );
		}

		// array of the items needed to become microtags
		$cwSeason_data = array(

			'actor' => 'pb_actor',
			'director' => 'pb_director',
			'endDate' => 'pb_enddate',
			'episode' => 'pb_episode',
			'numberOfEpisodes' => 'pb_number_of_episodes',
			'partOfSeries' => 'pb_part_of_series',
			'productionCompany' => 'pb_production_company',
			'seasonNumber' => 'pb_season_number',
			'startDate' => 'pb_start_date',
			'trailer' => 'pb_trailer'
		);

		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/CreativeWorkSeason">';

		foreach ( $cwSeason_data as $itemprop => $content ) {
			if ( isset( $metadata[ $content . '_' . $this->type_level ] ) ) {

				if ( ! $is_site ) { //we are using the get_first function to get the value from the returned array
					$value = $this->pmdt_get_first( $metadata[ $content . '_' . $this->type_level ] );
				} else {
					if ( $this->type_level == 'site-meta' ) {
						$value = $this->pmdt_get_first( $metadata[ $content . '_' . $this->type_level ] );
					} else {//We always use the get_first function except if our level is metadata coming from pressbooks
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