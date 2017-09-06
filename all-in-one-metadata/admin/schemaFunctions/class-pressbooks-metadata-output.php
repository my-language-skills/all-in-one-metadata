<?php

namespace schemaFunctions;
use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;
use vocabularyFunctions;

/**
 * The functions of the plugin that handle the output of metadata in our site.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.9
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
	 * @since    0.9
	 */
	public function header_run() {
		$generalFunctions = new Pressbooks_Metadata_General_Functions();
		if ( is_home() ) {
			echo $generalFunctions->get_root_level_metatags();
		} elseif ( is_front_page() && site_cpt::pressbooks_identify() ) {
			echo $generalFunctions->get_googleScholar_metatags();
		}
	}

	/**
	 * This function is used to output the metadata in the footer of the site.
	 * @since    0.9
	 */
	public function footer_run() {
		//Getting all instances of schema types that are enabled
		$engine = new Pressbooks_Metadata_Engine();
		$instances = $engine->engine_run();

		//Checking if we are executing Book Info or Site-Meta data for the front page - Site Level - Book Level
		if(!site_cpt::pressbooks_identify()){
			$front_schema = 'site-meta';
		}else{
			$front_schema = 'metadata';
		}
		if ( is_front_page() ) {
			//Here we get all the instances of metadata that have to be executed on the Book level - Site level
			foreach ( $instances as $class_instance ) {
				if($class_instance->pmdt_get_type_level() == $front_schema){
					echo $class_instance->pmdt_get_metatags();
				}
			}

			//Outputting the metadata for the Vocabularies
			$vocabularySettings = array(
				'coins_checkbox' => 'vocabularyFunctions\Pressbooks_Metadata_Coins',
				'dublin_checkbox' => 'vocabularyFunctions\Pressbooks_Metadata_Dublin',
				'educational_checkbox' => 'vocabularyFunctions\Pressbooks_Metadata_Educational'
			);

			foreach($vocabularySettings as $setting => $class){
				if(get_option($setting)){
					$vocabToUse = new $class;
					echo $vocabToUse->pmdt_get_metatags();
				}
			}

		} elseif ( ! is_home() ) {
			//Here we get all the instances of metadata that have to be executed on the post levels - Chapter Level
			foreach ( $instances as $class_instance ) {
				if($class_instance->pmdt_get_type_level() == get_post_type()){
					echo $class_instance->pmdt_get_metatags();
				}
			}
		}
	}
}

