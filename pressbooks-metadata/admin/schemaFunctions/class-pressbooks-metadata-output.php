<?php

namespace schemaFunctions;

/**
 * The functions of the plugin that handle the output of metadata in our site.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaFunctions
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Output {

	function __construct() {

	}

	/**
	 * This function is used to output the metadata in the header of the site.
	 * @since    0.x
	 */
	public function header_run() {

		$generalFunctions = new Pressbooks_Metadata_General_Functions();

		if ( is_home() ) {
			echo $generalFunctions->pmdt_get_root_level_metatags();
		} elseif ( is_front_page() ) {
			echo $generalFunctions->pmdt_get_googleScholar_metatags();
		}
	}

	/**
	 * This function is used to output the metadata in the footer of the site.
	 * @since    0.x
	 */
	public function footer_run() {
		$engine = new Pressbooks_Metadata_Engine();
		$instances = $engine->engine_run();
		if ( is_front_page() ) {
			//Here we get all the instances of metadata that have to be executed on the Book level - Site level
			foreach ( $instances as $class_instance ) {
				if($class_instance->pmdt_get_type_level() == 'metadata'){
					echo $class_instance->pmdt_get_metatags();
				}
			}
		} elseif ( ! is_home() ) {
			//Here we get all the instances of metadata that have to be executed on the Chapter level - Post Level
			foreach ( $instances as $class_instance ) {
				if($class_instance->pmdt_get_type_level() == 'chapter'){
					echo $class_instance->pmdt_get_metatags();
				}
			}
		}
	}
}

