<?php
/**
 * The file containing the html for the schemaLocations Metabox in the settings.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.10
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/partials
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */
?>

	<p>Select the place you want the metadata to show</p>
	<div class="nav-tab-wrapper">
		<button class="tablinks-level nav-tab" onclick="openSett(event,'tablinks-level', 'postLevel','levels')">Post Level</button>
		<button class="tablinks-level nav-tab" onclick="openSett(event,'tablinks-level', 'siteLevel','levels')">Site Level</button>
		<?php
		if(is_multisite()){
		?>
        <button class="tablinks-level nav-tab" onclick="openSett(event,'tablinks-level', 'multisiteLevel','levels')">Multisite Level</button>
        <?php
		}
		?>
    </div>

	<div id="postLevel" class="levels">
		<form method="post" action="options.php">
			<?php
			settings_fields( 'post_level_tab' );
			do_settings_sections( 'post_level_tab' );
			submit_button();
			?>
		</form>
		<p></p>
	</div>

	<div id="siteLevel" class="levels">
		<form method="post" action="options.php">
			<?php
			settings_fields( 'site_level_tab' );
			do_settings_sections( 'site_level_tab' );
			submit_button();
			?>
		</form>
		<p></p>
	</div>

    <?php
    if(is_multisite()){
        ?>
        <div id="multisiteLevel" class="levels">
            <form method="post" action="options.php">
                <?php
                settings_fields( 'multi_level_tab' );
                do_settings_sections( 'multi_level_tab' );
                submit_button();
                ?>
            </form>
        </div>
    <?php
    }
    ?>
