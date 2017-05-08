<?php

/**
 * The class handling theme-related setting and enforcing of plugin's themes.
 *
 * @link       http://on-lingua.com
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes
 */

/**
 * The class handling theme-related setting and enforcing of plugin's themes.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes
 * @author     julienCXX <software@chmodplusx.eu>
 */
class Pressbooks_Metadata_Themes {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the directory containing the plugin's specific themes.
	 *
	 * @since    0.1
	 */
	public function register_directory() {

		register_theme_directory( plugin_dir_path( dirname( __FILE__ ) ) . 'themes' );

	}

	/**
	 * Queue the plugin's specific themes.
	 *
	 * @since    0.1
	 */
	public function enqueue_custom_themes() {

		wp_register_style( 'pressbooks-metadata-generic', plugin_dir_url( dirname( __FILE__ ) ) . 'themes/pressbooks-metadata-generic/style.css', array( 'pressbooks-book' ), $this->version, 'all' );

		wp_enqueue_style( 'pressbooks-book' );
		wp_enqueue_style( 'pressbooks-metadata-generic' );

	}

	/**
	 * Add the plugin's specific themes to the PressBooks theme filter.
	 * Inspirated from Textbook's one.
	 *
	 * @since    0.1
	 * @param    array $themes The currently allowed themes in PressBooks
	 * @return   array The array from the input, with the plugin's themes
	 */
	public function add_themes_to_filter( $themes ) {

		$pbt_themes = array();
		if ( \Pressbooks\Book::isBook() ) { 
			$registered_themes = search_theme_directories();

			foreach ( $registered_themes as $key => $val ) { 
				if ( $val['theme_root'] == plugin_dir_path( dirname( __FILE__ ) ) . 'themes' ) {
					$pbt_themes[$key] = 1;
				}
			}
			// add our theme to the whitelist
			$themes = array_merge( $themes, $pbt_themes );

			return $themes;
		} else {
			return $themes;
		}

	}

	/**
	 * Add the plugin's themes to the Epub export. Dirty trick not to have
	 * to duplicate CSS code to Epub export directory.
	 *
	 * @since    0.1
	 * @param    string $styles The currently allowed themes in PressBooks
	 * @return   string The array from the input, with the added styles
	 */
	public function add_epub_export_styles( $styles ) {

		$editor_styles = file_get_contents( plugin_dir_path( dirname( __FILE__ ) ) . 'themes/pressbooks-metadata-generic/editor-style.css' );
		if ( $editor_styles ) {
			$styles .= $editor_styles;
		}
		return $styles;

	}

}
