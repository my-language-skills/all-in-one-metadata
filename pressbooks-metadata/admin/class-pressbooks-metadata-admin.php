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
	 * A function to echo an error if the latest version of pressbooks is not installed, and
	 * if there is no Pressbooks installation.
	 * 
	 * @since    0.6
	 */
	function s_md_init() {
		// Must meet miniumum requirements
		if ( ! @include_once( WP_PLUGIN_DIR . '/pressbooks/compatibility.php' ) ) {
			add_action( 'admin_notices', function () {
				echo '<div id="message" class="error fade"><p>' . __( 'PB metadata cannot find a Pressbooks install.', 'pressbooks-metadata' ) . '</p></div>';
			} );
			return;
		} elseif( ! version_compare( PB_PLUGIN_VERSION, '3.9.8.2', '>=' ) ) {
			add_action( 'admin_notices', function () {
				echo '<div id="message" class="error fade"><p>' . __( 'PB metadata requires Pressbooks 3.9.8.2 or greater.', 'pressbooks-metadata' ) . '</p></div>';
			} );
			return;
		}
	}

	/**
	 * Used in the header of our site
	 * 
	 * We can create a new Structured Data Type by adding a new type here. Check the link for an example
	 * https://search.google.com/structured-data/testing-tool/u/0/#url=pressbooks.com
	 * @since    0.6
	 */
	public function header_function() {

		global $post;

		if ( is_home() ) {?>
<div itemscope itemtype="http://schema.org/Website">
	<meta itemprop = 'name' content = '<?php echo get_bloginfo( 'name' ); ?>'>
	<meta itemprop = 'description' content = '<?php echo get_bloginfo( 'description' ); ?>'>
	<meta itemprop = 'url' content = '<?php echo get_bloginfo( 'url' ); ?>'>
	<meta itemprop = 'inLanguage' content = '<?php echo get_bloginfo( 'language' ); ?>'>
	<!--<meta itemprop='datePublished' content='<?php echo $post->post_date; ?>' >
	<meta itemprop='dateModified' content='<?php echo $post->post_modified; ?>' id='name'>-->
</div>
		<?php
		}

	}

	/**
	 * Used in the footer of our site
	 * 
	 * We can create a new Structured Data Type by adding a new type here. Check the link for an example
	 * https://search.google.com/structured-data/testing-tool/u/0/#url=pressbooks.com
	 * @since    0.2
	 */
	public function footer_function() {

		global $post;

		if ( is_home() ) {?>

		<?php
		}
		elseif ( is_front_page() ) { ?>

<!-- Course type -->
<div itemscope itemtype = 'http://schema.org/Course'>
			<?php
			$pm_BM = Pressbooks_Metadata_Educational_Information::get_instance();
			$pm_BM->print_microdata_meta_tags();
			$pm_BM->print_educationalAlignment_microdata_meta_tags();
			?>
</div>
<!-- Book type -->
<div itemscope itemtype = 'http://schema.org/Book'>
			<?php
			$pm_BB = Pressbooks_Metadata_General_Book_Information::get_instance();
			$pm_BB->print_microdata_meta_tags();
			?>
</div>
			<?php
		}
		else{
		?>
<!-- Scholarly Article type -->
<div itemscope itemtype = 'http://schema.org/ScholarlyArticle' >

<!-- Here we take data from the default fields of wordpress -->
	<meta itemprop = 'headline' content='<?php echo $post->post_title; ?>' />
	<meta itemprop = 'datePublished' content='<?php echo $post->post_date; ?>' />
	<meta itemprop = 'dateModified' content='<?php echo $post->post_modified; ?>' />

<!-- Here from the pressbooks fields in the Post level -->
			<?php
			$pm_CM = Pressbooks_Metadata_Chapter_Metadata::get_instance();
			$pm_CM->print_microdata_meta_tags();
			$pm_CM->print_ScolarlyArticle_meta_tags();
			$pm_CM->print_Chapter_Metadata_meta_tags();

			/*-- And here from the fields we need to use from the Educational Information metabox --*/
			$pm_CM = Pressbooks_Metadata_Educational_Information::get_instance();
			$pm_CM->print_ScolarlyArticle_meta_tags_from_Edu_Info();
			?>
</div>
			<?php
		}
		?>

		<?php
	}


}
