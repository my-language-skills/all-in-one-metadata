<?php

namespace schemaFunctions;

use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;

/**
 * The functions of the plugin that overwrite chapter/post schema properties from book-info or site-meta.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.11
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaFunctions
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Property_Overwrite {

	function __construct() {

    }

	/**
	 * The function that overwrites property values to chapter or post
	 *
	 * @since  0.11
	 */
    function do_overwrite(){
        //Wordpress Database variable for database operations
        global $wpdb;
         
        //Choosing the type of post for the data -> Pressbooks Installation is metadata
        $dataPostType = site_cpt::pressbooks_identify() ? 'metadata' : 'site-meta';

        //Get the posts table name
        $postsTable = $wpdb->prefix . "posts";

        //Get the postmeta table name
        $postMetaTable = $wpdb->prefix . "postmeta";

        //Our query that chooses the correct post ID for getting the data needed to overwrite chapter or post
        $selectedPostId = $wpdb->get_results($wpdb->prepare(" 
        SELECT ID FROM $postsTable WHERE post_type LIKE %s AND 
        post_status LIKE %s",$dataPostType,'publish'),ARRAY_A);

        //If we have more than one or 0 ids in the array then return and stop operation
        //If we have no chapters or posts to distribute data also stop operation
        if(count($selectedPostId) > 1 || count($selectedPostId) == 0 || count($this->get_all_post_ids()) == 0){
            return;
        }

        //The post ID
        $ID = $selectedPostId[0]['ID'];

        //Our query that chooses all the postmeta that are related to the Book-Info Post / Site-Meta Post 
        $selectedMeta = $wpdb->get_results($wpdb->prepare(" 
        SELECT meta_key, meta_value FROM $postMetaTable WHERE post_id LIKE %s
        AND meta_key LIKE %s AND meta_key LIKE %s
        AND meta_value <>''",$ID,'%%pb_%%','%%_'.$dataPostType.'%%') 
        ,ARRAY_A);

	    //Array for storing metakey=>metavalue
	    $metaData = null;
	    foreach($selectedMeta as $meta){
		    $metaData[$meta['meta_key']] = $meta['meta_value'];
	    }

	    //Getting the overwrite values from settings
	    $toOverwrite = $this->get_overwrite_values();

	    foreach($toOverwrite as $key){
		    //Creating the key to overwrite from settings
		    $modifiedKey = strtolower('pb_'.$key.'_'.$dataPostType);
		    if(isset($metaData[$modifiedKey])){
			    //If found we update
			    $this->inject_meta_to_posts($modifiedKey,$metaData[$modifiedKey],$this->get_all_post_ids(),false);
		    }else{
			    //If not it means the field we are trying to read is empty so we delete the related postmeta from all chapters/posts
			    $this->inject_meta_to_posts($modifiedKey,'',$this->get_all_post_ids(),true);
		    }
	    }
    }

	/**
	 * Function for updating/deleting post meta, this is called from do_overwrite.
	 *
	 * @since  0.11
	 */
	function inject_meta_to_posts($key,$value,$posts,$delete){

		//Choosing the type of post for inserting the data
		$overwritePostType = site_cpt::pressbooks_identify() ? 'chapter' : 'post';

		//The current post type where the information is comming from (Book Info - Sitemeta)
		$currentDataPostType = site_cpt::pressbooks_identify() ? 'metadata' : 'site-meta';

		//Creating the key for the new postmeta values
		$modifiedKey = str_replace($currentDataPostType,$overwritePostType,$key);

		foreach($posts as $post){
			if(!$delete){
				update_post_meta($post,$modifiedKey,$value);
			}else{
				delete_post_meta($post,$modifiedKey,$value);
			}
		}
	}

	/**
	 * The function that returns all the properties we have to overwrite
	 *
	 * @since  0.11
	 */
   function get_overwrite_values(){

        //Wordpress Database variable for database operations
        global $wpdb;

        //Get the options table name
        $optionsTable = $wpdb->prefix . "options";
            
        $filterOption = '%%_overwrite%%';

        //Our query that chooses options that are enabled and contain the word overwrite
        $selectedOptions = $wpdb->get_results($wpdb->prepare(" 
        SELECT option_name FROM $optionsTable WHERE option_value = 1 AND 
        option_name LIKE %s",$filterOption),ARRAY_A);

        //Final options to output
        $trimmedOptions = array();

        //Removing the _overwrite from each option, like that we have the property and the type
        foreach($selectedOptions as $option){
            $trimmedOptions []= str_replace('_overwrite','',$option['option_name']);
        }
        return $trimmedOptions;
    }

	/**
	 * The function used to extract all chapter/post ids, we use these ids to create the post meta for each chapter/post.
	 *
	 * @since  0.11
	 */
    function get_all_post_ids(){
        //Wordpress Database variable for database operations
        global $wpdb;
        
        //Choosing the type of post -> Pressbooks Installation is chapter
        $selectedPostType = site_cpt::pressbooks_identify() ? 'chapter' : 'post';

        //Get the posts table name
        $postsTable = $wpdb->prefix . "posts";

        //Our query that chooses all ids for posts with the selected post type
        $selectedPost = $wpdb->get_results($wpdb->prepare(" 
        SELECT ID FROM $postsTable WHERE post_type = %s",$selectedPostType),ARRAY_A);

        $allIds = array();

        foreach($selectedPost as $post){
            $allIds []= $post['ID'];
        }

        return $allIds;
    }
}

