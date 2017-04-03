<?php

/**
 * A field corresponding to an actual book metadata.
 * Does not have user input (data is provided by other means, e.g. Wordpress
 * internal functions)
 *
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields/data-fields
 */

require_once plugin_dir_path( __FILE__ ) . 'class-pressbooks-metadata-data-field.php';

/**
 * A field corresponding to an actual book metadata.
 * Does not have user input (data is provided by other means, e.g. Wordpress
 * internal functions).
 *
 * Defines the properties of a built-in field.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields/data-fields
 * @author     julienCXX <software@chmodplusx.eu>
 */
abstract class Pressbooks_Metadata_Built_In_Field extends Pressbooks_Metadata_Data_Field {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  0.1
	 * @param  string          $name           The field's name.
	 * @param  string          $slug           The field's slug. If no slug
	 * is given, it will be generated from the name.
	 * @param  string          $itemprop       The field's Microdata
	 * itemprop attibute.
	 * @throws DomainException If both the name and slug are empty (unable
	 * to generate a valid slug).
	 */
	public function __construct( $name, $slug = '', $itemprop = '' ) {

		parent::__construct( $name, '', $slug, '', '', '', '', $itemprop
		);

	}

	/**
	 * Returns the field's built-in value.
	 *
	 * @since  0.1
	 * @return mixed The value.
	 */
	protected abstract function get_built_in_value();

	/**
	 * Prevents adding this metadata to the current post metadata dashboard.
	 *
	 * @since 0.1
	 * @param string $slug_prefix Unused here.
	 */
	public function add_to_current_post_metadata(
		$slug_prefix = '' ) {
	}

	/**
	 * Creates a clone of itself with a value taken from the callback.
	 *
	 * @since 0.1
	 * @param  array $fetched_metadata Unused here.
	 * @return Pressbooks_Metadata_Abstract_Metadata The element, with its internal
	 * value set.
	 */
	public function clone_with_value( &$fetched_metadata ) {

		$cloned = clone $this;
		$cloned->set_value( $this->get_built_in_value() );
		return $cloned;

	}

}
