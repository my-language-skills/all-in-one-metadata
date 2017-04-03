<?php

/**
 * A field corresponding to an actual book metadata.
 *
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields/data-fields
 */

require_once plugin_dir_path( __FILE__ ) . '../class-pressbooks-metadata-field.php';

/**
 * A field corresponding to an actual book metadata.
 *
 * Defines the properties of an actual field.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields/data-fields
 * @author     julienCXX <software@chmodplusx.eu>
 */
abstract class Pressbooks_Metadata_Data_Field extends Pressbooks_Metadata_Field {

	/**
	 * The field's default value.
	 *
	 * @since  0.1
	 * @access private
	 * @var    object  $default_value The field's default value.
	 */
	private $default_value;

	/**
	 * The field's read only specification.
	 *
	 * @since  0.1
	 * @access private
	 * @var    boolean $read_only true if the field is read only,
	 * false otherwise.
	 */
	private $read_only;

	/**
	 * The field's Microdata itemprop attribute
	 *
	 * @since  0.1
	 * @access private
	 * @var    string  $itemprop A Microdata itemprop attibute.
	 */
	private $itemprop;

	/**
	 * The field's value (only used after metadata fetching).
	 *
	 * @since  0.1
	 * @access private
	 * @var    mixed   $value The field's value.
	 */
	private $value;

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
	 * @param  string          $itemprop      The field's Microdata itemprop
	 * attibute.
	 * @throws DomainException If both the name and slug are empty (unable
	 * to generate a valid slug).
	 */
	public function __construct( $name, $desc = '', $slug = '',
		$suffix = '', $disp_callback = '', $def_value = NULL,
		$read_only = false, $itemprop = '' ) {

		parent::__construct( $name, $desc, $slug, $suffix,
			$disp_callback );

		$this->default_value = $def_value;
		$this->read_only = $read_only;
		$this->value = NULL;
		$this->itemprop = $itemprop;

	}

	/**
	 * Returns the field's default value.
	 *
	 * @since  0.1
	 * @return object The field's default value.
	 */
	public function get_default_value() {

		return $this->default_value;

	}

	/**
	 * Returns the field's read only specification.
	 *
	 * @since  0.1
	 * @return boolean true if the field is read only, false otherwise.
	 */
	public function get_read_only() {

		return $this->read_only;

	}

	/**
	 * Returns the field's Microdata itemprop attribute.
	 *
	 * @since  0.1
	 * @return string The field's Microdata itemprop attribute.
	 */
	public function get_itemprop() {

		return $this->itemprop;

	}

	/**
	 * Sets the field's value.
	 *
	 * @since 0.1
	 * @param mixed $value The field's value.
	 */
	protected function set_value( $value ) {

		$this->value = $value;

	}

	/**
	 * Returns the field's value.
	 *
	 * @since  0.1
	 * @return mixed The field's value.
	 */
	public function get_value() {

		return $this->value;

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
		if ( NULL !== $this->default_value
			&& '' !== $this->default_value ) {
			$args['default_value'] = $this->default_value;
		}
		if ( $this->read_only ) {
			$args['readonly'] = true;
		}

		return $args;

	}

	/**
	 * Creates a string representation of the element.
	 *
	 * @since 0.1
	 * @return string A string representation of the element.
	 */
	public function __toString() {

		$value = $this->get_value();
		return htmlentities( $value, ENT_QUOTES | ENT_HTML5 );

	}

	/**
	 * Creates a string representation of the element, used for Microdata
	 * “content” attribute.
	 *
	 * @since 0.1
	 * @return string A string representation of the element, for Microdata.
	 */
	public function toMicrodataString() {

		return $this->__toString();

	}

}
