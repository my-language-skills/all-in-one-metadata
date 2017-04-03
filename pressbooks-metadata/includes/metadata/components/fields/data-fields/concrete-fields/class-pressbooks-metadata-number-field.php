<?php

/**
 * A number field.
 *
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields/data-fields/concrete-fields
 */

require_once plugin_dir_path( __FILE__ ) . '../class-pressbooks-metadata-placeholder-field.php';

/**
 * A number field.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields/data-fields/concrete-fields
 * @author     julienCXX <software@chmodplusx.eu>
 */
class Pressbooks_Metadata_Number_Field extends Pressbooks_Metadata_Placeholder_Field {

	/**
	 * The field's minimal accepted number.
	 *
	 * @since  0.1
	 * @access private
	 * @var    int|NULL $min The field's minimal accepted number.
	 */
	private $min;

	/**
	 * The field's maximal accepted number.
	 *
	 * @since  0.1
	 * @access private
	 * @var    int|NULL $max The field's maximal accepted number.
	 */
	private $max;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  0.1
	 * @param  string           $name          The field's name.
	 * @param  string           $desc          The field's description.
	 * @param  string           $slug          The field's slug. If no slug
	 * is given, it will be generated from the name.
	 * @param  string           $suffix        A suffix to append to the
	 * field's slug.
	 * @param  string           $disp_callback The callback used to display
	 * the field in the dashboard. Should be a static function.
	 * @param  object           $def_value     The field's default value.
	 * @param  boolean          $read_only     true if the field is read
	 * only, false otherwise.
	 * @param  string|int|float $min           The minimal value allowed in
	 * this field (empty string = no min). Floats will be truncated.
	 * @param  string|int|float $max           The maximal value allowed in
	 * this field (empty string = no max). Floats will be truncated.
	 * @param  string           $placeholder   The field's placeholder.
	 * @param  string           $itemprop      The field's Microdata
	 * itemprop attibute.
	 * @throws DomainException  If both the name and slug are empty (unable
	 * to generate a valid slug), or if “min” is bigger than “max”.
	 * @throws InvalidArgumentException If the “min” or ”max” argument is
	 * not empty and is not a number (or a string representing a number).
	 */
	public function __construct( $name, $desc = '', $slug = '',
		$suffix = '', $disp_callback = '', $def_value = '',
		$read_only = false, $min = '', $max = '', $placeholder = '',
		$itemprop = '' ) {

		parent::__construct( $name, $desc, $slug, $suffix,
			$disp_callback, strval( $def_value ), $read_only,
			'number', $placeholder, $itemprop );

		if ( '' === $min ) {
			$this->min = NULL;
		} else {
			$this->min = $min;
		}
		if ( '' === $max ) {
			$this->max = NULL;
		} else {
			$this->max = $max;
		}
		if ( ! empty( $this->min ) && ! empty( $this->max )
			&& $this->min > $this->max ) {
			throw new DomainException(
				'The given min value (' . $min
				. ') is bigger than the given max value ('
				. $max . ').' );
		}

	}

	/**
	 * Tries to convert an input to an integer (or NULL for an empty
	 * string).
	 *
	 * @since  0.1
	 * @param  object                   $input The value to convert to an
	 * integer.
	 * @return NULL|int                 The converted value (floats will be
	 * truncated).
	 * @throws InvalidArgumentException If the given argument is not empty
	 * and is not a number (or a string representing a number).
	 */
	private function to_int( $input ) {

		if ( empty( $input ) ) {
			return NULL;
		}
		if ( ! is_numeric( $input ) ) {
			throw new InvalidArgumentException( 'The given value ('
				. $input . ') is not a number.' );
		}
		return intval( $input );

	}

	/**
	 * Returns the field's minimal accepted number.
	 *
	 * @since  0.1
	 * @return string The field's minimal accepted number.
	 */
	public function get_min() {

		return $this->min;

	}

	/**
	 * Returns the field's maximal accepted number.
	 *
	 * @since  0.1
	 * @return string The field's maximal accepted number.
	 */
	public function get_max() {

		return $this->max;

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
		if ( NULL !== $this->min ) {
			$args['min'] = strval( $this->min );
		}
		if ( NULL !== $this->max ) {
			$args['max'] = strval( $this->max );
		}

		return $args;

	}

}
