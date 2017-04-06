<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://on-lingua.com
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin
 * @author     julienCXX <software@chmodplusx.eu>
 * @author 	   Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */
class Pressbooks_Metadata_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1
	 * @param    string    $plugin_name       The name of this plugin.
	 * @param    string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    0.1
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pressbooks_Metadata_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pressbooks_Metadata_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pressbooks-metadata-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    0.1
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pressbooks_Metadata_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pressbooks_Metadata_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pressbooks-metadata-admin.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * Used in the header of our site
	 *
	 * @since    0.2
	 */
	public function header_function() {
		if ( is_front_page() ) {?>
			<div itemscope itemtype="http://schema.org/Course">
			<?php
			$pm_BM = Pressbooks_Metadata_Educational_Information_Metadata::get_instance();
			$pm_BM->print_microdata_meta_tags();
			$pm_BM->print_educationalAlignment_microdata_meta_tags();
		}
		else{
			global $post;
		?>
			<div itemscope itemtype="http://schema.org/ScholarlyArticle" >
			<meta itemprop='name' content='<?php echo $post->post_title; ?>' id='name'>
			<meta itemprop='datePublished' content='<?php echo $post->post_date; ?>' id='name'>
			<meta itemprop='dateModified' content='<?php echo $post->post_modified; ?>' id='name'>
			<meta itemprop='author' content='<?php echo get_the_author(); ?>' id='name'>
			<?php
			//global $wpdb;
			//$findID = $wpdb->get_results("SELECT ID FROM pbo_wp_17_posts WHERE post_name = 'chapter-1'");
			//echo $findID[0]->ID;
			$pm_CM = Pressbooks_Metadata_Chapter_Metadata::get_instance();
			$pm_CM->print_microdata_meta_tags();
		}
		?>
		</div>
		<?php
	}


}
