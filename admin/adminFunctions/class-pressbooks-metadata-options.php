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
 * @author     Christos Amyrotos @MashRoofa
 * @author     Daniil Zhitnitskii @danzhik
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

		//Creating the options page for the plugin
		$this->pagehook = add_menu_page(__('All In One Metadata Settings', 'all-in-one-metadata'), "Metadata", 'manage_options', 'pressbooks_metadata_settings', array($this, 'render_options_page'), 'dashicons-search');

		//small fix to have different menu name of first tab
		add_submenu_page('pressbooks_metadata_settings',__('General Settings', 'all-in-one-metadata'), __('General Settings', 'all-in-one-metadata'), 'manage_options', 'pressbooks_metadata_settings');

		if(!site_cpt::pressbooks_identify()){
			//Used to remove the default menu for the cpt we created
			remove_menu_page( 'edit.php?post_type=site-meta' );
			remove_meta_box( 'submitdiv', 'site-meta', 'side' );
			add_meta_box( 'metadata-save', __('Save Site Metadata Information', 'all-in-one-metadata'), array( $this, 'metadata_save_box' ), 'site-meta', 'side', 'high' );
			$meta = site_cpt::get_site_meta_post();
			if ( ! empty( $meta ) ) {
				$site_meta_url = 'post.php?post=' . absint( $meta->ID ) . '&action=edit';
			} else {
				$site_meta_url = 'post-new.php?post_type=site-meta';
			}
			//adding Site-Meta page under main plugin page
			add_submenu_page('pressbooks_metadata_settings','Site-Meta', 'Site-Meta', 'edit_posts', $site_meta_url);
		}

		//getting active locations for metadata
		$this->locations = get_option('schema_locations') ?: [];

		//Creating subpages for all active post types
		foreach ($this->locations as $location => $enabled) {

			if ( $enabled && ! ( $location == 'site-meta' || $location == 'metadata' ) ) {
				add_submenu_page( 'pressbooks_metadata_settings', ucfirst( $location ) . __(' Metadata Settings', 'all-in-one-metadata'), ucfirst( $location ) .' Metadata', 'manage_options', $location . '_meta_settings'
                    , function () use ($location){
					wp_enqueue_script('common');
					wp_enqueue_script('wp-lists');
					wp_enqueue_script('postbox');

					//adding metabox to post options page
					add_meta_box('activated-schema-types', __('Active Schema Types', 'all-in-one-metadata'), array($this, 'render_metabox_active_schemas'), $location.'_meta_settings', 'normal', 'core');
					?>
                    <div class="wrap">
                        <h2><?=ucfirst($location)?> Metadata Settings</h2>
                        <div class="metabox-holder">
							<?php
							    do_meta_boxes($location . '_meta_settings', 'normal','');
							?>
                        </div>
                    </div>
                    <script type="text/javascript">
                        //<![CDATA[
                        jQuery(document).ready( function($) {
                            // close postboxes that should be closed
                            $('.if-js-closed').removeClass('if-js-closed').addClass('closed');
                            // postboxes setup
                            postboxes.add_postbox_toggles('<?php echo $location . '_meta_settings'; ?>');
                        });
                        //]]>
                    </script>
					<?php
                } );
			}
		}
		//Adding the metaboxes on main options page
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
            <h2><?=__('All In One Metadata Settings', 'all-in-one-metadata');?></h2>
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

		$site_level = site_cpt::pressbooks_identify() ? 'Book Info' : 'Site-Meta';

		add_meta_box('metadata-location', __('Location Of Metadata', 'all-in-one-metadata'), array($this, 'render_metabox_schema_locations'), $this->pagehook, 'normal', 'core');
		add_meta_box('activated-schema-types', $site_level.__(' Settings', 'all-in-one-metadata'), array($this, 'render_metabox_active_schemas'), $this->pagehook, 'normal', 'core');
		add_meta_box('specific-metadata', __('Specific Metadata', 'all-in-one-metadata'), array($this, 'render_metabox_specific_metadata'), $this->pagehook, 'normal', 'core');
		add_meta_box('general-settings', __('General Settings', 'all-in-one-metadata'), array($this, 'render_general_settings'), $this->pagehook, 'normal', 'core');
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
            <input name="save" type="submit" class="button button-primary button-large" id="publish" accesskey="p" value="<?=__('Save', 'all-in-one-metadata')?>"/>
		<?php } else { ?>
            <input name="original_publish" type="hidden" id="original_publish" value="Publish"/>
            <input name="publish" id="publish" type="submit" class="button button-primary button-large" value="<?=__('Save', 'all-in-one-metadata')?>" tabindex="5" accesskey="p"/>
			<?php
		}
	}
}

