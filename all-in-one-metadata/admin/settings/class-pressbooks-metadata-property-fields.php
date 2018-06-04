<?php

namespace settings;

use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;

/**
 * This class is an automation for creating fields in the type property sections,
 * it is targeted for the pressbooks-metadata plugin
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.10
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/settings
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Property_Fields {

	/**
	 * The name of the property.
	 *
	 * @since    0.10
	 * @access   private
	 * @var      string    $property  The string used to uniquely this field's schema type property.
	 */
	private $property;

	/**
	 * Accumulated option for properties of given post type and schema type
	 *
	 *  @since   0.17
	 *  @access private
	 */
	private $generalFunction;

	/**
	 * The property details.
	 *
	 * @since    0.10
	 * @access   private
	 * @var      array   $details  The array used for this property details.
	 */
	private $details;

	/**
	 * The section ID for the current field's section.
	 *
	 * @since    0.10
	 * @access   private
	 * @var      string    $sectionId  The string used to uniquely the field's section ID.
	 */
	private $sectionId;

	/**
	 * The section Name for the current field's section.
	 *
	 * @since    0.10
	 * @access   private
	 * @var      string    $sectionName  The string used to uniquely this field's section Name.
	 */
	private $sectionName;

	/**
	 * The field's Display Page.
	 *
	 * @since    0.10
	 * @access   private
	 * @var      string    $displayPage The string used to uniquely this fields's Display Page.
	 */
	private $displayPage;

	/**
	 * The constructor for passing all information to the variables and finally creating a field.
	 *
	 * @since    0.10
	 */
	function __construct($propertyInput,$detailsInput,$sectionIdInput,$sectionNameInput,$displayPageInput) {
		$this->property = $propertyInput;
		$this->details = $detailsInput;
		$this->sectionId = $sectionIdInput;
		$this->sectionName = $sectionNameInput;
		$this->displayPage = $displayPageInput;
		$this->generalFunction = get_option('schema_properties_'.$this->sectionId);

		$this->pmdt_create_field();
	}

	/**
	 * The main function used to create a field.
	 *
	 * @since  0.11
	 */
	function pmdt_create_field(){
		$postLevel = site_cpt::pressbooks_identify() ? 'metadata' : 'site-meta';
		//Overwrite to, message
		$overwriteTo = site_cpt::pressbooks_identify() ? ' to Chapter' : ' to Post';
		//Checking to see if we are on metadata post level or site-meta post level
		if((strpos($this->sectionId, $postLevel) !== false)){
			//Create the id for the overwrite field
			$overwriteField = str_replace($postLevel.'_level','overwrite',$this->property.'_'.$this->sectionId);
			//Create the callback function for the overwrite field
			$overwriteCallback = function() use ($overwriteField,$overwriteTo){
				$disabled = $this->details[0]==true? 'disabled' : '';
				$overwriteHide = get_option($overwriteField) ? 'hide' : '';
				$disableButton = $this->details[0] == false ? '<button class="overwrite_prop_disable propertyButtonStyle '.$overwriteHide.'" id="'.$overwriteField.'_btn2">Disable</button>' : '';
				$html = '<div class="tooltip"><input class="property-checkbox" type="checkbox" id="schema_properties_'.$this->sectionId.'['.$this->property.']" name="schema_properties_'.$this->sectionId.'['.$this->property.']" value="1" ' . checked(1, isset($this->generalFunction[$this->property]) ? ($this->generalFunction[$this->property] == 1 ? 1 : 0) : 0, false) . ''.$disabled.'/><span class="tooltiptext">'.$this->details[2].'</span></div>';
				$html .= $overwriteTo . ' <input class="property-checkbox property-overwrite" type="checkbox" id="'.$overwriteField.'" name="'.$overwriteField.'" value="1" ' . checked(1, get_option($overwriteField), false) . '/>';
				$html .= '<button class="overwrite_prop_clean propertyButtonStyle '.$overwriteHide.'" id="'.$overwriteField.'_btn">Clear</button>';
				$html .= $disableButton;
				echo $html;
			};
			//Register overwrite setting
			register_setting( $this->displayPage, $overwriteField);
		}else{
			//If level is not metadata or site-meta we just create the property field without the overwrite
			$overwriteCallback = function(){
				$disabled = $this->details[0]==true? 'disabled' : '';
				$html = '<div class="tooltip"><input class="property-checkbox" type="checkbox" id="schema_properties_'.$this->sectionId.'['.$this->property.']" name="schema_properties_'.$this->sectionId.'['.$this->property.']" value="1" ' . checked(1, isset($this->generalFunction[$this->property]) ? ($this->generalFunction[$this->property] == 1 ? 1 : 0) : 0, false) . ''.$disabled.'/><span class="tooltiptext">'.$this->details[2].'</span></div>';
				echo $html;
			};
		}

		//Adding the property field
		add_settings_field(
			'schema_properties_'.$this->sectionId.'['.$this->property.']',           // ID used to identify the field throughout the theme
			$this->details[1],                              // The label to the left of the option interface element
			$overwriteCallback,              				// The name of the function responsible for rendering the option interface
			$this->displayPage,                             // The page on which this option will be displayed
			$this->sectionId                                // The name of the section to which this field belongs
		);
		
		//Registering the property field
		$this->generalFunction[$this->property] = isset($this->generalFunction[$this->property]) ? ($this->generalFunction[$this->property] == 1 ? 1 : '') : '';
		update_option('schema_properties_'.$this->sectionId,$this->generalFunction);
		//Setting the required properties to be always enabled
		if($this->details[0] == true){
			$this->generalFunction[$this->property] = 1;
			update_option('schema_properties_'.$this->sectionId,$this->generalFunction);
		}
	}
}