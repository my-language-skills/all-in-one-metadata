<?php

/**
 * A field used to close a group of fields.
 *
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields
 */

require_once plugin_dir_path( __FILE__ ) . 'class-pressbooks-metadata-field.php';

/**
 * A field used to close a group of fields.
 *
 * Should not be used outside of Pressbooks_Metadata_Field_Group.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields
 * @author     julienCXX <software@chmodplusx.eu>
 */
class Pressbooks_Metadata_Field_Group_Closing extends Pressbooks_Metadata_Field {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  0.1
	 * @param  string          $slug   The field's slug.
	 * @param  string          $suffix A suffix to append to the field's
	 * slug.
	 * @throws DomainException If the slug is empty.
	 */
	public function __construct( $slug, $suffix = '-closing' ) {

		parent::__construct( '', '', $slug, $suffix,
			'Pressbooks_Metadata_Field_Group_Closing::print_group_closing'
		);

	}

	/**
	 * Prints the closing part of a field group, in the dashboard.
	 *
	 * @since 0.1
	 * @param string $field_slug  The slug/id of the field.
	 * @param object $field       The field object.
	 * @param string $object_type What object type is the field associated
	 * with.
	 */
	public static function print_group_closing( $field_slug,
		$field, $object_type ) {

		?></fieldset><?php

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

		if ( array_key_exists( $this->get_slug(), $fetched_metadata ) ) {
			unset( $fetched_metadata[ $this->get_slug() ] );
		}

		return NULL; // the field's value has no meaning

	}

}
