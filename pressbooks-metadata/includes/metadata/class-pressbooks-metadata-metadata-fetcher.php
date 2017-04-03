<?php

/**
 * A metadata querying and fetching.
 *
 * @link       http://on-lingua.com
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata
 */

/**
 * A metadata querying and fetching.
 *
 * Fetches any useful metadata (installation, book, chapter, …).
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata
 * @author     julienCXX <software@chmodplusx.eu>
 */
class Pressbooks_Metadata_Metadata_Fetcher {

	/**
	 * No instance creation.
	 */
	private function __construct() {}


	/**
	 * Fetches the metadata for the current post.
	 *
	 * @since  0.1
	 * @param  string $type The post type.
	 * @return array  The list of fetched metadata.
	 */
	private static function fetch_metadata( $type ) {

		$args = array(
			'post_type' => $type,
			'post_per_page' => 1,
			'post_status' => 'publish',
			'orderby' => 'modified',
			'no_found_rows' => true,
			'cache_results' => true
		);
		$wpq = new \WP_Query();
		$res = $wpq->query( $args );

		if ( empty( $res ) ) {
			return array();
		}

		return get_post_meta( $res[0]->ID );

	}

	/**
	 * Fetches the metadata for the current post. Cleans some data types (boolean, array with one element).
	 *
	 * @since  0.1
	 * @param  string $type The post type.
	 * @return array  The list of fetched metadata.
	 */
	private static function fetch_clean_metadata( $type ) {

		$meta = Pressbooks_Metadata_Metadata_Fetcher::fetch_metadata( $type );

		foreach ( $meta as $key => &$value ) {
			if ( ! is_array( $value ) ) {
				continue;
			}
			// unarray if there is only one element
			if ( 1 == count( $value ) ) {
				$value = trim( $value[0] );
				// remove empty elements
				if ( empty( $value ) ) {
					unset( $meta[$key] ) ;
					continue;
				}
				// checkbox boolean conversion
				if ( 'on' == $value ) {
					$value = true;
				} elseif ( 'off' == $value ) {
					$value = false;
				}
			}
		}

		return $meta;

	}

	/**
	 * Fetches the metadata for the current post and removes a prefix if
	 * present.
	 *
	 * @since  0.1
	 * @param  string $type   The post type.
	 * @param  string $prefix The prefix to remove.
	 * @return array  The list of fetched metadata.
	 */
	public static function fetch_unprefixed_metadata( $type, $prefix = '' ) {

		$res = Pressbooks_Metadata_Metadata_Fetcher::fetch_metadata( $type );
		$ret = array();
		$pat_len = strlen( $prefix );

		if ( 0 == $pat_len ) {
			return $res;
		}

		$pattern = '/^' . $prefix . '/';

		foreach ( $res as $key => $val ) {
			if ( preg_match( $pattern, $key ) ) {
				$n_key = substr( $key, $pat_len );
				$ret[ $n_key ] = $val;
			}
		}

		return $ret;

	}

	/**
	 * Fetches the book related metadata for the current book.
	 *
	 * @since  0.1
	 * @return array The list of fetched metadata.
	 */
	public static function fetch_book_metadata() {

		return Pressbooks_Metadata_Metadata_Fetcher::fetch_clean_metadata( 'metadata' );

	}

	/**
	 * Fetches the chapter related metadata for the current chapter.
	 *
	 * @since  0.1
	 * @return array The list of fetched metadata.
	 */
	public static function fetch_chapter_metadata() {

		return Pressbooks_Metadata_Metadata_Fetcher::fetch_clean_metadata( 'chapter' );

	}

}
