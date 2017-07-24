<?php

namespace vocabularyFunctions;

/**
 * The functions of the plugin that manage other vocabularies.
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/vocabularyFunctions
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Nicole Acuña      <@nicoleacuna>
 */

class Pressbooks_Metadata_VC_Functions {

	function __construct() {

	}

	/**
	 * This function is used to output the dublin core vocabulary metadata.
	 * @since    0.9
	 */
	public static function get_dublin_core(){
		//TODO Review and change the fields where data comes from
		//We take the information of fields created in book info
		$metadata =  \Pressbooks\Book::getBookInformation();
		// title
		$html = "<!-- Dublin Core metatags -->\n";
		// link to DC schema
		$html .="<link rel='schema.DC' href='http://purl.org/dc/elements/1.1/' />";
		//We walk the array and for each element we see if it matches the fields that we want to visualize
		foreach ( $metadata as $key => $val ) {
			//contributor
			if($key == 'pb_illustrator_metadata'){
				$html .="<meta name='DC.contributor' content='" .$val. "'/>";
			}
			//coverage
			if($key == 'pb_edition_metadata'){
				$html .="<meta name='DC.coverage' content='" .$val. "'/>";
			}
			//provider
			if($key == 'pb_provider_metadata'){
				$html .="<meta name='DC.publisher' content='" .$val. "' />";
			}
			//audience
			if($key == 'pb_age_range_metadata'){
				$html .="<meta name='DC.audience' content='" .$val. "'/>";
			}
			//relation
			if($key == 'pb_learning_resource_type_metadata'){
				$html .="<meta name='DC.relation' content='" .$metadata['pb_learning_resource_type_chapter']. "'/>";
			}
			//relation
			if($key == 'pb_interactivity_type_metadata'){
				$html .="<meta name='DC.relation' content='" .$val. "'/>";
			}
			//coverage
			if($key == 'pb_time_required_metadata'){
				$html .="<meta name='DC.coverage' content='" .$val. "'/>";
			}
			//rights
			if($key == 'pb_license_url_metadata'){
				$html .="<meta name='DC.rights' content='" .$val. "' />";
			}
			//identifier
			if($key == 'pb_bibliography_url_metadata'){
				$html .="<meta name='DC.identifier' content='" .$val. "' />";
			}
			//identifier
			if($key == 'pb_questions_and_answers_metadata'){
				$html .="<meta name='DC.identifier' content='" .$val. "' />";
			}
		}
		return $html;
	}

	/**
	 * This function is used to output the coins vocabulary metadata.
	 * @since    0.x
	 */
	public static function get_coins(){
		//TODO Review and change the fields where data comes from
		//we take url of web site
		$URL = get_permalink();
		//take information of post metadata
		$metadata =  \Pressbooks\Book::getBookInformation();
		$content = "<!-- Coins metatags -->\n";
		//create a coinsTitle
		$coinsTitle = 'ctx_ver=Z39.88-2004'

		              . '&amp;rft_val_fmt=info%3Aofi%2Ffmt%3Akev%3Amtx%3Adc'
		              . '&amp;rfr_id=info:sid/en.wikipedia.org:'
		              . '&amp;rft.type='
		              . '&amp;rft.format=text';
		//We walk the array and for each element we see if it matches the fields that we want to visualize
		foreach ( $metadata as $key => $val ) {
			// title and site title
			if($key == 'pb_title'){
				$coinsTitle .= '&amp;rft.title='. urlencode($val) ;
				$coinsTitle .= '&amp;rft.source='. urlencode(get_the_title() . '|' . get_bloginfo( '  name' ));
			}
			//author
			if($key == 'pb_author'){
				$coinsTitle .= '&amp;rft.au='. urlencode($val);
			}
			//language
			if($key== 'pb_language'){
				$coinsTitle .= '&amp;rft.language='. urlencode($val);
			}
			//pending publisher
			if($key == 'pb_provider_metadata'){
				$coinsTitle .= '&amp;rft.pub='. urlencode( $val);
			}
			//pending genre
			if($key == 'pb_learning_resource_type_metadata'){
				$coinsTitle .= '&amp;rft.genre='. urlencode( $val );
			}
			//problems to visualizate date
			if($key == 'pb_publication_date'){
				//$v= CAST($val AS DATETIME);
				//$coinsTitle .= '&amp;rft.date='. the_time('Y-m-d');
			}
		}
		//URL web site
		$coinsTitle .= '&amp;rft.identifier='. urlencode( $URL);
		$content .= '<span class="Z3988" title="' . esc_html( $coinsTitle ) . '"></span>' ;
		return $content;
	}
}

