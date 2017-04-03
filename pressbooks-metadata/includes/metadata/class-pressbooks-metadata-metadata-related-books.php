<?php

/**
 * The book's related books information.
 *
 * @link       http://on-lingua.com
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata
 */

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'metadata/class-pressbooks-metadata-metadata-fetcher.php';

/**
 * The book's related books information.
 *
 * Defines the plugin's related books handling and fetching.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata
 * @author     julienCXX <software@chmodplusx.eu>
 */
class Pressbooks_Metadata_Metadata_Related_Books {

	/**
	 * The prefix to be added to each field slug.
	 *
	 * @since  0.1
	 * @access private
	 * @var    string  $slug_prefix The slug prefix.
	 */
	private $slug_prefix;

	/**
	 * The name of the dashboard metabox (in book metadata) the fields have
	 * to reside in.
	 *
	 * @since  0.1
	 * @access private
	 * @var    string  $metabox_name The name of the metabox.
	 */
	private $metabox_name;

	/**
	 * The extra book group metadata added by this class.
	 *
	 * @since  0.1
	 * @access private
	 * @var    string  $related_book_groups The book metadata groups (smaller than metaboxes).
	 */
	private $related_book_groups = NULL;

	/**
	 * The extra book metadata added by this class.
	 *
	 * @since  0.1
	 * @access private
	 * @var    string  $related_book_fields The book metadata fields added by this class.
	 */
	private $related_book_fields = NULL;

	/**
	 * The extra chapter metadata added by this class.
	 *
	 * @since  0.1
	 * @access private
	 * @var    string  $chapter_metadata The extra chapter metadata of this class.
	 */
	private $chapter_metadata = NULL;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 0.1
	 * @param string $slug_prefix  The slug prefix.
	 * @param string $metabox_name The slug of the metabox the metadata should reside in.
	 */
	public function __construct( $slug_prefix, $metabox_name ) {

		$this->slug_prefix = $slug_prefix;
		$this->metabox_name = $metabox_name;
		$this->related_book_groups = array();
		$this->related_book_fields = array();
		$this->chapter_metadata = array();
		$this->add_related_books_fields();
		$this->add_related_books_chapter_enable();

	}

