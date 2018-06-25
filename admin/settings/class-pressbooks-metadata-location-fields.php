<?php

namespace settings;
use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;

/**
 * This class is an automation for creating fields in the section where we select post types to show meta,
 * it is targeted for the pressbooks-metadata plugin
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.17
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/settings
 * @author     Daniil Zhitnitskii @danzhik
 */

class Pressbooks_Metadata_Location_Fields {

	/**
	 * The name of general option where location options are stored
	 *
	 * @since 0.17
	 * @access private
	 */
	private $optionGeneral;


	/**
	 * The identifier for the field inside option.
	 *
	 * @since    0.17
	 * @access   private
	 */
	private $fieldIdentifier;

	/**
	 * The field name
	 *
	 * @since    0.17
	 * @access   private
	 */
	private $fieldName;

	/**
	 * The section page for displaying.
	 *
	 * @since    0.17
	 * @access   private
	 */
	private $sectionPage;

	/**
	 * The section name.
	 *
	 * @since    0.17
	 * @access   private
	 */
	private $sectionName;

	function __construct($fieldIdentifierInput,$fieldNameInput,$sectionPageInput,$sectionNameInput) {
		$this->fieldIdentifier = $fieldIdentifierInput;
		$this->fieldName = $fieldNameInput;
		$this->sectionPage = $sectionPageInput;
		$this->sectionName = $sectionNameInput;
		$this->optionGeneral = get_option('schema_locations') ?: [];

		//This is a small fix for naming
		if($this->fieldName == 'Metadata'){
			$this->fieldName = 'Site-meta';
		}

		$this->pmdt_create_field();
	}

	/**
	 * The main function used to create a field.
	 *
	 * @since  0.17
	 */
	function pmdt_create_field(){
		add_settings_field(
			'schema_locations['.$this->fieldIdentifier.']',            // ID used to identify the field throughout the theme
			$this->fieldName,                  // The label to the left of the option interface element
			array( $this, 'pmdt_field_draw' ), // The name of the function responsible for rendering the option interface
			$this->sectionPage,                // The page on which this option will be displayed
			$this->sectionName                 // The name of the section to which this field belongs
		);

		$this->optionGeneral[$this->fieldIdentifier] = isset($this->optionGeneral[$this->fieldIdentifier]) ? $this->optionGeneral[$this->fieldIdentifier] : '';
		//Adding field to accumulated option
		update_option('schema_locations', $this->optionGeneral);
	}

	/**
	 * The main function used to render the description of the field.
	 *
	 * @since  0.17
	 */
	function pmdt_field_draw(){
		echo '<input type="checkbox" id="schema_locations['.$this->fieldIdentifier.']" name="schema_locations['.$this->fieldIdentifier.']" value="1" ' . checked(1, isset($this->optionGeneral[$this->fieldIdentifier]) ? ($this->optionGeneral[$this->fieldIdentifier] == 1 ? 1 : 0) : 0, false) . '/>';
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