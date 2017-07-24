<?php

namespace schemaTypes\action;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;

/**
 * The class for the Action type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Action {

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
	 * @since    0.x
	 * @access   public
	 */
	public $class_name;

	public function __construct($type_level_input) {
		$this->type_level = $type_level_input;
		$this->pmdt_add_metabox($this->type_level);
		$this->class_name = __CLASS__ .'_'. $this->type_level;
	}
	/**
	 * The function which produces the metaboxes for the action type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position){
		//----------- metabox ----------- //
		x_add_metadata_group(  'Action', $meta_position, array(
			'label'       => 'Action Type Properties',
			'priority'        => 'high',
		) );
		//----------- metafields ----------- //
		// [schemaprop]
		
		// actionStatus Property
		x_add_metadata_field(  'pb_actionStatus_'.$meta_position, $meta_position, array(
			'group'       =>     'Action',
			'label'       =>     'actionStatus',
			'description' => 	'Indicates the current disposition of the Action.'
		) );
		
		// agent Property
		x_add_metadata_field(  'pb_agent_'.$meta_position, $meta_position, array(
			'group'       =>     'Action',
			'label'       =>     'agent',
			'description' => 	'The direct performer or driver of the action (animate or inanimate). e.g. John wrote a book.'
		) );
		
		
		// endTime Property
		x_add_metadata_field(  'pb_endTime_'.$meta_position, $meta_position, array(
			'group'       =>     'Action',
			'label'       =>     'endTime',
			'description' => 	'The endTime of something. For a reserved event or service (e.g. FoodEstablishmentReservation), the time that it is expected to end. For actions that span a period of time, when the action was performed. e.g. John wrote a book from January to December.'
		) );
		
		// error Property
		x_add_metadata_field(  'pb_error_'.$meta_position, $meta_position, array(
			'group'       =>     'Action',
			'label'       =>     'error',
			'description' => 	'For failed actions, more information on the cause of the failure.'
		) );
		
		
		// instrument Property
		x_add_metadata_field(  'pb_instrument_'.$meta_position, $meta_position, array(
			'group'       =>     'Action',
			'label'       =>     'instrument',
			'description' => 	'The object that helped the agent perform the action. e.g. John wrote a book with a pen.'
		) );
		
		// location Property
		x_add_metadata_field(  'pb_location_'.$meta_position, $meta_position, array(
			'group'       =>     'Action',
			'label'       =>     'location',
			'description' => 	'The location of for example where the event is happening, an organization is located, or where an action takes place.'
		) );
		
		
		// object Property
		x_add_metadata_field(  'pb_object_'.$meta_position, $meta_position, array(
			'group'       =>     'Action',
			'label'       =>     'object',
			'description' => 	'The object upon which the action is carried out, whose state is kept intact or changed. Also known as the semantic roles patient, affected or undergoer (which change their state) or theme (which doesn\'t). e.g. John read a book.'
		) );
		
		
		// participant Property
		x_add_metadata_field(  'pb_participant_'.$meta_position, $meta_position, array(
			'group'       =>     'Action',
			'label'       =>     'participant',
			'description' => 	'Other co-agents that participated in the action indirectly. e.g. John wrote a book with Steve.'
		) );
		
		
		// result Property
		x_add_metadata_field(  'pb_result_'.$meta_position, $meta_position, array(
			'group'       =>     'Action',
			'label'       =>     'result',
			'description' => 	'The result produced in the action. e.g. John wrote a book.'
		) );
		
		
		// startTime Property
		x_add_metadata_field(  'pb_startTime_'.$meta_position, $meta_position, array(
			'group'       =>     'Action',
			'label'       =>     'startTime',
			'description' => 	'The startTime of something. For a reserved event or service (e.g. FoodEstablishmentReservation), the time that it is expected to start. For actions that span a period of time, when the action was performed. e.g. John wrote a book from January to December.'
		) );
		
		
		// target Property
		x_add_metadata_field(  'pb_target_'.$meta_position, $meta_position, array(
			'group'       =>     'Action',
			'label'       =>     'target',
			'description' => 	'Indicates a target EntryPoint for an Action.'
		) );
	}

	/* FUNCTIONS FOR THIS TYPE START HERE */

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
	 * Returns the father for the type.
	 *
	 * @since    0.x
	 * @access   public
	 */
	public function pmdt_parent_init(){
		// We don't need this function because we are not dealing with the parents of the types right now.
		//return new Pressbooks_Metadata_[schema-parent-type]($this->type_level);
	}

	/**
	 * Returns type level.
	 *
	 * @since    0.x
	 * @access   public
	 */
	public function pmdt_get_type_level(){
		return $this->type_level;
	}

	/**
	 * A function needed for the array of metadata that comes from each post site-meta cpt or chapter
	 * It automatically returns the first item in the array.
	 * @since 0.8.1
	 *
	 */
	private function pmdt_get_first($my_array){
		return $my_array[0];
	}

	/**
	 * A function that creates the metadata for the action type.
	 * @since 0.8.1
	 *
	 */
	public function pmdt_get_metatags() {
		//Distinguishing if we are working on a post --- chapter level or on the main site level
		//The type_level variable is the string we used to create the metabox

		$is_site; // This bool var is used to identify if the level is site level or any other post level
		if ( $this->type_level == 'metadata' || $this->type_level == 'site-meta' ) { //loading the appropriate metadata depending on the type level
			$metadata = gen_func::get_metadata();
			$is_site = true;
		} else {
			$is_site = false;
			$metadata = get_post_meta( get_the_ID() );
		}

		// array of the items needed to become microtags
		$Action_data = array(

			'actionStatus' => 'pb_actionStatus',
			'agent' => 'pb_agent',
			'endTime' => 'pb_endTime',
			'error' => 'pb_error',
			'instrument' => 'pb_instrument',
			'location' => 'pb_location',
			'object' => 'pb_object',
			'participant' => 'pb_participan',
			'result' => 'pb_result',
			'startTime' => 'pb_startTime',
			'target' => 'pb_target'
		);

		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/Action">';

		foreach ( $Action_data as $itemprop => $content ) {
			if ( isset( $metadata[ $content . '_' . $this->type_level ] ) ) {

				if ( !$is_site ) { //we are using the get_first function to get the value from the returned array
					$value = $this->pmdt_get_first( $metadata[ $content . '_' . $this->type_level ] );
				} else {
					if($this->type_level == 'site-meta'){
						$value = $this->pmdt_get_first($metadata[ $content . '_' . $this->type_level ]);
					}else{//We always use the get_first function except if our level is metadata coming from pressbooks
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