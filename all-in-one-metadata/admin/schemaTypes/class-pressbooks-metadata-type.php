<?php

namespace schemaTypes;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;
use schemaFunctions\Pressbooks_Metadata_Create_Metabox as create_metabox;
use schemaTypes\Pressbooks_Metadata_Type_Structure as structure;
//use Spatie\SchemaOrg\Schema as jsonldGen;

/**
 * The class for the Type including operations, this class is used as a base class for all the types
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.10
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Type {

	/**
	 * The type level where these metaboxes and their schema operations will go
	 *
	 * @since    0.10
	 * @access   public
	 */
	public $type_level;

	/**
	 * The name of the class along with the type_level
	 * Used to identify each type differently so we can eliminate parent types not needed
	 *
	 * @since    0.10
	 * @access   public
	 */
	public $class_name;

	/**
	 * The variable that holds the fields/properties for the metaboxes
	 *
	 * @since    0.10
	 * @access   public
	 */
	public $type_fields;

	/**
	 * The variable that checks if we are on a post level or site level
	 *
	 * @since    0.10
	 * @access   public
	 */
	public $is_site;

	/**
	 * The variable that holds the values from the database for the schema output
	 *
	 * @since    0.10
	 * @access   public
	 */
	public $metadata;

	/**
	 * The variable that holds the name of the type.
	 *
	 * @since    0.10
	 * @access   public
	 */
	public $typeName;

	/**
	 * The variable that holds the display name of the type.
	 *
	 * @since    0.10
	 * @access   public
	 */
	public $typeDisplayName;

	/**
	 * The variable that holds the url of the type.
	 *
	 * @since    0.10
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
	 * @since    0.10
	 * @access   public
	 */
	public function pmdt_prop_run($metaProperty){
		//get option for native properties
		$propertiesOption = get_option('schema_properties_'.$this->typeName. '_' . $this->type_level . '_level');

		//get option for parent properties and if metaProp is there, change $propertiesOption to array of parent properties
		foreach(structure::$allSchemaTypes as $type) {
			if(gen_func::get_type_id($type) == $this->typeName) {
				$propertiesOptionsParent = [];
				foreach ( $type::$type_parents as $parent ) {
					$propertiesOptionsParent  = get_option( $this->typeName . '_' . $this->type_level . '_level_' .$parent::type_name[1].'_dis' ) ?: [];
					if (key_exists($metaProperty,$propertiesOptionsParent)){
						$propertiesOption = $propertiesOptionsParent;
					}
				}
			}
		}
		if($this->type_fields[$metaProperty][0] == true){
			return true;
		}else if(isset($propertiesOption[$metaProperty]) ? ($propertiesOption[$metaProperty] == 1 ? 1 : 0) : 0){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * Function that extracts the type's details from its settings.
	 *
	 * @since    0.10
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
	 * @since    0.10
	 * @access   public
	 */
	public function pmdt_get_value($propName){
		$value = [];
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
	 * @since    0.10
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
	 * This is a routing function used to check if the administrator wants the metadata to be in jsonld or microdata format
	 * @since 0.x
	 *
	 */
	public function pmdt_get_metatags(){
		//Here we need to check for a wordpress option
		if(!get_option('jsonld_output')){
			return $this->get_microdata();
		}else{
			return $this->get_jsonld();
		}
	}

	/**
	 * A function that creates the metadata for the types using microdata.
	 * @since 0.8.1
	 *
	 */
	private function get_microdata() {
		//Creating microtags
		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="'.$this->typeUrl.'">';

		foreach ( $this->type_fields as $itemprop => $details ) {
			$propName = strtolower('pb_' . $itemprop . '_'.$this->typeName.'_' . $this->type_level);
			$clearTypeName = str_replace('http://schema.org/','',$this->typeUrl);
			if ($this->pmdt_prop_run($itemprop)) {
				$value = $this->pmdt_get_value($propName);
				if(!empty($value)){$html .= "<meta itemprop = '" . $itemprop . "' content = '" . $value . "'>\n";}
			}
		}
		$html .= '</div>';
		return $html;
	}

	/**
	 * A function that creates the metadata for the types using jsonld.
	 * @since 0.x
	 *
	 */
	/*
	private function get_jsonld(){

		//Getting the clear name of the type so we can load a class (type object) from the spatie/schema
		$clearTypeName = str_replace('http://schema.org/','',$this->typeUrl);

		//Changing the first letter of the type into lower case so we can match the function name in the library (starting point Schema.php)
		$clearTypeName = lcfirst($clearTypeName);

		//Calling the Schema.php class from the library invoking its function that returns the type
		//Note that the functions in Schema.php are static and the name of the function ($clearTypeName) returns the type of the name
		//For example $schema = jsonldGen::$book(); will return a book object
		$schema = new jsonldGen;

		//Checking if the type exists in the library, in case we have a naming error comming from our type files we end the opperation
		if(!method_exists($schema,$clearTypeName)){
			return;
		}

		//Creating a schema type from the library
		$schema = jsonldGen::$clearTypeName();


		//Where ever we find a property that has a value we add it into the object created above ($schema)
		foreach ( $this->type_fields as $itemprop => $details ) {
			$propName = strtolower('pb_' . $itemprop . '_'.$this->typeName.'_' . $this->type_level);
			if ($this->pmdt_prop_run($itemprop)) {
				$value = $this->pmdt_get_value($propName);
				if(!empty($value)){
					//Note that schema is the object created above and $itemprop is used to call a function from the type stored in the $schema variable
					//Assuming like above that the $schema is holding a book object doing this $schema->illustrator('a_name') sets the illustrator property of the type to 'a_name'
					$schema->$itemprop($value);
				}
			}
		}
		//This uses the $schema object and all the properties we gave it above (illustrator for example) to return jasonld data
		return $schema->toScript();
	}
	*/
}
