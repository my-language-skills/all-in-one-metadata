<?php

use schemaFunctions\Pressbooks_Metadata_Engine as engine;

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
}

?>
	<div class="nav-tab-wrapper">
		<?php
		if($activatedLevels != 0){
		    $itterator = 0;
			foreach($allPostTypes as $postType) {
				if ( get_option( $postType . '_checkbox' ) ) {
				    $defaultClass = ($itterator == 0 ? "nav-tab-active" : "");
				    $tabName = $postType == 'metadata' || $postType == 'site-meta' ? 'Site Meta' : ucfirst($postType);
				    ?>
					<button class="tablinks-activeSch nav-tab <?=$defaultClass?>" onclick="openSett(event,'tablinks-activeSch', '<?=$postType?>','activeSchemas')"><?=$tabName?></button>
                    <?php
					$itterator++;
				}
			}
			?></div><?php
			foreach($allPostTypes as $postType) {
				if ( get_option( $postType . '_checkbox' ) ) {
					?>
                    <div id="<?= $postType ?>" class="activeSchemas">
                       <form class="parent-filters-form" method="post" action="options.php">
                           <p>Click On What You Are Trying To Describe With Metadata</p>
                           <?php
                            settings_fields( 'parents_display_page' );
                            do_settings_sections( 'parents_display_page' );
                           ?>
                            </form>

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
