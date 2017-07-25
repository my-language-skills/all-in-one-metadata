<?php

namespace schemaTypes\cw;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;

/**
 * The class for the message section type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Message{

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

	public function __construct($type_level_input) {
		$this->type_level = $type_level_input;
		$this->pmdt_add_metabox($this->type_level);
		$this->class_name = __CLASS__ .'_'. $this->type_level;
	}

	/**
	 * The function which produces the metaboxes for the message type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position){
		//----------- metabox ----------- //
		x_add_metadata_group( 	'message', $meta_position, array(
			'label' 		=>	'Message Type Properties',
			'priority' 		=>	'high',
		) );
		//----------- metafields ----------- //
		// Date Read
		x_add_metadata_field( 	'pb_date_read_'.$meta_position, $meta_position, array(
			'group' 		=>	'message',
			'label' 		=>	'Date Read',
			'description' 	=>	'The date/time at which the message has been read by the recipient if a single recipient exists.'
		) );
		// Date Received
		x_add_metadata_field( 	'pb_date_received_'.$meta_position, $meta_position, array(
			'group' 		=>	'message',
			'label' 		=>	'Date Received',
			'description' 	=>	'The date/time the message was received if a single recipient exists.'
		) );
		// Date Sent
		x_add_metadata_field( 	'pb_date_sent_'.$meta_position, $meta_position, array(
			'group' 		=>	'message',
			'label' 		=>	'Date Sent',
			'description' 	=>	'The date/time at which the message was sent.'
		) );
		// Message Attachment
		x_add_metadata_field( 	'pb_message_attachment_'.$meta_position, $meta_position, array(
			'group' 		=>	'message',
			'label' 		=>	'Message Attachment',
			'description' 	=>	'A CreativeWork attached to the message.'
		) );
		// Recipient
		x_add_metadata_field( 	'pb_recipient_'.$meta_position, $meta_position, array(
			'group' 		=>	'message',
			'label' 		=>	'Recipient',
			'description' 	=>	'A sub property of participant. The participant who is at the receiving end of the action.'
		) );
		// Sender
		x_add_metadata_field( 	'pb_sender_'.$meta_position, $meta_position, array(
			'group' 		=>	'message',
			'label' 		=>	'Sender',
			'description' 	=>	'A sub property of participant. The participant who is at the sending end of the action.'
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
	public function pmdt_parent_init(){
		return new Pressbooks_Metadata_Creative_Work($this->type_level);
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
	 * A function needed for the array of metadata that comes from each post or chapter
	 * It automatically returns the first item in the array.
	 * @since 0.8.1
	 *
	 */
	private function pmdt_get_first($my_array){
		return $my_array[0];
	}

	/**
	 * A function that creates the metadata for the Message Section type.
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
		$message_data = array(

			'dateRead' => 'pb_date_read',
			'dateReceived' => 'pb_date_received',
			'dateSent' => 'pb_date_sent',
			'messageAttachment' => 'pb_message_attachment',
			'recipient' => 'pb_recipient',
			'sender' => 'pb_sender'
		);

		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/Message">';

		foreach ( $message_data as $itemprop => $content ) {
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