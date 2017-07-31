<?php

namespace schemaTypes\cw;
use schemaTypes\Pressbooks_Metadata_Type;

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

class Pressbooks_Metadata_Empty_Type extends Pressbooks_Metadata_Type {

	public function __construct($type_level_input) {
		parent::__construct($type_level_input);
		$this->class_name = __CLASS__ .'_'. $this->type_level;
		$this->type_settings = array(
			'conversation_type'        => array('Conversation Type','http://schema.org/Conversation','CreativeWorks'),
			'painting_type'      	   => array('Painting Type','http://schema.org/Painting','CreativeWorks'),
			'photograph_type'          => array('Photograph Type','http://schema.org/Photograph','CreativeWorks'),
			'sculpture_type'           => array('Sculpture Type','http://schema.org/Sculpture','CreativeWorks'),
			'series_type'              => array('Series Type','http://schema.org/Series','CreativeWorks'),
			'webPageElement_type'      => array('Web Page Element Type','http://schema.org/WebPageElement','CreativeWorks'),
			'webSite_type'             => array('Website Type','http://schema.org/WebSite','CreativeWorks')
		);
		$this->parent_type = new Pressbooks_Metadata_Creative_Work($this->type_level);
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
	 * A function that creates the metadata for the Data Set type.
	 * @since 0.8.1
	 *
	 */
	public function pmdt_get_metatags() {

	}
}