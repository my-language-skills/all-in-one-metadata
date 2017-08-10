<?php

namespace schemaTypes;

/**
 * The class for the CreativeWork type including just the properties, this type will inject properties on its child types
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_CreativeWork {

	const type_name = array('Creative Work Properties','creative_work_properties');
/* TODO THIS FILE IS FOR TESTING REMEMBER TO CHANGE IT */
	const type_properties = array(
		'testProp1' => array(false,'PROP1','DESC1'),
		'testProp2' => array(false,'PROP2','DESC2')
	);
}