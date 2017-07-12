<?php

namespace schemaFunctions;

/**
 * Function used to return all instances for the selected schema types in the settings,
 * Instances are used to create the metaboxes and the metadata. Here we also create the
 * sections and fields for the settings page of the plugin
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaFunctions
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Engine {

	/**
	 * Variable for creating settings
	 * Variable also used when creating type instances.
	 * @since    0.x
	 *
	 */
	private $metaSettings;

	function __construct() {
		//Use this array to create new settings for new types that you add
		//Every setting you create can be accessed using the example here
		//book_type -> This is the id of a field in the array below
		//book_level -> This is the section id that this fields exists (we have 2 sections for now BOOK AND CHAPTER)
		//if you add them together with a '_' you have the setting -> book_type_book_level
		//Use get_option() to get the value from the database (Process is Automatic)
		$this->metaSettings =
			array(
				//For every new type we add we need to add the settings here, url can be empty
				'book_type'    => array( 'Book Type', 'http://schema.org/Book' ),
				'course_type'  => array( 'Course Type', 'http://schema.org/Course' ),
				'webpage_type' => array( 'Webpage Type', 'http://schema.org/WebPage' ),
				'educational_info' => array('Educational Information','')
			);
	}

	/**
	 * Adding metaboxes with fields in the desired pages.
	 *
	 * @since  0.8.1
	 */
	public function place_metaboxes() {
		//All the instances created by the engine_run function - automatically create their metaboxes
		$this->engine_run();
	}

	/**
	 * Adding sections with fields in the options page using the class section.
	 *
	 * @since  0.8.1
	 */
	public function register_settings() {

		//For every new level / custom post type we add we need modifications here

		new \settings\Pressbooks_Metadata_Sections(
			'book_level',
			'Book Level',
			'pressbooks_metadata_options_page',
			$this->metaSettings
		);

		new \settings\Pressbooks_Metadata_Sections(
			'chapter_level',
			'Chapter Level',
			'pressbooks_metadata_options_page',
			$this->metaSettings
		);
	}

	/**
	 * Function used to return all instances for the selected types,
	 * Instances are used to create the metaboxes and the metadata
	 * For every new type that we add we need to make modifications here
	 *
	 * @since  0.x
	 */
	public function engine_run(){
		//This array will be filled up with instances of the active types, then it will be returned for processing
		$instances = array();

		//This array is needed for the levels that we show different types like chapter and book levels
		$levels = array(
			//For every new level / custom post type we add we need modifications here
			'book_level' => 'metadata',
			'chapter_level' => 'chapter'
		);

		foreach ($levels as $level => $cpt) {
			foreach ($this->metaSettings as $type => $link){

				//Checking the settings for each level and we create instances for the active types
				if(get_option($type.'_'.$level)){
					switch($type){

						case 'book_type':
							$instances[] = new \schemaTypes\Pressbooks_Metadata_Book($cpt);
							break;

						case 'course_type':
							$instances[] = new \schemaTypes\Pressbooks_Metadata_Course($cpt);
							break;

						case 'webpage_type':
							$instances[] = new \schemaTypes\Pressbooks_Metadata_WebPage($cpt);
							break;

						case 'educational_info':
							//Preventing the Educational metadata being created or run on chapter level (for now)
							if($cpt != 'chapter'){
								$instances[] = new \schemaTypes\Pressbooks_Metadata_Educational($cpt);
							}
							break;
					}

				}
			}
		}
		//Here we create a parent for each type if one exists
		foreach($instances as $instance){
			$instances []= $instance->pmdt_parent_init();
		}

		//Then we clear duplicates from the instances
		//For example book and webpage have both creative works as parent, so we keep only one
		$instances = array_unique($instances);
		return $instances;
	}
}

