<?php

namespace schemaTypes\cw;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;
use schemaTypes\Pressbooks_Metadata_Type;

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

class Pressbooks_Metadata_Message extends Pressbooks_Metadata_Type {

	public function __construct($type_level_input) {
		parent::__construct($type_level_input);
		$this->class_name = __CLASS__ .'_'. $this->type_level;
		$this->type_settings = array('message_type' => array('Message Type','http://schema.org/Message'));
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