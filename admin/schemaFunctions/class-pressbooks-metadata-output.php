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
 * @author     Christos Amyrotos @MashRoofa
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
		$post_schema = get_post_type();
		if ( is_front_page() ) {
			//Here we get all the instances of metadata that have to be executed on the Book level - Site level
			foreach ( $instances as $class_instance ) {
				if($class_instance->pmdt_get_type_level() == $front_schema){
					echo $class_instance->pmdt_get_metatags();
				}
			}

			if (is_plugin_active('aiom-educational-related-content/aiom-educational-related-content.php')) {
				//Outputting metadata for the Educational Vocabulary on Site Level
				require_once ABSPATH . '/wp-content/plugins/aiom-educational-related-content/admin/class-pressbooks-metadata-educational.php';
				require_once ABSPATH . '/wp-content/plugins/aiom-educational-related-content/admin/class-pressbooks-metadata-dublin.php';
				require_once ABSPATH . '/wp-content/plugins/aiom-educational-related-content/admin/class-pressbooks-metadata-coins.php';

				if (get_option( $front_schema.'_edu_op')){
					$vocabToUse = new \educa\Pressbooks_Metadata_Educational( $front_schema );
					echo $vocabToUse->pmdt_get_metatags();
				}

				if (get_option( $front_schema.'_edu_dublin_op')){
					$vocabToUse = new \educa\Pressbooks_Metadata_Dublin( $front_schema );
					echo $vocabToUse->pmdt_get_metatags();
				}

				if (get_option( $front_schema.'_edu_coins_op')){
					$vocabToUse = new \educa\Pressbooks_Metadata_Coins( $front_schema );
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

			if (is_plugin_active('aiom-educational-related-content/aiom-educational-related-content.php')) {
				//Outputting metadata for the Educational Vocabulary on Post Level
				require_once ABSPATH . '/wp-content/plugins/aiom-educational-related-content/admin/class-pressbooks-metadata-educational.php';
				require_once ABSPATH . '/wp-content/plugins/aiom-educational-related-content/admin/class-pressbooks-metadata-dublin.php';
				require_once ABSPATH . '/wp-content/plugins/aiom-educational-related-content/admin/class-pressbooks-metadata-coins.php';

				if (get_option( $front_schema.'_edu_op')){
					$vocabToUse = new \educa\Pressbooks_Metadata_Educational( $post_schema );
					echo $vocabToUse->pmdt_get_metatags();
				}

				if (get_option( $front_schema.'_edu_dublin_op')){
					$vocabToUse = new \educa\Pressbooks_Metadata_Dublin( $post_schema );
					echo $vocabToUse->pmdt_get_metatags();
				}

				if (get_option( $front_schema.'_edu_coins_op')){
					$vocabToUse = new \educa\Pressbooks_Metadata_Coins( $post_schema );
					echo $vocabToUse->pmdt_get_metatags();
				}
			}
		}
	}
}

