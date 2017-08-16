<?php

namespace schemaTypes;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;
use schemaFunctions\Pressbooks_Metadata_Create_Metabox as create_metabox;

/**
 * The class for the Type including operations, this class is used as a base class for all the types
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      1.0
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Type {

	/**
	 * The type level where these metaboxes and their schema operations will go
	 *
	 * @since    1.0
	 * @access   public
	 */
	public $type_level;

	/**
	 * The name of the class along with the type_level
	 * Used to identify each type differently so we can eliminate parent types not needed
	 *
	 * @since    1.0
	 * @access   public
	 */
	public $class_name;

	/**
	 * The variable that holds the fields/properties for the metaboxes
	 *
	 * @since    1.0
	 * @access   public
	 */
	public $type_fields;

	/**
	 * The variable that checks if we are on a post level or site level
	 *
	 * @since    1.0
	 * @access   public
	 */
	public $is_site;

	/**
	 * The variable that holds the values from the database for the schema output
	 *
	 * @since    1.0
	 * @access   public
	 */
	public $metadata;

	/**
	 * The variable that holds the name of the type.
	 *
	 * @since    1.0
	 * @access   public
	 */
	public $typeName;

	/**
	 * The variable that holds the display name of the type.
	 *
	 * @since    1.0
	 * @access   public
	 */
	public $typeDisplayName;

	/**
	 * The variable that holds the url of the type.
	 *
	 * @since    1.0
	 * @access   public
	 */
	public $typeUrl;

	public function __construct($type_level_input) {
		$this->type_level = $type_level_input;
		//Distinguishing if we are working on a post --- chapter level or on the main site level
		//The type_level variable is the string we used to create the metabox

		$this->is_site; // This bool var is used to identify if the level is site level or any other post level
		if ( $this->type_level == 'metadata' || $this->type_level == 'site-meta' ) { //loading the appropriate metadata depending on the type level
			$this->metadata = gen_func::get_metadata();
			$this->is_site = true;
		} else {
			$this->is_site = false;
			$this->metadata = get_post_meta( get_the_ID() );
		}
	}

	/**
	 * Function that checks if the property has to run on output or not.
	 *
	 * @since    1.0
	 * @access   public
	 */
	public function pmdt_prop_run($metaProperty){

		if($this->type_fields[$metaProperty][0] == true){
			return true;
		}else if(get_option( strtolower($metaProperty) . '_' . $this->typeName . '_' . $this->type_level . '_level' )){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * Function that extracts the type's details from its settings.
	 *
	 * @since    1.0
	 * @access   public
	 */
	public function pmdt_populate_names($settings){
		foreach($settings as $type => $details){
			$this->typeName = $type;
			$this->typeDisplayName = $details[0];
			$this->typeUrl = $details[1];
		}
	}

	/**
	 * Gets the value for the microtags from $this->metadata.
	 *
	 * @since    1.0
	 * @access   public
	 */
	public function pmdt_get_value($propName){
		$value;
		$array = isset($this->metadata[$propName])? $this->metadata[$propName] : '';
		if ( !$this->is_site ) { //we are using the get_first function to get the value from the returned array
			$value = $this->pmdt_get_first( $array );
		} else {
			if($this->type_level == 'site-meta'){
				$value = $this->pmdt_get_first($array);
			}else{//We always use the get_first function except if our level is metadata coming from pressbooks
				$value = $array;
			}
		}
		return $value;
	}

	/**
	 * Returns type level.
	 *
	 * @since    1.0
	 * @access   public
	 */
	public function pmdt_get_type_level(){
		return $this->type_level;
	}

	/**
	 * A function needed for the array of metadata that comes from each post site-meta cpt or chapter
	 * It automatically returns the first item in the array.
	 * @since 0.8.1
	 *
	 */
	public function pmdt_get_first($my_array){
		if($my_array == ''){
			return '';
		}else {
			return $my_array[0];
		}
	}

	/**
	 * The function which produces the metaboxes for the book type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	public function pmdt_add_metabox($meta_position) {
		new create_metabox($this->typeName,$this->typeDisplayName,$meta_position,$this->type_fields);
	}

	/**
	 * A function that creates the metadata for the book type.
	 * @since 0.8.1
	 *
	 */
	public function pmdt_get_metatags() {
		//Creating microtags
		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="'.$this->typeUrl.'">';

		foreach ( $this->type_fields as $itemprop => $details ) {
			$propName = strtolower('pb_' . $itemprop . '_' . $this->type_level);
			if ($this->pmdt_prop_run($itemprop)) {
				$value = $this->pmdt_get_value($propName);
				if(!empty($value)){$html .= "<meta itemprop = '" . $itemprop . "' content = '" . $value . "'>\n";}
			}
		}
		$html .= '</div>';
		return $html;
	}
}