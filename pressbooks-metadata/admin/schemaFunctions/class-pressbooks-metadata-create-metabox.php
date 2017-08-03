<?php

namespace schemaFunctions;

/**
 * This class is an automation for creating metaboxes for each type, this file creates
 * the metabox with the desired properties enabled. It also handles the settings for each property.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaFunctions
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Create_Metabox {

	/**
	 * The metabox ID.
	 *
	 * @since    0.x
	 * @access   private
	 */
	private $groupId;

	/**
	 * The metabox name, title that shows on the top of the metabox.
	 *
	 * @since    0.x
	 * @access   private
	 */
	private $metaboxName;

	/**
	 * The metabox level, variable specifies where the metabox should appear.
	 *
	 * @since    0.x
	 * @access   private
	 */
	private $metaboxlevel;

	/**
	 * The array containing all the field properties.
	 *
	 * @since    0.x
	 * @access   private
	 */
	private $fieldProp;

	/**
	 * The array containing all the dropdown 'select' properties.
	 *
	 * @since    0.x
	 * @access   private
	 */
	private $dropDownProp;


	/**
	 * The constructor for passing all information to the variables and finally creating a metabox.
	 *
	 * @since    0.x
	 */
	function __construct($inpGroupId,$inpMetaboxName,$inpMetaboxlevel,$inpFieldProp = NULL,$inpDropDownProp = NULL) {
		//Getting Variables
		$this->groupId = $inpGroupId;
		$this->metaboxName = $inpMetaboxName;
		$this->metaboxlevel = $inpMetaboxlevel;
		$this->fieldProp = $inpFieldProp;
		$this->dropDownProp = $inpDropDownProp;

		//Running functions
		$this->create_metabox();

		if($this->fieldProp != NULL){
			$this->create_metabox_fields();
		}
		if($this->dropDownProp != NULL){
			$this->create_metabox_dropdown();
		}
	}

	/**
	 * The function for creating the metabox.
	 *
	 * @since    0.x
	 */
	function create_metabox(){
		//Creating the metabox
		x_add_metadata_group( 	$this->groupId,$this->metaboxlevel, array(
			'label' 		=>	$this->metaboxName,
			'priority' 		=>	'high'
		) );
	}

	/**
	 * The function for creating the fields (single).
	 *
	 * @since    0.x
	 */
	function create_metabox_fields() {
		//Creating the Single Fields
		foreach ( $this->fieldProp as $property => $details ) {
			//Checking if the property is required
			if ($details[0] == true) {
				x_add_metadata_field( 'pb_' . $property . '_' . $this->metaboxlevel, $this->metaboxlevel, array(
					'group'       => $this->groupId,
					'label'       => $details[1],
					'description' => $details[2]
				) );
			}else if(get_option(strtolower($property).'_'.$this->groupId.'_'.$this->metaboxlevel.'_level')){
				x_add_metadata_field( 'pb_' . $property . '_' . $this->metaboxlevel, $this->metaboxlevel, array(
					'group'       => $this->groupId,
					'label'       => $details[1],
					'description' => $details[2]
				) );
			}
		}
	}

	/**
	 * The function for creating the fields (dropdown).
	 *
	 * @since    0.x
	 */
	function create_metabox_dropdown(){
		//Creating the drop down properties
		foreach($this->dropDownProp as $property => $details){
			if($details[0] == true || get_option('pb_'.$property.'_'.$this->metaboxlevel.'_sett')){
				x_add_metadata_field( 	'pb_'.$property.'_'.$this->metaboxlevel, $this->metaboxlevel, array(
					'group' 		=> 	$this->groupId,
					'field_type' 	=> 	'select',
					'values' 		=> 	$details[3],
					'label' 		=> 	$details[1],
					'description' 	=> 	$details[2]
				) );
			}
		}
	}
}