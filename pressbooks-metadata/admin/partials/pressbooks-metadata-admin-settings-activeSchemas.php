<?php

use schemaFunctions\Pressbooks_Metadata_Engine as engine;

/**
 * The file containing the html for the activeSchemas Metabox in the settings.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
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
		    //Filtering form
			echo'<form id="parent-filters-form" method="post" action="options.php">';


			echo'</form>';
			//End filtering form
		    $itterator = 0;
			foreach($allPostTypes as $postType) {
				if ( get_option( $postType . '_checkbox' ) ) {
				    $defaultClass = ($itterator == 0 ? "defaultOpen" : "");
				    $tabName = $postType == 'metadata' || $postType == 'site-meta' ? 'Site Meta' : ucfirst($postType);
				    ?>
					<button class="tablinks nav-tab <?=$defaultClass?>" onclick="openSett(event, '<?=$postType?>','activeSchemas')"><?=$tabName?></button>
                    <?php
					$itterator++;
				}
			}
			foreach($allPostTypes as $postType) {
				if ( get_option( $postType . '_checkbox' ) ) {
					?>
                    <div id="<?= $postType ?>" class="activeSchemas">
                        <br>
                        <br>
                        <form method="post" class="active-schemas-forms" action="options.php">

                            <?php
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
	</div>
