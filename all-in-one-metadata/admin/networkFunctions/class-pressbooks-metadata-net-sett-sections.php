<?php
namespace networkFunctions;

/**
 * The class that handles the creation of fields for the network admin settings
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.10
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/networkFunctions
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Net_Sett_Sections {

	/**
	 * The id for the section of fields.
	 *
	 * @since    0.10
	 */
	public $sectionId;

	/**
	 * The display page for the section of fields.
	 *
	 * @since    0.10
	 */
	public $sectionDisPage;

	/**
	 * The title for the section of fields.
	 *
	 * @since    0.10
	 */
	public $sectionTitle;

	/**
	 * The type name.
	 *
	 * @since    0.10
	 */
	public $typeId;

	/**
	 * The type properties.
	 *
	 * @since    0.10
	 */
	public $typeProperties;

	/**
	 * The type level.
	 *
	 * @since    0.10
	 */
	public $typeLevel;

	/**
	 * If the type is empty of properties.
	 *
	 * @since    0.13
	 */
	public $isEmpty;

	function __construct($inpSectionId,$inpSectionDisPage,$inpSectionTitle,$inpTypeId,$inpTypeProperties,$inpTypeLevel,$inpIsEmpty){
		$this->sectionId = $inpSectionId;
		$this->sectionDisPage = $inpSectionDisPage;
		$this->sectionTitle = $inpSectionTitle;
		$this->typeId = $inpTypeId;
		$this->typeProperties = $inpTypeProperties;
		$this->typeLevel = $inpTypeLevel;
		$this->isEmpty = $inpIsEmpty;
		$this->createSection();
	}

	/**
	 * Function that creates the settings section, each schema type has its own section.
	 *
	 * @since    0.13
	 */
	function createSection(){

		//Callback function for the section
		$sectionCallback = !isset($this->isEmpty) ? false : function() {
			$html =  '<p class="noPropType">The type is Empty of Properties</p><br>';
			echo $html;
		};

		//Adding the settings section
		add_settings_section($this->sectionId,$this->sectionTitle
			,$sectionCallback,$this->sectionDisPage);

		//If the type has properties then we populate them
		if(!isset($this->isEmpty)){
			$this->createFields($this->typeProperties);
        }
	}

	/**
	 * Function that creates the fields for each section, each schema type property is a field.
	 *
	 * @since    0.10
	 */
	function createFields($data){
		//Looping through the properties of the type
		foreach($data as $propertyId => $details){

			//Creating the name of the options
			$propertyOptionName = $propertyId.'_'.$this->typeId.'_'.$this->typeLevel;
			$propertyFreeze = $propertyOptionName.'_freeze';

			//Registering the setting holding the value
			register_setting($this->sectionDisPage,$propertyOptionName);

			//Registering the setting for freezing
			register_setting($this->sectionDisPage,$propertyFreeze);

			//Callback function for the input field
			$fieldRenderFunction = function() use ($propertyOptionName){
				$html =  '<input type="text" class="regular-text" name="'.$propertyOptionName.'" value="'.get_option($propertyOptionName).'"><br>';
				echo $html;
			};

			//Callback function for the freeze checkbox
			$checkboxRenderFunction = function() use ($propertyFreeze){
				?>
				<label><input type="checkbox" name="<?=$propertyFreeze?>"
				              value="1" <?php checked(get_option($propertyFreeze)); ?> /> <?php
				echo 'Check this box if you want to freeze this property.' ?></label>
				<?php
			};

			//Adding the property field
			add_settings_field($propertyOptionName,$details[1]
				,$fieldRenderFunction,$this->sectionDisPage,$this->sectionId);

			//Adding the checkbox field
			add_settings_field($propertyFreeze,''
				,$checkboxRenderFunction,$this->sectionDisPage,$this->sectionId);
		}
	}
}