<?php

namespace adminFunctions;
use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;

/**
 * The functions of the plugin that handle the the options pages.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.9
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/adminFunctions
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Options {

	function __construct() {

	}

	/**
	 * Render the options page for plugin.
	 *
	 * @since  0.8.1
	 */
	public function display_options_page() {
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/pressbooks-metadata-admin-display.php';
	}

	/**
	 * Add an options page under the Settings and handle changes on the new cpt if pressbooks is disabled.
	 *
	 * @since  0.8.1
	 */
	public function add_options_page() {
		if(!site_cpt::pressbooks_identify()){
			//Used to remove the default menu for the cpt we created
			remove_menu_page( 'edit.php?post_type=site-meta' );
			remove_meta_box( 'submitdiv', 'site-meta', 'side' );
			add_meta_box( 'metadata-save', 'Save Site Metadata Information', array( $this, 'metadata_save_box' ), 'site-meta', 'side', 'high' );
			$meta = site_cpt::get_site_meta_post();
			if ( ! empty( $meta ) ) {
				$site_meta_url = 'post.php?post=' . absint( $meta->ID ) . '&action=edit';
			} else {
				$site_meta_url = 'post-new.php?post_type=site-meta';
			}
			add_submenu_page('tools.php','Site Metadata', 'Site Metadata', 'edit_posts', $site_meta_url);
		}

		//Creating the options page for the plugin
		$this->plugin_screen_hook_suffix =
			add_options_page(
				'Pressbooks Metadata Settings',
				'PB Metadata',
				'manage_options',
				'pressbooks_metadata_options_page',
				array( $this, 'display_options_page' )
			);
	}

	/**
	 * A function that manipulates the inputs for saving the new cpt
	 * @since    0.9
	 */
	function metadata_save_box( $post ) {
		if ( 'publish' === $post->post_status ) { ?>
			<input name="original_publish" type="hidden" id="original_publish" value="Update"/>
			<input name="save" type="submit" class="button button-primary button-large" id="publish" accesskey="p" value="Save"/>
		<?php } else { ?>
			<input name="original_publish" type="hidden" id="original_publish" value="Publish"/>
			<input name="publish" id="publish" type="submit" class="button button-primary button-large" value="Save" tabindex="5" accesskey="p"/>
			<?php
		}
	}
}

