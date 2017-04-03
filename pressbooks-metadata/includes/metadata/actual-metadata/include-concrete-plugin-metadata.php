<?php

/**
 * Includes all the existing concrete classes for metadata provided by this
 * plugin.
 *
 * @since      0.1
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/actual-metadata
 */

foreach( glob( plugin_dir_path( __FILE__ )
	. 'concrete-metadata/*.php' )
	as $file ) {
	require_once( $file );
}
