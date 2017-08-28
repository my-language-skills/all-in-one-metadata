<?php
/**
 * The file containing the html for the Network Admin Settings
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.10
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/partials
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */
if (isset($_GET['updated'])): ?>
<div id="message" class="updated notice is-dismissible"><p><?php _e('Options saved.') ?></p></div>
<?php endif; ?>
<div class="wrap">
    <h1>My Network Options</h1>
    <form method="POST" action="edit.php?action=update_network_options"><?php
		settings_fields('site_level_admin_display');
		do_settings_sections('site_level_admin_display');
		submit_button(); ?>
    </form>
</div>
<?php