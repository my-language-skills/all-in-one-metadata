<?php

/**
 * A field containing a placeholder value.
 *
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields/data-fields
 */

require_once plugin_dir_path( __FILE__ ) . 'class-pressbooks-metadata-single-field.php';

/**
 * A field containing a placeholder value.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields/data-fields
 * @author     julienCXX <software@chmodplusx.eu>
 */
abstract class Pressbooks_Metadata_Placeholder_Field
	extends Pressbooks_Metadata_Single_Field {

	/**
	 * The field's placeholder.
	 *
	 * @since  0.1
	 * @access private
	 * @var    string  $placeholder the field's placeholder.
	 */
	private $placeholder;

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
	 * @param  string          $placeholder   The field's placeholder.
	 * @param  string          $itemprop      The field's Microdata
	 * itemprop attibute.
	 * @throws DomainException If both the name and slug are empty (unable
	 * to generate a valid slug).
	 */
	public function __construct( $name, $desc = '', $slug = '',
		$suffix = '', $disp_callback = '', $def_value = '',
		$read_only = false, $input_type = '', $placeholder = '',
		$itemprop = '' ) {

		parent::__construct( $name, $desc, $slug, $suffix,
			$disp_callback, $def_value, $read_only, $input_type,
			$itemprop );

		$this->placeholder = $placeholder;

	}

	/**
	 * Returns the field's placeholder.
	 *
	 * @since  0.1
	 * @return string The field's placeholder.
	 */
	public function get_placeholder() {

		return $this->placeholder;

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
		if ( ! empty( $this->placeholder ) ) {
			$args['placeholder'] = $this->placeholder;
		}

		return $args;

	}

}
