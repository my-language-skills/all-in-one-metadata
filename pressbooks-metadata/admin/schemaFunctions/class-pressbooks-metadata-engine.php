<?php

namespace schemaFunctions;
use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;
use settings\Pressbooks_Metadata_Post_Type_Fields as post_type_fields;
use settings\Pressbooks_Metadata_Sections as sections;
use schemaTypes\cw as cw;

/**
 * Function used to return all instances for the selected schema types in the settings,
 * Instances are used to create the metaboxes and the metadata. Here we also create the
 * sections and fields for the settings page of the plugin
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaFunctions
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Engine {

	/**
	 * Variable for creating settings
	 * Variable also used when creating type instances.
	 * @since    0.9
	 *
	 */
	private $metaSettings;

	function __construct() {
		//TODO This approach has to change into a more modular one, we can use the database
		//Use this array to create new settings for new types that you add
		//Every setting you create can be accessed using the example here
		//book_type -> This is the id of a field in the array below
		//book_level -> This is the section id that this fields exists
		//if you add them together with a '_' you have the setting -> book_type_book_level
		//Use get_option() to get the value from the database (Process is Automatic)
		$this->metaSettings =
			array(
				//For every new type we add we need to add the settings here, url can be empty
				'book_type'        => array( 'Book Type', 'http://schema.org/Book' ),
				'course_type'      => array( 'Course Type', 'http://schema.org/Course' ),
				'webpage_type'     => array( 'Webpage Type', 'http://schema.org/WebPage' ),
				'educational_info' => array('Educational Information',''),
				'clip_type'        => array('Clip Type','http://schema.org/Clip'),
				'blog_type'        => array('Blog Type','http://schema.org/Blog'),
				'article_type'        => array('Article Type','http://schema.org/Article'),
				'comment_type'        => array('Comment Type','http://schema.org/Comment'),
				'creativeWorkSeason_type'        => array('Creative Work Season Type','http://schema.org/CreativeWorkSeason'),
				'creativeWorkSeries_type'        => array('Creative Work Series Type','http://schema.org/CreativeWorkSeries'),
				'dataCatalog_type'        => array('Data Catalog Type','http://schema.org/DataCatalog'),
				'dataSet_type'        => array('Data Set Type','http://schema.org/Dataset'),
				'digitalDocument_type'        => array('Digital Document Type','http://schema.org/DigitalDocument'),
				'episode_type'        => array('Episode Type','http://schema.org/Episode'),
				'game_type'        => array('Game Type','http://schema.org/Game'),
				'map_type'        => array('Map Type','http://schema.org/Map'),
				'mediaObject_type'        => array('Media Object Type','http://schema.org/MediaObject'),
				'menu_type'        => array('Menu Type','http://schema.org/Menu'),
				'menuSection_type'        => array('Menu Section Type','http://schema.org/MenuSection'),
				'message_type'        => array('Message Type','http://schema.org/Message'),
				'movie_type'        => array('Movie Type','http://schema.org/Movie'),
				'musicComposition_type'        => array('Music Composition Type','http://schema.org/MusicComposition'),
				'musicPlaylist_type'        => array('Music Playlist Type','http://schema.org/MusicPlaylist'),
				'musicRecording_type'        => array('Music Recording Type','http://schema.org/MusicRecording'),
				'publicationIssue_type'        => array('Publication Issue Type','http://schema.org/PublicationIssue'),
				'publicationVolume_type'        => array('Publication Volume Type','http://schema.org/PublicationVolume'),
				'question_type'        => array('Question Type','http://schema.org/Question'),
				'recipe_type'        => array('Recipe Type','http://schema.org/Recipe'),
				'review_type'        => array('Review Type','http://schema.org/Review'),
				'softwareApplication_type'        => array('Software Application Type','http://schema.org/SoftwareApplication'),
				'softwareSourceCode_type'        => array('Software Source Code Type','http://schema.org/SoftwareSourceCode'),
				'tvSeason_type'        => array('TV Season Type','http://schema.org/TVSeason'),
				'tvSeries_type'        => array('TV Series Type','http://schema.org/TVSeries'),
				'visualArtWork_type'        => array('Visual Artwork Type','http://schema.org/VisualArtwork'),
				'claimReview_type'        => array('Claim Review Type','http://schema.org/ClaimReview'),
				'emailMessage_type'        => array('Email Message Type','http://schema.org/EmailMessage'),
				'musicAlbum_type'        => array('Music Album Type','http://schema.org/MusicAlbum'),
				'musicRelease_type'        => array('Music Release Type','http://schema.org/MusicRelease'),
				//Here we add the types that have no elements
				//For these types we add a third argument inside the array,this argument is the parent type
				'conversation_type'        => array('Conversation Type','http://schema.org/Conversation','CreativeWorks'),
				'painting_type'        => array('Painting Type','http://schema.org/Painting','CreativeWorks'),
				'photograph_type'        => array('Photograph Type','http://schema.org/Photograph','CreativeWorks'),
				'sculpture_type'        => array('Sculpture Type','http://schema.org/Sculpture','CreativeWorks'),
				'series_type'        => array('Series Type','http://schema.org/Series','CreativeWorks'),
				'webPageElement_type'        => array('Web Page Element Type','http://schema.org/WebPageElement','CreativeWorks'),
				'webSite_type'        => array('Website Type','http://schema.org/WebSite','CreativeWorks')
			);
	}

	/**
	 * Adding metaboxes with fields in the desired pages.
	 *
	 * @since  0.8.1
	 */
	public function place_metaboxes() {
		//All the instances created by the engine_run function - automatically create their metaboxes
		$this->engine_run();
	}

	/**
	 * Returning available post types. The post types we receive are different depending
	 * whether pressbooks is installed or not
	 *
	 * @since  0.9
	 */
	public static function get_all_post_types(){
		//Gathering the post types that are public including the wordpress ones if pressbooks is disabled
		if(!site_cpt::pressbooks_identify()){
			$postTypes = array_keys( get_post_types( array( 'public' => true )) );
		}else{
			$postTypes = array_keys( get_post_types( array( 'public' => true,'_builtin' => false )) );
		}
		return $postTypes;
	}

	/**
	 * Adding sections with fields in the options page using the class section.
	 *
	 * @since  0.8.1
	 */
	public function register_settings() {

		//Setting section name and page
		$section = "postTypeSection";
		$page = "post_options_page";

		//Creating the section
		add_settings_section($section, "Choose Post Types For Metadata Manipulation", null, $page);

		//Gathering post types
		$postTypes = $this->get_all_post_types();

		//Creating fields for the section
		foreach($postTypes as $post_type){
			new post_type_fields($post_type.'_checkbox',ucfirst($post_type),$page,$section);
		}

		//Creating another section with the fields automatically created for the schema types
		foreach($postTypes as $post_type){
			if(get_option($post_type.'_checkbox')){
				new sections(
					$post_type.'_level',
					ucfirst($post_type.' Level'),
					'meta_options_page',
					$this->metaSettings
				);
			}
		}
	}

	/**
	 * Function used to return all post types or 'levels' that are active from the settings
	 * Under the Post Levels Tab
	 * @since  0.9
	 */
	public static function get_enabled_levels(){

		//Getting all the post types
		$postTypes = self::get_all_post_types();

		//This array is needed for the levels that we show different schema types, like chapter and metadata
		$schemaPostLevels = array();

		//The loop checks if the setting is enabled and then stores the activated post in the level array
		foreach($postTypes as $post_type){
			if(get_option($post_type.'_checkbox')) {
				$schemaPostLevels []= $post_type.'_level';
			}
		}
		return $schemaPostLevels;
	}

	/**
	 * Function used to return all instances for the selected types,
	 * Instances are used to create the metaboxes and the metadata
	 * For every new type that we add we need to make modifications here
	 *
	 * @since  0.9
	 */
	public function engine_run(){
		//Getting all active post levels
		$schemaPostLevels = $this->get_enabled_levels();

		//This array will be filled up with instances of the active types, then it will be returned for processing
		$instances = array();

		foreach ($schemaPostLevels as $level) {
			foreach ($this->metaSettings as $type => $link){

				//Checking the settings for each level and we create instances for the active types
				if(get_option($type.'_'.$level)){
					//We use the name of the post excluding the _level part so we can create instances for each post type and its enabled schema types
					$cpt = str_replace("_level","",$level);
					switch($type){

						//TODO Here we can find the correct classes automatically, we need to make improvements

						//Handling types with no properties
						case 'conversation_type':
						case 'painting_type':
						case 'sculpture_type':
						case 'photograph_type':
						case 'series_type':
						case 'webSite_type':
						case 'webPageElement_type':
						$instances[] = new cw\Pressbooks_Metadata_Empty_Type($cpt);
						break;

						case 'claimReview_type':
							$instances[] = new cw\Pressbooks_Metadata_ClaimReview($cpt);
							break;

						case 'emailMessage_type':
							$instances[] = new cw\Pressbooks_Metadata_EmailMessage($cpt);
							break;

						case 'musicAlbum_type':
							$instances[] = new cw\Pressbooks_Metadata_MusicAlbum($cpt);
							break;

						case 'musicRelease_type':
							$instances[] = new cw\Pressbooks_Metadata_MusicRelease($cpt);
							break;

						case 'visualArtWork_type':
							$instances[] = new cw\Pressbooks_Metadata_Visual_Art_Work($cpt);
							break;

						case 'tvSeries_type':
							$instances[] = new cw\Pressbooks_Metadata_Tv_Series($cpt);
							break;

						case 'tvSeason_type':
							$instances[] = new cw\Pressbooks_Metadata_Tv_Season($cpt);
							break;

						case 'softwareSourceCode_type':
							$instances[] = new cw\Pressbooks_Metadata_Software_Source_Code($cpt);
							break;

						case 'softwareApplication_type':
							$instances[] = new cw\Pressbooks_Metadata_Software_Application($cpt);
							break;

						case 'review_type':
							$instances[] = new cw\Pressbooks_Metadata_Review($cpt);
							break;

						case 'recipe_type':
							$instances[] = new cw\Pressbooks_Metadata_Recipe($cpt);
							break;

						case 'question_type':
							$instances[] = new cw\Pressbooks_Metadata_Question($cpt);
							break;

						case 'publicationVolume_type':
							$instances[] = new cw\Pressbooks_Metadata_Publication_Volume($cpt);
							break;

						case 'publicationIssue_type':
							$instances[] = new cw\Pressbooks_Metadata_Publication_Issue($cpt);
							break;

						case 'musicRecording_type':
							$instances[] = new cw\Pressbooks_Metadata_Music_Recording($cpt);
							break;

						case 'musicPlaylist_type':
							$instances[] = new cw\Pressbooks_Metadata_Music_Playlist($cpt);
							break;

						case 'musicComposition_type':
							$instances[] = new cw\Pressbooks_Metadata_Music_Composition($cpt);
							break;

						case 'movie_type':
							$instances[] = new cw\Pressbooks_Metadata_Movie($cpt);
							break;

						case 'message_type':
							$instances[] = new cw\Pressbooks_Metadata_Message($cpt);
							break;

						case 'menuSection_type':
							$instances[] = new cw\Pressbooks_Metadata_Menu_Section($cpt);
							break;

						case 'menu_type':
							$instances[] = new cw\Pressbooks_Metadata_Menu($cpt);
							break;

						case 'mediaObject_type':
							$instances[] = new cw\Pressbooks_Metadata_Media_Object($cpt);
							break;

						case 'map_type':
							$instances[] = new cw\Pressbooks_Metadata_Map($cpt);
							break;

						case 'game_type':
							$instances[] = new cw\Pressbooks_Metadata_Game($cpt);
							break;

						case 'episode_type':
							$instances[] = new cw\Pressbooks_Metadata_Episode($cpt);
							break;

						case 'digitalDocument_type':
							$instances[] = new cw\Pressbooks_Metadata_Digital_Document($cpt);
							break;

						case 'dataSet_type':
							$instances[] = new cw\Pressbooks_Metadata_Data_Set($cpt);
							break;

						case 'dataCatalog_type':
							$instances[] = new cw\Pressbooks_Metadata_Data_Catalog($cpt);
							break;

						case 'creativeWorkSeries_type':
							$instances[] = new cw\Pressbooks_Metadata_Creative_Work_Series($cpt);
							break;

						case 'creativeWorkSeason_type':
							$instances[] = new cw\Pressbooks_Metadata_Creative_Work_Season($cpt);
							break;

						case 'comment_type':
							$instances[] = new cw\Pressbooks_Metadata_Comment($cpt);
							break;

						case 'article_type':
							$instances[] = new cw\Pressbooks_Metadata_Article($cpt);
							break;


						case 'blog_type':
							$instances[] = new cw\Pressbooks_Metadata_Blog($cpt);
							break;


						case 'clip_type':
							$instances[] = new cw\Pressbooks_Metadata_Clip($cpt);
							break;

						case 'book_type':
							$instances[] = new cw\Pressbooks_Metadata_Book($cpt);
							break;

						case 'course_type':
							$instances[] = new cw\Pressbooks_Metadata_Course($cpt);
							break;

						case 'webpage_type':
							$instances[] = new cw\Pressbooks_Metadata_WebPage($cpt);
							break;

						case 'educational_info':
							//Educational information only appears on the site level schema
							if($cpt == 'metadata' || $cpt == 'site-meta'){
								$instances[] = new cw\Pressbooks_Metadata_Educational($cpt);
							}
							break;
					}

				}
			}
		}
		//Here we create a parent for each type if one exists
		foreach($instances as $instance){
			$instances []= $instance->pmdt_parent_init();
		}

		//We duplicated this so grand children can have their grand parent, TODO we can/have to improve this
		foreach($instances as $instance){
			$instances []= $instance->pmdt_parent_init();
		}

		//Then we clear duplicates from the instances
		//For example book and webpage have both creative works as parent, so we keep only one
		$instances = array_unique($instances);

		//Removing Null Values in case we spot any
		$cleanInstances = array();
		foreach($instances as $instance){
			if($instance != NULL){
				$cleanInstances[]=$instance;
			}
		}
		return $cleanInstances;
	}
}

