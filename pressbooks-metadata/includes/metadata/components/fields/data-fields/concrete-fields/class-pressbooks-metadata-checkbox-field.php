<?php

/**
 * A checkbox field.
 *
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields/data-fields/concrete-fields
 */

require_once plugin_dir_path( __FILE__ ) . '../class-pressbooks-metadata-single-field.php';

/**
 * A checkbox field.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields/data-fields/concrete-fields
 * @author     julienCXX <software@chmodplusx.eu>
 */
class Pressbooks_Metadata_Checkbox_Field extends Pressbooks_Metadata_Single_Field {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  0.1
	 * @param  string          $name          The field's name.
	 * @param  string          $desc          The field's description.
	 * @param  string          $slug          The field's slug. If no slug
	 * is given, it will be generated from the name.
	 * @param  string          $suffix        A suffix to append to the
	 * field's slug.
	 * @param  string          $disp_callback The callback used to display
	 * the field in the dashboard. Should be a static function.
	 * @param  object          $def_value     The field's default value. If
	 * not empty, has to be an existing key of the list's values.
	 * @param  string          $itemprop      The field's Microdata itemprop
	 * attibute.
	 * @throws DomainException If both the name and slug are empty (unable
	 * to generate a valid slug).
	 */
	public function __construct( $name, $desc = '', $slug = '',
		$suffix = '', $disp_callback = '', $def_value = '',
		$itemprop = '' ) {

		parent::__construct( $name, $desc, $slug, $suffix,
			$disp_callback, $def_value, false, 'checkbox',
			$itemprop );

	}

	/**
	 * Creates a clone of itself with a value previously extracted.
	 *
	 * @since 0.1
	 * @param  array $fetched_metadata The extracted metadata values (from
	 * current post), where the key matches the slug (without prefix). If
	 * the value is found, the element is removed from this list.
	 * @return Pressbooks_Metadata_Abstract_Metadata The element, with its internal
	 * value set, or NULL if the value was not found.
	 */
	public function clone_with_value( &$fetched_metadata ) {

		$cloned = parent::clone_with_value( $fetched_metadata );
		if ( NULL === $cloned ) {
			return NULL;
		}
		$value = $cloned->get_value();
		$cloned->set_value( 'on' == $value );

		return $cloned;

	}

}
