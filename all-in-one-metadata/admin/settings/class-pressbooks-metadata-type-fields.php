<?php

namespace settings;
use schemaTypes\Pressbooks_Metadata_Type_Structure as structure;

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
	 * The function used to get the current type for finding its parents.
	 * The function returns parent ID or parent Name
	 * @since  0.10
	 */
	private function get_type_parents($getName = false){
		$foundParents = array();
		foreach(structure::$allSchemaTypes as $type){
			$typeSettings = $type::$type_setting;
			foreach($typeSettings as $name => $setting){
				if($name == $this->metaType){
					foreach($type::$type_parents as $parent){
						$getName == false ? $foundParents []= $parent::type_name[1] : $foundParents []= $parent::type_name[0];
					}
				}
			}
		}
		return $foundParents;
	}

	/**
	 * The main function used to render the description of the field.
	 *
	 * @since  0.8.1
	 */
	function pmdt_field_draw(){
		$html = '<input type="checkbox" id="'.$this->metaType.'_'.$this->sectionId.'" name="'.$this->metaType.'_'.$this->sectionId.'" value="1" ' . checked(1, get_option($this->metaType.'_'.$this->sectionId), false) . '/>';

		$html .= '<label for="show_header">By checking this you allow the '.$this->metaInfo[0].' to show in the '.$this->sectionName.'</label>';

		//If the type has no properties than we show the user that the parent type will be used insted
		if(isset($this->metaInfo[2])){
			$html .= '<p class="noPropType">Type is Empty of properties '.$this->metaInfo[2].' will be used</p>';
		}

		//Deciding if a support link will appear on the settings or not
		if($this->metaInfo[1] != ''){
			$html .= '<p>Find more info about this type <a href="'.$this->metaInfo[1].'"target="_blank">here</a></p>';
		}else{
			$html .= '<p>No description available - this is a custom type</p>';
		}
		if(!isset($this->metaInfo[2]) && get_option($this->metaType.'_'.$this->sectionId)) {
			add_thickbox();

			$sectionFieldId = $this->metaType.'_'.$this->sectionId.'_properties';
			$ID = $this->metaType . '-' . $this->sectionId;

			ob_start();

			//Rendering the default properties of the type
			?><form class="properties-options-form" method="post" action="options.php"><?php
			settings_fields( $sectionFieldId );
			do_settings_sections( $sectionFieldId );
            ?></form><?php

			/* GETTING PARENTS AND SETTING UP THE SELECT ELEMENT */

			$parentIds = $this->get_type_parents(false);
			$parentNames = $this->get_type_parents(true);

			//Creating the select element for selecting parents
			?><select class="selectParent">
			  <option value="parents">Show Basic Properties</option> <?php

			for($i = 0; $i < count($parentIds); $i++){
				?><option value="<?= $parentIds[$i] ?>">Show <?= str_replace('Thing','General',$parentNames[$i]) ?></option><?php
			}

			?> </select> <?php

			//Creating DIVS with the parents properties inside
			foreach($parentIds as $parent){

				?><div class="parents" id="<?= $parent ?>" style="display: none"><?php

				$parentField = $this->metaType.'_'.$this->sectionId.'_'.$parent.'_dis';
				?><form class="properties-options-form" method="post" action="options.php"><?php
				settings_fields( $parentField );
				do_settings_sections( $parentField );
                ?></form><?php

				?></div><?php
			}

			/* END */

			$contents = ob_get_contents();

			ob_end_clean();

			$html .= '<div class="property-settings" id="my-content-id-' . $ID . '" style="display:none;">
			<h1>
				Choose ' . $this->metaInfo[0] . ' Properties:<br>
			</h1>
			<div style="display: none;" class="properties-loading-image">
            <img style="width: 30px; height: 30px;" src="' . plugin_dir_url('') . 'all-in-one-metadata/assets/loading.gif"/>
            </div>
            <p class="saving-message" style="display: none">Settings Saved!</p>
			</form> <!-- This is a fix for the first types properties not saving -->
					'.$contents.'
			</div>
			<a href="#TB_inline?width=380&height=550&inlineId=my-content-id-' . $ID . '" class="thickbox">Edit Type Properties</a>';
		}
		echo $html;
	}


}