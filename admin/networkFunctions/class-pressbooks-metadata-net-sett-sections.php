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
 * @author     Christos Amyrotos @MashRoofa
 * @author     Daniil Zhitnitskii @danzhik
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
			$html =  '<p class="noPropType">'.__('The type is Empty of Properties.', 'all-in-one-metadata').'</p><br>';
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

	    //declaring names for accumulated options
	    $optionName = 'property_network_value';
		$freezeOptionName = $optionName.'_freeze';
		$shareOptionName = $optionName.'_share';

		//getting option array, if not, initialize empty array
		$values = get_option($optionName) ?: [];
		$freeze_values = get_option($freezeOptionName) ?: [];
		$share_values = get_option($shareOptionName) ?: [];

		//Registering the setting holding the values of options
		register_setting($this->sectionDisPage,$optionName);

		//Registering the setting for freezing values
		register_setting($this->sectionDisPage,$freezeOptionName);

		//Registering option fpr option sharing
		register_setting($this->sectionDisPage,$shareOptionName);

		//Looping through the properties of the type
		foreach($data as $propertyId => $details){
			//Creating the name of the options
		    $propertyOptionName = $propertyId.'_'.$this->typeId.'_'.$this->typeLevel;
		    $propertyFreeze = $propertyOptionName.'_freeze';
		    $propertyShare = $propertyOptionName.'_share';

		    //retrieving property option from array, if not, initialize it
			$values[$propertyOptionName] = isset($values[$propertyOptionName]) ? $values[$propertyOptionName] : '';
			$freeze_values[$propertyFreeze] = isset($freeze_values[$propertyFreeze]) ? $freeze_values[$propertyFreeze] : '';
			$share_values[$propertyShare] = isset($share_values[$propertyShare]) ? $share_values[$propertyShare] : '';

			//Callback function for the input field
			$fieldRenderFunction = function() use ($propertyOptionName, $optionName, $values){
				$html =  '<input type="text" class="regular-text" name="'.$optionName.'['.$propertyOptionName.']" value="'.$values[$propertyOptionName].'"><br>';
				echo $html;
			};

			//Callback function for the freeze checkbox
			$checkboxRenderFunction = function() use ($propertyFreeze, $freezeOptionName, $freeze_values){
				?>
				<label><input type="checkbox" name="<?=$freezeOptionName.'['.$propertyFreeze.']'?>"
				              value="1" <?php checked($freeze_values[$propertyFreeze]); ?> /> <?php
				_e('Enable this property on Site-Meta level over all sites and deactivate further modifications.', 'all-in-one-metadata') ?></label>
				<?php
			};

			//Callback function for the share checkbox
			$checkboxRenderFunctionShare = function() use ($propertyShare, $shareOptionName, $share_values){
				?>
                <label><input type="checkbox" name="<?=$shareOptionName.'['.$propertyShare.']'?>"
                              value="1" <?php checked($share_values[$propertyShare]); ?> /> <?php
                    _e('Enable this property on Site-Meta level over all sites and share the value above.', 'all-in-one-metadata') ?></label>
				<?php
			};

			//Adding the property field
			add_settings_field($optionName.'['.$propertyOptionName.']',$details[1]
				,$fieldRenderFunction,$this->sectionDisPage,$this->sectionId);

			//Adding the checkbox field for freezing
			add_settings_field($freezeOptionName.'['.$propertyFreeze.']',''
				,$checkboxRenderFunction,$this->sectionDisPage,$this->sectionId);

			//Adding the checkbox field for sharing
			add_settings_field($shareOptionName.'['.$propertyShare.']',''
				,$checkboxRenderFunctionShare,$this->sectionDisPage,$this->sectionId);
		}
	}
}