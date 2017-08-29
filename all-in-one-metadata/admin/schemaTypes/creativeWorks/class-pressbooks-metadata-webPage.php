<?php

namespace schemaTypes\cw;
use schemaTypes;
use schemaTypes\Pressbooks_Metadata_Type;

/**
 * The class for the webPage
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

class Pressbooks_Metadata_WebPage extends Pressbooks_Metadata_Type {

	/**
	 * The variable that holds the values for the settings for this schema type
	 *
	 * @since    0.x
	 * @access   public
	 */
	static $type_setting = array('webPage_type' => array('WebPage Type','http://schema.org/WebPage'));

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
		'breadcrumb' => array(false,'Breadcrumb','A set of links that can help a user understand and navigate a website hierarchy.'),
		'lastReviewed' => array(false,'Last Reviewed','Date on which the content on this web page was last reviewed for accuracy and/or completeness.'),
		'mainContentOfPage' => array(false,'Main Content Of Page','Indicates if this web page element is the main subject of the page. Supersedes aspect.'),
		'primaryImageOfPage' => array(false,'Primary Image Of Page','Indicates the main image on the page.'),
		'relatedLink' => array(false,'Related Link','A link related to this web page, for example to other related web pages.'),
		'reviewedBy' => array(false,'Reviewed By','People or organizations that have reviewed the content on this web page for accuracy and/or completeness.'),
		'significantLink' => array(false,'Significant Link','One of the more significant URLs on the page. Typically, these are the non-navigation links that are clicked on the most. Supersedes significantLinks.'),
		'speakable' => array(false,'Speakable','Indicates sections of a Web page that are particularly \'speakable\' in the sense of being highlighted as being especially appropriate for text-to-speech conversion. Other sections of a page may also be usefully spoken in particular circumstances; the \'speakable\' property serves to indicate the parts most likely to be generally useful for speech.
The speakable property can be repeated an arbitrary number of times, with three kinds of possible \'content-locator\' values:
1.) id-value URL references - uses id-value of an element in the page being annotated. The simplest use of speakable has (potentially relative) URL values, referencing identified sections of the document concerned.
2.) CSS Selectors - addresses content in the annotated page, eg. via class attribute. Use the cssSelector property.
3.) XPaths - addresses content via XPaths (assuming an XML view of the content). Use the xpath property.
For more sophisticated markup of speakable sections beyond simple ID references, either CSS selectors or XPath expressions to pick out document section(s) as speakable. For this we define a supporting type, SpeakableSpecification which is defined to be a possible value of the speakable property.'),
		'specialty' => array(false,'Specialty','One of the domain specialities to which this web page\'s content applies.')
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
