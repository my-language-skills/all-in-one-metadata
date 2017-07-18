<?php

namespace settings;

/**
 * This class is an automation for creating fields in the section where we show post types,
 * it is targeted for the pressbooks-metadata plugin
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/settings
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Post_Type_Fields {

	/**
	 * The identifier for the field.
	 *
	 * @since    0.x
	 * @access   private
	 */
	private $fieldIdentifier;

	/**
	 * The field name
	 *
	 * @since    0.x
	 * @access   private
	 */
	private $fieldName;

	/**
	 * The section page for displaying.
	 *
	 * @since    0.x
	 * @access   private
	 */
	private $sectionPage;

	/**
	 * The section name.
	 *
	 * @since    0.x
	 * @access   private
	 */
	private $sectionName;

	function __construct($fieldIdentifierInput,$fieldNameInput,$sectionPageInput,$sectionNameInput) {
		$this->fieldIdentifier = $fieldIdentifierInput;
		$this->fieldName = $fieldNameInput;
		$this->sectionPage = $sectionPageInput;
		$this->sectionName = $sectionNameInput;

		//This is a small fix for naming
		if($this->fieldName == 'Metadata'){
			$this->fieldName = 'Site-meta';
		}

		$this->pmdt_create_field();
	}

	/**
	 * The main function used to create a field.
	 *
	 * @since  0.x
	 */
	function pmdt_create_field(){
		add_settings_field(
			$this->fieldIdentifier,            // ID used to identify the field throughout the theme
			$this->fieldName,                  // The label to the left of the option interface element
			array( $this, 'pmdt_field_draw' ), // The name of the function responsible for rendering the option interface
			$this->sectionPage,                // The page on which this option will be displayed
			$this->sectionName                 // The name of the section to which this field belongs
		);

		//Registering field
		register_setting( $this->sectionPage, $this->fieldIdentifier);
	}

	/**
	 * The main function used to render the description of the field.
	 *
	 * @since  0.x
	 */
	function pmdt_field_draw(){
		echo '<input type="checkbox" id="'.$this->fieldIdentifier.'" name="'.$this->fieldIdentifier.'" value="1" ' . checked(1, get_option($this->fieldIdentifier), false) . '/>';

	}
}