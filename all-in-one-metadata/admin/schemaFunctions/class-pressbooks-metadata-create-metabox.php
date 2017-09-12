<?php

namespace schemaFunctions;
use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;

/**
 * This class is an automation for creating metaboxes for each type, this file creates
 * the metabox with the desired properties enabled. It also handles the settings for each property.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.10
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaFunctions
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Create_Metabox {

    /**
     * The metabox ID.
     *
     * @since    0.10
     * @access   private
     */
    private $groupId;

    /**
     * The metabox name, title that shows on the top of the metabox.
     *
     * @since    0.10
     * @access   private
     */
    private $metaboxName;

    /**
     * The metabox level, variable specifies where the metabox should appear.
     *
     * @since    0.10
     * @access   private
     */
    private $metaboxlevel;

    /**
     * The array containing all the field properties.
     *
     * @since    0.10
     * @access   private
     */
    private $fieldProp;

    /**
     * The constructor for passing all information to the variables and finally creating a metabox.
     *
     * @since    0.10
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
     * @since    0.10
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
     * The function for rendering frozen fields.
     *
     * @since    0.x
     */
    function frozen_field( $field_slug, $field, $value ) {
        $value = get_post_meta(get_the_ID(),$field_slug);
        $value = $value[0];
        $broken_slug = explode('_',$field_slug);
        $property = ucfirst($broken_slug[1]);
        ?>
        <hr />
        <p><strong><?=$property?></strong> is Frozen by super admin. The value is "<?=$value?>".</p>
        <input type="hidden" name="<?=$field_slug?>" value="<?=$value?>" />
        <hr />
        <?php
    }

    /**
     * The function for rendering overwritten fields.
     *
     * @since    0.x
     */
    function overwritten_field( $field_slug, $field, $value ) {
        //Getting the origin for overwritten data
        $dataFrom = site_cpt::pressbooks_identify() ? 'Book-Info' : 'Site-Meta';
        $value = get_post_meta(get_the_ID(),$field_slug);
        $value = $value[0];
        $broken_slug = explode('_',$field_slug);
        $property = ucfirst($broken_slug[1]);
        ?>
        <hr />
        <p><strong><?=$property?></strong> is Overwritten by <?=$dataFrom?>. The value is "<?=$value?>".</p>
        <input type="hidden" name="<?=$field_slug?>" value="<?=$value?>" />
        <hr />
        <?php
    }

    /**
     * The function for creating the fields.
     *
     * @since    0.10
     */
    private function create_metabox_fields() {
        //Creating the Single Fields
        foreach ( $this->fieldProp as $property => $details ) {
            //Creating the field id
            $fieldId = 'pb_' . $property . '_' .$this->groupId. '_' .$this->metaboxlevel;

            //Render function name, by default is empty
            $renderFunction = '';

            //Checking if the property is frozen from super admin
            if(is_multisite() && ($this->metaboxlevel == 'site-meta' || $this->metaboxlevel == 'metadata')){
                $frozzenFieldId = get_blog_option(1,$property . '_' .$this->groupId. '_' .$this->metaboxlevel.'_freeze');
                if($frozzenFieldId){
                    $renderFunction = 'frozen_field';
                }
            }

            //Checking if the property is being overwritten
            //Giving message
            if($this->metaboxlevel == 'post' || $this->metaboxlevel == 'chapter'){
                if(get_option($property . '_' .$this->groupId. '_overwrite')){
                    $renderFunction = 'overwritten_field';
                }
            }


            //Checking if we need a dropdown field
            if(!isset($details[3])){
                //Checking if the property is required
                if ($details[0] == true) {
                    x_add_metadata_field( $fieldId, $this->metaboxlevel, array(
                        'group'       => $this->groupId,
                        'label'       => $details[1],
                        'description' => $details[2],
                        'display_callback' => array($this,$renderFunction)
                    ) );
                }else if(get_option($property.'_'.$this->groupId.'_'.$this->metaboxlevel.'_level')){
                    x_add_metadata_field( $fieldId, $this->metaboxlevel, array(
                        'group'       => $this->groupId,
                        'label'       => $details[1],
                        'description' => $details[2],
                        'display_callback' => array($this,$renderFunction)
                    ) );
                }
            }else{
                if($details[3]=='number'){
                    //This creates a field of type number
                    //To use this functionality add the string 'number' in the fourth parameter when creating a field -> [3] position in the array
                    //'dublin_time_required' => array( true, 'Required Time', '', 'number' ),
                    if ($details[0] == true) {
                        x_add_metadata_field( $fieldId, $this->metaboxlevel, array(
                            'group'       => $this->groupId,
                            'field_type'	=> 	'number',
                            'label'       => $details[1],
                            'description' => $details[2],
                            'display_callback' => array($this,$renderFunction)
                        ) );
                    }else if(get_option($property.'_'.$this->groupId.'_'.$this->metaboxlevel.'_level')){
                        x_add_metadata_field( $fieldId, $this->metaboxlevel, array(
                            'group'       => $this->groupId,
                            'field_type'	=> 	'number',
                            'label'       => $details[1],
                            'description' => $details[2],
                            'display_callback' => array($this,$renderFunction)
                        ) );
                    }
                }else{
                    if ($details[0] == true) {
                        x_add_metadata_field( 	$fieldId, $this->metaboxlevel, array(
                            'group' 		=> 	$this->groupId,
                            'field_type' 	=> 	'select',
                            'values' 		=> 	$details[3],
                            'label' 		=> 	$details[1],
                            'description' 	=> 	$details[2],
                            'display_callback' => array($this,$renderFunction)
                        ) );
                    }else if(get_option($property.'_'.$this->groupId.'_'.$this->metaboxlevel.'_level')){
                        x_add_metadata_field( $fieldId, $this->metaboxlevel, array(
                            'group' 		=> 	$this->groupId,
                            'field_type' 	=> 	'select',
                            'values' 		=> 	$details[3],
                            'label' 		=> 	$details[1],
                            'description' 	=> 	$details[2],
                            'display_callback' => array($this,$renderFunction)
                        ) );
                    }
                }
            }
        }
    }
}