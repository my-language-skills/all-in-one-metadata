<?php

namespace schemaTypes\cw;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;
use schemaTypes\Pressbooks_Metadata_Type;

/**
 * The class for the publication issue type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Publication_Issue extends Pressbooks_Metadata_Type {

	public function __construct($type_level_input) {
	parent::__construct($type_level_input);
	$this->class_name = __CLASS__ .'_'. $this->type_level;
	$this->type_settings = array('publicationIssue_type' => array('Publication Issue Type','http://schema.org/PublicationIssue'));
	$this->parent_type = new Pressbooks_Metadata_Creative_Work($this->type_level);
	$this->pmdt_add_metabox($this->type_level);
}

	/**
	 * Function used for comparing the instances of the schema types
	 *
	 * @since    0.x
	 * @access   public
	 */
	public function __toString() {
		return $this->class_name;
	}

	/**
	 * The function which produces the metaboxes for the publication issue type
	 *
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 *
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox( $meta_position ) {
		//----------- metabox ----------- //
		x_add_metadata_group( 'publication-issue', $meta_position, array(
			'label'    => 'Publication Issue Type Properties',
			'priority' => 'high',
		) );
		//----------- metafields ----------- //
		// Issue Number
		x_add_metadata_field( 'pb_issue_number_' . $meta_position, $meta_position, array(
			'group'       => 'publication-issue',
			'label'       => 'Issue Number',
			'description' => 'Identifies the issue of publication; for example, "iii" or "2".'
		) );
		// Page End
		x_add_metadata_field( 'pb_page_end_' . $meta_position, $meta_position, array(
			'group'       => 'publication-issue',
			'label'       => 'Page End',
			'description' => 'The page on which the work ends; for example "138" or "xvi".'
		) );
		// Page Start
		x_add_metadata_field( 'pb_page_start_' . $meta_position, $meta_position, array(
			'group'       => 'publication-issue',
			'label'       => 'Page Start',
			'description' => 'The page on which the work starts; for example "135" or "xiii".'
		) );
		// Pagination
		x_add_metadata_field( 'pb_pagination_' . $meta_position, $meta_position, array(
			'group'       => 'publication-issue',
			'label'       => 'Pagination',
			'description' => 'Any description of pages that is not separated into pageStart and pageEnd; for example, "1-6, 9, 55" or "10-12, 46-49".'
		) );

	}

	/**
	 * A function that creates the metadata for the Publication Issue type.
	 * @since 0.8.1
	 *
	 */
	public function pmdt_get_metatags() {
		//Distinguishing if we are working on a post --- chapter level or on the main site level
		//The type_level variable is the string we used to create the metabox

		$is_site; // This bool var is used to identify if the level is site level or any other post level
		if ( $this->type_level == 'metadata' || $this->type_level == 'site-meta' ) { //loading the appropriate metadata depending on the type level
			$metadata = gen_func::get_metadata();
			$is_site  = true;
		} else {
			$is_site  = false;
			$metadata = get_post_meta( get_the_ID() );
		}

		// array of the items needed to become microtags
		$publication_data = array(

			'issueNumber' => 'pb_issue_number',
			'pageEnd' => 'pb_page_end',
			'pageStart' => 'pb_page_start',
			'pagination' => 'pb_pagination'

		);

		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/PublicationIssue">';

		foreach ( $publication_data as $itemprop => $content ) {
			if ( isset( $metadata[ $content . '_' . $this->type_level ] ) ) {

				if ( ! $is_site ) { //we are using the get_first function to get the value from the returned array
					$value = $this->pmdt_get_first( $metadata[ $content . '_' . $this->type_level ] );
				} else {
					if ( $this->type_level == 'site-meta' ) {
						$value = $this->pmdt_get_first( $metadata[ $content . '_' . $this->type_level ] );
					} else {//We always use the get_first function except if our level is metadata coming from pressbooks
						$value = $metadata[ $content . '_' . $this->type_level ];
					}
				}
				$html .= "<meta itemprop = '" . $itemprop . "' content = '" . $value . "'>\n";
			}
		}
		$html .= '</div>';

		return $html;
	}
}