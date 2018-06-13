<?php

use schemaFunctions\Pressbooks_Metadata_Engine as engine;
use schemaTypes\Pressbooks_Metadata_Type_Structure as structure;

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
$activatedLevels = 0;
if (!empty($allPostTypes)) {
	$activatedLevels ++;
}
if($activatedLevels == 0){
    echo '<p id="noLocationError">Select a Location to show metadata</p>';
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
                $tabName = 'types_tab';
                settings_fields( $tabName );
                do_settings_sections( $tabName );
                echo '<br><br>';
                ?>
            </form>
        </div>
<?php } ?>
