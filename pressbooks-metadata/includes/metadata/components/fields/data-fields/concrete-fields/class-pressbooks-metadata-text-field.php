<?php

/**
 * A text field.
 *
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields/data-fields/concrete-fields
 */

require_once plugin_dir_path( __FILE__ ) . '../class-pressbooks-metadata-placeholder-field.php';

/**
 * A text field.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields/data-fields/concrete-fields
 * @author     julienCXX <software@chmodplusx.eu>
 */
class Pressbooks_Metadata_Text_Field extends Pressbooks_Metadata_Placeholder_Field {

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
	 * @param  string          $placeholder   The field's placeholder.
	 * @param  string          $itemprop      The field's Microdata itemprop
	 * attibute.
	 * @throws DomainException If both the name and slug are empty (unable
	 * to generate a valid slug).
	 */
	public function __construct( $name, $desc = '', $slug = '',
		$suffix = '', $disp_callback = '', $def_value = '',
		$read_only = false, $placeholder = '', $itemprop = '' ) {

		parent::__construct( $name, $desc, $slug, $suffix,
			$disp_callback, $def_value, $read_only, 'text',
			$placeholder, $itemprop );

	}

}
