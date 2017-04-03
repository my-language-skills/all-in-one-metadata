<?php

/**
 * A field corresponding to an actual book metadata.
 * Has only one input field.
 *
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields/data-fields
 */

require_once plugin_dir_path( __FILE__ ) . 'class-pressbooks-metadata-data-field.php';

/**
 * A field corresponding to an actual book metadata.
 * Has only one input field.
 *
 * Defines the properties of a single field.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields/data-fields
 * @author     julienCXX <software@chmodplusx.eu>
 */
abstract class Pressbooks_Metadata_Single_Field extends Pressbooks_Metadata_Data_Field {

	/**
	 * The field's input type.
	 *
	 * @since  0.1
	 * @access private
	 * @var    string  $input_type An input type, as described in HTML.
	 */
	private $input_type;

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
	 * @param  object          $def_value     The field's default value.
	 * @param  boolean         $read_only     true if the field is read
	 * only, false otherwise.
	 * @param  string          $input_type    The field's input type, as
	 * described in HTML.
	 * @param  string          $itemprop      The field's Microdata itemprop
	 * attibute.
	 * @throws DomainException If both the name and slug are empty (unable
	 * to generate a valid slug).
	 */
	public function __construct( $name, $desc = '', $slug = '',
		$suffix = '', $disp_callback = '', $def_value = NULL,
		$read_only = false, $input_type = '', $itemprop = '' ) {

		parent::__construct( $name, $desc, $slug, $suffix,
			$disp_callback, $def_value, $read_only, $itemprop );

		$this->input_type = $input_type;

	}

	/**
	 * Returns the field's input type.
	 *
	 * @since  0.1
	 * @return string The field's input type, as described in HTML.
	 */
	public function get_input_type() {

		return $this->input_type;

	}

	/**
	 * Returns the arguments to be used when adding this metadata to the
	 * dashboard.
	 *
	 * @since  0.1
	 * @return array The arguments.
	 */
	protected function get_args() {

		$args = parent::get_args();
		if ( ! empty( $this->input_type ) ) {
			$args['field_type'] = $this->input_type;
		}

		return $args;

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

		if ( ! array_key_exists( $this->get_slug(), $fetched_metadata )
		) {
			return NULL;
		}

		$data = $fetched_metadata[ $this->get_slug() ];
		if ( empty( $data ) ) {
			unset( $fetched_metadata[ $this->get_slug() ] );
			return NULL;
		}

		if ( is_array( $data ) ) {
			$data = $data[0];
		}
		$cloned = clone $this;
		$cloned->set_value( $data );
		unset( $fetched_metadata[ $this->get_slug() ] );
		return $cloned;

	}

}
