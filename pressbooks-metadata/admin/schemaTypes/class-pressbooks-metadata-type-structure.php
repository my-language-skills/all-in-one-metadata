<?php

namespace schemaTypes;

/**
 * File containing an array for loading the types automatically
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Type_Structure{
	public static $allSchemaTypes = array(
		'schemaTypes\cw\Pressbooks_Metadata_Book',
		'schemaTypes\cw\Pressbooks_Metadata_Blog',
		'schemaTypes\cw\Pressbooks_Metadata_Message'
	);

	public static $allParents = array(
		'schemaTypes\Pressbooks_Metadata_Thing',
		'schemaTypes\Pressbooks_Metadata_CreativeWork'
	);
}