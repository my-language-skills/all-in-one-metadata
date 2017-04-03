<?php

/**
 * Most of the chapter metadata included/used by this plugin.
 *
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/actual-metadata/concrete-metadata
 */

require_once plugin_dir_path( __FILE__ )
. '../class-pressbooks-metadata-plugin-metadata.php';

/**
 * Most of the chapter metadata included/used by this plugin.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/actual-metadata/concrete-metadata
 * @author     julienCXX <software@chmodplusx.eu>
 */
class Pressbooks_Metadata_Chapter_Metadata extends Pressbooks_Metadata_Plugin_Metadata {

	/**
	 * The class instance.
	 *
	 * @since  0.1
	 * @access private
	 * @var    Pressbooks_Metadata_Plugin_Metadata $instance The class instance.
	 */
	private static $instance = NULL;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  0.1
	 */
	protected function __construct() {

		parent::__construct();

		// Preexisting meta-box
		$chap_meta = new Pressbooks_Metadata_Meta_Box(
			'Chapter Metadata', '',
			'chapter-metadata', true );
		$chap_meta->add_post_type( 'chapter' );

		$chap_meta->add_field( new Pressbooks_Metadata_Url_Field(
			'Questions and answers',
			'The URL of a forum/discussion about this page.',
			'discussion_url', '', '', '', false,
			'http://site.com/','URL' ) );

		$chap_meta->add_field( new Pressbooks_Metadata_Number_Field(
			'Class Learning Time (minutes)',
			'', 'time_required', '', '', 0, false, 0, '', '', 'timeRequired') );

		// Built-in fields (from WordPress)
		$chap_meta->add_field( new Pressbooks_Metadata_Creation_Date_Field(
			'Created on' ) );

		$chap_meta->add_field( new Pressbooks_Metadata_Modification_Date_Field(
			'Last modified on' ) );

		$this->add_component( $chap_meta );

	}

	/**
	 * Returns the class instance.
	 *
	 * @since  0.1
	 * @return Pressbooks_Metadata_Book_Metadata The class instance.
	 */
	public static function get_instance() {

		if ( NULL == Pressbooks_Metadata_Chapter_Metadata::$instance ) {
			Pressbooks_Metadata_Chapter_Metadata::$instance
				= new Pressbooks_Metadata_Chapter_Metadata();
		}
		return Pressbooks_Metadata_Chapter_Metadata::$instance;

	}

	/**
	 * Prints the HTML code of chapter metadata for the public part of
	 * the book.
	 *
	 * @since 0.1
	 */
	public function print_chapter_metadata_fields() {

		$meta = $this->get_current_metadata_flat();
		if ( empty( $meta ) ) {
			return;
		}

		?><table><?php
		foreach ( $meta as $elt ) {
			?><tr><td><?php echo $elt->get_name(); ?></td><?php
			?><td><?php echo $elt; ?></td></tr><?php
		}
		?></table><?php

	}

}

