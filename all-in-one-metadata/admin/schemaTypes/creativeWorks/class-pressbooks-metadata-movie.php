<?php

namespace schemaTypes\cw;
use schemaTypes;
use schemaTypes\Pressbooks_Metadata_Type;

/**
 * The class for the movie
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.13
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 * @author    Corentin Perrot <perrotcore@gmail.com>
 */

class Pressbooks_Metadata_Movie extends Pressbooks_Metadata_Type {

    /**
     * The variable that holds all parent required properties
     *
     * @since    0.x
     * @access   public
     */
    static $required_parent_props = array(
		'image', 'name'
    );

	/**
	 * The variable for the movies
	 *
	 * @since    0.x
	 * @access   public
	 */
	static $type_setting = array('movie_type' => array('Movie Type','http://schema.org/Movie'));

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
		'countryOfOrigin' => array(false,'Country Of Origin','The country of the principal offices of the production company or individual responsible for the movie or program.'),
		'director' => array(false,'Director','A director of e.g. tv, radio, movie, video gaming etc. content, or of an event. Directors can be associated with individual items or with a series, episode, clip. Supersedes directors.'),
		'duration' => array(false,'Duration','The duration of the item (movie, audio recording, event, etc.) in ISO 8601 date format.'),
		'musicBy' => array(false,'Music By','The composer of the soundtrack.'),
		'productionCompany' => array(false,'Production Company','The production company or studio responsible for the item e.g. series, video game, episode etc.'),
		'subtitleLanguage' => array(false,'Subtitle Language','Languages in which subtitles/captions are available, in IETF BCP 47 standard format.'),
		//'trailer' => array(false,'Trailer','The trailer of a movie or tv/radio series, season, episode, etc.')
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
