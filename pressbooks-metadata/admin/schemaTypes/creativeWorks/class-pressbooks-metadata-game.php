<?php

namespace schemaTypes\cw;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;
use schemaTypes\Pressbooks_Metadata_Type;

/**
 * The class for the game type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Game extends Pressbooks_Metadata_Type {

	public function __construct($type_level_input) {
		parent::__construct($type_level_input);
		$this->class_name = __CLASS__ .'_'. $this->type_level;
		$this->type_settings = array('game_type' => array('Game Type','http://schema.org/Game'));
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
	 * The function which produces the metaboxes for the game type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position){
		//----------- metabox ----------- //
		x_add_metadata_group( 	'game', $meta_position, array(
			'label' 		=>	'Game Type Properties',
			'priority' 		=>	'high',
		) );
		//----------- metafields ----------- //
		// Character Attribute
		x_add_metadata_field( 	'pb_character_attribute_'.$meta_position, $meta_position, array(
			'group' 		=>	'game',
			'label' 		=>	'Character Attribute',
			'description' 	=>	'A piece of data that represents a particular aspect of a fictional character (skill, power, character points, advantage, disadvantage).'
		) );
		// Game Item
		x_add_metadata_field( 	'pb_game_item_'.$meta_position, $meta_position, array(
			'group' 		=>	'game',
			'label' 		=>	'Game Item',
			'description' 	=>	'An item is an object within the game world that can be collected by a player or, occasionally, a non-player character.'
		) );
		// Game Location
		x_add_metadata_field( 	'pb_game_location_'.$meta_position, $meta_position, array(
			'group' 		=>	'game',
			'label' 		=>	'Game Location',
			'description' 	=>	'Real or fictional location of the game (or part of game).'
		) );
		// Number of Players
		x_add_metadata_field( 	'pb_number_of_players_'.$meta_position, $meta_position, array(
			'group' 		=>	'game',
			'label' 		=>	'Number of Players',
			'description' 	=>	'Indicate how many people can play this game (minimum, maximum, or range).'
		) );
		// Quest
		x_add_metadata_field( 	'pb_quest_'.$meta_position, $meta_position, array(
			'group' 		=>	'game',
			'label' 		=>	'Quest',
			'description' 	=>	'The task that a player-controlled character, or group of characters may complete in order to gain a reward.'
		) );
	}

	/**
	 * A function that creates the metadata for the Game type.
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
		$game_data = array(

			'characterAttribute' => 'pb_character_attribute',
			'gameItem' => 'pb_game_item',
			'gameLocation' => 'pb_game_location',
			'numberOfPlayers' => 'pb_number_of_players',
			'quest' => 'pb_quest',
		);
		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/Game">';

		foreach ( $game_data as $itemprop => $content ) {
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
