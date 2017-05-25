<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/metaboxes
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */
class Pressbooks_Metadata_Chapter_Metadata {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.8
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.8
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since      0.8
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	* The function which produces the metafields to the existing
	* metabox Chapter Metadata of Pressbooks
	*
	* @since 0.8
	*/
	public function add_metadata(){

		//---- Chapter Metadata metabox ----//

		//----------- metafields ----------- //
		
		// Questions and answers
		x_add_metadata_field( 	'pb_questions_and_answers', 'chapter', array(
			'group' 		=>	'chapter-metadata',
			'label' 		=>	'Questions and answers',
			'description'	=>	'The URL of a forum/discussion about this page.',
			'placeholder' 	=>	'http://site.com/'
		) );

		// Topic Learning Time
		x_add_metadata_field( 	'pb_class_learning_time', 'chapter', array(
			'group' 		=> 	'chapter-metadata',
			'field_type'	=> 	'number',
			'label' 		=> 	'Topic Learning Time (minutes)',
			'description' 	=> 	'The study time required for the topic'
		) );

	}
	

}
