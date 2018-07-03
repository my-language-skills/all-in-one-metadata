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
 * @author     Christos Amyrotos @MashRoofa
 * @author     Daniil Zhitnitskii @danzhik
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
        add_submenu_page( 'settings.php', __('All In One Metadata Network Admin Settings', 'all-in-one-metadata'),
            'Metadata', 'manage_network_options',
            'site_level_admin_display', array( $this, 'render_network_settings' ) );

        //These variables are static now because this is a prototype for the book level types
        $displayPage = 'site_level_admin_display';
        $sectionId   = 'site_level_section';

        //adding metabox for proper output layout
        add_meta_box('site_level_admin', __('Manage Options', 'all-in-one-metadata'), array($this, 'render_metabox_network'), $displayPage, 'normal', 'core');

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
                $type_details[1].__(' On Site Level', 'all-in-one-metadata'),
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
     * Render network settings page
     *
     * @since  0.18
     */
    function render_network_settings(){
	    ?>
	    <div class="wrap">
		    <div class="metabox-holder">
			    <?php
			    do_meta_boxes('site_level_admin_display', 'normal','');
			    ?>
		    </div>
	    </div>
	    <?php
    }

	/**
	 * Linking the page that the settings will render
	 *
	 * @since 0.18
	 */
    function render_metabox_network(){
	    include_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/pressbooks-metadata-network-admin-settings.php';
    }

	/**
	 * Function used to distribute shared or frozen properties for a newly created blog
     *
     * @since 0.19
     * @author Daniil Zhitnitskii @danzhik
	 */
	function update_properties_new_blog ($blog_id, $user_id){

		//Wordpress Database variable for database operations
		global $wpdb;

		//getting options for freezing and sharing properties and values of properties
		$shared_properties = get_blog_option(1, 'property_network_value_share') ?: [];
		$frozen_properties = get_blog_option(1, 'property_network_value_freeze') ?: [];
		$values = get_blog_option(1, 'property_network_value') ?: [];

		switch_to_blog($blog_id);

		//Get the post type we want to work with
		$postType = site_cpt::pressbooks_identify() ? 'metadata' : 'site-meta';

		//Get the posts table name for the current site
		$postsTable = $wpdb->prefix . "posts";

		//Our query that chooses posts of type site-meta or metadata for the book info
		$selectedPosts = $wpdb->get_results($wpdb->prepare(" 
			SELECT ID,post_type FROM $postsTable WHERE post_type = %s",$postType),ARRAY_A);

		//If no initial site-meta/metadata post found we create one
		if(empty($selectedPosts)){
			$args = array(
				'post_author'		=>	$user_id,
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

		foreach ($shared_properties as $shared_property => $value){
		    $data = explode('_',$shared_property);
		    $property = $data[0].'_'.$data[1].'_'.$data[2].'_'.$data[3];
		    if (isset($frozen_properties[$property.'_freeze'])) { continue;}

			//Going through all posts and adding the new post_meta
			foreach($selectedPosts as $post){
		        $val = isset($values[$property]) ? $values[$property] : '';
		        update_post_meta($post['ID'], 'pb_'.strtolower($property), $val);
			}

			//> get parent type to select proper schema type option
			foreach(structure::$allSchemaTypes as $type) {
				if(stripos($type,'metadata_'.$data[1])){
					$schemaTypeParents = $type::$type_parents;
				}
			}

			if (in_array('schemaTypes\Pressbooks_Metadata_Organization',$schemaTypeParents)) {
				$schemaOptionName = $postType.'_schemaTypes\Pressbooks_Metadata_Organization';
			} else{
				$schemaOptionName = $postType.'_schemaTypes\Pressbooks_Metadata_CreativeWork';
			}
			//<

			//get accumulated option for schema types activated
			$optionsSchemaTypes = get_option($schemaOptionName);

			//get accumulated option for activated properties
			$optionsSchemaProperties = get_option('schema_properties_'.$data[1].'_'.$data[2].'_'.$postType.'_level');

			//Enable Site-Meta Level
			update_option($postType.'_checkbox', 1);

			//Enable Type
			$optionsSchemaTypes[$data[1].'_'.$data[2]] = 1;

			update_option($schemaOptionName,$optionsSchemaTypes);

			//Enable Property
			$optionsSchemaProperties[$data[0]] = 1;
			update_option('schema_properties_'.$data[1].'_'.$data[2].'_'.$postType.'_level', $optionsSchemaProperties);

        }

		foreach ($frozen_properties as $frozen_property => $value){
			$data = explode('_',$frozen_property);
			$property = $data[0].'_'.$data[1].'_'.$data[2].'_'.$data[3];

			//Going through all posts and adding the new post_meta
			foreach($selectedPosts as $post){
				$val = isset($values[$property]) ? $values[$property] : '';
				update_post_meta($post['ID'], 'pb_'.strtolower($property), $val);
			}

			//if property was shared, next iteration in order not to activate schema type and property twice
			if (isset($shared_properties[$property.'_share'])) { continue;}

			//> get parent type to select proper schema type option
			foreach(structure::$allSchemaTypes as $type) {
				if(stripos($type,'metadata_'.$data[1])){
					$schemaTypeParents = $type::$type_parents;
				}
			}

			if (in_array('schemaTypes\Pressbooks_Metadata_Organization',$schemaTypeParents)) {
				$schemaOptionName = $postType.'_schemaTypes\Pressbooks_Metadata_Organization';
			} else{
				$schemaOptionName = $postType.'_schemaTypes\Pressbooks_Metadata_CreativeWork';
			}
			//<

			//get accumulated option for schema types activated
			$optionsSchemaTypes = get_option($schemaOptionName);

			//get accumulated option for activated properties
			$optionsSchemaProperties = get_option('schema_properties_'.$data[1].'_'.$data[2].'_'.$postType.'_level');

			//Enable Site-Meta Level
			update_option($postType.'_checkbox', 1);

			//Enable Type
			$optionsSchemaTypes[$data[1].'_'.$data[2]] = 1;

			update_option($schemaOptionName,$optionsSchemaTypes);

			//Enable Property
			$optionsSchemaProperties[$data[0]] = 1;
			update_option('schema_properties_'.$data[1].'_'.$data[2].'_'.$postType.'_level', $optionsSchemaProperties);

		}

		//enabling _saoverwr option
        update_option($postType.'_saoverwr', '1');

        restore_current_blog();
	}

    /**
     * Function used to distribute property data to all our Book-Info/Site-Meta on all our Sites/Books
     *
     * @since  0.10
     */
    private function update_properties($metaKey,$newValue,$freezes, $shares){

        if ((strpos($metaKey, '_freeze') !== false) || (strpos($metaKey, '_share') !== false) || $newValue=="") {
            return;
        }

        //Wordpress Database variable for database operations
        global $wpdb;


	    //Extracting data for enabling property
	    $dataForEnabling = explode('_',$metaKey);
	    $schemaProp = $dataForEnabling[0];

        //Modifying the metakey so it matches the already saved fields created by create metabox class
        $metaKey = strtolower('pb_'.$metaKey);

        //Grabbing all the site IDs
        $siteids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

        //Going through the sites
        foreach ($siteids as $site_id) {

            //Skipping the RootSite
            if($site_id == self::ROOT_SITE) {continue;}

            //Get the post type we want to work with
            $postType = site_cpt::pressbooks_identify() ? 'metadata' : 'site-meta';

            //Switching site
            switch_to_blog($site_id);

            //Check if the site allows super admin to change data
            if(!(get_option($postType.'_saoverwr')) && (!isset($freezes[str_replace('pb_','',$metaKey).'_freeze']) || !isset($shares[str_replace('pb_','',$metaKey).'_share']))){
                continue;
            }

            //Get the posts table name for the current site
            $postsTable = $wpdb->prefix . "posts";

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
	            if(!isset($freezes[str_replace('pb_','',$metaKey).'_freeze']) && isset($shares[str_replace('pb_','',$metaKey).'_share']) && empty(get_post_meta( $post['ID'], $metaKey))){
		            update_post_meta( $post['ID'],$metaKey,$newValue);
		            continue;
                } elseif (isset($freezes[str_replace('pb_','',$metaKey).'_freeze'])) {
		            update_post_meta( $post['ID'], $metaKey, $newValue );
	            }
            }

            //Extracting data for enabling the post level and the schema type
            $dataForEnabling = explode('_',$metaKey);
            $schemaType = $dataForEnabling[2].'_'.$dataForEnabling[3];

	        //> get parent type to select proper schema type option
	        foreach(structure::$allSchemaTypes as $type) {
	        	if(stripos($type,'metadata_'.$dataForEnabling[2])){
	        		$schemaTypeParents = $type::$type_parents;
		        }
	        }

			if (in_array('schemaTypes\Pressbooks_Metadata_Organization',$schemaTypeParents)) {
				$schemaOptionName = $postType.'_schemaTypes\Pressbooks_Metadata_Organization';
			} else{
				$schemaOptionName = $postType.'_schemaTypes\Pressbooks_Metadata_CreativeWork';
			}
			//<

	        //get accumulated option for schema types activated
	        $optionsSchemaTypes = get_option($schemaOptionName);

	        //get accumulated option for activated properties
	        $optionsSchemaProperties = get_option('schema_properties_'.$schemaType.'_'.$postType.'_level');

            //Enable Site-Meta Level
            update_option($postType.'_checkbox', 1);

            //Enable Type
	        $optionsSchemaTypes[$schemaType] = 1;

            update_option($schemaOptionName,$optionsSchemaTypes);

            //Enable Property
	        $optionsSchemaProperties[$schemaProp] = 1;
            update_option('schema_properties_'.$schemaType.'_'.$postType.'_level', $optionsSchemaProperties);
        }
    }

    /**
     * Function used for taking an array and generating a cleaned one with the keys you ask
     *
     * @since  0.18
     */
    function cleanCollect($arrayInput,$searchWord,$toLower){
        $newArray = array();
        if($toLower == true){
            foreach($arrayInput as $key => $val){
                if(strpos($key,$searchWord) !== false){
                    $newArray[strtolower($key)] = $val;
                }
            }
        }else{
            foreach($arrayInput as $key => $val){
                if(strpos($key,$searchWord) !== false){
                    $newArray[$key] = $val;
                }
            }
        }

        return $newArray;
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
        $options = array_unique($new_whitelist_options['site_level_admin_display']);

        //Collecting freezes from post variable - converting keys to lowercase
        $freezes = $this->cleanCollect($_POST,'_freeze',true);
        $freezes = $freezes['property_network_value_freeze'];
        $shares = $this->cleanCollect($_POST,'_share',true);
        $shares = $shares['property_network_value_share'];

        // Go through the posted data and save only our options.
        foreach ($options as $option) {
            if (isset($_POST[$option])) {
                //Making sure we are saving the option on the root site
                switch_to_blog(self::ROOT_SITE);
                // Save our option with the site's options.
                $readyOption =  $_POST[$option];
                update_option($option, $readyOption);

				//get all properties from option
	            $properties = $_POST[$option];

                foreach ($properties as $property => $value) {

	                //Updating the property on all sites
	                $this->update_properties( $property, $properties[$property], $freezes, $shares );
                }
            } else {
	            //Making sure we are deleting the option from the root site
	            switch_to_blog(self::ROOT_SITE);
	            // If the option is not here then delete it.
	            delete_option($option);
            }
        }

        // At the end we redirect back to our options page.
       wp_redirect(add_query_arg(array('page' => 'site_level_admin_display',
           'updated' => 'true'), network_admin_url('settings.php')));

        exit;
    }
}