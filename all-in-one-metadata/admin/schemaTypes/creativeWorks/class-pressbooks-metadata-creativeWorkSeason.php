<?php

namespace schemaTypes\cw;
use schemaTypes;
use schemaTypes\Pressbooks_Metadata_Type;

/**
 * The class for the creativeWorkSeason
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 * @author    Corentin Perrot <perrotcore@gmail.com>
 */

class Pressbooks_Metadata_CreativeWorkSeason extends Pressbooks_Metadata_Type {

	/**
	 * The variable that holds the values for the settings for this schema type
	 *
	 * @since    0.x
	 * @access   public
	 */
	static $type_setting = array('creativeWorkSeason_type' => array('CreativeWorkSeason Type','http://schema.org/CreativeWorkSeason'));

	/**
	 * The variable that holds the parents for the type
	 *
	 * @since    0.x
	 * @access   public
	 */
	static $type_parents = array(
		'schemaTypes\Pressbooks_Metadata_Thing',
		'schemaTypes\Pressbooks_Metadata_CreativeWork'
	);

	/**
	 * The variable that holds the properties of this schema type
	 *
	 * @since    0.x
	 * @access   public
	 */
	static $type_properties = array(
		'actor' => array(false,'Actor','An actor, e.g. in tv, radio, movie, video games etc., or in an event. Actors can be associated with individual items or with a series, episode, clip. Supersedes actors.'),
		'director' => array(false,'Director','A director of e.g. tv, radio, movie, video gaming etc. content, or of an event. Directors can be associated with individual items or with a series, episode, clip. Supersedes directors.'),
		'endDate' => array(false,'End Date','The end date and time of the item (in ISO 8601 date format).'),
		'episode' => array(false,'Episode','An episode of a tv, radio or game media within a series or season. Supersedes episodes.'),
		'numberOfEpisodes' => array(false,'Number Of Episodes','The number of episodes in this season or series.'),
		'partOfSeries' => array(false,'Part Of Series','The series to which this episode or season belongs. Supersedes partOfTVSeries.'),
		'productionCompany' => array(false,'Production Company','The production company or studio responsible for the item e.g. series, video game, episode etc.'),
		'seasonNumber' => array(false,'Season Number','Position of the season within an ordered group of seasons.'),
		'startDate' => array(false,'Start Date','The start date and time of the item (in ISO 8601 date format).'),
		'trailer' => array(false,'Trailer','The trailer of a movie or tv/radio series, season, episode, etc.')
	);

	public function __construct($type_level_input) {
		parent::__construct($type_level_input);
		$this->type_fields = $this->get_all_properties();
		$this->class_name = __CLASS__ .'_'. $this->type_level;
		$this->pmdt_populate_names(self::$type_setting);
		$this->pmdt_add_metabox($this->type_level);
	}

	/**
	 * Function used for combining the current types properties with its parents fields
	 *
	 * @since    0.x
	 * @access   public
	 */
	public function get_all_properties() {
		$properties = self::$type_properties;
		foreach(self::$type_parents as $parentType){
			$properties = array_merge($properties,$parentType::type_properties);
		}
		return $properties;
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
}
