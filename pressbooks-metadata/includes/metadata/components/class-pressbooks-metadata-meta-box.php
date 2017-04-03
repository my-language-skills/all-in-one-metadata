<?php

/**
 * A meta box (box that contains the fields).
 *
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components
 */

require_once plugin_dir_path( __FILE__ )
. 'class-pressbooks-metadata-abstract-metadata.php';

/**
 * A meta box (box that contains the fields).
 *
 * Defines the properties of a meta box, addable to the dashboard.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components
 * @author     julienCXX <software@chmodplusx.eu>
 */
final class Pressbooks_Metadata_Meta_Box extends Pressbooks_Metadata_Abstract_Metadata {

	/**
	 * The fields contained in this meta box.
	 *
	 * @since  0.1
	 * @access private
	 * @var    array  $fields The fields as an array of Pressbooks_Metadata_Field.
	 */
	private $fields;

	/**
	 * The context of this meta box (side, …).
	 *
	 * @since  0.1
	 * @access private
	 * @var    string  $context The context of this meta box.
	 */
	private $context;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  0.1
	 * @param  string  $name            The meta box's name.
	 * @param  string  $desc            The meta box's description.
	 * @param  string  $slug            The meta box's slug. If no slug is
	 * given, it will be generated from the name.
	 * @param  boolean $is_pre_existent true if the metadata is supplied by
	 * another plugin.
	 * @param  string  $context         The meta box's context (side, …).
	 * @throws DomainException          If both the name and slug are empty
	 * (unable to generate a valid slug).
	 */
	public function __construct( $name, $desc = '', $slug = '',
		$is_pre_existent = false, $context = '' ) {

		parent::__construct( $name, $desc, $slug, '', $is_pre_existent );

		$this->fields = array();
		$this->context = $context;

	}

	/**
	 * Adds a field to this meta box.
	 *
	 * @since 0.1
	 * @param Pressbooks_Metadata_Field $field The field to be added.
	 */
	public function add_field( Pressbooks_Metadata_Field $field ) {

		$field->set_meta_box( $this );
		$this->fields[ $field->get_slug() ] = $field;

	}

	/**
	 * Returns the fields contained in this meta box.
	 *
	 * @since  0.1
	 * @return array The fields as an array of Pressbooks_Metadata_Field.
	 */
	public function get_fields() {

		return $this->fields;

	}

	/**
	 * Returns this meta box's context.
	 *
	 * @since  0.1
	 * @return string The context of this meta box.
	 */
	public function get_context() {

		return $this->context;

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
	 * Adds this meta box's contents to the current post metadata
	 * dashboard. To be used when appending metadata to an existing meta box
	 * in the dashboard.
	 *
	 * @since 0.1
	 * @param string $slug_prefix The prefix to append to each element
	 * added, for the sake of slug unicity.
	 */
	private function add_fields_to_current_post_metadata(
		$slug_prefix = '' ) {

		foreach ( $this->fields as $key => $val ) {
			$val->add_to_current_post_metadata( $slug_prefix );
		}

	}

	/**
	 * Adds this meta box (unless provided by another plugin) and its
	 * contents to the current post metadata dashboard.
	 *
	 * @since 0.1
	 * @param string $slug_prefix The prefix to append to each element
	 * added, for the sake of slug unicity. No prefix is added to the
	 * metabox slug.
	 */
	public function add_to_current_post_metadata( $slug_prefix = '' ) {

		if ( ! $this->get_is_pre_existent() ) {
			$args = $this->get_args();
			$context = $this->get_context();
			if ( ! empty( $context ) ) {
				$args['context'] = $context;
			}
			x_add_metadata_group( $this->get_slug(),
				$this->get_post_types(), $args );
		}

		$this->add_fields_to_current_post_metadata( $slug_prefix );

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

		// save two deep copies of fields
		$cloned = new Pressbooks_Metadata_Meta_Box( $this->get_name(),
			$this->get_description(), $this->get_slug(),
			$this->get_is_pre_existent(), $this->get_context() );

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
