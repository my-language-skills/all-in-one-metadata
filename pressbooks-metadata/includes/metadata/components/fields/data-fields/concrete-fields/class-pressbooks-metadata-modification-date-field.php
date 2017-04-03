<?php

/**
 * The last modification date of the current page.
 *
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields/data-fields/concrete-fields
 */

require_once plugin_dir_path( __FILE__ )
. '../class-pressbooks-metadata-built-in-field.php';

/**
 * The last modification date of the current page.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields/data-fields/concrete-fields
 * @author     julienCXX <software@chmodplusx.eu>
 */
class Pressbooks_Metadata_Modification_Date_Field extends Pressbooks_Metadata_Built_In_Field {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  0.1
	 * @param  string          $name          The field's name. If no name
	 * is given, a dfault one will be used.
	 * @param  string          $slug          The field's slug. If no slug
	 * is given, it will be generated from the name.
	 * @param  string          $itemprop      The field's Microdata itemprop
	 * attibute.
	 * @throws DomainException If both the name and slug are empty (unable
	 * to generate a valid slug).
	 */
	public function __construct( $name = '', $slug = '', $itemprop = '' ) {

		$actual_name = $name;
		if ( empty( $actual_name ) ) {
			$actual_name = 'Modification date';
		}
		$actual_slug = $slug;
		if ( empty( $actual_slug ) ) {
			$actual_slug = 'modification_date';
		}

		parent::__construct( $actual_name, $actual_slug, $itemprop );

	}

	/**
	 * Returns the field's built-in value.
	 *
	 * @since  0.1
	 * @return mixed The value.
	 */
	protected function get_built_in_value() {

		return get_the_modified_time( 'F j, Y, G:i' );

	}

}
