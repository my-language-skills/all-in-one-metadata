<?php

/**
 * The related books (book and chapter level)  metadata included by this plugin.
 *
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/actual-metadata/concrete-metadata
 */

require_once plugin_dir_path( __FILE__ )
. '../class-pressbooks-metadata-plugin-metadata.php';

/**
 * The related books (book and chapter level)  metadata included by this plugin.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/actual-metadata/concrete-metadata
 * @author     julienCXX <software@chmodplusx.eu>
 */
class Pressbooks_Metadata_Related_Books_Metadata extends Pressbooks_Metadata_Plugin_Metadata {

	/**
	 * The class instance.
	 *
	 * @since  0.1
	 * @access private
	 * @var    Pressbooks_Metadata_Plugin_Metadata $instance The class instance.
	 */
	private static $instance = NULL;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  0.1
	 */
	protected function __construct() {

		parent::__construct();

		// Book part
		$book_meta = new Pressbooks_Metadata_Meta_Box(
			'Related Books',
			'The books (one per content type) that are meant to '
			. 'be linked with this one.',
			'related-books-slugs' );
		$book_meta->add_post_type( 'metadata' );

		$not_com = new Pressbooks_Metadata_Field_Group( 'Notional Components',
			'', 'notional-components' );
		$not_com->add_field( new Pressbooks_Metadata_Text_Field( 'Vocabulary',
			'', 'vocabulary_book' ) );
		/*
		$not_com->add_field( new Pressbooks_Metadata_Text_Field(
			'General Notions', '', 'general_notions_book' ) );
		$not_com->add_field( new Pressbooks_Metadata_Text_Field(
			'Specific Notions', '', 'specific_notions_book' ) );
		 */
		$book_meta->add_field( $not_com );

		$gram_com = new Pressbooks_Metadata_Field_Group(
			'Grammatical Components', '', 'grammatical-components'
		);
		$gram_com->add_field( new Pressbooks_Metadata_Text_Field(
			'Grammar', '', 'grammar_book' ) );
		$gram_com->add_field( new Pressbooks_Metadata_Text_Field(
			'Phonetics and Spelling', '', 'phonetics_spelling_book'
		) );
		/*
		$gram_com->add_field( new Pressbooks_Metadata_Text_Field(
			'Spelling', '', 'spelling_book' ) );
		*/
		$book_meta->add_field( $gram_com );

		$prag_com = new Pressbooks_Metadata_Field_Group(
			'Pragmatic Components', '', 'pragmatic-components' );
		$prag_com->add_field( new Pressbooks_Metadata_Text_Field(
			'Texts and Functions', '', 'texts_functions_book' ) );
		/*
		$prag_com->add_field( new Pressbooks_Metadata_Text_Field(
			'Tactics and Pragmatic Strategies', '', 'tactics_book'
		) );
		$prag_com->add_field( new Pressbooks_Metadata_Text_Field(
			'Texts', '', 'texts_book' ) );
		*/
		$book_meta->add_field( $prag_com );

		/*
		$cult_com = new Pressbooks_Metadata_Field_Group(
			'Cultural Components', '', 'cultural-components' );
		$cult_com->add_field( new Pressbooks_Metadata_Text_Field(
			'Cultural Components', '', 'cultural_components_book'
		) );
		$cult_com->add_field( new Pressbooks_Metadata_Text_Field(
			'Cultural References', '', 'cultural_references_book'
		) );
		$cult_com->add_field( new Pressbooks_Metadata_Text_Field(
			'Cultural Behaviours', '', 'cultural_behaviours_book',
		) );
		$cult_com->add_field( new Pressbooks_Metadata_Text_Field(
			'Cultural Habits', '', 'cultural_habits_book',
		) );
		$book_meta->add_field( $cult_com );
		*/

		$book_meta->add_field( new Pressbooks_Metadata_Text_Field(
			'Extra Content', '', 'extra_content_book' ) );

		$this->add_component( $book_meta );

		// Chapter part
		$chap_meta = new Pressbooks_Metadata_Meta_Box(
			'Related Books', '',
			'use-related-books', false, 'side' );
		$chap_meta->add_post_type( 'chapter' );

		$chap_meta->add_field( new Pressbooks_Metadata_Checkbox_Field(
			'Enable “Related Books” Button', '', 'use_related_books'
		) );

		$this->add_component( $chap_meta );

	}

	/**
	 * Returns the class instance.
	 *
	 * @since  0.1
	 * @return Pressbooks_Metadata_Book_Metadata The class instance.
	 */
	public static function get_instance() {

		if ( NULL == Pressbooks_Metadata_Related_Books_Metadata::$instance ) {
			Pressbooks_Metadata_Related_Books_Metadata::$instance
				= new Pressbooks_Metadata_Related_Books_Metadata();
		}
		return Pressbooks_Metadata_Related_Books_Metadata::$instance;

	}

	/**
	 * Checks if the “Related Books” option is enabled for the current page.
	 *
	 * @since 0.1
	 * @return boolean true if the option is enabled, false otherwise.
	 */
	public function are_related_books_enabled() {

		$meta = $this->get_current_metadata_flat();
		if ( ! isset( $meta['use_related_books'] ) ) {
			return false;
		}
		return $meta['use_related_books'];

	}

	/**
	 * Replaces the book slug of the current URL with another one.
	 *
	 * @since  0.1
	 * @param  string $new_book_slug The slug of the book to put in the URL.
	 * @return string The current URL (starting with /), with the book slug
	 * replaced.
	 */
	private function other_book_url( $new_book_slug ) {

		$book_home_uri = get_blog_details()->path;
		$page_base_uri = $_SERVER['REQUEST_URI'];
		$page_relative_uri
			= str_replace( $book_home_uri, '', $page_base_uri );
		$new_book_home_uri = preg_replace( '!/[^/]+/$!', '/'
			. $new_book_slug . '/', $book_home_uri );

		return $new_book_home_uri . $page_relative_uri;

	}

	/**
	 * Prints the links (HTML code) to related books for the public part of
	 * the book.
	 *
	 * @since 0.1
	 */
	public function print_related_books_fields() {

		$meta = $this->get_current_metadata();
		if ( ! array_key_exists( 'related-books-slugs', $meta ) ) {
			return;
		}
		$slugs = &$meta['related-books-slugs'];

		?><ul><?php
		foreach ( $slugs->get_fields() as $key => $val ) {
			if ( $val->is_group_of_fields() ) {
				// we are in a group
				?><li><?php
				echo $val->get_name();
				?><ul><?php
				foreach ( $val->get_fields()
					as $field_key => $field_val ) {
					?><a href="<?php
					echo $this->other_book_url(
					$field_val->get_value() ); ?>">
					<?php
					echo $field_val->get_name(); ?></a><?php
				}
				?></ul></li><?php
			}
			else {
				// field without group
				?><li><a href="<?php
					echo $this->other_book_url(
						$val->get_value() ); ?>">
				<?php echo $val->get_name(); ?></a></li><?php
			}
		}
		?></ul><?php

	}

}

