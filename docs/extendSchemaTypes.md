# Use this file if you want to extend Pressbooks Metadata Plugin.
## Extending: Schema Types
### STEPS:

1.	Create a new file in the schemaTypes/[type-parent] -> class-pressbooks-metadata-‘name of the type’.php
2.	Download the [template](https://github.com/Books4Languages/pressbooks-metadata/blob/christos/docs/schema_type_template.zip).
3.  Extract the zip archive and open the file named 'type-template.php', then copy all of its contents.
4.  Paste the contents in the new type file you created.
5.  Replace all the fields having this indications [namespace], [schema-type-name], [property-name], [property-name-title], and [property-description] -- see instructions in file.
6.  For every property populate the type_properties array as indicated in the file. Also be care full to use the correct namespace on the beginning of the file.
7.  Add any parent related with this type in the type_parents array, use the parents namespace to do that properly.
Remember some schema types need modifications on how they present the metadata,
sometimes you will have to change or add functions in the Type Base Class. Note that modifying this file means you are changing the
structure so you have to be care full.

**EDIT TYPE TEMPLATE CODE**
```
<?php

//Remember to include the correct namespace of the folder
//For example CreativeWork types go in folder admin/schemaTypes/CreativeWorks, this folder has namespace schemaTypes\cw
//If you forget a folder namespace find it from a file in the same folder or from the composer.json

namespace schemaTypes\[namespace];
use schemaTypes;
use schemaTypes\Pressbooks_Metadata_Type;

/**
 * The class for the [schema-type-name] type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_[schema-type-name] extends Pressbooks_Metadata_Type {

	/**
	 * The variable that holds the values for the settings for this schema type
	 *
	 * @since    1.0
	 * @access   public
	 */
	static $type_setting = array('[schema-type-name]_type' => array('[schema-type-name] Type','http://schema.org/[schema-type-name]'));
	//static $type_setting = array('book_type' => array('Book Type','http://schema.org/Book'));->example please remove

	/**
	 * The variable that holds the parents for the type
	 *
	 * @since    1.0
	 * @access   public
	 */
	static $type_parents = array(
		'schemaTypes\Pressbooks_Metadata_Thing',
		//Include all parent namespaces that are related with this type
		//Thing parent goes to all types
	);

	/**
	 * The variable that holds the properties of this schema type
	 *
	 * @since    1.0
	 * @access   public
	 */
	static $type_properties = array(
            //Here you enter the properties for the schema type, the boolean variable makes this property mandatory to be used by the user
            //[property-name-title] is the value that is displayed as the field title
            //If you want to make a drop down list use the fourth parrameter in the =>array('','','',array('value'=>'field_name','value'=>'field_name'))
            //If you want to generate a number field use the fourth parameter in the =>array('','','','number')
            //'illustrator' => array(true,'Illustrator','This is the Description of Illustrator') -> example please remove
            '[property-name]' => array(true,'[property-name-title]','[property-description]'),
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
	 * @since    1.0
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
	 * @since    1.0
	 * @access   public
	 */
	public function __toString() {
		return $this->class_name;
	}
}
```
Once you finished making changes on the new type remember to go in the file schemaTypes/class-pressbooks-metadata-type-structure.php
and add the new type under the allSchemaTypes array, you have to use the types namespace in order to add it.
Finally run this command on composer.

*Composer Command:*
```composer dump-autoload -o```

## Extending: Schema Parents
### STEPS:
1.	Create a new file in the schemaTypes -> class-pressbooks-metadata-‘name of the parent-type’.php
2.	Download the [template](https://github.com/Books4Languages/pressbooks-metadata/blob/christos/docs/schema_type_template.zip).
3.  Extract the zip archive and open the file named 'parent-template.php', then copy all of its contents.
4.  Paste the contents in the new type file you created.
5.  Replace all the fields having this indications [parent-type-name], [property-name], [property-name-title] and [property-description] -- see instructions in file.
6.  For every property populate the type_properties array as indicated in the file.
7.  Add a new folder under admin/schemaTypes using the parents name, in this folder will go all the child types that inherit from this parent.
8.  Finally go in the composer.json file and add the new namespace indicating the new directory. 
For example this was appended in the json file for the creative works parent:
```
"schemaTypes\\cw\\": "admin/schemaTypes/creativeWorks",
```

**EDIT PARENT TYPE TEMPLATE CODE**
```
<?php

namespace schemaTypes;

/**
 * The class for the [parent-type-name] type including just the properties, this type will inject properties on its child types
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      1.0
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_[parent-type-name] {

	const type_name = array('[parent-type-name] Properties','[parent-type-name]_properties');

	const type_properties = array(
		//Here you enter the properties for the parent type, the boolean variable makes this property mandatory to be used by the user
		//[property-name-title] is the value that is displayed as the field title
		//If you want to make a drop down list use the fourth parrameter in the =>array('','','',array('value'=>'field_name','value'=>'field_name'))
		//If you want to generate a number field use the fourth parameter in the =>array('','','','number')
		//'illustrator' => array(true,'Illustrator','This is the Description of Illustrator') -> example please remove
		'[property-name]' => array(true,'[property-name-title]','[property-description]'),
	);
}
```

Once you have finished the creation of the parent type file under /admin/schemaTypes remember to go in the file schemaTypes/class-pressbooks-metadata-type-structure.php
and edit the allParents array by adding the namespace of the new parent.

Finally run this command on composer.

*Composer Command:*
```composer dump-autoload -o```
