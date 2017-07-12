<?php

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

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

    <form action="options.php" method="post">
		<?php

			settings_fields('pressbooks_metadata_options_page');
			do_settings_sections( 'pressbooks_metadata_options_page');

		submit_button();
		?>
    </form>
</div>
