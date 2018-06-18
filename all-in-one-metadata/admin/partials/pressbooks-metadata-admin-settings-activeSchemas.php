<?php

use schemaFunctions\Pressbooks_Metadata_Engine as engine;
use schemaTypes\Pressbooks_Metadata_Type_Structure as structure;
use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;

/**
 * The file containing the html for the activeSchemas Metabox in the settings.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.10
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/partials
 * @author     Christos Amyrotos @MashRoofaaw
 */
?>

<?php
$allPostTypes = engine::get_enabled_levels();


//getting current page slug to retrieve post type
$name_data = explode('_',get_current_screen()->base);
$post_type = $name_data[2];
//if we are on a main plugin settings page, set $post_type to 'site-meta' post type
if($post_type == 'pressbooks'){
	$post_type = site_cpt::pressbooks_identify() ? 'metadata' : 'site-meta';
}


if(($post_type == 'site-meta' && !in_array('site-meta', $allPostTypes)) || ($post_type == 'metadata' && !in_array('metadata', $allPostTypes))){
    echo '<p id="noLocationError">Activate Site-Meta location to manage Schema Types on this level</p>';
}else{

        echo '<p>Select schema types that you want to be active</p>';
        echo '<p>Choose What You Are Trying To Describe With Metadata</p>';
        ?>
        <form method="post" action="options.php" id="parent_filter_form">
            <?php
            settings_fields('parent_filter_group');
            $options = get_option('parent_filter_settings');
            foreach(structure::$allParents as $parent){
                $parentDetails = $parent::type_name;
                //Not allowing the thing filter to show
                if($parentDetails[1] == 'thing_properties'){
                    continue;
                    } ?>
                <input type="radio" class="" name="parent_filter_settings[radio1]" value="<?=$parentDetails[1]?>" <?php checked($parentDetails[1], $options['radio1']); ?> /><?=str_replace(" Properties","",$parentDetails[0])?>
            <?php } ?>
        </form>


        <div id="types" class="activeSchemas">
            <form method="post" class="active-schemas-forms" action="options.php">
                <?php
                $tabName = $post_type.'_type_tab';
                settings_fields( $tabName );
                do_settings_sections( $tabName );
                echo '<br><br>';
                ?>
            </form>
        </div>
<?php } ?>
