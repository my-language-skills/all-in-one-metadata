<?php

namespace settings;
use schemaTypes\Pressbooks_Metadata_Type_Structure as structure;
use schemaFunctions\Pressbooks_Metadata_General_Functions as genFunc;
use schemaFunctions\Pressbooks_Metadata_Engine as engine;

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
	 * The name of general option where schema types options are stored
	 *
	 * @since 0.17
	 * @access private
	 */
	private $optionGeneral;


	/**
	 * Post type to which schema will be applied
     *
     * @since 0.18
	 * @access private
	 */
	private $post_type;

	/**
	 * The name of parent type for schema type to choose appropriate type option
     * @since 0.18
     * @access private
	 */
	private $parentType;

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
		$this->parentType = genFunc::get_active_parent();
		$this->post_type = explode('_', $this->displayPage)[0];
		$this->optionGeneral = get_option($this->post_type.'_'.$this->parentType) ?: [];

		$this->pmdt_create_field();

	}

	/**
	 * The main function used to create a field.
	 *
	 * @since  0.8.1
	 */
	function pmdt_create_field(){
		add_settings_field(
			$this->parentType.'['.$this->metaType.']',           // ID used to identify the field throughout the theme
			$this->metaInfo[0],                                // The label to the left of the option interface element
			array( $this, 'pmdt_field_draw' ),              // The name of the function responsible for rendering the option interface
			$this->displayPage,                             // The page on which this option will be displayed
			$this->sectionId                                // The name of the section to which this field belongs
		);

		//We are using a combination of the metaType and the sectionId for the field id so
		// we can rapidly create fields of the same type in more that one sections,
		// without having to specify different ids for each section's field's
		$this->optionGeneral[$this->metaType] = isset($this->optionGeneral[$this->metaType]) ? $this->optionGeneral[$this->metaType] : '';
		//Adding field to accumulated option
		update_option($this->parentType, $this->optionGeneral);
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

	    $optionValue = isset($this->optionGeneral[$this->metaType]) ? ($this->optionGeneral[$this->metaType] == 1 ? '1' : '0') : '0';

	    if (isset($this->optionGeneral[$this->metaType]) ? ($this->optionGeneral[$this->metaType] != 1 ? 1 : 0) : 1) {
		    $html = '<button class="button-primary type-button" type="button"  name="'. $this->post_type. '_' . $this->parentType . '[' . $this->metaType . ']" value="1" />Activate</button>';
		    $html .= '<input type="hidden" value="'.$optionValue.'" id = "'. $this->post_type. '_' . $this->parentType . '[' . $this->metaType . ']" name="'. $this->post_type. '_' . $this->parentType . '[' . $this->metaType . ']">';
	    } else {
		    $ID = $this->metaType . '-' . $this->sectionId;
		    $html = '<button class="button-primary type-button-deact" type="button"  name="'. $this->post_type. '_' . $this->parentType . '[' . $this->metaType . ']" value="1" />Deactivate</button>';
		    $html .='<a href="#TB_inline?height=550&width=500&inlineId=my-content-id-' . $ID . '" class="thickbox button-primary">Edit</a>';
		    $html .= '<input type="hidden" value="'.$optionValue.'" id = "'. $this->post_type. '_' . $this->parentType . '[' . $this->metaType . ']" name="'. $this->post_type. '_' . $this->parentType . '[' . $this->metaType . ']">';
        }

        if(!isset($this->metaInfo[2])) {
	        $html .= '<p><i>';

	        foreach ( structure::$allSchemaTypes as $schema_type ) {
		        if ( key_exists( $this->metaType, $schema_type::$type_setting ) ) {
			        $flag = 0;
			        foreach ( $schema_type::$type_properties as $property ) {
				        $html .= $flag == 1 ? ', ' : '';
				        $html .= $property[1];
				        $flag = 1;
			        }
		        }
	        }
	        $html .= '.</i></p>';
        } else {
	        //If the type has no properties than we show the user that the parent type will be used instead
	        $html .= '<p class="noPropType" "><i>Type is Empty of properties. '.$this->metaInfo[2].' properties will be used.</i></p>';
        }

		if(!isset($this->metaInfo[2]) && isset($this->optionGeneral[$this->metaType]) && $this->optionGeneral[$this->metaType] == 1) {
	        //add pop-up box styles and scripts
			add_thickbox();


			$properties_page = $this->metaType.'_'.$this->post_type.'_level';

			/* START BUFFERING*/
			ob_start();

			echo '<form class="properties-options-form" method="post" action="options.php">';
			    settings_fields( $properties_page.'_properties' );
			    do_settings_sections( $properties_page.'_properties' );
			echo '</form>';

            /* GETTING PARENTS AND SETTING UP THE SELECT ELEMENT */
			$parentIds = $this->get_type_parents(false);
			$parentNames = $this->get_type_parents(true);

			//Creating the select element for selecting parents
			?><div style="clear: both;"></div><select class="selectParent">
			  <option value="parents">Show Basic Properties</option> <?php

			for($i = 0; $i < count($parentIds); $i++){
				?><option value="<?= $parentIds[$i] ?>">Show <?= str_replace('Thing','General',$parentNames[$i]) ?></option><?php
			}

			?> </select> <?php

			//Creating DIVS with the parents properties inside
			foreach($parentIds as $parent){
				?><div class="parents" id="<?= $parent ?>" style="display: none">
                <?php
					$parentField = $properties_page.'_'.$parent . '_dis';
					echo '<form class="properties-options-form" method="post" action="options.php">';
					settings_fields( $parentField );
					do_settings_sections( $parentField );
                        ?></form></div>
                <?php
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
            <br><br>
			</form> <!-- This is a fix for the first types properties not saving -->
					'.$contents.'
			</div>';
		}
		echo $html;
	}


}