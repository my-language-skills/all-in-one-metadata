<?php

/**
 * Includes all the existing concrete metadata field classes.
 *
 * @since      0.1
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata
 */

require_once( plugin_dir_path( __FILE__ )
. 'components/class-pressbooks-metadata-meta-box.php' );

require_once( plugin_dir_path( __FILE__ )
. 'components/fields/class-pressbooks-metadata-field-group.php' );

foreach( glob( plugin_dir_path( __FILE__ )
	. 'components/fields/data-fields/concrete-fields/*.php' )
	as $file ) {
	require_once( $file );
}
