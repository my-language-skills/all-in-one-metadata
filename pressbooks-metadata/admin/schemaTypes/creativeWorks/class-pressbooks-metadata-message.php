<?php

namespace schemaTypes\cw;
use schemaTypes;
use schemaTypes\Pressbooks_Metadata_Type;

/**
 * The class for the message type including operations and metaboxes
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

	/**
	 * The variable that holds the values for the settings for this schema type
	 *
	 * @since    0.10
	 * @access   public
	 */
	static $type_setting = array('message_type' => array('Message Type','http://schema.org/Message'));

	/**
	 * The variable that holds the parents for the type
	 *
	 * @since    0.10
	 * @access   public
	 */
	static $type_parents = array(
		'schemaTypes\Pressbooks_Metadata_Thing',
		'schemaTypes\Pressbooks_Metadata_CreativeWork'
	);

	/**
	 * The variable that holds the properties of this schema type
	 *
	 * @since    0.10
	 * @access   public
	 */
	static $type_properties = array(
		'dateRead' => array(true,'Date Read','The date/time at which the message has been read by the recipient if a single recipient exists.'),
		'dateReceived' => array(false,'Date Received','The date/time the message was received if a single recipient exists.'),
		'dateSent' => array(false,'Date Sent','The date/time at which the message was sent.'),
		'messageAttachment' => array(false,'Message Attachment','A CreativeWork attached to the message.'),
		'recipient' => array(false,'Recipient','A sub property of participant. The participant who is at the receiving end of the action.'),
		'sender' => array(false,'Sender','A sub property of participant. The participant who is at the sending end of the action.')
	);

	public function __construct($type_level_input) {
		parent::__construct($type_level_input);
		$this->type_fields = $this->get_all_properties();
		$this->class_name = __CLASS__ .'_'. $this->type_level;
		$this->pmdt_populate_names(self::$type_setting);
		$this->pmdt_add_metabox($this->type_level);
	}

	/**
	 * Function used for combining the current types properties with its parents fields
	 *
	 * @since    0.10
	 * @access   public
	 */
	public function get_all_properties() {
		$properties = self::$type_properties;
		foreach(self::$type_parents as $parentType){
			$properties = array_merge($properties,$parentType::type_properties);
		}
		return $properties;
	}

	/**
	 * Function used for comparing the instances of the schema types
	 *
	 * @since    0.10
	 * @access   public
	 */
	public function __toString() {
		return $this->class_name;
	}
}