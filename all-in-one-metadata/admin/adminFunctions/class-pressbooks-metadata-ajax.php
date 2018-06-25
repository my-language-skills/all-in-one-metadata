<?php

namespace adminFunctions;
use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;

/**
 * The functions of the plugin that handle custom ajax requests.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.13
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/adminFunctions
 * @author     Christos Amyrotos @MashRoofa
 * @author     Daniil Zhitnitskii @danzhik
 */

class Pressbooks_Metadata_Ajax {

	function __construct() {

    }

    /**
     * This function cleans the fields of the property that was overwritten to post/chapter
     *
     * @since  0.13
     */
    function overwrite_prop_clean(){
        //Receiving the property
        $ajaxProperty = $_POST['property'];

        //Get the post type we want to work with
        $postType = site_cpt::pressbooks_identify() ? 'chapter' : 'post';

        //Wordpress Database variable for database operations
        global $wpdb;

        //Get the posts table name
        $postsTable = $wpdb->prefix . "posts";

        //Getting all posts that need to be cleared
        $selectedPosts = $wpdb->get_results($wpdb->prepare(" 
        SELECT ID FROM $postsTable WHERE post_type = %s",$postType),ARRAY_A);

        //Processing the property
        $dataForClean = explode('_',$ajaxProperty);

	    //Collecting exploded strings
	    if (stripos($ajaxProperty, '_dis')){
		    $schemaType = $dataForClean[0].'_'.$dataForClean[1];
		    $schemaProp = substr_replace(explode('[', $dataForClean[5])[1], '', -1);

	    } else {
		    $schemaType = $dataForClean[2].'_'.$dataForClean[3];
		    $schemaProp = substr_replace(explode('[', $dataForClean[4])[1], '', -1);
	    }


        //Constructing the postMeta key that has to be cleared
        $metaKey = 'pb_'.$schemaProp.'_'.$schemaType.'_'.$postType;
	    
        //Removing the postMeta from all $selectedPosts
        foreach($selectedPosts as $post){
            delete_post_meta($post['ID'],$metaKey);
        }
        
        // this is required to terminate immediately and return a proper response
        wp_die();
    }

    /**
     * This function disables the property that was overwritten to post/chapter
     *
     * @since  0.13
     */
    function overwrite_prop_disable(){
        //Receiving the property
        $ajaxProperty = $_POST['property'];

        //Get the post type we want to work with
        $postType = site_cpt::pressbooks_identify() ? 'chapter' : 'post';

        //Processing the property
        $dataForClean = explode('_',$ajaxProperty);

	    //Collecting exploded strings to update correct option
	    if (stripos($ajaxProperty, '_dis')){
		    $optionName = $dataForClean[0].'_'.$dataForClean[1].'_'.$postType.'_level_'.$dataForClean[3].'_'.$dataForClean[4].'_'.explode('[', $dataForClean[5])[0];
		    $optinValues = get_option($optionName) ?: [];
		    $propertyDirty = explode('[', $dataForClean[5])[1];
		    $property = substr_replace($propertyDirty, '', -1);
		    $optinValues[$property] = 0;

	    } else {
		    $optionName = $dataForClean[0].'_'.$dataForClean[1].'_'.$dataForClean[2].'_'.$dataForClean[3].'_'.$postType.'_level';
		    $optinValues = get_option($optionName) ?: [];
		    $propertyDirty = explode('[', $dataForClean[4])[1];
		    $property = substr_replace($propertyDirty, '', -1);
		    $optinValues[$property] = 0;
	    }

        //Disabling the property
        update_option($optionName, $optinValues);

        // this is required to terminate immediately and return a proper response
        wp_die();
    }
}

