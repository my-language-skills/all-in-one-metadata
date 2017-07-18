<?php

namespace settings;

/**
 * This class is an automation for creating fields in the desired sections,
 * it is targeted for the pressbooks-metadata plugin
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/settings
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Fields {

	/**
	 * The metadata (schema) type for the field.
	 *
	 * @since    0.8.1
	 * @access   private
	 * @var      string    $metaType  The string used to uniquely this field's schema type.
	 */
	private $metaType;

	/**
	 * The metadata (schema) caption for the settings to show.
	 *
	 * @since    0.8.1
	 * @access   private
	 * @var      string    $metaInfo  The array used for this field's caption and type support website.
	 */
	private $metaInfo;

	/**
	 * The section ID for the current field's section.
	 *
	 * @since    0.8.1
	 * @access   private
	 * @var      string    $sectionId  The string used to uniquely the field's section ID.
	 */
	private $sectionId;

	/**
	 * The section Name for the current field's section.
	 *
	 * @since    0.8.1
	 * @access   private
	 * @var      string    $sectionName  The string used to uniquely this field's section Name.
	 */
	private $sectionName;

	/**
	 * The field's Display Page.
	 *
	 * @since    0.8.1
	 * @access   private
	 * @var      string    $displayPage The string used to uniquely this fields's Display Page.
	 */
	private $displayPage;

	/**
	 * The constructor for passing all information to the variables and finally creating a field.
	 *
	 * @since    0.8.1
	 */
	function __construct($metaTypeInput,$metaInfoInput,$sectionIdInput,$sectionNameInput,$displayPageInput) {
		$this->metaType = $metaTypeInput;
		$this->metaInfo = $metaInfoInput;
		$this->sectionId = $sectionIdInput;
		$this->sectionName = $sectionNameInput;
		$this->displayPage = $displayPageInput;

		$this->pmdt_create_field();
	}

	/**
	 * The main function used to create a field.
	 *
	 * @since  0.8.1
	 */
	function pmdt_create_field(){
		add_settings_field(
			$this->metaType.'_'.$this->sectionId,           // ID used to identify the field throughout the theme
			$this->metaInfo[0],                                // The label to the left of the option interface element
			array( $this, 'pmdt_field_draw' ),              // The name of the function responsible for rendering the option interface
			$this->displayPage,                             // The page on which this option will be displayed
			$this->sectionId                                // The name of the section to which this field belongs
		);

		//We are using a combination of the metaType and the sectionId for the field id so
		// we can rapidly create fields of the same type in more that one sections,
		// without having to specify different ids for each section's field's
		register_setting( $this->displayPage, $this->metaType.'_'.$this->sectionId);
	}

	/**
	 * The main function used to render the description of the field.
	 *
	 * @since  0.8.1
	 */
	function pmdt_field_draw(){
		$html = '<input type="checkbox" id="'.$this->metaType.'_'.$this->sectionId.'" name="'.$this->metaType.'_'.$this->sectionId.'" value="1" ' . checked(1, get_option($this->metaType.'_'.$this->sectionId), false) . '/>';

		$html .= '<label for="show_header">By checking this you allow the '.$this->metaInfo[0].' to show in the '.$this->sectionName.'</label>';

		//Deciding if a support link will appear on the settings or not
		if($this->metaInfo[1] != ''){
			$html .= '<p>Find more info about this type <a href="'.$this->metaInfo[1].'">here</a></p>';
		}else{
			$html .= '<p>No description available - this is a custom type</p>';
		}

		$html.= '<a href="">';

		echo $html;
	}


}