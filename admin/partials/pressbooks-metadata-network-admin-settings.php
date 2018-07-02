<?php
/**
 * The file containing the html for the Network Admin Settings Metabox
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.10
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/partials
 * @author     Christos Amyrotos @MashRoofa
 * @author     Daniil Zhitnitskii @danzhik
 */
if (isset($_GET['updated'])): ?>
<div id="message" class="updated notice is-dismissible"><p><?php _e('Options saved.', 'all-in-one-metadata') ?></p></div>
<?php endif; ?>
<div class="network_setts">
    <h1><?=__('All In One Metadata Network Settings', 'all-in-one-metadata')?></h1>
    <form method="POST" action="edit.php?action=update_network_options"><?php
		settings_fields('site_level_admin_display');
	    submit_button();
	    do_settings_sections('site_level_admin_display');
		?>
    </form>
    <p></p>
</div>
<?php