<?php
/**
 * The file containing the html for the Network Admin Settings Metabox
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.18
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/partials
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */
if (isset($_GET['updated'])): ?>
<div id="message" class="updated notice is-dismissible"><p><?php _e('Options saved.') ?></p></div>
<?php endif; ?>
<div class="network_setts">
    <h1>All In One Metadata Network Settings</h1>
    <form method="POST" action="edit.php?action=update_network_options"><?php
		settings_fields('site_level_admin_display');
	    submit_button();
	    do_settings_sections('site_level_admin_display');
		?>
    </form>
    <p></p>
</div>
<?php