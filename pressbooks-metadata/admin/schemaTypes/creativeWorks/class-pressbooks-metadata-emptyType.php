<?php

namespace schemaTypes\cw;

/**
 * The class for managing the types with no properties
 * We just initialise the father of the type
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Empty_Type {

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
	 * Here we add all the types of CreativeWork that have no properties
	 *
	 * @since    0.x
	 * @access   public
	 */
	public static $type_settings = array(
		'conversation_type'        => array('Conversation Type','http://schema.org/Conversation','CreativeWorks'),
		'painting_type'      	   => array('Painting Type','http://schema.org/Painting','CreativeWorks'),
		'photograph_type'          => array('Photograph Type','http://schema.org/Photograph','CreativeWorks'),
		'sculpture_type'           => array('Sculpture Type','http://schema.org/Sculpture','CreativeWorks'),
		'series_type'              => array('Series Type','http://schema.org/Series','CreativeWorks'),
		'webPageElement_type'      => array('Web Page Element Type','http://schema.org/WebPageElement','CreativeWorks'),
		'webSite_type'             => array('Website Type','http://schema.org/WebSite','CreativeWorks')
	);

	public function __construct($type_level_input) {
		$this->type_level = $type_level_input;
		$this->class_name = __CLASS__ .'_'. $this->type_level;
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
	 * A function that creates the metadata for the Data Set type.
	 * @since 0.8.1
	 *
	 */
	public function pmdt_get_metatags() {

	}
}