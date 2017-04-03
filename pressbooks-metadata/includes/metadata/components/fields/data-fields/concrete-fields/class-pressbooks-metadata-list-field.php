<?php

/**
 * A list field.
 *
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields/data-fields/concrete-fields
 */

require_once plugin_dir_path( __FILE__ ) . '../class-pressbooks-metadata-single-field.php';

/**
 * A list field.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields/data-fields/concrete-fields
 * @author     julienCXX <software@chmodplusx.eu>
 */
class Pressbooks_Metadata_List_Field extends Pressbooks_Metadata_Single_Field {

	/**
	 * The values that can be chosen from the list.
	 *
	 * @since  0.1
	 * @access private
	 * @var    array   $values Key/value pairs of values that can be chosen
	 * from the list.
	 */
	private $values;

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
	 * @param  array           $values        The key/value pairs of values
	 * that can be chosen from the list.
	 * @param  string          $itemprop      The field's Microdata itemprop
	 * attibute.
	 * @throws DomainException If both the name and slug are empty (unable
	 * to generate a valid slug), if the default value is not part of the
	 * values (keys), or if there is an invalid key (empty string or
	 * non-string value).
	 * @throws InvalidArgumentException If no values are given, or not as an
	 * array.
	 */
	public function __construct( $name, $desc = '', $slug = '',
		$suffix = '', $disp_callback = '', $def_value = '', $values,
		$itemprop = '' ) {

		parent::__construct( $name, $desc, $slug, $suffix,
			$disp_callback, $def_value, false, 'select',
			$itemprop );

		if ( empty( $values ) ) {
			throw new InvalidArgumentException(
				'The “values” argument is empty.' );
		}
		if ( ! is_array( $values ) ) {
			throw new InvalidArgumentException(
				'The “values” argument is not an array.' );
		}
		if ( ! empty( $default_value )
			&& ! array_key_exists( $def_value, $values ) ) {
			throw new DomainException(
				'The “default value” (' . $def_value
				. ') argument is not part of the provided '
				. 'list of values.' );
		}
		if ( array_key_exists( '', $values ) ) {
			throw new DomainException( 'The empty string is not '
				. 'allowed as a part of keys in list of values.'
			);
		}
		$this->values = $values;

	}

	/**
	 * Returns the values that can be chosen from the list.
	 *
	 * @since  0.1
	 * @return array The values that can be chosen from the list.
	 */
	public function get_values() {

		return $this->values;

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
		if ( ! empty( $this->values ) ) {
			$args['values'] = $this->values;
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
		$value_name = '';
		if ( isset( $this->values[$value] ) ) {
			$value_name = $this->values[$value];
		}
		return htmlentities( $value_name, ENT_QUOTES | ENT_HTML5 );

	}

}
