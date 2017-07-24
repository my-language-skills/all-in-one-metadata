<?php

namespace schemaTypes\cw;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;

/**
 * The class for the question type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Question {

	/**
	 * The type level where these metaboxes and their schema operations will go
	 *
	 * @since    0.x
	 * @access   private
	 */
	private $type_level;

	/**
	 * The name of the class along with the type_level
	 * Used to identify each type differently so we can eliminate parent types not needed
	 *
	 * @since    0.9
	 * @access   public
	 */
	public $class_name;

	public function __construct( $type_level_input ) {
		$this->type_level = $type_level_input;
		$this->pmdt_add_metabox( $this->type_level );
		$this->class_name = __CLASS__ . '_' . $this->type_level;
	}

	/**
	 * The function which produces the metaboxes for the question type
	 *
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 *
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox( $meta_position ) {
		//----------- metabox ----------- //
		x_add_metadata_group( 'question', $meta_position, array(
			'label'    => 'Question Properties',
			'priority' => 'high',
		) );
		//----------- metafields ----------- //
		// Accepted Answer
		x_add_metadata_field( 'pb_accepted_answer_' . $meta_position, $meta_position, array(
			'group'       => 'question',
			'label'       => 'Accepted Answer',
			'description' => 'The answer that has been accepted as best, typically on a Question/Answer site. Sites vary in their selection mechanisms, e.g. drawing on community opinion and/or the view of the Question author.'
		) );
		// Answer Count
		x_add_metadata_field( 'pb_answer_count_' . $meta_position, $meta_position, array(
			'group'       => 'question',
			'label'       => 'Answer Count',
			'description' => 'The number of answers this question has received.'
		) );
		// Down Vote Count
		x_add_metadata_field( 'pb_down_vote_count_' . $meta_position, $meta_position, array(
			'group'       => 'question',
			'label'       => 'Down Vote Count',
			'description' => 'The number of downvotes this question, answer or comment has received from the community.'
		) );
		// Suggested Answer
		x_add_metadata_field( 'pb_suggested_answer_' . $meta_position, $meta_position, array(
			'group'       => 'question',
			'label'       => 'Suggested Answer',
			'description' => 'An answer (possibly one of several, possibly incorrect) to a Question, e.g. on a Question/Answer site.'
		) );
		// Up Vote Count
		x_add_metadata_field( 'pb_up_vote_count_' . $meta_position, $meta_position, array(
			'group'       => 'question',
			'label'       => 'Up Vote Count',
			'description' => 'The number of upvotes this question, answer or comment has received from the community.'
		) );
	}

	/*FUNCTIONS FOR THIS TYPE START HERE*/

	/**
	 * Function used for comparing the instances of the schema types
	 *
	 * @since    0.9
	 * @access   public
	 */
	public function __toString() {
		return $this->class_name;
	}

	/**
	 * Returns the father for the type.
	 *
	 * @since    0.9
	 * @access   public
	 */
	public function pmdt_parent_init() {
		return new Pressbooks_Metadata_Creative_Work( $this->type_level );
	}

	/**
	 * Returns type level.
	 *
	 * @since    0.x
	 * @access   public
	 */
	public function pmdt_get_type_level() {
		return $this->type_level;
	}

	/**
	 * A function needed for the array of metadata that comes from each post or chapter
	 * It automatically returns the first item in the array.
	 * @since 0.8.1
	 *
	 */
	private function pmdt_get_first( $my_array ) {
		return $my_array[0];
	}

	/**
	 * A function that creates the metadata for the Question type.
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
		$question_data = array(

			'acceptedAnswer' => 'pb_accepted_answer',
			'answerCount' => 'pb_answer_count',
			'downvoteCount' => 'pb_down_vote_count',
			'suggestedAnswer' => 'pb_suggested_answer',
			'upvoteCount' => 'pb_up_vote_count'

		);

		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/Question">';

		foreach ( $question_data as $itemprop => $content ) {
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