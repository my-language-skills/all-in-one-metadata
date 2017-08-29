<?php

namespace schemaTypes;

/**
 * The class for the Thing type including just the properties, this type will inject properties on its child types
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.10
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Thing {

	const type_name = array('Thing Properties','thing_properties');

	const type_properties = array(
		'additionalType' => array(false,'Additional Type','	An additional type for the item, typically used for adding more specific types from external vocabularies in microdata syntax.'),
		'alternateName' => array(false,'Alternate Name','An alias for the item.'),
		'description' => array(false,'Description','A description of the item.'),
		'disambiguatingDescription' => array(false,'Disambiguating Description','A sub property of description. A short description of the item used to disambiguate from other, similar items.'),
		'identifier' => array(false,'Identifier','The identifier property represents any kind of identifier for any kind of Thing, such as ISBNs, GTIN codes, UUIDs etc.'),
		'image' => array(false,'Image','An image of the item. This can be a URL or a fully described ImageObject.'),
		'mainEntityOfPage' => array(false,'Main Entity Of Page','Indicates a page (or other CreativeWork) for which this thing is the main entity being described.'),
		'name' => array(false,'Name','The name of the item.'),
		'potentialAction' => array(false,'Potential Action','Indicates a potential Action, which describes an idealized action in which this thing would play an \'object\' role.'),
		'sameAs' => array(false,'Same As','URL of a reference Web page that unambiguously indicates the item\'s identity. E.g. the URL of the item\'s Wikipedia page.'),
		'url' => array(false,'Url','URL of the item.')
	);
}