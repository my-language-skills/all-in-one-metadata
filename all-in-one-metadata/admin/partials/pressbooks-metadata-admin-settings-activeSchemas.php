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
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */
?>

<?php
$allPostTypes = engine::get_all_post_types();
$activatedLevels = 0;
foreach($allPostTypes as $postType){
	if ( get_option( $postType . '_checkbox' ) )
	    $activatedLevels++;
}
if($activatedLevels == 0){
    echo '<p id="noLocationError">Select a Location to show metadata</p>';
}else{
    echo '<p>Select the schema types that you want active on each level</p>';
    echo '<p>Click On What You Are Trying To Describe With Metadata</p>';
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
                    }
            ?>
            <input type="radio" class="" name="parent_filter_settings[radio1]" value="<?=$parentDetails[1]?>" <?php checked($parentDetails[1], $options['radio1']); ?> /><?=str_replace(" Properties","",$parentDetails[0])?>
                <?php } ?>
        </form>
    <?php
}

if($activatedLevels != 0){
?>
	<div class="nav-tab-wrapper">
		<?php
			foreach($allPostTypes as $postType) {
				if ( get_option( $postType . '_checkbox' ) ) {
				    $tabName = $postType == 'metadata' || $postType == 'site-meta' ? 'Site Meta' : ucfirst($postType);
				    ?>
					    <button class="tablinks-activeSch nav-tab" onclick="openSett(event,'tablinks-activeSch', '<?=$postType?>','activeSchemas')"><?=$tabName?></button>
                    <?php
				}
			}
        ?>
    </div>
    
<?php
        foreach($allPostTypes as $postType) {
            if ( get_option( $postType . '_checkbox' ) ) {
                ?>
                    <div id="<?= $postType ?>" class="activeSchemas">

                        <form method="post" class="active-schemas-forms" action="options.php">

                            <?php
                                submit_button();
                                $tabName = $postType.'_tab';

                                settings_fields( $tabName );
                                do_settings_sections( $tabName );
                                submit_button();
                                echo '<br><br>';
                            ?>

                        </form>
                    </div>
                <?php
            }
        }
    }
?>
