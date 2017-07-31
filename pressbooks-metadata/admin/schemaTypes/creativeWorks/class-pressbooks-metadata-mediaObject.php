<?php

namespace schemaTypes\cw;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;

/**
 * The class for the media object type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Media_Object {

	/**
	 * The type level where these metaboxes and their schema operations will go
	 *
	 * @since    0.x
	 * @access   private
	 */
	private $type_level;

	/**
	 * The name of the class along with the type_level
	 * Used to identify each type differently so we can eliminate parent types not needed
	 *
	 * @since    0.9
	 * @access   public
	 */
	public $class_name;

	/**
	 * The variable that holds the values for the settings for this schema type
	 *
	 * @since    0.x
	 * @access   public
	 */
	public static $type_settings = array('mediaObject_type' => array('Media Object Type','http://schema.org/MediaObject'));

	public function __construct($type_level_input) {
		$this->type_level = $type_level_input;
		$this->pmdt_add_metabox($this->type_level);
		$this->class_name = __CLASS__ .'_'. $this->type_level;
	}

	/**
	 * The function which produces the metaboxes for the media object type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position){
		//----------- metabox ----------- //
		x_add_metadata_group( 	'media-object', $meta_position, array(
			'label' 		=>	'Media Object Type Properties',
			'priority' 		=>	'high',
		) );
		//----------- metafields ----------- //
		// Assosciated Article
		x_add_metadata_field( 	'pb_associated_article_'.$meta_position, $meta_position, array(
			'group' 		=>	'media-object',
			'label' 		=>	'Associated Article',
			'description' 	=>	'A NewsArticle associated with the Media Object.'
	
		) );
		// Bit Rate
		x_add_metadata_field( 	'pb_bit_rate_'.$meta_position, $meta_position, array(
			'group' 		=>	'media-object',
			'label' 		=>	'Bit Rate',
			'description' 	=>	'The bitrate of the media object.'
	
		) );
		// Content Size
		x_add_metadata_field( 	'pb_content_size_'.$meta_position, $meta_position, array(
			'group' 		=>	'media-object',
			'label' 		=>	'Content Size',
			'description' 	=>	'File size in (mega/kilo) bytes.'
	
		) );
		// Content Url
		x_add_metadata_field( 	'pb_content_url_'.$meta_position, $meta_position, array(
			'group' 		=>	'media-object',
			'label' 		=>	'Content Url',
			'description' 	=>	'Actual bytes of the media object, for example the image file or video file.'
	
		) );
		// Duration
		x_add_metadata_field( 	'pb_duration_'.$meta_position, $meta_position, array(
			'group' 		=>	'media-object',
			'label' 		=>	'Duration',
			'description' 	=>	'The duration of the item (movie, audio recording, event, etc.) in ISO 8601 date format.'
	
		) );
		// Embed Url
		x_add_metadata_field( 	'pb_embed_url_'.$meta_position, $meta_position, array(
			'group' 		=>	'media-object',
			'label' 		=>	'Embed Url',
			'description' 	=>	'A URL pointing to a player for a specific video. In general, this is the information in the src element of an embed tag and should not be the same as the content of the loc tag.'
	
		) );
		// Encodes Creative Work
		x_add_metadata_field( 	'pb_encodes_creative_work_'.$meta_position, $meta_position, array(
			'group' 		=>	'media-object',
			'label' 		=>	'Encodes Creative Work',
			'description' 	=>	'The CreativeWork encoded by this media object.'
	
		) );
		// Encoding Format
		x_add_metadata_field( 	'pb_encoding_format_'.$meta_position, $meta_position, array(
			'group' 		=>	'media-object',
			'label' 		=>	'Encoding Format',
			'description' 	=>	'mp3, mpeg4, etc.'
	
		) );
		// Expires
		x_add_metadata_field( 	'pb_expires_'.$meta_position, $meta_position, array(
			'group' 		=>	'media-object',
			'label' 		=>	'Expires',
			'description' 	=>	'Date the content expires and is no longer useful or available. Useful for videos.'
	
		) );
		// Height
		x_add_metadata_field( 	'pb_height_'.$meta_position, $meta_position, array(
			'group' 		=>	'media-object',
			'label' 		=>	'Height',
			'description' 	=>	'The height of the item.'
	
		) );
		// Player Type
		x_add_metadata_field( 	'pb_player_type_'.$meta_position, $meta_position, array(
			'group' 		=>	'media-object',
			'label' 		=>	'Player Type',
			'description' 	=>	'Player type required—for example, Flash or Silverlight.'
	
		) );
		// Production Company
		x_add_metadata_field( 	'pb_production_company_'.$meta_position, $meta_position, array(
			'group' 		=>	'media-object',
			'label' 		=>	'Production Company',
			'description' 	=>	'The production company or studio responsible for the item e.g. series, video game, episode etc.'
	
		) );
		// Regions Allowed
		x_add_metadata_field( 	'pb_regions_allowed_'.$meta_position, $meta_position, array(
			'group' 		=>	'media-object',
			'label' 		=>	'Regions Allowed',
			'description' 	=>	'The regions where the media is allowed. If not specified, then it s assumed to be allowed everywhere. Specify the countries in ISO 3166 format.'
	
		) );
		// Requires Subscription
		x_add_metadata_field( 	'pb_requiers_subscription_'.$meta_position, $meta_position, array(
			'group' 		=>	'media-object',
			'label' 		=>	'Requires Subscription',
			'description' 	=>	'Indicates if use of the media require a subscription (either paid or free). Allowed values are true or false (note that an earlier version had yes, no).'
	
		) );
		// Upload Date
		x_add_metadata_field( 	'pb_upload_date_'.$meta_position, $meta_position, array(
			'group' 		=>	'media-object',
			'label' 		=>	'Upload Date',
			'description' 	=>	'Date when this media object was uploaded to this site.'
	
		) );
		// Width
		x_add_metadata_field( 	'pb_width_'.$meta_position, $meta_position, array(
			'group' 		=>	'media-object',
			'label' 		=>	'Width',
			'description' 	=>	'The width of the item.'
	
		) );

	}

		/*FUNCTIONS FOR THIS TYPE START HERE*/

	/**
	 * Function used for comparing the instances of the schema types
	 *
	 * @since    0.9
	 * @access   public
	 */
	public function __toString() {
		return $this->class_name;
	}

	/**
	 * Returns the father for the type.
	 *
	 * @since    0.9
	 * @access   public
	 */
	public function pmdt_parent_init(){
		return new Pressbooks_Metadata_Creative_Work($this->type_level);
	}

	/**
	 * Returns type level.
	 *
	 * @since    0.x
	 * @access   public
	 */
	public function pmdt_get_type_level(){
			return $this->type_level;
		}

	/**
	 * A function needed for the array of metadata that comes from each post or chapter
	 * It automatically returns the first item in the array.
	 * @since 0.8.1
	 *
	 */
	private function pmdt_get_first($my_array){
		return $my_array[0];
	}

	/**
	 * A function that creates the metadata for the Media Object type.
	 * @since 0.8.1
	 *
	 */
	public function pmdt_get_metatags() {
		//Distinguishing if we are working on a post --- chapter level or on the main site level
		//The type_level variable is the string we used to create the metabox

		$is_site; // This bool var is used to identify if the level is site level or any other post level
		if ( $this->type_level == 'metadata' || $this->type_level == 'site-meta' ) { //loading the appropriate metadata depending on the type level
			$metadata = gen_func::get_metadata();
			$is_site = true;
		} else {
			$is_site = false;
			$metadata = get_post_meta( get_the_ID() );
		}

		// array of the items needed to become microtags
		$mediaObject_data = array(

			'associatedArticle' => 'pb_associated_article',
			'bitrate' => 'pb_bit_rate',
			'contentSize' => 'pb_content_size',
			'contentUrl' => 'pb_content_url',
			'duration	' => 'pb_duration',
			'embedUrl' => 'pb_embed_url',
			'encodesCreativeWork' => 'pb_encodes_creative_work',
			'encodingFormat' => 'pb_associated_article',
			'expires' => 'pb_associated_article',
			'height' => 'pb_associated_article',
			'playerType' => 'pb_associated_article',
			'productionCompany' => 'pb_associated_article',
			'regionsAllowed' => 'pb_associated_article',
			'requiresSubscription' => 'pb_requiers_subscription',
			'uploadDate' => 'pb_upload_date',
			'width' => 'pb_width'
		);

		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/MediaObject">';

		foreach ( $mediaObject_data as $itemprop => $content ) {
			if ( isset( $metadata[ $content . '_' . $this->type_level ] ) ) {

				if ( !$is_site ) { //we are using the get_first function to get the value from the returned array
					$value = $this->pmdt_get_first( $metadata[ $content . '_' . $this->type_level ] );
				} else {
					if($this->type_level == 'site-meta'){
						$value = $this->pmdt_get_first($metadata[ $content . '_' . $this->type_level ]);
					}else{//We always use the get_first function except if our level is metadata coming from pressbooks
						$value = $metadata[ $content . '_' . $this->type_level ];
					}
				}
				$html .= "<meta itemprop = '" . $itemprop . "' content = '" . $value . "'>\n";
			}
		}
		$html .= '</div>';
		return $html;
	}
}