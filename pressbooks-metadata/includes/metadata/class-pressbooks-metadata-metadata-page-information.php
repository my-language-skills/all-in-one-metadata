<?php

/**
 * The page's specific information.
 *
 * @link       http://on-lingua.com
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata
 */

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'metadata/class-pressbooks-metadata-metadata-fetcher.php';

/**
 * The page's specific information.
 *
 * Defines the plugin's page information handling and fetching.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata
 * @author     julienCXX <software@chmodplusx.eu>
 */
class Pressbooks_Metadata_Metadata_Page_Information {

	/**
	 * The prefix to be added to each field slug.
	 *
	 * @since  0.1
	 * @access private
	 * @var    string  $slug_prefix The slug prefix.
	 */
	private $slug_prefix;

	/**
	 * The extra page metadata added by this class.
	 *
	 * @since  0.1
	 * @access private
	 * @var    string  $page_metadata The extra page metadata of this class.
	 */
	private $page_metadata = NULL;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 0.1
	 * @param string $slug_prefix  The slug prefix.
	 */
	public function __construct( $slug_prefix ) {

		$this->slug_prefix = $slug_prefix;
		$this->page_metadata = array();
		$this->add_page_information();

	}

	/**
	 * Generates a slug from a label.
	 *
	 * @since  0.1
	 * @param  string $label The input label.
	 * @return string The slugged label.
	 */
	private function get_slug_from_label( $label ) {

		$cleaned_label = trim( $label );
		if ( empty( $cleaned_label ) ) {
			return '';
		}
		$cleaned_label = strtolower( $cleaned_label );
		$res = preg_replace( '/[^a-z]/', '_', $cleaned_label );
		return $res;

	}

	/**
	 * Adds the actual fields to the related books field list, at chapter level (button for enabling the related books).
	 *
	 * @since  0.1
	 */
	private function add_page_information() {

		$this->page_metadata['discussion_url'] = array(
			'group' => 'chapter-metadata',
			'field_type' => 'text',
			'label' => 'Questions and Answers',
			'description' => 'The URL of a forum/discussion about this page.',
			'placeholder' => 'http://site.com/'
		);

		$this->page_metadata['time_required'] = array(
			'group' => 'chapter-metadata',
			'field_type' => 'number',
			'min' => '0',
			'label' => 'Class Learning Time (minutes)',
			'default_value' => '0'
		);

	}

	/**
	 * Generates an array with the fields to be added to the dashboard, in the “Chapter” page.
	 *
	 * @since  0.1
	 * @return array The generated array.
	 */
	public function get_page_fields_for_dashboard() {

		return $this->page_metadata;

	}

	/**
	 * Prints the HTML code of page-specific metadata for the public part of the book.
	 *
	 * @since 0.1
	 */
	public function print_page_metadata_for_public() {

		$raw_meta = Pressbooks_Metadata_Metadata_Fetcher::fetch_chapter_metadata();
		if ( isset( $raw_meta[$this->slug_prefix . 'discussion_url'] ) ) {
			?><div><a href="<?php
			echo $raw_meta[$this->slug_prefix . 'discussion_url'];
			?>">Questions and Answers</a></div><?php
		}
		?><table><?php
		if ( isset( $raw_meta[$this->slug_prefix . 'time_required'] ) ) {
			?><tr><td>Learning Time</td><td><?php
			echo new Pressbooks_Metadata_Duration( $raw_meta[$this->slug_prefix . 'time_required'] );
			?></td></tr><?php
		}
		?><tr><td>Created on</td><td><?php
		the_time( 'F j, Y, G:i' );
		?></td></tr>
		<tr><td>Last modified on</td><td><?php
		the_modified_time( 'F j, Y, G:i' );
		?></td></tr></table><?php

	}
}
