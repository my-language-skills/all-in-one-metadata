<?php
 use schemaFunctions\Pressbooks_Metadata_Engine as engine;
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/partials
 */

?>

<div class="wrap">

	<?php
	$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'post_options_page';
	?>


    <h2 class="nav-tab-wrapper">
        <a href="?page=pressbooks_metadata_options_page&tab=post_options_page" class="nav-tab <?php echo $active_tab == 'post_options_page' ? 'nav-tab-active' : ''; ?>">Post Levels</a>
        <a href="?page=pressbooks_metadata_options_page&tab=meta_options_page" class="nav-tab <?php echo $active_tab == 'meta_options_page' ? 'nav-tab-active' : ''; ?>">Schema Types</a>
    </h2>

    <form method="post" action="options.php">
		<?php

		if( $active_tab == 'post_options_page' ) {
			settings_fields( 'post_options_page' );
			do_settings_sections( 'post_options_page' );
		} else {
			settings_fields( 'meta_options_page' );
			do_settings_sections( 'meta_options_page' );
			//Checking for active post levels, if none we show a message
			$schemaPostLevels = engine::get_enabled_levels();
			if(empty($schemaPostLevels)){
				echo '<h3>Please go to Post Levels Tab and select some post types where you want to show schema metadata.</h3>';
            }
		}

		submit_button();

		?>
    </form>

</div>