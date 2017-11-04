<?php

namespace settings;

/**
 * This class is an automation for creating sections and fields in the desired setting pages,
 * it is targeted for the pressbooks-metadata plugin
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/settings
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

//Including the field class so fields can be created for the current section
require_once('class-pressbooks-metadata-type-fields.php' );
require_once('class-pressbooks-metadata-property-fields.php');

class Pressbooks_Metadata_Sections {

	/**
	 * The section ID for the current section.
	 *
	 * @since    0.8.1
	 * @access   private
	 * @var      string    $sectionId  The string used to uniquely this section's ID.
	 */
	private $sectionId;

	/**
	 * The section Name for the current section.
	 *
	 * @since    0.8.1
	 * @access   private
	 * @var      string    $sectionName  The string used to uniquely this section's Name.
	 */
	private $sectionName;

	/**
	 * The section's Display Page for the current section.
	 *
	 * @since    0.8.1
	 * @access   private
	 * @var      string    $displayPage The string used to uniquely this section's Display Page.
	 */
	private $displayPage;

	/**
	 * The information for the metadata so the fields can be created.
	 *
	 * @since    0.8.1
	 * @access   private
	 * @var      array    $metaData  The array used for the creation of the fields.
	 */
	private $fieldsData;

    /**
     * The required properties from all parents.
     *
     * @since    0.13
     * @access   private
     */
    private $requiredParentProps;

	/**
	 * The constructor.
	 *
	 * @since    0.10
	 */
	function __construct() {
	}

	/**
	 * Function for creating an instance of settings for the schema types.
	 *
	 * @since  0.10
	 */
	public static function properties( $sectionInputId,$sectionInputName,$sectionInputDisplayPage,$fieldsDataInput,$requiredParentPropsInput ) {
		$instance = new self();
		$instance->sectionId = $sectionInputId;
		$instance->sectionName = $sectionInputName;
		$instance->displayPage = $sectionInputDisplayPage;
		$instance->fieldsData = $fieldsDataInput;
		$instance->requiredParentProps = $requiredParentPropsInput;
		$instance->pmdt_load_by_property();
		return $instance;
	}

	/**
	 * The main function used to create the section, it also creates new objects of type field, this is used for the types.
	 *
	 * @since  0.13
	 */
	function pmdt_load_by_property(){
		add_settings_section(
			$this->sectionId,                                   //Id to identify section
			$this->sectionName,                                 //Title of the section
			array( $this, 'pmdt_property_section_draw' ),       //Rendering the description of the section
			$this->displayPage                                  //Which page to show the section
		);

		//A loop that goes through the fieldData array and constructs fields corresponding to the arrays size
		foreach ($this->fieldsData as $property => $details) {

            if(is_array($this->requiredParentProps)){
                //Checking if the property being processed is in the requiredParentProps array
                if(in_array($property,$this->requiredParentProps)){
                    //Changing the details array of the property to make it required for the current type
                    $details[0] = true;
                }
            }

			//New field objects created with the fields class
			new Pressbooks_Metadata_Property_Fields($property,$details,$this->sectionId,$this->sectionName,$this->displayPage);
		}
	}

	/**
	 * The main function used to render the description of the section.
	 *
	 * @since  0.8.1
	 */
	function pmdt_property_section_draw(){

	}

	/**
	 * Function for creating an instance of settings for the schema properties.
	 *
	 * @since  0.10
	 */
	public static function types( $sectionInputId,$sectionInputName,$sectionInputDisplayPage,$fieldsDataInput ) {
		$instance = new self();
		$instance->sectionId = $sectionInputId;
		$instance->sectionName = $sectionInputName == 'Site-meta Level' || $sectionInputName == 'Metadata Level' ? 'Site Meta Level' : $sectionInputName;
		$instance->displayPage = $sectionInputDisplayPage;
		$instance->fieldsData = $fieldsDataInput;
		$instance->pmdt_load_by_type();
		return $instance;
	}

	/**
	 * The main function used to create the section, it also creates new objects of type field, this is used for the types.
	 *
	 * @since  0.8.1
	 */
	function pmdt_load_by_type(){
		add_settings_section(
			$this->sectionId,                                   //Id to identify section
			$this->sectionName,                                 //Title of the section
			array( $this, 'pmdt_type_section_draw' ),                //Rendering the description of the section
			$this->displayPage                                  //Which page to show the section
		);

		//A loop that goes through the fieldData array and constructs fields corresponding to the arrays size
		foreach ($this->fieldsData as $metaType => $metaInfo) {
			//New field objects created with the fields class
			new Pressbooks_Metadata_Fields($metaType,$metaInfo,$this->sectionId,$this->sectionName,$this->displayPage);
		}
	}

	/**
	 * The main function used to render the description of the section.
	 *
	 * @since  0.8.1
	 */
	function pmdt_type_section_draw(){
		echo '<p>Here you can choose what types of Metadata you want to show in the '.$this->sectionName.' </>';
	}
}