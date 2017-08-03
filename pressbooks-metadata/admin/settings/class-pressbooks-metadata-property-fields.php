<?php

namespace settings;

/**
 * This class is an automation for creating fields in the type property sections,
 * it is targeted for the pressbooks-metadata plugin
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/settings
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Property_Fields {

	/**
	 * The name of the property.
	 *
	 * @since    0.x
	 * @access   private
	 * @var      string    $property  The string used to uniquely this field's schema type property.
	 */
	private $property;

	/**
	 * The property details.
	 *
	 * @since    0.x
	 * @access   private
	 * @var      array   $details  The array used for this property details.
	 */
	private $details;

	/**
	 * The section ID for the current field's section.
	 *
	 * @since    0.x
	 * @access   private
	 * @var      string    $sectionId  The string used to uniquely the field's section ID.
	 */
	private $sectionId;

	/**
	 * The section Name for the current field's section.
	 *
	 * @since    0.x
	 * @access   private
	 * @var      string    $sectionName  The string used to uniquely this field's section Name.
	 */
	private $sectionName;

	/**
	 * The field's Display Page.
	 *
	 * @since    0.x
	 * @access   private
	 * @var      string    $displayPage The string used to uniquely this fields's Display Page.
	 */
	private $displayPage;

	/**
	 * The constructor for passing all information to the variables and finally creating a field.
	 *
	 * @since    0.x
	 */
	function __construct($propertyInput,$detailsInput,$sectionIdInput,$sectionNameInput,$displayPageInput) {
		$this->property = $propertyInput;
		$this->details = $detailsInput;
		$this->sectionId = $sectionIdInput;
		$this->sectionName = $sectionNameInput;
		$this->displayPage = $displayPageInput;

		$this->pmdt_create_field();
	}

	/**
	 * The main function used to create a field.
	 *
	 * @since  0.x
	 */
	function pmdt_create_field(){
		add_settings_field(
			$this->property.'_'.$this->sectionId,           // ID used to identify the field throughout the theme
			$this->details[1],                                // The label to the left of the option interface element
			array( $this, 'pmdt_field_draw' ),              // The name of the function responsible for rendering the option interface
			$this->displayPage,                             // The page on which this option will be displayed
			$this->sectionId                                // The name of the section to which this field belongs
		);

		register_setting( $this->displayPage, $this->property.'_'.$this->sectionId);
		if($this->details[0] == true){
			//Setting the required properties to be always enabled
			update_option($this->property.'_'.$this->sectionId,1);
		}
	}

	/**
	 * The main function used to render the description of the field.
	 *
	 * @since  0.x
	 */
	function pmdt_field_draw(){

		$disabled = $this->details[0]==true? 'disabled' : '';
		$html = '<input type="checkbox" id="'.$this->property.'_'.$this->sectionId.'" name="'.$this->property.'_'.$this->sectionId.'" value="1" ' . checked(1, get_option($this->property.'_'.$this->sectionId), false) . ''.$disabled.'/>';
		echo $html;
	}
}