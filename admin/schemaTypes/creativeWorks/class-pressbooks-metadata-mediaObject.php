<?php

namespace schemaTypes\cw;
use schemaTypes;
use schemaTypes\Pressbooks_Metadata_Type;

/**
 * The class for the mediaObject
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

class Pressbooks_Metadata_MediaObject extends Pressbooks_Metadata_Type {

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
	static $type_setting = array('mediaObject_type' => array('MediaObject Type','http://schema.org/MediaObject'));

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
		//'associatedArticle' => array(false,'Associated Article','A NewsArticle associated with the Media Object.'),
		'bitrate' => array(false,'Bitrate','The bitrate of the media object.'),
		'contentSize' => array(false,'Content Size','File size in (mega/kilo) bytes.'),
		'contentUrl' => array(false,'Content Url','Actual bytes of the media object, for example the image file or video file.'),
		'duration' => array(false,'Duration','The duration of the item (movie, audio recording, event, etc.) in ISO 8601 date format.'),
		'embedUrl' => array(false,'Embed URL','A URL pointing to a player for a specific video. In general, this is the information in the src element of an embed tag and should not be the same as the content of the loc tag.'),
		'encodesCreativeWork' => array(false,'Encodes Creative Work','The CreativeWork encoded by this media object.'),
		'encodingFormat' => array(false,'Encoding Format','mp3, mpeg4, etc.'),
		'height' => array(false,'Height','The height of the item.'),
		'playerType' => array(false,'Player Type','Player type required—for example, Flash or Silverlight.'),
		'productionCompany' => array(false,'Production Company','The production company or studio responsible for the item e.g. series, video game, episode etc.'),
		'regionsAllowed' => array(false,'Regions Allowed','The regions where the media is allowed. If not specified, then it\'s assumed to be allowed everywhere. Specify the countries in ISO 3166 format.'),
		'requiresSubscription' => array(false,'Requires Subscription','Indicates if use of the media require a subscription (either paid or free). Allowed values are true or false (note that an earlier version had \'yes\', \'no\').'),
		'uploadDate' => array(false,'Upload Date','Date when this media object was uploaded to this site.'),
		'width' => array(false,'Width','The width of the item.')
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
