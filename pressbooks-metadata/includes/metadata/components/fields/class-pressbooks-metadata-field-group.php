<?php

/**
 * A group of fields to be added to the dashboard. This is a smaller division
 * than meta boxes.
 *
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields
 */

require_once plugin_dir_path( __FILE__ ) . 'class-pressbooks-metadata-field.php';
require_once plugin_dir_path( __FILE__ )
	. 'class-pressbooks-metadata-field-group-closing.php';

/**
 * A group of fields to be added to the dashboard. This is a smaller division
 * than meta boxes.
 *
 * Defines the properties of a group of fields.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields
 * @author     julienCXX <software@chmodplusx.eu>
 */
class Pressbooks_Metadata_Field_Group extends Pressbooks_Metadata_Field {

	/**
	 * The fields contained in this group.
	 *
	 * @since  0.1
	 * @access private
	 * @var    array  $fields The fields as an array of
	 * Pressbooks_Metadata_Data_Field.
	 */
	private $fields;

	/**
	 * The field used to close this group.
	 *
	 * @since  0.1
	 * @access private
	 * @var    Pressbooks_Metadata_Field_Group_Closing $closing_field The field
	 * used to close this group.
	 */
	private $closing_field;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  0.1
	 * @param  string          $name The group's name.
	 * @param  string          $desc The group's description.
	 * @param  string          $slug The group's slug. If no slug is given,
	 * it will be generated from the name.
	 * @throws DomainException If both the name and slug are empty
	 * (unable to generate a valid slug).
	 */
	public function __construct( $name, $desc = '', $slug = '' ) {

		parent::__construct( $name, $desc, $slug, '-group',
			'Pressbooks_Metadata_Field_Group::print_group_opening'
		);

		$this->fields = array();

		$this->closing_field = new Pressbooks_Metadata_Field_Group_Closing(
			$this->get_slug() );

	}

	/**
	 * Sets the meta box this group (and contained fields) resides in. Also
	 * adds the meta box's post types.
	 *
	 * @since  0.1
	 * @param Pressbooks_Metadata_Meta_Box $meta_box The meta box this group resides
	 * in or NULL if the group does not reside in a metabox.
	 */
	public function set_meta_box( &$meta_box ) {

		parent::set_meta_box( $meta_box );
		foreach ( $this->fields as &$field ) {
			$field->set_meta_box( $meta_box );
		}
		$this->closing_field->set_meta_box( $meta_box );

	}

	/**
	 * Adds a field to this group.
	 *
	 * @since 0.1
	 * @param Pressbooks_Metadata_Data_Field $field The field to be added.
	 */
	public function add_field( Pressbooks_Metadata_Data_Field $field ) {

		if ( NULL !== $this->get_meta_box() ) {
			$field->set_meta_box( $this->get_meta_box() );
		}
		return $this->fields[ $field->get_slug() ] = $field;

	}

	/**
	 * Returns the fields contained in this group.
	 *
	 * @since  0.1
	 * @return array The fields as an array of Pressbooks_Metadata_Data_Field.
	 */
	public function get_fields() {

		return $this->fields;

	}

	/**
	 * Says if this element of metadata is a group of fields.
	 * Does not include fields composed of sub-fields.
	 *
	 * @since  0.1
	 * @return boolean true if this element of metadata is a group of fields
	 * or false otherwise.
	 */
	public function is_group_of_fields() {

		return true;

	}

	/**
	 * Adds this meta box and its contents to the current post metadata
	 * dashboard.
	 *
	 * @since 0.1
	 * @param string $slug_prefix The prefix to append to each element
	 * added, for the sake of slug unicity. No prefix is added to the
	 * metabox slug.
	 */
	public function add_to_current_post_metadata( $slug_prefix = '' ) {

		$args = $this->get_args();
		// group opening dummy field
		x_add_metadata_field( $slug_prefix . $this->get_slug(),
			$this->get_post_types(), $args );

		foreach ( $this->fields as $key => $val ) {
			$val->add_to_current_post_metadata( $slug_prefix );
		}

		// group closing dummy field
		$this->closing_field->add_to_current_post_metadata(
			$slug_prefix );

	}

	/**
	 * Prints the opening part of a field group, in the dashboard.
	 *
	 * @since 0.1
	 * @param string $field_slug  The slug/id of the field.
	 * @param object $field       The field object.
	 * @param string $object_type What object type is the field associated
	 * with.
	 */
	public static function print_group_opening( $field_slug, $field,
		$object_type ) {

		?><fieldset><legend><?php
		echo $field->label;
		?></legend><?php

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
		$this->closing_field->clone_with_value( $fetched_metadata );

		// save two deep copies of fields
		$cloned = new Pressbooks_Metadata_Field_Group( $this->get_name(),
			$this->get_description(), $this->get_slug(),
			$this->get_meta_box() );

		foreach ( $this->fields as $key => $val ) {
			$cloned_field = $val->clone_with_value(
				$fetched_metadata );
			if ( NULL != $cloned_field ) {
				$cloned->fields[ $key ] = $cloned_field;
			}
		}

		if ( 0 == count( $cloned->fields ) ) {
			return NULL;
		}
		return $cloned;

	}

}
