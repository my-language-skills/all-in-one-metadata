<?php

/**
 * The educational information (book and chapter level)  metadata included by this plugin.
 *
 * @since      0.2
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/actual-metadata/concrete-metadata
 */

require_once plugin_dir_path( __FILE__ )
. '../class-pressbooks-metadata-plugin-metadata.php';

/**
 * The educational information (book and chapter level)  metadata included by this plugin.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/actual-metadata/concrete-metadata
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */
class Pressbooks_Metadata_Educational_Information_Metadata extends Pressbooks_Metadata_Plugin_Metadata {

	/**
	 * The class instance.
	 *
	 * @since  0.2
	 * @access private
	 * @var    Pressbooks_Metadata_Plugin_Metadata $instance The class instance.
	 */
	private static $instance = NULL;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  0.2
	 */
	protected function __construct() {

		parent::__construct();

		// Educational Information part
		$edu_info = new Pressbooks_Metadata_Meta_Box(
			'Educational Information',
			'',
			'educational-information' );
		$edu_info->add_post_type( 'metadata' );


		$edu_info->add_field( new Pressbooks_Metadata_Text_Field(
			'Subject', '', 'subject', '', '', '', false, '',
			'name' ) );

		$edu_info->add_field( new Pressbooks_Metadata_Text_Field(
			'Educational Level', '', 'level', '', '', '', false, '',
			'' ) );

		$edu_info->add_field( new Pressbooks_Metadata_Text_Field(
			'Educational Framework', '', 'framework', '', '', '', false, '',
			'' ) );

		$edu_info->add_field( new Pressbooks_Metadata_Text_Field(
			'Small Description', '', 'description', '', '', '', false, '',
			'description' ) );

		$edu_info->add_field( new Pressbooks_Metadata_Text_Field(
			'Provider', '', 'provider', '', '', '', false, '',
			'provider' ) );


		$edu_info->add_field( new Pressbooks_Metadata_List_Field(
			'Learning Resource Type',
			'The kind of resource this book represents',
			'learning_resource_type', '', '', 'course',
			array(
				'course' => 'Course',
				'exam' => 'Examination',
				'exercise' => 'Exercise'
			), 'learningResourceType' ) );

		$edu_info->add_field( new Pressbooks_Metadata_List_Field(
			'Interactivity Type',
			'The interactivity type of this book',
			'interactivity_type', '', '', 'expositive',
			array(
				'active' => 'Active',
				'expositive' => 'Expositive',
				'mixed' => 'Mixed'
			), 'interactivityType' ) );

		$edu_info->add_field( new Pressbooks_Metadata_List_Field( 'Age Range',
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

		$edu_info->add_field( new Pressbooks_Metadata_Number_Field(
			'Class Learning Time (hours)', '',
			'time_required', '', '', 0, false, 0, '', '', 'timeRequired' ) );

		$edu_info->add_field( new Pressbooks_Metadata_Text_Field( 'License URL',
			'', 'rights_url', '', '', '', false, 'http://site.com/',
			'license' ) );

		$edu_info->add_field( new Pressbooks_Metadata_Text_Field(
			'Bibliography URL',
			'The URL of a website/book this book is inspirated of',
			'bibliography_url',
			'', '', '', false, 'http://site.com/',
			'isBasedOnUrl' ) );

		$this->add_component( $edu_info );

		

	}

	/**
	 * Returns the class instance.
	 *
	 * @since  0.2
	 * @return Pressbooks_Metadata_Educational_Information_Metadata The class instance.
	 */
	public static function get_instance() {

		if ( NULL == Pressbooks_Metadata_Educational_Information_Metadata::$instance ) {
			Pressbooks_Metadata_Educational_Information_Metadata::$instance
				= new Pressbooks_Metadata_Educational_Information_Metadata();
		}
		return Pressbooks_Metadata_Educational_Information_Metadata::$instance;

	}

	
	/**
	 * Prints the links (HTML code) to related books for the public part of
	 * the book.
	 *
	 * @since 0.2
	 */
	public function print_educational_information_fields() {

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

