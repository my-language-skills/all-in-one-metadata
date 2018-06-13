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

	<div id="postLevel" class="levels">
		<form method="post" action="options.php">
			<?php
			settings_fields( 'location_levels_tab' );
			do_settings_sections( 'location_levels_tab' );
			submit_button();
			?>
		</form>
		<p></p>
	</div>

