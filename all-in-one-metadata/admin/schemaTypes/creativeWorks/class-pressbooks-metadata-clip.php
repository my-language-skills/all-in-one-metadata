<?php

namespace schemaTypes\cw;
use schemaTypes;
use schemaTypes\Pressbooks_Metadata_Type;

/**
 * The class for the clip
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

class Pressbooks_Metadata_Clip extends Pressbooks_Metadata_Type {

    /**
     * The variable that holds all parent required properties
     *
     * @since    0.13
     * @access   public
     */
    static $required_parent_props = array(

    );

	/**
	 * The variable that holds the values for the settings for this schema type
	 *
	 * @since    0.13
	 * @access   public
	 */
	static $type_setting = array('clip_type' => array('Clip Type','http://schema.org/Clip'));

	/**
	 * The variable that holds the parents for the type
	 *
	 * @since    0.13
	 * @access   public
	 */
	static $type_parents = array(
		'schemaTypes\Pressbooks_Metadata_Thing',
		'schemaTypes\Pressbooks_Metadata_CreativeWork'
	);

	/**
	 * The variable that holds the properties of this schema type
	 *
	 * @since    0.13
	 * @access   public
	 */
	static $type_properties = array(
		'actor' => array(false,'Actor','	An actor, e.g. in tv, radio, movie, video games etc., or in an event. Actors can be associated with individual items or with a series, episode, clip. Supersedes actors.'),
		'clipNumber' => array(false,'Clip Number','Position of the clip within an ordered group of clips.'),
		'director' => array(false,'Director','A director of e.g. tv, radio, movie, video gaming etc. content, or of an event. Directors can be associated with individual items or with a series, episode, clip. Supersedes directors.'),
		'musicBy' => array(false,'Music By','The composer of the soundtrack.'),
		'partOfEpisode' => array(false,'Part Of Episode','The episode to which this clip belongs.'),
		'partOfSeason' => array(false,'Part Of Season','The season to which this episode belongs.'),
		'partOfSeries' => array(false,'Part Of Series','The series to which this episode or season belongs. Supersedes partOfTVSeries.')
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
	 * @since    0.13
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
	 * @since    0.13
	 * @access   public
	 */
	public function __toString() {
		return $this->class_name;
	}
}
