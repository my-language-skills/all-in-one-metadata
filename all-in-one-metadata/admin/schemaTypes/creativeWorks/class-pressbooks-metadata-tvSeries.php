<?php

namespace schemaTypes\cw;
use schemaTypes;
use schemaTypes\Pressbooks_Metadata_Type;

/**
 * The class for the tvSeries
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

class Pressbooks_Metadata_TVSeries extends Pressbooks_Metadata_Type {

    /**
     * The variable that holds all parent required properties
     *
     * @since    0.x
     * @access   public
     */
    static $required_parent_props = array(

    );

	/**
	 * The variable that holds the values for the settings for this schema type
	 *
	 * @since    0.x
	 * @access   public
	 */
	static $type_setting = array('tvSeries_type' => array('TVSeries Type','http://schema.org/TVSeries'));

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
		'actor' => array(false,'TVSeries Code','An actor, e.g. in tv, radio, movie, video games etc., or in an event. Actors can be associated with individual items or with a series, episode, clip. Supersedes actors.'),
		'containsSeason' => array(false,'Contains Season','A season that is part of the media series. Supersedes season.'),
		'countryOfOrigin' => array(false,'Country Of Origin','	The country of the principal offices of the production company or individual responsible for the movie or program.'),
		'director' => array(false,'Director','An offering of the tvSeries at a specific time and place or through specific media or mode of study or to a specific section of students.'),
		'episode' => array(false,'Episode','The identifier for the TVSeries used by the tvSeries provider (e.g. CS101 or 6.001).'),
		'musicBy' => array(false,'Music By','Requirements for taking the TVSeries. May be completion of another TVSeries or a textual description like "permission of instructor". Requirements may be a pre-requisite competency, referenced using AlignmentObject.'),
		'numberOfEpisodes' => array(false,'Number Of Episodes','A description of the qualification, award, certificate, diploma or other educational credential awarded as a consequence of successful completion of this tvSeries.'),
		'numberOfSeasons' => array(false,'Number Of Seasons','An offering of the tvSeries at a specific time and place or through specific media or mode of study or to a specific section of students.'),
		'productionCompany' => array(false,'Production Company','An offering of the tvSeries at a specific time and place or through specific media or mode of study or to a specific section of students.'),
		'trailer' => array(false,'Trailer','An offering of the tvSeries at a specific time and place or through specific media or mode of study or to a specific section of students.')
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
