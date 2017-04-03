<?php

/**
 * Most of the book metadata included/used by this plugin.
 *
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/actual-metadata/concrete-metadata
 */

require_once plugin_dir_path( __FILE__ )
. '../class-pressbooks-metadata-plugin-metadata.php';

/**
 * Most of the book metadata included/used by this plugin.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/actual-metadata/concrete-metadata
 * @author     julienCXX <software@chmodplusx.eu>
 */
class Pressbooks_Metadata_Book_Metadata extends Pressbooks_Metadata_Plugin_Metadata {

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
		$g_b_info = new Pressbooks_Metadata_Meta_Box(
			'Educational Book Information', '',
			'general-book-information', true );
		$g_b_info->add_post_type( 'metadata' );

		$g_b_info->add_field( new Pressbooks_Metadata_Language_List_Field(
			'Target language', 'The language this book is about',
			'target_language','','',' ' ) );

		$g_b_info->add_field( new Pressbooks_Metadata_List_Field( 'Level',
			'The language level the book is about', 'level', '',
			'', 'none', array(
				'none' => 'None',
				'a1' => 'A1',
				'a2' => 'A2',
				'b1' => 'B1',
				'b2' => 'B2',
				'c1' => 'C1',
				'c2' => 'C2'
			), ' ') );

		/* The Common European Framework of Reference for Languages
		 * (itemprop = educationalAlignment)
		 * not used for now */

		$g_b_info->add_field( new Pressbooks_Metadata_List_Field(
			'Learning Resource Type',
			'The kind of resource this book represents',
			'learning_resource_type', '', '', 'course',
			array(
				'course' => 'Course',
				'exam' => 'Examination',
				'exercise' => 'Exercise'
			), 'learningResourceType' ) );

		$g_b_info->add_field( new Pressbooks_Metadata_List_Field(
			'Interactivity Type',
			'The interactivity type of this book',
			'interactivity_type', '', '', 'expositive',
			array(
				'active' => 'Active',
				'expositive' => 'Expositive',
				'mixed' => 'Mixed'
			), 'interactivityType' ) );

		$g_b_info->add_field( new Pressbooks_Metadata_List_Field( 'Age Range',
			'The target age of this book',
			'age_range', '', '', '18',
			array(
				'18' => 'Adults',
				'17' => '17-18 years',
				'16' => '16-17 years',
				'15' => '15-16 years',
				'14' => '14-15 years',
				'13' => '13-14 years',
				'12' => '12-13 years',
				'11' => '11-12 years',
				'10' => '10-11 years',
				'9' => '9-10 years',
				'8' => '8-9 years',
				'7' => '7-8 years',
				'6' => '6-7 years',
				'5' => '5-3 years'
			), 'typicalAgeRange' ) );

		$g_b_info->add_field( new Pressbooks_Metadata_Number_Field(
			'Class Learning Time (hours)', '',
			'time_required', '', '', 0, false, 0, '', '', 'timeRequired' ) );

		$g_b_info->add_field( new Pressbooks_Metadata_Text_Field( 'License URL',
			'', 'rights_url', '', '', '', false, 'http://site.com/',
			'license' ) );

		$g_b_info->add_field( new Pressbooks_Metadata_Text_Field(
			'Bibliography URL',
			'The URL of a website/book this book is inspirated of',
			'bibliography_url',
			'', '', '', false, 'http://site.com/',
			'isBasedOnUrl' ) ); // TODO: there can be multiple URLs

		$this->add_component( $g_b_info );

	}

	/**
	 * Returns the class instance.
	 *
	 * @since  0.1
	 * @return Pressbooks_Metadata_Book_Metadata The class instance.
	 */
	public static function get_instance() {

		if ( NULL == Pressbooks_Metadata_Book_Metadata::$instance ) {
			Pressbooks_Metadata_Book_Metadata::$instance
				= new Pressbooks_Metadata_Book_Metadata();
		}
		return Pressbooks_Metadata_Book_Metadata::$instance;

	}

	/**
	 * Prints the HTML code of book metadata for the public part of
	 * the book.
	 *
	 * @since 0.1
	 */
	public function print_book_metadata_fields() {

		$meta = $this->get_current_metadata_flat();
		if ( empty( $meta ) ) {
			return;
		}

		foreach ( $meta as $elt ) {
			?><tr><td><?php echo $elt->get_name(); ?>:</td><?php
			?><td><?php echo $elt; ?></td></tr><?php
		}

	}

}

