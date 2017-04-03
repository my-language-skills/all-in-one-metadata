<?php

/**
 * A metadata (anything that can be added to the dashboard).
 *
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components
 */

/**
 * A metadata (anything that can be added to the dashboard).
 *
 * Defines the common properties of any metadata that can be added to the
 * dashboard.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components
 * @author     julienCXX <software@chmodplusx.eu>
 */
abstract class Pressbooks_Metadata_Abstract_Metadata {

	/*
	 * A field has:
	 * slug (without prefix)
	 * name (label)
	 * description
	 * type (text, url, list, …)
	 * value (if fetched)
	 * default value
	 * is read only
	 * associated post type
	 * associated metabox
	 * associated group (optional)
	 * placeholder (depends on type)
	 * values list (for list types only)
	 * min/max (for number type only)
	 * display callback (has to be static)
	 * sanitize callback (has to be static)
	 * microdata itemProp
	 * ? metabox slug
	 *
	 * it can be composed of several sub-fields
	 *
	 * A field has to do:
	 * getters
	 * return array for adding to metadata list
	 * return meta tag (ready to be printed)
	 *
	 * A group has:
	 * name
	 * a slug
	 * a list of fields
	 *
	 * A group can:
	 * getters
	 */

	/**
	 * The metadata's name (title).
	 *
	 * @since  0.1
	 * @access private
	 * @var    string  $name The metadata's name (title).
	 */
	private $name;

	/**
	 * The field's description.
	 *
	 * @since  0.1
	 * @access private
	 * @var    string  $description The field's description.
	 */
	private $description;

	/**
	 * The field's slug (unique ID).
	 *
	 * @since  0.1
	 * @access private
	 * @var    string  $slug The field's slug (unique ID).
	 */
	private $slug;

	/**
	 * The post types the metadata is part of.
	 *
	 * @since  0.1
	 * @access private
	 * @var    array  $post_types The post types the metadata is part of.
	 */
	private $post_types;

	/**
	 * If the metadata is supplied by another plugin.
	 *
	 * @since  0.1
	 * @access private
	 * @var    boolean $is_pre_existent true if the metadata is supplied by
	 * another plugin.
	 */
	private $is_pre_existent;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  0.1
	 * @param  string  $name            The metadata's name.
	 * @param  string  $desc            The metadata's description.
	 * @param  string  $slug            The metadata's slug. If no slug is
	 * given, it will be generated from the name.
	 * @param  string  $suffix          A suffix to append to the metadata's
	 * slug.
	 * @param  boolean $is_pre_existent true if the metadata is supplied by
	 * another plugin.
	 * @throws DomainException          If both the name and slug are empty
	 * (unable to generate a valid slug).
	 */
	public function __construct( $name, $desc = '', $slug = '',
		$suffix = '', $is_pre_existent = false ) {

		$this->name = trim( $name );
		$this->description = trim( $desc );
		$this->slug = trim( $slug );
		if ( empty( $this->slug ) ) {
			$this->slug = $this->get_slug_from_label( $this->name );
		}
		if ( empty( $this->slug ) ) {
			throw new DomainException(
				'Could not create a valid slug from name: '
				. $this->name );
		}
		$this->slug .= $suffix;
		$this->post_types = array();
		$this->is_pre_existent = $is_pre_existent;

	}

	/**
	 * Generates a slug from a label.
	 *
	 * @since  0.1
	 * @param  string $label The input label.
	 * @return string The slugged label.
	 */
	private function get_slug_from_label( $label ) {

		if ( empty( $label ) ) {
			return '';
		}
		$label = strtolower( $label );
		$res = preg_replace( '/[^a-z]/', '_', $label );
		return $res;

	}

	/**
	 * Returns the metadata's name.
	 *
	 * @since  0.1
	 * @return string The name of the metadata.
	 */
	public function get_name() {

		return $this->name;

	}

	/**
	 * Returns the metadata's description.
	 *
	 * @since  0.1
	 * @return string The metadata's description.
	 */
	public function get_description() {

		return $this->description;

	}

	/**
	 * Returns the metadata's slug.
	 *
	 * @since  0.1
	 * @return string The metadata's slug.
	 */
	public function get_slug() {

		return $this->slug;

	}

	/**
	 * Adds a post type this metadata is part of.
	 * If this metadata is already part of the given post type, nothing is
	 * changed (set semantic). The same happens for an empty string.
	 *
	 * @since 0.1
	 * @param string $post_type The post type to add.
	 */
	public function add_post_type( $post_type ) {

		$to_add = trim( $post_type );
		if ( empty( $to_add )
			|| in_array( $to_add, $this->post_types ) ) {
			return;
		}
		$this->post_types[] = $to_add;

	}

	/**
	 * Adds an array of post types this metadata is part of.
	 * If this metadata is already part of the given post types, nothing is
	 * changed (set semantic). The same happens for empty strings.
	 *
	 * @since 0.1
	 * @param array $post_type The post types to add.
	 */
	public function add_post_types( $post_types ) {

		foreach ( $post_types as $key => $val ) {
			$this->add_post_type( $val );
		}

	}

	/**
	 * Returns the post types this metadata is part of.
	 *
	 * @since  0.1
	 * @return array The post types this metadata is part of.
	 */
	public function get_post_types() {

		return $this->post_types;

	}

	/**
	 * Says if this element of metadata is a supplied by another plugin.
	 *
	 * @since  0.1
	 * @return boolean $is_pre_existent true if the metadata is supplied by
	 * another plugin.
	 */
	public function get_is_pre_existent() {

		return $this->is_pre_existent;

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

		return false;

	}

	/**
	 * Returns the arguments to be used when adding this metadata to the
	 * dashboard.
	 *
	 * @since  0.1
	 * @return array The arguments.
	 */
	protected function get_args() {

		$args = array();
		if ( ! empty( $this->name ) ) {
			$args['label'] = $this->name;
		}
		if ( ! empty( $this->description ) ) {
			$args['description'] = $this->description;
		}
		return $args;

	}

	/**
	 * Adds this metadata to the current post metadata dashboard.
	 *
	 * @since 0.1
	 * @param string $slug_prefix The prefix to append to each element.
	 */
	abstract public function add_to_current_post_metadata(
		$slug_prefix = '' );

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
	abstract public function clone_with_value( &$fetched_metadata );

}
