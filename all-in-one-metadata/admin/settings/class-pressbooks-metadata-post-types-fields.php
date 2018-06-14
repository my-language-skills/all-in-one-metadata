<?php

namespace settings;
use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;

/**
 * This class is an automation for creating fields on settings page, to see which fields are created with this class check register_settings method in engine class
 * it is targeted for the pressbooks-metadata plugin
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.9
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/settings
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Post_Type_Fields {

	/**
	 * The identifier for the field.
	 *
	 * @since    0.9
	 * @access   private
	 */
	private $fieldIdentifier;

	/**
	 * The field name
	 *
	 * @since    0.9
	 * @access   private
	 */
	private $fieldName;

	/**
	 * The section page for displaying.
	 *
	 * @since    0.9
	 * @access   private
	 */
	private $sectionPage;

	/**
	 * The section name.
	 *
	 * @since    0.9
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
			$this->fieldName = 'Book Info';
		}

		$this->pmdt_create_field();
	}

	/**
	 * The main function used to create a field.
	 *
	 * @since  0.9
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
	 * @since  0.9
	 */
	function pmdt_field_draw(){
		echo '<input type="checkbox" id="'.$this->fieldIdentifier.'" name="'.$this->fieldIdentifier.'" value="1" ' . checked(1, get_option($this->fieldIdentifier), false) . '/>';
		//Outputting messages for the site level -- book level metadata
		if($this->fieldName == 'Site-meta'){
			if(site_cpt::pressbooks_identify()){
				echo '<p>If you enable this you will be able to add metadata to your Book from Book Info menu.</p>';
			}else{
				echo '<p>If you enable this you will be able to add metadata to your Site from Site Metadata submenu under Tools</p>';
			}
		}else if($this->fieldName == 'Allow Overwrite'){
            echo '<p>If you enable this you allow the super admin to take full access on your site metadata.</p>';
        }
	}
}