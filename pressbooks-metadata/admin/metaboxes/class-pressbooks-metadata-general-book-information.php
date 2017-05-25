<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       hhttps://github.com/Books4Languages/pressbooks-metadata
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
class Pressbooks_Metadata_General_Book_Information {

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
	 * @since    0.8
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	* The function which produces the metafields to the existing
	* metabox General Book Information of Pressbooks
	*
	* @since 0.8
	*/
	public function add_metadata(){

		//--- Genral Book Informaton metabox ---//

		//----------- metafields ----------- //
		
		// Illustrator
		x_add_metadata_field( 	'pb_illustrator', 'metadata', array(
			'group' 		=> 	'general-book-information',
			'label' 		=> 	'Illustrator',
		) );

		// Book Edition
		x_add_metadata_field( 	'pb_edition', 'metadata', array(
			'group' 		=>	'general-book-information',
			'label' 		=>	'Book Edition',
			'description'	=>	'The edition of the book. Example: First Edition or 1 or 1.0.0',
		) );


	}
	

}
