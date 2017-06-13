<?php

/**
 * This class is an automation for creating sections and fields in the desired setting pages,
 * it is targeted for the pressbooks-metadata plugin
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

//Including the field class so fields can be created for the current section
require_once('class-pressbooks-metadata-fields.php');

class Pressbooks_Metadata_Sections {

	/**
	 * The section ID for the current section.
	 *
	 * @since    0.x
	 * @access   private
	 * @var      string    $sectionId  The string used to uniquely this section's ID.
	 */
	private $sectionId;

	/**
	 * The section Name for the current section.
	 *
	 * @since    0.x
	 * @access   private
	 * @var      string    $sectionName  The string used to uniquely this section's Name.
	 */
	private $sectionName;

	/**
	 * The section's Display Page for the current section.
	 *
	 * @since    0.x
	 * @access   private
	 * @var      string    $displayPage The string used to uniquely this section's Display Page.
	 */
	private $displayPage;

	/**
	 * The information for the metadata so the fields can be created.
	 *
	 * @since    0.x
	 * @access   private
	 * @var      array    $metaData  The array used for the creation of the fields.
	 */
	private $metaData;

	/**
	 * The constructor for passing all information to the variables and finally creating a section.
	 *
	 * @since    0.x
	 */
	function __construct($sectionInputId,$sectionInputName,$sectionInputDisplayPage,$metaDataInput) {
		$this->sectionId = $sectionInputId;
		$this->sectionName = $sectionInputName;
		$this->displayPage = $sectionInputDisplayPage;
		$this->metaData = $metaDataInput;

		$this->pmdt_create_section();
	}

	/**
	 * The main function used to create the section, it also creates new objects of type field.
	 *
	 * @since  0.x
	 */
	function pmdt_create_section(){
		add_settings_section(
			$this->sectionId,                                   //Id to identify section
			$this->sectionName,                                 //Title of the section
			array( $this, 'pmdt_section_draw' ),                //Rendering the description of the section
			$this->displayPage                                  //Which page to show the section
		);

		//A loop that goes through the metaData array and constructs fields corresponding to the arrays size
		foreach ($this->metaData as $metaType => $metaName) {
			//New field objects created with the fields class
			new Pressbooks_Metadata_Fields($metaType,$metaName,$this->sectionId,$this->sectionName,$this->displayPage);
		}
	}

	/**
	 * The main function used to render the description of the section.
	 *
	 * @since  0.x
	 */
	function pmdt_section_draw(){
		echo '<p>Here you can choose what types of Metadata you want to show in the '.$this->sectionName.' </>';
	}
}