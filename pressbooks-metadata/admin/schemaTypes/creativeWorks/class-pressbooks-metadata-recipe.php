<?php

namespace schemaTypes\cw;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;

/**
 * The class for the recipe type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Recipe{

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
	 * The function which produces the metaboxes for the recipe type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position){
		//----------- metabox ----------- //
		x_add_metadata_group( 	'recipe', $meta_position, array(
			'label' 		=>	'Recipe Properties',
			'priority' 		=>	'high',
		) );
		//----------- metafields ----------- //
		// Cook Time
		x_add_metadata_field( 	'pb_cook_time_'.$meta_position, $meta_position, array(
			'group' 		=> 	'recipe',
			'label' 		=> 	'Cook Time',
			'description'	=>	'The time it takes to actually cook the dish, in ISO 8601 duration format.'
		) );
		// Cooking Method
		x_add_metadata_field( 	'pb_cooking_method_'.$meta_position, $meta_position, array(
			'group' 		=> 	'recipe',
			'label' 		=> 	'Cooking Method',
			'description'	=>	'The method of cooking, such as Frying, Steaming, ...'
		) );
		// Nutrition
		x_add_metadata_field( 	'pb_nutrition_'.$meta_position, $meta_position, array(
			'group' 		=> 	'recipe',
			'label' 		=> 	'Nutrition',
			'description'	=>	'Nutrition information about the recipe or menu item.'
		) );
		// Prep Time
		x_add_metadata_field( 	'pb_prep_time_'.$meta_position, $meta_position, array(
			'group' 		=> 	'recipe',
			'label' 		=> 	'Prep Time',
			'description'	=>	'The length of time it takes to prepare the recipe, in ISO 8601 duration format.'
		) );
		// Recipe Category
		x_add_metadata_field( 	'pb_recipe_category_'.$meta_position, $meta_position, array(
			'group' 		=> 	'recipe',
			'label' 		=> 	'Recipe Category',
			'description'	=>	'The category of the recipe—for example, appetizer, entree, etc.'
		) );
		// Recipe Cuisine
		x_add_metadata_field( 	'pb_recipe_cuisine_'.$meta_position, $meta_position, array(
			'group' 		=> 	'recipe',
			'label' 		=> 	'Recipe Cuisine',
			'description'	=>	'The cuisine of the recipe (for example, French or Ethiopian).'
		) );
		// Recipe Ingredient
		x_add_metadata_field( 	'pb_recipe_ingredient_'.$meta_position, $meta_position, array(
			'group' 		=> 	'recipe',
			'label' 		=> 	'Recipe Ingredient',
			'description'	=>	'A single ingredient used in the recipe, e.g. sugar, flour or garlic. Supersedes ingredients.'
		) );
		// Recipe Instructions
		x_add_metadata_field( 	'pb_recipe_instructions_'.$meta_position, $meta_position, array(
			'group' 		=> 	'recipe',
			'label' 		=> 	'Recipe Instructions',
			'description'	=>	'A step or instruction involved in making the recipe.'
		) );
		// Recipe Yield
		x_add_metadata_field( 	'pb_recipe_yield_'.$meta_position, $meta_position, array(
			'group' 		=> 	'recipe',
			'label' 		=> 	'Recipe Yield',
			'description'	=>	'The quantity produced by the recipe (for example, number of people served, number of servings, etc).'
		) );
		// Suitable For Diet
		x_add_metadata_field( 	'pb_suitable_for_diet_'.$meta_position, $meta_position, array(
			'group' 		=> 	'recipe',
			'label' 		=> 	'Suitable For Diet',
			'description'	=>	'Indicates a dietary restriction or guideline for which this recipe or menu item is suitable, e.g. diabetic, halal etc.'
		) );
		// Total Time
		x_add_metadata_field( 	'pb_total_time_'.$meta_position, $meta_position, array(
			'group' 		=> 	'recipe',
			'label' 		=> 	'Total Time',
			'description'	=>	'The total time it takes to prepare and cook the recipe, in ISO 8601 duration format.'
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
	 * A function that creates the metadata for the Recipe type.
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
		$recipe_data = array(

			'cookTime' => 'pb_cook_time',
			'cookingMethod' => 'pb_cooking_method',
			'nutrition' => 'pb_nutrition',
			'prepTime' => 'pb_prep_time',
			'recipeCategory' => 'pb_recipe_category',
			'recipeCuisine' => 'pb_recipe_cuisine',
			'recipeIngredient' => 'pb_recipe_ingredient',
			'recipeInstructions' => 'pb_recipe_instructions',
			'recipeYield' => 'pb_recipe_yield',
			'suitableForDiet' => 'pb_suitable_for_diet',
			'totalTime' => 'pb_total_time'

		);

		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/Recipe">';

		foreach ( $recipe_data as $itemprop => $content ) {
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