	/**
	 * Creates a group entry if it does not exists.
	 *
	 * @since 0.1
	 * @param string $label The group label.
	 * @param string $slug  The group slug.
	 */
	private function create_group_if_required( $label, $slug ) {

		if ( ! isset( $this->related_book_groups[$slug] ) ) {
			$this->related_book_groups[$slug] = $label;
			$this->related_book_fields[$slug] = array();
		}

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
	 * Adds a field to the related books field list.
	 * Creates groups when needed.
	 *
	 * @since 0.1
	 * @param string $field_slug  The field slug.
	 * @param string $field_label The field label.
	 * @param string $group_label The group label or an empty string if the field is not part of a group.
	 */
	private function add_related_books_field( $field_slug, $field_label, $group_label = '' ) {

		$group_slug = $this->get_slug_from_label( $group_label );
		$field = array(
			'label' => $field_label,
			'field_type' => 'text',
			'group' => $this->metabox_name
		);
		if ( ! empty( $group_slug ) ) {
			$group_slug = $group_slug . '-group'; // avoid potential conflicts with field label
			$this->create_group_if_required( $group_label, $group_slug );
			$this->related_book_fields[$group_slug][$field_slug] = $field;
		} else {
			$this->related_book_fields[$field_slug] = $field;
		}

	}

	/**
	 * Adds the actual fields to the related books field list, at book level.
	 *
	 * @since 0.1
	 */
	private function add_related_books_fields() {

		$this->add_related_books_field( 'vocabulary_book', 'Vocabulary', 'Notional Components' );
		//$this->add_related_books_field( 'general_notions_book', 'General Notions', 'Notional Components' );
		//$this->add_related_books_field( 'specific_notions_book', 'Specific Notions', 'Notional Components' );

		$this->add_related_books_field( 'grammar_book', 'Grammar', 'Grammatical Components' );
		$this->add_related_books_field( 'phonetics_spelling_book', 'Phonetics and Spelling', 'Grammatical Components' );
		//$this->add_related_books_field( 'spelling_book', 'Spelling', 'Grammatical Components' );

		$this->add_related_books_field( 'texts_functions_book', 'Texts and Functions', 'Pragmatic Components' );
		//$this->add_related_books_field( 'tactics_book', 'Tactics and Pragmatic Strategies', 'Pragmatic Components' );
		//$this->add_related_books_field( 'texts_book', 'Texts', 'Pragmatic Components' );

		//$this->add_related_books_field( 'cultural_components_book', 'Cultural Components', 'Cultural Components' );
		//$this->add_related_books_field( 'cultural_references_book', 'Cultural References', 'Cultural Components' );
		//$this->add_related_books_field( 'cultural_behaviours_book', 'Cultural Behaviours', 'Cultural Components' );
		//$this->add_related_books_field( 'cultural_habits_book', 'Cultural Habits', 'Cultural Components' );

		$this->add_related_books_field( 'extra_content_book', 'Extra Content' );

	}

	/**
	 * Prints the opening part of a field group, in the dashboard.
	 *
	 * @since 0.1
	 * @param string $field_slug  The slug/id of the field.
	 * @param object $field       The field object.
	 * @param string $object_type What object type is the field associated with.
	 */
	public static function print_dashboard_group_opening( $field_slug, $field, $object_type ) {
		?><fieldset><legend><?php
		echo $field->label;
		?></legend><?php
	}

	/**
	 * Prints the closing part of a field group, in the dashboard.
	 *
	 * @since 0.1
	 * @param string $field_slug  The slug/id of the field.
	 * @param object $field       The field object.
	 * @param string $object_type What object type is the field associated with.
	 */
	public static function print_dashboard_group_closing( $field_slug, $field, $object_type ) {
		?></fieldset><?php
	}

	/**
	 * Generates an array with the fields to be added to the dashboard, in the “General Book Information” page.
	 *
	 * @since  0.1
	 * @return array The generated array.
	 */
	public function get_related_books_fields_for_dashboard() {

		$fields = array();
		foreach ( $this->related_book_fields as $key => $val ) {
			if ( array_key_exists( $key, $this->related_book_groups ) ) {
				// we are in a group
				$fields[$this->slug_prefix . $key] = array(
					'group' => $this->metabox_name,
					'display_callback' => 'Pressbooks_Metadata_Metadata_Related_Books::print_dashboard_group_opening',
					'label' => $this->related_book_groups[$key]
				);
				foreach ( $val as $field_key => $field_val ) {
					$fields[$this->slug_prefix . $field_key] = $field_val;
				}
				$fields[$this->slug_prefix . $key . '-closing'] = array(
					'group' => $this->metabox_name,
					'display_callback' => 'Pressbooks_Metadata_Metadata_Related_Books::print_dashboard_group_closing'
				);
			}
			else {
				// field without group
				$fields[$this->slug_prefix . $key] = $val;
			}
		}

		return $fields;

	}

	/**
	 * Adds the actual fields to the related books field list, at chapter level (button for enabling the related books).
	 *
	 * @since  0.1
	 */
	private function add_related_books_chapter_enable() {

		$this->chapter_metadata['use_related_books-metabox'] = array(
			'is_group' => true,
			'label' => 'Related Books',
			'context' => 'side'
		);

		$this->chapter_metadata['use_related_books'] = array(
			'group' => 'use_related_books-metabox',
			'field_type' => 'checkbox',
			'label' => 'Enable “Related Books” Button',
			'separated' => true
		);

	}

	/**
	 * Generates an array with the fields to be added to the dashboard, in the “Chapter” page.
	 *
	 * @since  0.1
	 * @return array The generated array.
	 */
	public function get_related_books_chapter_fields_for_dashboard() {

		return $this->chapter_metadata;

	}

	/**
	 * Generates an array with the values of the fields containing the slugs to related books.
	 *
	 * @since  0.1
	 * @return array The generated array.
	 */
	private function get_current_book_metadata_values() {

		$ret = array();
		$raw_meta = Pressbooks_Metadata_Metadata_Fetcher::fetch_book_metadata();
		foreach ( $this->related_book_fields as $key => $val ) {
			if ( preg_match( '/-group$/', $key ) ) {
				foreach ( $val as $f_key => $f_val ) {
					if ( array_key_exists( $this->slug_prefix . $f_key, $raw_meta ) ) {
						$elt = $raw_meta[$this->slug_prefix . $f_key];
						if ( is_array( $elt ) ) {
							continue;
						}
						$ret[$f_key] = $elt;
					}
				}
			} else {
				if ( array_key_exists( $this->slug_prefix . $key, $raw_meta ) ) {
					$elt = $raw_meta[$this->slug_prefix . $key];
					if ( is_array( $elt ) ) {
						continue;
					}
					$ret[$key] = $elt;
				}
			}
		}

		return $ret;

	}

	/**
	 * Replaces the book slug of the current URL with another one.
	 *
	 * @since  0.1
	 * @param  string $new_book_slug The slug of the book to put in the URL.
	 * @return string The current URL (starting with /), with the book slug replaced.
	 */
	private function other_book_url( $new_book_slug ) {

		$book_home_uri = get_blog_details()->path;
		$page_base_uri = $_SERVER['REQUEST_URI'];
		$page_relative_uri = str_replace( $book_home_uri, '', $page_base_uri );
		$new_book_home_uri = preg_replace( '!/[^/]+/$!', '/' . $new_book_slug . '/', $book_home_uri );

		return $new_book_home_uri . $page_relative_uri;

	}

	/**
	 * Checks if the “Related Books” option is enabled for the current page.
	 *
	 * @since 0.1
	 * @return string True if the option is enabled, false otherwise.
	 */
	public function are_related_books_enabled() {

		$chapter_information = Pressbooks_Metadata_Metadata_Fetcher::fetch_chapter_metadata();
		if ( ! isset( $chapter_information[$this->slug_prefix . 'use_related_books'] ) ) {
			return false;
		}
		return $chapter_information[$this->slug_prefix . 'use_related_books'];

	}

	/**
	 * Prints the links (HTML code) to related books for the public part of the book.
	 *
	 * @since 0.1
	 */
	public function print_related_books_fields_for_public() {

		$meta_values = $this->get_current_book_metadata_values();
		?><ul><?php
		foreach ( $this->related_book_fields as $key => $val ) {
			if ( array_key_exists( $key, $this->related_book_groups ) ) {
				// we are in a group
				$group_name_printed = false;
				foreach ( $val as $field_key => $field_val ) {
					if ( isset( $meta_values[$field_key] ) && ! empty( $meta_values[$field_key] ) ) {
						if ( ! $group_name_printed ) {
							?><li><?php
							echo $this->related_book_groups[$key];
							?><ul><?php
							$group_name_printed = true;
						}
						?><a href="<?php echo $this->other_book_url( $meta_values[$field_key] ); ?>">
							<?php echo $field_val['label']; ?></a><?php
					}
				}
				if ( $group_name_printed ) {
					?></ul></li><?php
				}
			}
			else {
				// field without group
				if ( isset( $meta_values[$field_key] ) && ! empty( $meta_values[$field_key] ) ) {
					?><li><a href="<?php echo $this->other_book_url( $meta_values[$key] ); ?>">
						<?php echo $val['label']; ?></a></li><?php
				}
			}
		}
		?></ul><?php

	}

}
