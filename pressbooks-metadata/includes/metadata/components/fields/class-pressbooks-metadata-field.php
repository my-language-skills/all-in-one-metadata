<?php

/**
 * A metadata field (that can be added to the dashboard).
 *
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields
 */

require_once plugin_dir_path( __FILE__ )
. '../class-pressbooks-metadata-abstract-metadata.php';

/**
 * A metadata field (that can be added to the dashboard).
 *
 * Defines the properties of a field, addable to the dashboard.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields
 * @author     julienCXX <software@chmodplusx.eu>
 */
abstract class Pressbooks_Metadata_Field extends Pressbooks_Metadata_Abstract_Metadata {

	/**
	 * The meta box this field resides in.
	 *
	 * @since  0.1
	 * @access private
	 * @var    Pressbooks_Metadata_Meta_Box $meta_box The meta box this field
	 * resides in.
	 */
	private $meta_box;

	/**
	 * The callback used to display the field in the dashboard.
	 *
	 * @since  0.1
	 * @access private
	 * @var    string  $display_callback The callback used to display the
	 * field in the dashboard.
	 */
	private $display_callback;

	/**
	 * Initialize the class and set its properties. Adds the field to the
	 * given meta box, if required.
	 *
	 * @since  0.1
	 * @param  string          $name   The field's name.
	 * @param  string          $desc   The field's description.
	 * @param  string          $slug   The field's slug. If no slug is
	 * given, it will be generated from the name.
	 * @param  string          $suffix A suffix to append to the field's
	 * slug.
	 * @param  string          $disp_callback The callback used to display
	 * the field in the dashboard. Should be a static function.
	 * @throws DomainException If both the name and slug are empty
	 * (unable to generate a valid slug).
	 */
	public function __construct( $name, $desc = '', $slug = '',
		$suffix = '', $disp_callback = '' ) {

		parent::__construct( $name, $desc, $slug, $suffix );

		$this->meta_box = NULL;
		$this->display_callback = $disp_callback;

	}

	/**
	 * Sets the meta box this field resides in. Also adds the meta box's
	 * post types.
	 *
	 * @since  0.1
	 * @param Pressbooks_Metadata_Meta_Box $meta_box The meta box this field resides
	 * in or NULL if the field does not reside in a metabox.
	 */
	public function set_meta_box( &$meta_box ) {

		if ( $this->meta_box == $meta_box ) {
			return;
		}
		$this->meta_box = $meta_box;
		$this->add_post_types( $meta_box->get_post_types() );

	}

	/**
	 * Returns the meta box this field resides in.
	 *
	 * @since  0.1
	 * @return Pressbooks_Metadata_Meta_Box The meta box this field resides in or
	 * NULL if the field does not reside in a metabox.
	 */
	public function get_meta_box() {

		return $this->meta_box;

	}

	/**
	 * Returns the callback used to display the field in the dashboard.
	 *
	 * @since  0.1
	 * @return string The callback used to display the field in the
	 * dashboard.
	 */
	public function get_display_callback() {

		return $this->display_callback;

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
		if ( ! empty( $this->meta_box ) ) {
			$args['group'] = $this->meta_box->get_slug();
		}
		if ( ! empty( $this->display_callback ) ) {
			$args['display_callback'] = $this->display_callback;
		}

		return $args;

	}

	/**
	 * Adds this metadata to the current post metadata dashboard.
	 *
	 * @since 0.1
	 * @param string $slug_prefix The prefix to append to each element.
	 */
	public function add_to_current_post_metadata(
		$slug_prefix = '' ) {

		$args = $this->get_args();
		x_add_metadata_field( $slug_prefix . $this->get_slug(),
			$this->get_post_types(), $args );

	}

}
