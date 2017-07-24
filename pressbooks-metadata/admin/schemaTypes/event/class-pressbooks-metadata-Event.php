<?php

namespace schemaTypes\event;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;

/**
 * The class for the event type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Event {

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
	 * The function which produces the metaboxes for the event type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position){
		//----------- metabox ----------- //
		x_add_metadata_group(  'Event', $meta_position, array(
			'label'       => 'Event Type Properties',
			'priority'        => 'high',
		) );
		//----------- metafields ----------- //
		// [schemaprop]
		
		// actionStatus Property
		x_add_metadata_field(  'pb_about_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'about',
			'description' => 	'The subject matter of the content.'
		) );
		
		// agent Property
		x_add_metadata_field(  'pb_actor_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'actor',
			'description' => 	'An actor, e.g. in tv, radio, movie, video games etc., or in an event. Actors can be associated with individual items or with a series, episode, clip. Supersedes actors.'
		) );
		
		
		// endTime Property
		x_add_metadata_field(  'pb_aggregateRating_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'aggregateRating',
			'description' => 	'The overall rating, based on a collection of reviews or ratings, of the item.'
		) );
		
		// error Property
		x_add_metadata_field(  'pb_attendee_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'attendee',
			'description' => 	'A person or organization attending the event. Supersedes attendees.'
		) );
		
		
		// instrument Property
		x_add_metadata_field(  'pb_audience_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'audience',
			'description' => 	'An intended audience, i.e. a group for whom something was created. Supersedes serviceAudience.'
		) );
		
		// location Property
		x_add_metadata_field(  'pb_composer_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'composer',
			'description' => 	'The person or organization who wrote a composition, or who is the composer of a work performed at some event.'
		) );
		
		
		// object Property
		x_add_metadata_field(  'pb_contributor_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'contributor',
			'description' => 	'A secondary contributor to the CreativeWork or Event.'
		) );
		
		
		// participant Property
		x_add_metadata_field(  'pb_director_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'director',
			'description' => 	'A director of e.g. tv, radio, movie, video gaming etc. content, or of an event. Directors can be associated with individual items or with a series, episode, clip. Supersedes directors.'
		) );
		
		
		// result Property
		x_add_metadata_field(  'pb_doorTime_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'doorTime',
			'description' => 	'The time admission will commence.'
		) );
		
		
		// startTime Property
		x_add_metadata_field(  'pb_duration_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'duration',
			'description' => 	'The duration of the item (movie, audio recording, event, etc.) in ISO 8601 date format.'
		) );
		
		
		// target Property
		x_add_metadata_field(  'pb_endDate_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'endDate',
			'description' => 	'The end date and time of the item (in ISO 8601 date format).'
		) );
		
		
			// target Property
		x_add_metadata_field(  'pb_eventStatus_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'eventStatus',
			'description' => 	'An eventStatus of an event represents its status; particularly useful when an event is cancelled or rescheduled.'
		) );
		
		
			// target Property
		x_add_metadata_field(  'pb_funder_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'funder',
			'description' => 	'A person or organization that supports (sponsors) something through some kind of financial contribution.'
		) );
		
		
			// target Property
		x_add_metadata_field(  'pb_inLanguage_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'inLanguage',
			'description' => 	'The language of the content or performance or used in an action. Please use one of the language codes from the IETF BCP 47 standard. See also availableLanguage. Supersedes language.'
		) );
		
		
		// target Property
		x_add_metadata_field(  'pb_isAccessibleForFree_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'isAccessibleForFree',
			'description' => 	'A flag to signal that the publication is accessible for free. Supersedes free.'
		) );
		
		
		
		// target Property
		x_add_metadata_field(  'pb_location_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'location',
			'description' => 	'The location of for example where the event is happening, an organization is located, or where an action takes place.'
		) );
		
		
		// target Property
		x_add_metadata_field(  'pb_maximumAttendeeCapacity_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'maximumAttendeeCapacity',
			'description' => 	'The total number of individuals that may attend an event or venue.'
		) );
		
		
		// target Property
		x_add_metadata_field(  'pb_offers_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'offers',
			'description' => 	'An offer to provide this item—for example, an offer to sell a product, rent the DVD of a movie, perform a service, or give away tickets to an event.'
		) );
		
		
		// target Property
		x_add_metadata_field(  'pb_organizer_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'organizer',
			'description' => 	'An organizer of an Event.'
		) );
		
		
		// target Property
		x_add_metadata_field(  'pb_performer_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'performer',
			'description' => 	'A performer at the event—for example, a presenter, musician, musical group or actor. Supersedes performers.'
		) );
		
		
			// target Property
		x_add_metadata_field(  'pb_previousStartDate_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'previousStartDate',
			'description' => 	'Used in conjunction with eventStatus for rescheduled or cancelled events. This property contains the previously scheduled start date. For rescheduled events, the startDate property should be used for the newly scheduled start date. In the (rare) case of an event that has been postponed and rescheduled multiple times, this field may be repeated.'
		) );
		
		
			// target Property
		x_add_metadata_field(  'pb_recordedIn_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'recordedIn',
			'description' => 	'The CreativeWork that captured all or part of his Event.
								Inverse property: recordedAt.'
		) );
		
		
			// target Property
		x_add_metadata_field(  'pb_review_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'review',
			'description' => 	'	A review of the item. Supersedes reviews.'
		) );
		
		
			// target Property
		x_add_metadata_field(  'pb_sponsor_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'sponsor',
			'description' => 	'A person or organization that supports a thing through a pledge, promise, or financial contribution. e.g. a sponsor of a Medical Study or a corporate sponsor of an event.'
		) );
		
		
				// target Property
		x_add_metadata_field(  'pb_startDate_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'startDate',
			'description' => 	'The start date and time of the item (in ISO 8601 date format).'
		) );
		
		
				// target Property
		x_add_metadata_field(  'pb_subEvent_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'subEvent',
			'description' => 	'An Event that is part of this event. For example, a conference event includes many presentations, each of which is a subEvent of the conference. Supersedes subEvents.
			Inverse property: superEvent.'
		) );
		
		
				// target Property
		x_add_metadata_field(  'pb_superEvent_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'superEvent',
			'description' => 	'An event that this event is a part of. For example, a collection of individual music performances might each have a music festival as their superEvent.
			Inverse property: subEvent.'
		) );
		
		
				// target Property
		x_add_metadata_field(  'pb_translator_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'translator',
			'description' => 	'Organization or person who adapts a creative work to different languages, regional differences and technical requirements of a target market, or that translates during some event.'
		) );
		
		
					// target Property
		x_add_metadata_field(  'pb_typicalAgeRange_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'typicalAgeRange',
			'description' => 	'The typical expected age range, e.g. \'7-9\', \'11-\'.'
		) );
		
		
					// target Property
		x_add_metadata_field(  'pb_workFeatured_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'workFeatured',
			'description' => 	'	A work featured in some event, e.g. exhibited in an ExhibitionEvent. Specific subproperties are available for workPerformed (e.g. a play), or a workPresented (a Movie at a ScreeningEvent).'
		) );
		
					// target Property
		x_add_metadata_field(  'pb_workPerformed_'.$meta_position, $meta_position, array(
			'group'       =>     'Event',
			'label'       =>     'workPerformed',
			'description' => 	'A work performed in some event, for example a play performed in a TheaterEvent.'
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
	 * A function that creates the metadata for the event type.
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
		$Event_data = array(

			'about' => 'pb_about',
			'actor' => 'pb_actor',
			'aggregateRating' => 'pb_aggregateRating',
			'attendee' => 'pb_attendee',
			'audience' => 'pb_audience',
			'composer' => 'pb_composer',
			'contributor' => 'pb_contributor',
			'director' => 'pb_director',
			'doorTime' => 'pb_doorTime',
			'duration' => 'pb_duration',
			'endDate' => 'pb_endDate',
			'eventStatus' => 'pb_eventStatus',
			'funder' => 'pb_funder',
			'inLanguage' => 'pb_inLanguage',
			'isAccessibleForFree' => 'pb_isAccessibleForFree',
			'maximumAttendeeCapacity' => 'pb_maximumAttendeeCapacity',
			'offers' => 'pb_offers',
			'organizer' => 'pb_organizer',
			'performer' => 'pb_performer',
			'previousStartDate' => 'pb_previousStartDate',
			'recordedIn' => 'pb_recordedIn',
			'remainingAttendeeCapacity' => 'pb_remainingAttendeeCapacity',
			'review' => 'pb_review',
			'sponsor' => 'pb_sponsor',
			'startDate' => 'pb_startDate',
			'subEvent' => 'pb_subEvent',
			'superEvent	' => 'pb_superEvent	',
			'translator' => 'pb_translator',
			'typicalAgeRange' => 'pb_typicalAgeRange',
			'workFeatured' => 'pb_workFeatured',
			'workPerformed' => 'pb_workPerformed'
		);

		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/Event">';

		foreach ( $Event_data as $itemprop => $content ) {
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