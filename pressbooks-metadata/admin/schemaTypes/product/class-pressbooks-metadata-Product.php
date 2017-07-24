<?php

namespace schemaTypes\product;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;

/**
 * The class for the product type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Product {

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
	 * The function which produces the metaboxes for the product type
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function pmdt_add_metabox($meta_position){
		//----------- metabox ----------- //
		x_add_metadata_group(  'Product', $meta_position, array(
			'label'       => 'Product Type Properties',
			'priority'        => 'high',
		) );
		//----------- metafields ----------- //
		// [schemaprop]
		
		// actionStatus Property
		x_add_metadata_field(  'pb_additionalProperty_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'additionalProperty',
			'description' => 	'A property-value pair representing an additional characteristics of the entitity, e.g. a product feature or another characteristic for which there is no matching property in schema.org.'
		) );
		
		
		// endTime Property
		x_add_metadata_field(  'pb_aggregateRating_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'aggregateRating',
			'description' => 	'The overall rating, based on a collection of reviews or ratings, of the item.'
		) );
		
		// error Property
		x_add_metadata_field(  'pb_audience_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'audience',
			'description' => 	'An intended audience, i.e. a group for whom something was created. Supersedes serviceAudience.'
		) );
		
		
		// instrument Property
		x_add_metadata_field(  'pb_award_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'award',
			'description' => 	'An award won by or for this item. Supersedes awards.'
		) );
		
		// location Property
		x_add_metadata_field(  'pb_brand_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'brand',
			'description' => 	'The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.'
		) );
		
		
		// object Property
		x_add_metadata_field(  'pb_category_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'category',
			'description' => 	'A category for the item. Greater signs or slashes can be used to informally indicate a category hierarchy.'
		) );
		
		
		// participant Property
		x_add_metadata_field(  'pb_depth_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'depth',
			'description' => 	'The depth of the item.'
		) );
		
		
		// result Property
		x_add_metadata_field(  'pb_gtin12_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'gtin12',
			'description' => 	'The GTIN-12 code of the product, or the product to which the offer refers. The GTIN-12 is the 12-digit GS1 Identification Key composed of a U.P.C. Company Prefix, Item Reference, and Check Digit used to identify trade items. See GS1 GTIN Summary for more details.'
		) );
		
		
		// startTime Property
		x_add_metadata_field(  'pb_gtin13_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'gtin13',
			'description' => 	'The GTIN-13 code of the product, or the product to which the offer refers. This is equivalent to 13-digit ISBN codes and EAN UCC-13. Former 12-digit UPC codes can be converted into a GTIN-13 code by simply adding a preceeding zero. See GS1 GTIN Summary for more details.'
		) );
		
		
		// target Property
		x_add_metadata_field(  'pb_gtin14_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'gtin14',
			'description' => 	'The GTIN-14 code of the product, or the product to which the offer refers. See GS1 GTIN Summary for more details.'
		) );
		
		
			// target Property
		x_add_metadata_field(  'pb_gtin8_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'gtin8',
			'description' => 	'The GTIN-8 code of the product, or the product to which the offer refers. This code is also known as EAN/UCC-8 or 8-digit EAN. See GS1 GTIN Summary for more details.'
		) );
		
		
			// target Property
		x_add_metadata_field(  'pb_height_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'height',
			'description' => 	'The height of the item.'
		) );
		
		
			// target Property
		x_add_metadata_field(  'pb_isAccessoryOrSparePartFor_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'isAccessoryOrSparePartFor',
			'description' => 	'A pointer to another product (or multiple products) for which this product is an accessory or spare part.'
		) );
		
			// target Property
		x_add_metadata_field(  'pb_isConsumableFor_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'isConsumableFor',
			'description' => 	'A pointer to another product (or multiple products) for which this product is a consumable.'
		) );
		
			// target Property
		x_add_metadata_field(  'pb_isRelatedTo_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'isRelatedTo',
			'description' => 	'A pointer to another, somehow related product (or multiple products).'
		) );
		
			// target Property
		x_add_metadata_field(  'pb_isSimilarTo_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'isSimilarTo',
			'description' => 	'A pointer to another, functionally similar product (or multiple products).'
		) );
		
			// target Property
		x_add_metadata_field(  'pb_itemCondition_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'itemCondition',
			'description' => 	'A predefined value from OfferItemCondition or a textual description of the condition of the product or service, or the products or services included in the offer.'
		) );
		
			// target Property
		x_add_metadata_field(  'pb_logo_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'logo',
			'description' => 	'An associated logo.'
		) );
		
			// target Property
		x_add_metadata_field('pb_manufacturer_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'manufacturer',
			'description' => 	'The manufacturer of the product.'
		) );
		
		
					// target Property
		x_add_metadata_field(  'pb_material_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'material',
			'description' => 	'A material that something is made from, e.g. leather, wool, cotton, paper.'
		) );
		
						// target Property
		x_add_metadata_field(  'pb_model_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'model',
			'description' => 	'The model of the product. Use with the URL of a ProductModel or a textual representation of the model identifier. The URL of the ProductModel can be from an external source. It is recommended to additionally provide strong product identifiers via the gtin8/gtin13/gtin14 and mpn properties.'
		) );
		
						// target Property
		x_add_metadata_field(  'pb_mpn_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'mpn',
			'description' => 	'The Manufacturer Part Number (MPN) of the product, or the product to which the offer refers.'
		) );
		
						// target Property
		x_add_metadata_field(  'pb_offers_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'offers',
			'description' => 	'An offer to provide this item—for example, an offer to sell a product, rent the DVD of a movie, perform a service, or give away tickets to an event.'
		) );
		
						// target Property
		x_add_metadata_field(  'pb_productID_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'productID',
			'description' => 	'The product identifier, such as ISBN. For example: meta itemprop="productID" content="isbn:123-456-789".'
		) );
		
						// target Property
		x_add_metadata_field(  'pb_productionDate_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'productionDate',
			'description' => 	'The date of production of the item, e.g. vehicle.'
		) );
		
						// target Property
		x_add_metadata_field(  'pb_purchaseDate_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'purchaseDate',
			'description' => 	'The date the item e.g. vehicle was purchased by the current owner.'
		) );
		
						// target Property
		x_add_metadata_field(  'pb_releaseDate_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'releaseDate',
			'description' => 	'The release date of a product or product model. This can be used to distinguish the exact variant of a product.'
		) );
		
						// target Property
		x_add_metadata_field(  'pb_review_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'review',
			'description' => 	'A review of the item. Supersedes reviews.'
		) );
		
						// target Property
		x_add_metadata_field(  'pb_sku_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'sku',
			'description' => 	'The Stock Keeping Unit (SKU), i.e. a merchant-specific identifier for a product or service, or the product to which the offer refers.'
		) );
		
						// target Property
		x_add_metadata_field(  'pb_weight_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'weight',
			'description' => 	'The weight of the product or person.'
		) );
		
						// target Property
		x_add_metadata_field(  'pb_width_'.$meta_position, $meta_position, array(
			'group'       =>     'Product',
			'label'       =>     'width',
			'description' => 	'The width of the item.'
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
	 * A function that creates the metadata for the product type.
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
		$Product_data = array(

			'additionalProperty' => 'pb_additionalProperty',
			'aggregateRating' => 'pb_aggregateRating',
			'audience' => 'pb_audience',
			'award' => 'pb_award',
			'brand' => 'pb_brand',
			'category' => 'pb_category',
			'color' => 'pb_color',
			'depth' => 'pb_depth',
			'gtin12' => 'pb_gtin12',
			'gtin13' => 'pb_gtin13',
			'gtin14'  => 'pb_gtin14',
			'gtin8' => 'pb_gtin8',
			'height' => 'pb_height',
			'isAccessoryOrSparePartFor' => 'pb_isAccessoryOrSparePartFor',
			'isConsumableFor' => 'pb_isConsumableFor',
			'isRelatedTo' => 'pb_isRelatedTo',
			'isSimilarTo' => 'pb_isSimilarTo',
			'itemCondition' => 'pb_itemCondition',
			'logo' => 'pb_logo',
			'manufacturer' => 'pb_manufacturer',
			'material' => 'pb_material',
			'model' => 'pb_model',
			'mpn' => 'pb_mpn',
			'offers' => 'pb_offers',
			'productID' => 'pb_productID',
			'productionDate' => 'pb_productionDate',
			'purchaseDate' => 'pb_purchaseDate',
			'releaseDate' => 'pb_releaseDate',
			'review' => 'pb_review',
			'sku' => 'pb_sku',
			'weight' => 'pb_weight',
			'width' => 'pb_width',
		);

		$html = "<!-- Microtags --> \n";

		$html .= '<div itemscope itemtype="http://schema.org/Product">';

		foreach ( $Product_data as $itemprop => $content ) {
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