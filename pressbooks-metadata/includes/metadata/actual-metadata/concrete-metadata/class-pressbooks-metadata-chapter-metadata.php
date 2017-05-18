<?php


require_once plugin_dir_path( __FILE__ )
. '../class-pressbooks-metadata-plugin-metadata.php';

/**
 * Most of the chapter metadata included/used by this plugin.
 *
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/actual-metadata/concrete-metadata
 * @author     julienCXX <software@chmodplusx.eu>
 * @author 	   Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
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
			'pb_questions_and_answers', '', '', '', false,
			'http://site.com/','discussionUrl' ) );

		$chap_meta->add_field( new Pressbooks_Metadata_Number_Field(
			'Topic Learning Time (minutes)',
			'The study time required for the topic', 'pb_class_learning_time', '', '', 0, false, 0, '', '', 'timeRequired') );

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
	 * @return Pressbooks_Metadata_Chapter_Metadata The class instance.
	 */
	public static function get_instance() {

		if ( NULL == Pressbooks_Metadata_Chapter_Metadata::$instance ) {
			Pressbooks_Metadata_Chapter_Metadata::$instance
				= new Pressbooks_Metadata_Chapter_Metadata();
		}
		return Pressbooks_Metadata_Chapter_Metadata::$instance;

	}

	

}

