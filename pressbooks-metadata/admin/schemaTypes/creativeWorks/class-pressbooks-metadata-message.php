<?php

namespace schemaTypes\cw;
use schemaFunctions\Pressbooks_Metadata_Create_Metabox as create_metabox;
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
	 * @since    0.x
	 * @access   public
	 */
	const type_setting = array('message_type' => array('Message Type','http://schema.org/Message'));

	/**
	 * The variable that holds the properties of this schema type
	 *
	 * @since    0.x
	 * @access   public
	 */
	const type_properties = array(
		'dateRead' => array(true,'Date Read','The date/time at which the message has been read by the recipient if a single recipient exists.'),
		'dateReceived' => array(false,'Date Received','The date/time the message was received if a single recipient exists.'),
		'dateSent' => array(false,'Date Sent','The date/time at which the message was sent.'),
		'messageAttachment' => array(false,'Message Attachment','A CreativeWork attached to the message.'),
		'recipient' => array(false,'Recipient','A sub property of participant. The participant who is at the receiving end of the action.'),
		'sender' => array(false,'Sender','A sub property of participant. The participant who is at the sending end of the action.')
	);

	public function __construct($type_level_input) {
		parent::__construct($type_level_input);
		$this->type_fields = self::type_properties;
		$this->class_name = __CLASS__ .'_'. $this->type_level;
		//$this->parent_type = new Pressbooks_Metadata_Creative_Work($this->type_level);
		$this->pmdt_populate_names(self::type_setting);
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
	 * The function which produces the metaboxes for the book type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position) {
		new create_metabox($this->typeName,$this->typeDisplayName,$meta_position,$this->type_fields,NULL);
	}

	/**
	 * A function that creates the metadata for the book type.
	 * @since 0.8.1
	 *
	 */
	public function pmdt_get_metatags() {
		//Creating microtags
		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/Message">';

		foreach ( $this->type_fields as $itemprop => $details ) {
			$propName = strtolower('pb_' . $itemprop . '_' . $this->type_level);
			if ($this->pmdt_prop_run($itemprop)) {
				$value = $this->pmdt_get_value($propName);
				if(!empty($value)){$html .= "<meta itemprop = '" . $itemprop . "' content = '" . $value . "'>\n";}
			}
		}
		$html .= '</div>';
		return $html;
	}
}