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
		$this->pagehook = add_options_page('All In One Metadata Settings', "All In One Metadata Settings", 'manage_options', 'pressbooks_metadata_settings', array($this, 'render_options_page'));
		//Adding the metaboxes on the options page
		add_action('load-'.$this->pagehook, array($this, 'add_metaboxes'));
	}

	/**
	 * Render the options page for plugin.
	 *
	 * @since  0.10
	 */
	function render_options_page() {
		?>
        <div class="wrap">
            <h2>All In One Metadata Settings</h2>
            <div class="metabox-holder">
					<?php
					do_meta_boxes($this->pagehook, 'normal','');
					?>
            </div>
        </div>
        <script type="text/javascript">
            //<![CDATA[
            jQuery(document).ready( function($) {
                // close postboxes that should be closed
                $('.if-js-closed').removeClass('if-js-closed').addClass('closed');
                // postboxes setup
                postboxes.add_postbox_toggles('<?php echo $this->pagehook; ?>');
            });
            //]]>
        </script>
		<?php
	}

	/**
	 * Add the metaboxes to the options page.
	 *
	 * @since  0.10
	 */
	function add_metaboxes() {
		wp_enqueue_script('common');
		wp_enqueue_script('wp-lists');
		wp_enqueue_script('postbox');

		add_meta_box('metadata-location', 'Location Of Metadata', array($this, 'render_metabox_schema_locations'), $this->pagehook, 'normal', 'core');
		add_meta_box('activated-schema-types', 'Activated Schema Types', array($this, 'render_metabox_active_schemas'), $this->pagehook, 'normal', 'core');
		add_meta_box('specific-metadata', 'Specific Metadata', array($this, 'render_metabox_specific_metadata'), $this->pagehook, 'normal', 'core');
		add_meta_box('general-settings', 'General Settings', array($this, 'render_general_settings'), $this->pagehook, 'normal', 'core');
	}

	/**
	 * Render data for the  metabox.
	 *
	 * @since  0.10
	 */
	function render_metabox_schema_locations() {
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/pressbooks-metadata-admin-settings-schemaLocations.php';
	}

	/**
	 * Render data for the specific_metadata metabox.
	 *
	 * @since  0.10
	 */
	function render_metabox_specific_metadata(){
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/pressbooks-metadata-admin-settings-specificMeta.php';
	}

	/**
	 * Render data for the active_schemas metabox.
	 *
	 * @since  0.10
	 */
	function render_metabox_active_schemas(){
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/pressbooks-metadata-admin-settings-activeSchemas.php';
	}

	/**
	 * Render data for the general_settings metabox.
	 *
	 * @since  0.x
	 */
	function render_general_settings(){
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/pressbooks-metadata-admin-settings-general.php';
	}

	/**
	 * A function that manipulates the inputs for saving the new cpt data
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

