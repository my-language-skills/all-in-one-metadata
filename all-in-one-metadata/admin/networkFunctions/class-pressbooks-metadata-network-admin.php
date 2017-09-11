<?php

namespace networkFunctions;
use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;
use schemaTypes\Pressbooks_Metadata_Type_Structure as structure;
use networkFunctions\Pressbooks_Metadata_Net_Sett_Sections as net_sections;

/**
 * The functions of the plugin that handle the the settings of the network admin and the network admin schema functionality.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.10
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/networkFunctions
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Network_Admin {

    /**
     * Variable for holding the Root Site ID
     *
     * @since    0.10
     */
    const ROOT_SITE = 1;

    function __construct() {

    }

    /**
     * Creating the settings page for the network administrator, this page is for managing the
     * Site-Meta/Book-info information on all sites
     *
     * @since    0.x
     */
    function add_settings() {
        // Create our options page.
        add_submenu_page( 'settings.php', 'All In One Metadata Network Admin Settings',
            'All In One Metadata Network Settings', 'manage_network_options',
            'site_level_admin_display', array( $this, 'render_network_settings' ) );

        //These variables are static now because this is a prototype for the book level types
        $displayPage = 'site_level_admin_display';
        $sectionId   = 'site_level_section';

        //Getting the value of the level
        //In our case is metadata for pressbooks or site-meta for the wordpress default installation
        //This reflects the site level metadata
        $siteLevelIndicator = site_cpt::pressbooks_identify() ? 'metadata' : 'site-meta';

        //Population sections with settings
        //Each section is a schema type containing its properties as fields
        foreach ( structure::$allSchemaTypes as $type ) {
            $type_details = $this->get_type_details( $type );
            new net_sections(
                $sectionId . '_' . $type_details[0],
                $displayPage,
                $type_details[1].' On Site Level',
                $type_details[0],
                $type::$type_properties,
                $siteLevelIndicator,
                $type_details[2] //If is empty this will be set
            );
        }
    }

    /**
     * Function used to extract the details the type from its settings
     *
     * @since  0.x
     */
    private function get_type_details($type) {
        foreach($type::$type_setting as $typeId => $details) {
            if(isset($details[2])){
                return array($typeId,$details[0],$details[2]);
            }else{
                return array($typeId,$details[0],null);
            }

        }
    }

    /**
     * Linking the page that the settings will render
     *
     * @since  0.10
     */
    function render_network_settings(){
        include_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/pressbooks-metadata-network-admin-settings.php';
    }

    /**
     * Function used to distribute property data to all our Book-Info/Site-Meta on all our Sites/Books
     *
     * @since  0.10
     */
    private function update_properties($metaKey,$newValue){

        if ((strpos($metaKey, '_freeze') !== false) || $newValue=="") {
            return;
        }

        //Wordpress Database variable for database operations
        global $wpdb;

        //Modifying the metakey so it maches the already saved fields created by create metabox class
        $metaKey = strtolower('pb_'.$metaKey);

        //Grabbing all the site IDs
        $siteids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

        //Going through the sites
        foreach ($siteids as $site_id) {

            //Skipping the RootSite
            if($site_id == self::ROOT_SITE) {continue;}

            //Switching site
            switch_to_blog($site_id);

            //Get the posts table name for the current site
            $postsTable = $wpdb->prefix . "posts";

            //Get the post type we want to work with
            $postType = site_cpt::pressbooks_identify() ? 'metadata' : 'site-meta';

            //Our query that chooses posts of type site-meta or metadata for the book info
            $selectedPosts = $wpdb->get_results($wpdb->prepare(" 
			SELECT ID,post_type FROM $postsTable WHERE post_type = %s",$postType),ARRAY_A);

            //If no initial site-meta/metadata post found we create one
            if(empty($selectedPosts)){
                $args = array(
                    'post_author'		=>	get_current_user_id(),
                    'post_date'			=>  the_date(),
                    'post_content'		=>  '',
                    'post_title'		=> 	'Auto Draft',
                    'post_status'		=>	'publish',
                    'comment_status'	=>  'closed',
                    'ping_status' 		=>  'closed',
                    'post_password'		=>  '',
                    'post_name' 		=>  'auto-draft',
                    'menu_order'		=>  0,
                    'post_type'			=>	$postType
                );

                $newPostId = wp_insert_post($args);

                $selectedPosts []= array('ID' => $newPostId, 'post_type' => $postType);
            }

            //Going through all posts and adding the new post_meta
            foreach($selectedPosts as $post){
                update_post_meta( $post[ID],$metaKey,$newValue);
            }

            //Extracting data for enabling the post level the schema type and property
            $dataForEnabling = explode('_',$metaKey);
            $schemaType = $dataForEnabling[2].'_'.$dataForEnabling[3];
            $schemaProp = $dataForEnabling[1];

            //Enable Post Level
            update_option($postType.'_checkbox',1);

            //Enable Type
            update_option($schemaType.'_'.$postType.'_level',1);

            //Enable Property
            update_option($schemaProp.'_'.$schemaType.'_'.$postType.'_level',1);
        }
    }

    /**
     * Function used for saving the settings on the Super Admin
     *
     * @since  0.10
     */
    function update_network_options() {
        // Make sure we are posting from our options page. There's a little surprise
        // here, on the options page we used the 'site_level_admin_display'
        // slug when calling 'settings_fields' but we must add the '-options' postfix
        // when we check the referer.
        check_admin_referer('site_level_admin_display-options');

        // This is the list of registered options.
        global $new_whitelist_options;
        $options = $new_whitelist_options['site_level_admin_display'];

        // Go through the posted data and save only our options.
        foreach ($options as $option) {
            if (isset($_POST[$option])) {
                //Making sure we are saving the option on the root site
                switch_to_blog(self::ROOT_SITE);
                // Save our option with the site's options.
                $readyOption =  $_POST[$option];
                update_option($option, $readyOption);
                //Updating the property on all sites
                $this->update_properties($option,$_POST[$option]);
            } else {
                //Making sure we are deleting the option from the root site
                switch_to_blog(self::ROOT_SITE);
                // If the option is not here then delete it.
                delete_option($option);
            }
        }

        // At last we redirect back to our options page.
        wp_redirect(add_query_arg(array('page' => 'site_level_admin_display',
            'updated' => 'true'), network_admin_url('settings.php')));

        exit;
    }
}