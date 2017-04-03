<?php

/**
 * A list field containing a list of languages.
 *
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields/data-fields/concrete-fields
 */

require_once plugin_dir_path( __FILE__ ) . 'class-pressbooks-metadata-list-field.php';

/**
 * A list field containing a list of languages.
 *
 * Puts some languages before others.
 * The others languages are sorted alphabetically.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/components/fields/data-fields/concrete-fields
 * @author     julienCXX <software@chmodplusx.eu>
 */
class Pressbooks_Metadata_Language_List_Field extends Pressbooks_Metadata_List_Field {

	/**
	 * The languages with an high priority (always displayed on top).
	 *
	 * @since  0.1
	 * @access private
	 * @var    array   $high_pri_languages The languages with an high
	 * priority.
	 */
	private static $high_pri_languages = array (
		'vlc' => 'Valencian'
	);

	/**
	 * The languages with a low priority (displayed after the high priority
	 * ones).
	 *
	 * @since  0.1
	 * @access private
	 * @var    array   $low_pri_languages The languages with a low priority.
	 */
	private static $low_pri_languages = array (
		'bg' => 'Bulgarian',
		'hr' => 'Croatian',
		'cs' => 'Czech',
		'nl' => 'Dutch',
		'en' => 'English',
		'et' => 'Estonian',
		'fi' => 'Finnish',
		'fr' => 'French',
		'de' => 'German',
		'el' => 'Greek',
		'hu' => 'Hungarian',
		'ga' => 'Irish',
		'it' => 'Italian',
		'lv' => 'Latvian',
		'lt' => 'Lithuanian',
		'mt' => 'Maltese',
		'pl' => 'Polish',
		'pt' => 'Portuguese',
		'ro' => 'Romanian',
		'sk' => 'Slovak',
		'sl' => 'Slovene',
		'es' => 'Spanish',
		'sv' => 'Swedish'
	);

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  0.1
	 * @param  string          $name          The field's name.
	 * @param  string          $desc          The field's description.
	 * @param  string          $slug          The field's slug. If no slug
	 * is given, it will be generated from the name.
	 * @param  string          $suffix        A suffix to append to the
	 * field's slug.
	 * @param  string          $disp_callback The callback used to display
	 * the field in the dashboard. Should be a static function.
	 * @param  string          $itemprop      The field's Microdata itemprop
	 * attibute.
	 * @throws DomainException If both the name and slug are empty (unable
	 * to generate a valid slug).
	 */
	public function __construct( $name, $desc = '', $slug = '',
		$suffix = '', $disp_callback = '', $itemprop = '' ) {

		$values = array_merge( array(),
			Pressbooks_Metadata_Language_List_Field::$high_pri_languages );

		// TODO: handle sort on localized language names
		$values = array_merge( $values,
			Pressbooks_Metadata_Language_List_Field::$low_pri_languages );

		parent::__construct( $name, $desc, $slug, $suffix,
			$disp_callback, 'en', $values, $itemprop );

	}

}
