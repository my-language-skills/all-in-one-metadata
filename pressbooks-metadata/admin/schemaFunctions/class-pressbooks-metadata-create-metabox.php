<?php

namespace schemaFunctions;

/**
 * This class is an automation for creating metaboxes for each type, this file creates
 * the metabox with the desired properties enabled. It also handles the settings for each property.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      1.0
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaFunctions
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Create_Metabox {

	/**
	 * The metabox ID.
	 *
	 * @since    1.0
	 * @access   private
	 */
	private $groupId;

	/**
	 * The metabox name, title that shows on the top of the metabox.
	 *
	 * @since    1.0
	 * @access   private
	 */
	private $metaboxName;

	/**
	 * The metabox level, variable specifies where the metabox should appear.
	 *
	 * @since    1.0
	 * @access   private
	 */
	private $metaboxlevel;

	/**
	 * The array containing all the field properties.
	 *
	 * @since    1.0
	 * @access   private
	 */
	private $fieldProp;

	/**
	 * The constructor for passing all information to the variables and finally creating a metabox.
	 *
	 * @since    1.0
	 */
	function __construct($inpGroupId,$inpMetaboxName,$inpMetaboxlevel,$inpFieldProp) {
		//Getting Variables
		$this->groupId = $inpGroupId;
		$this->metaboxName = $inpMetaboxName;
		$this->metaboxlevel = $inpMetaboxlevel;
		$this->fieldProp = $inpFieldProp;

		//Running functions
		$this->create_metabox();
	}

	/**
	 * The function for creating the metabox.
	 *
	 * @since    1.0
	 */
	function create_metabox(){
		//Creating the metabox
		x_add_metadata_group( 	$this->groupId,$this->metaboxlevel, array(
			'label' 		=>	$this->metaboxName,
			'priority' 		=>	'high'
		) );
		$this->create_metabox_fields();
	}

	/**
	 * The function for creating the fields.
	 *
	 * @since    1.0
	 */
	private function create_metabox_fields() {
		//Creating the Single Fields
		foreach ( $this->fieldProp as $property => $details ) {
			//Checking if we need a dropdown field
			if(!isset($details[3])){
				//Checking if the property is required
				if ($details[0] == true) {
					x_add_metadata_field( 'pb_' . $property . '_' . $this->metaboxlevel, $this->metaboxlevel, array(
						'group'       => $this->groupId,
						'label'       => $details[1],
						'description' => $details[2]
					) );
				}else if(get_option($property.'_'.$this->groupId.'_'.$this->metaboxlevel.'_level')){
					x_add_metadata_field( 'pb_' . $property . '_' . $this->metaboxlevel, $this->metaboxlevel, array(
						'group'       => $this->groupId,
						'label'       => $details[1],
						'description' => $details[2]
					) );
				}
			}else{
				if($details[3]=='number'){
					//This creates a field of type number
					//To use this functionality add the string 'number' in the fourth parameter when creating a field -> [3] position in the array
					//'dublin_time_required' => array( true, 'Required Time', '', 'number' ),
					if ($details[0] == true) {
						x_add_metadata_field( 'pb_' . $property . '_' . $this->metaboxlevel, $this->metaboxlevel, array(
							'group'       => $this->groupId,
							'field_type'	=> 	'number',
							'label'       => $details[1],
							'description' => $details[2]
						) );
					}else if(get_option($property.'_'.$this->groupId.'_'.$this->metaboxlevel.'_level')){
						x_add_metadata_field( 'pb_' . $property . '_' . $this->metaboxlevel, $this->metaboxlevel, array(
							'group'       => $this->groupId,
							'field_type'	=> 	'number',
							'label'       => $details[1],
							'description' => $details[2]
						) );
					}
				}else{
					if ($details[0] == true) {
						x_add_metadata_field( 	'pb_'.$property.'_'.$this->metaboxlevel, $this->metaboxlevel, array(
							'group' 		=> 	$this->groupId,
							'field_type' 	=> 	'select',
							'values' 		=> 	$details[3],
							'label' 		=> 	$details[1],
							'description' 	=> 	$details[2]
						) );
					}else if(get_option($property.'_'.$this->groupId.'_'.$this->metaboxlevel.'_level')){
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
	}
}