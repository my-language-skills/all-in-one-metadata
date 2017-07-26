<?php

namespace schemaTypes\cw;
use schemaFunctions\Pressbooks_Metadata_General_Functions as gen_func;
use adminFunctions\Pressbooks_Metadata_Site_Cpt as site_cpt;

/**
 * The class for the creativeWork type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.8.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_Creative_Work {

	/**
	 * The type level where these metaboxes and their schema operations will go
	 *
	 * @since    0.9
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
		$this->add_metabox($this->type_level);
		$this->class_name = __CLASS__ .'_'. $this->type_level;
	}

	/**
	 * The function which produces the metaboxes for creative work
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 * The value passed here is also used when calling the metadata functions in the header and the footer.
	 * @since 0.8.1
	 */
	private function add_metabox($meta_position){

		//----------- metabox ----------- //

		x_add_metadata_group( 	'CreativeWork', $meta_position, array(
			'label' 		=>	'Creative Work Type Properties',
			'priority' 		=>	'high',
		) );

		//----------- metafields ----------- //

		// Provider
		x_add_metadata_field( 	'pb_provider_'.$meta_position, $meta_position, array(
			'group' 		=>	'CreativeWork',
			'label' 		=>	'Provider',
			'description' 	=>	'The Organization, University or Person who provides this subject.'
		) );

		// Age Range
		x_add_metadata_field( 	'pb_age_range_'.$meta_position, $meta_position, array(
			'group' 		=> 	'CreativeWork',
			'field_type' 	=> 	'select',
			'values' 		=> 	array(
				'18-' 		=> 	'Adults',
				'17-18'		=> 	'17-18 years',
				'16-17' 	=> 	'16-17 years',
				'15-16' 	=> 	'15-16 years',
				'14-15' 	=> 	'14-15 years',
				'13-14' 	=> 	'13-14 years',
				'12-13' 	=> 	'12-13 years',
				'11-12' 	=> 	'11-12 years',
				'10-11' 	=> 	'10-11 years',
				'9-10'  	=> 	 '9-10 years',
				'8-9'  		=> 	  '8-9 years',
				'7-8'  		=> 	  '7-8 years',
				'6-7'  		=> 	  '6-7 years',
				'3-5'	  	=> 	  '3-5 years'
			),
			'label'	 			=> 	'Age Range',
			'description'	 	=> 	'The target age of this book',
		) );

		// Class Learning Time
		x_add_metadata_field( 	'pb_time_required_'.$meta_position, $meta_position, array(
			'group' 		=> 	'CreativeWork',
			'field_type'	=> 	'number',
			'label' 		=> 	'Class Learning Time (hours)',
			'description' 	=> 	'The study time required for the book'
		) );

		// License URL
		x_add_metadata_field( 	'pb_license_url_'.$meta_position, $meta_position, array(
			'group' 		=> 	'CreativeWork',
			'label' 		=> 	'License URL',
			'description' 	=> 	'The url of the website with the license of this book.',
			'placeholder' 	=>	'http://site.com/'
		) );

		// About
		x_add_metadata_field(  'pb_about_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'About',
			'description' => 	'The subject matter of the content.'
		) );


		// Access Mode
		x_add_metadata_field(  'pb_accessMode_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Access Mode',
			'description' => 	'The human sensory perceptual system or cognitive faculty through which a person may process or perceive information. Expected values include: auditory, 							tactile, textual, visual, colorDependent, chartOnVisual, chemOnVisual, diagramOnVisual, mathOnVisual, musicOnVisual, textOnVisual.'
		) );

		// Access Mode Sufficient
		x_add_metadata_field(  'pb_accessModeSufficient_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Access Mode Sufficient',
			'description' => 	'A list of single or combined accessModes that are sufficient to understand all the intellectual content of a resource. Expected values include: auditory, 							tactile, textual, visual.'
		) );


		// instrument Property
		x_add_metadata_field(  'pb_award_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'award',
			'description' => 	'An award won by or for this item. Supersedes awards.'
		) );

		// location Property
		x_add_metadata_field(  'pb_brand_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'brand',
			'description' => 	'The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.'
		) );


		// Accessibility API
		x_add_metadata_field(  'pb_accessibilityAPI_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Accessibility API',
			'description' => 	'Indicates that the resource is compatible with the referenced accessibility API (WebSchemas wiki lists possible values).'
		) );


		// Accessibility Control
		x_add_metadata_field(  'pb_accessibilityControl_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Accessibility Control',
			'description' => 	'Identifies input methods that are sufficient to fully control the described resource (WebSchemas wiki lists possible values).'
		) );


		// Accessibility Feature
		x_add_metadata_field(  'pb_accessibilityFeature_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Accessibility Feature',
			'description' => 	'Content features of the resource, such as accessible media, alternatives and supported enhancements for accessibility (WebSchemas wiki lists possible values).'
		) );


		// Accessibility Hazard
		x_add_metadata_field(  'pb_accessibilityHazard_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Accessibility Hazard',
			'description' => 	'A characteristic of the described resource that is physiologically dangerous to some users. Related to WCAG 2.0 guideline 2.3 (WebSchemas wiki lists possible 						values).'
		) );


		// Accessibility Summary
		x_add_metadata_field(  'pb_accessibilitySummary_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Accessibility Summary',
			'description' => 	'A human-readable summary of specific accessibility features or deficiencies, consistent with the other accessibility metadata but expressing subtleties such as 					 "short descriptions are present but long descriptions will be needed for non-visual users" or "short descriptions are present and no long descriptions are 						needed."'
		) );


		// Accountable Person
		x_add_metadata_field(  'pb_accountablePerson_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Accountable Person',
			'description' => 	'Specifies the Person that is legally accountable for the CreativeWork.'
		) );


		// Aggregate Rating
		x_add_metadata_field(  'pb_aggregateRating_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Aggregate Rating',
			'description' => 	'The overall rating, based on a collection of reviews or ratings, of the item.'
		) );


		// Alternative Headline
		x_add_metadata_field(  'pb_alternativeHeadline_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Alternative Headline',
			'description' => 	'A secondary title of the CreativeWork.'
		) );

		// Associated Media
		x_add_metadata_field(  'pb_associatedMedia_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Associated Media',
			'description' => 	'A media object that encodes this CreativeWork. This property is a synonym for encoding.'
		) );

		// Audience
		x_add_metadata_field(  'pb_audience_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Audience',
			'description' => 	'An intended audience, i.e. a group for whom something was created. Supersedes serviceAudience.'
		) );

		// Audio
		x_add_metadata_field(  'pb_audio_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Audio',
			'description' => 	'An embedded audio object.'
		) );

		// Author
		x_add_metadata_field(  'pb_author_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Author',
			'description' => 	'The author of this content or rating. Please note that author is special in that HTML 5 provides a special mechanism for indicating authorship via the rel tag. 					  That is equivalent to this and may be used interchangeably.'
		) );

		// Award
		x_add_metadata_field(  'pb_award_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Award',
			'description' => 	'An award won by or for this item. Supersedes awards.'
		) );

		// Character
		x_add_metadata_field('pb_character_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Character',
			'description' => 	'Fictional person connected with a creative work.'
		) );


		// Citation
		x_add_metadata_field(  'pb_citation_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Citation',
			'description' => 	'A citation or reference to another creative work, such as another publication, web page, scholarly article, etc.'
		) );

		// Comment
		x_add_metadata_field(  'pb_comment_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Comment',
			'description' => 	'Comments, typically from users.'
		) );

		// Comment Count
		x_add_metadata_field(  'pb_commentCount_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Comment Count',
			'description' => 	'The number of comments this CreativeWork (e.g. Article, Question or Answer) has received. This is most applicable to works published in Web sites with 							commenting system; additional comments may exist elsewhere.'
		) );

		// Content Location
		x_add_metadata_field(  'pb_contentLocation_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Content Location',
			'description' => 	'The location depicted or described in the content. For example, the location in a photograph or painting.'
		) );

		// Content Rating
		x_add_metadata_field(  'pb_contentRating_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Content Rating',
			'description' => 	'Official rating of a piece of content—for example,\'MPAA PG-13\'.'
		) );

		// Contributor
		x_add_metadata_field(  'pb_contributor_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Contributor',
			'description' => 	'A secondary contributor to the CreativeWork or Event.'
		) );

		// Copyright Holder
		x_add_metadata_field(  'pb_copyrightHolder_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Copyright Holder',
			'description' => 	'The party holding the legal copyright to the CreativeWork.'
		) );

		// Copyright Year
		x_add_metadata_field(  'pb_copyrightYear_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Copyright Year',
			'description' => 	'The year during which the claimed copyright for the CreativeWork was first asserted.'
		) );

		// Creator
		x_add_metadata_field(  'pb_creator_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Creator',
			'description' => 	'The creator/author of this CreativeWork. This is the same as the Author property for CreativeWork.'
		) );

		// Date Created
		x_add_metadata_field(  'pb_dateCreated_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Date Created',
			'description' => 	'The date on which the CreativeWork was created or the item was added to a DataFeed.'
		) );

		// Date Modified
		x_add_metadata_field(  'pb_dateModified_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Date Modified',
			'description' => 	'The date on which the CreativeWork was most recently modified or when the item\'s entry was modified within a DataFeed.'
		) );

		// Date Published
		x_add_metadata_field(  'pb_datePublished_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Date Published',
			'description' => 	'Date of first broadcast/publication.'
		) );
		// Discussion Url
		x_add_metadata_field(  'pb_discussionUrl_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Discussion Url',
			'description' => 	'A link to the page containing the comments of the CreativeWork.',
			'placeholder' =>	'http://www.example.com'
		) );
		// Editor
		x_add_metadata_field(  'pb_editor_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Editor',
			'description' => 	'Specifies the Person who edited the CreativeWork.'
		) );
		// Educational Alignment
		x_add_metadata_field(  'pb_educationalAlignment_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Educational Alignment',
			'description' => 	'An alignment to an established educational framework.'
		) );
		// Educational Use
		x_add_metadata_field(  'pb_educationalUse_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Educational Use',
			'description' => 	'The purpose of a work in the context of education; for example, \'assignment\', \'group work\'.'
		) );
		// Encoding
		x_add_metadata_field(  'pb_encoding_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Encoding',
			'description' => 	'A media object that encodes this CreativeWork. This property is a synonym for associatedMedia. Supersedes encodings.'
		) );
		// Example Of Work
		x_add_metadata_field(  'pb_exampleOfWork_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Example Of Work',
			'description' => 	'A creative work that this work is an example/instance/realization/derivation of.
								<br>Inverse property: workExample.'
		) );
		// File Format
		x_add_metadata_field(  'pb_fileFormat_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'File Format',
			'description' => 	'Media type, typically MIME format (see IANA site) of the content e.g. application/zip of a SoftwareApplication binary. In cases where a CreativeWork has 							several media type representations, \'encoding\' can be used to indicate each MediaObject alongside particular fileFormat information. Unregistered or niche file 					formats can be indicated instead via the most appropriate URL, e.g. defining Web page or a Wikipedia entry.'
		) );
		// Funder
		x_add_metadata_field(  'pb_funder_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Funder',
			'description' => 	'A person or organization that supports (sponsors) something through some kind of financial contribution.'
		) );
		// Genre
		x_add_metadata_field(  'pb_genre_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Genre',
			'description' => 	'Genre of the creative work, broadcast channel or group.'
		) );
		// Has Part
		x_add_metadata_field(  'pb_hasPart_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Has Part',
			'description' => 	'Indicates a CreativeWork that is (in some sense) a part of this CreativeWork.
								<br>Inverse property: isPartOf.'
		) );
		// Headline
		x_add_metadata_field(  'pb_headline_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Headline',
			'description' => 	'Headline of the article.'
		) );
		// In Language
		x_add_metadata_field(  'pb_inLanguage_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'In Language',
			'description' => 	'The language of the content or performance or used in an action. Please use one of the language codes from the IETF BCP 47 standard. See also 										availableLanguage. Supersedes language.'
		) );
		// Interaction Statistic
		x_add_metadata_field(  'pb_interactionStatistic_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Interaction Statistic',
			'description' => 	'The number of interactions for the CreativeWork using the WebSite or SoftwareApplication. The most specific child type of InteractionCounter should be used. 						Supersedes interactionCount.'
		) );
		// Interactivity Type
		x_add_metadata_field(  'pb_interactivityType_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Interactivity Type',
			'description' => 	'The predominant mode of learning supported by the learning resource. Acceptable values are \'active\', \'expositive\', or \'mixed\'.'
		) );
		// Is Accessible For Free
		x_add_metadata_field(  'pb_isAccessibleForFree_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Is Accessible For Free',
			'description' => 	'A flag to signal that the publication is accessible for free. Supersedes free.'
		) );
		// Is Based On
		x_add_metadata_field(  'pb_isBasedOn_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Is Based On',
			'description' => 	'A resource that was used in the creation of this resource. This term can be repeated for multiple sources. For example, http://example.com/great-									multiplication-intro.html. Supersedes isBasedOnUrl.'
		) );
		// Is Family Friendly
		x_add_metadata_field(  'pb_isFamilyFriendly_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Is Family Friendly',
			'description' => 	'Indicates whether this content is family friendly.'
		) );
		// Is Part Of
		x_add_metadata_field(  'pb_isPartOf_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Is Part Of',
			'description' => 	'Indicates a CreativeWork that this CreativeWork is (in some sense) part of.
								<br>Inverse property: hasPart.'
		) );
		// Keywords
		x_add_metadata_field(  'pb_keywords_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Keywords',
			'description' => 	'Keywords or tags used to describe this content. Multiple entries in a keywords list are typically delimited by commas.'
		) );
		// Learning Resource Type
		x_add_metadata_field(  'pb_learningResourceType_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Learning Resource Type',
			'description' => 	'The predominant type or kind characterizing the learning resource. For example, \'presentation\', \'handout\'.'
		) );
		// Location Created
		x_add_metadata_field(  'pb_locationCreated_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Location Created',
			'description' => 	'The location where the CreativeWork was created, which may not be the same as the location depicted in the CreativeWork.'
		) );
		// Main Entity
		x_add_metadata_field(  'pb_mainEntity_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Main Entity',
			'description' => 	'Indicates the primary entity described in some page or other CreativeWork.
								<br>Inverse property: mainEntityOfPage.'
		) );
		// Material
		x_add_metadata_field(  'pb_material_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Material',
			'description' => 	'A material that something is made from, e.g. leather, wool, cotton, paper.'
		) );
		// Mentions
		x_add_metadata_field(  'pb_mentions_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Mentions',
			'description' => 	'Indicates that the CreativeWork contains a reference to, but is not necessarily about a concept.'
		) );
		// Offers
		x_add_metadata_field(  'pb_offers_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Offers',
			'description' => 	'An offer to provide this item—for example, an offer to sell a product, rent the DVD of a movie, perform a service, or give away tickets to an event.'
		) );
		// Position
		x_add_metadata_field(  'pb_position_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Position',
			'description' => 	'The position of an item in a series or sequence of items.'
		) );
		// Producer
		x_add_metadata_field(  'pb_producer_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Producer',
			'description' => 	'The person or organization who produced the work (e.g. music album, movie, tv/radio series etc.).'
		) );

		// Publication
		x_add_metadata_field(  'pb_publication_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Publication',
			'description' => 	'A publication event associated with the item.'
		) );
		// Publisher
		x_add_metadata_field(  'pb_publisher_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Publisher',
			'description' => 	'The publisher of the creative work.'
		) );
		// Publishing Principles
		x_add_metadata_field(  'pb_publishingPrinciples_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Publishing Principles',
			'description' => 	'Link to page describing the editorial principles of the organization primarily responsible for the creation of the CreativeWork.'
		) );
		// Recorded At
		x_add_metadata_field(  'pb_recordedAt_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Recorded At',
			'description' => 	'The Event where the CreativeWork was recorded. The CreativeWork may capture all or part of the event.
								<br>Inverse property: recordedIn.'
		) );
		// Released Event
		x_add_metadata_field(  'pb_releasedEvent_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Released Event',
			'description' => 	'The place and time the release was issued, expressed as a PublicationEvent.'
		) );
		// Review
		x_add_metadata_field(  'pb_review_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Review',
			'description' => 	'A review of the item. Supersedes reviews.'
		) );
		// Schema Version
		x_add_metadata_field(  'pb_schemaVersion_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Schema Version',
			'description' => 	'Indicates (by URL or string) a particular version of a schema used in some CreativeWork. For example, a document could declare a schemaVersion using an URL 						such as http://schema.org/version/2.0/ if precise indication of schema version was required by some application.'
		) );
		// Source Organization
		x_add_metadata_field(  'pb_sourceOrganization_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Source Organization',
			'description' => 	'The Organization on whose behalf the creator was working.'
		) );
		// Spatial Coverage
		x_add_metadata_field(  'pb_spatialCoverage_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Spatial Coverage',
			'description' => 	'The spatialCoverage of a CreativeWork indicates the place(s) which are the focus of the content. It is a subproperty of contentLocation intended primarily for 					more technical and detailed materials. For example with a Dataset, it indicates areas that the dataset describes: a dataset of New York weather would have 							spatialCoverage which was the place: the state of New York. Supersedes spatial.'
		) );
		// Sponsor
		x_add_metadata_field(  'pb_sponsor_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Sponsor',
			'description' => 	'A person or organization that supports a thing through a pledge, promise, or financial contribution. e.g. a sponsor of a Medical Study or a corporate sponsor 						of an event.'
		) );
		// Temporal Coverage
		x_add_metadata_field(  'pb_temporalCoverage_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Temporal Coverage',
			'description' => 	'The temporalCoverage of a CreativeWork indicates the period that the content applies to, i.e. that it describes, either as a DateTime or as a textual string 						indicating a time period in ISO 8601 time interval format. In the case of a Dataset it will typically indicate the relevant time period in a precise notation 						(e.g. for a 2011 census dataset, the year 2011 would be written "2011/2012"). Other forms of content e.g. ScholarlyArticle, Book, TVSeries or TVEpisode may 						indicate their temporalCoverage in broader terms - textually or via well-known URL. Written works such as books may sometimes have precise temporal coverage 						too, e.g. a work set in 1939 - 1945 can be indicated in ISO 8601 interval format format via "1939/1945". Supersedes datasetTimeInterval, temporal.'
		) );
		// Text
		x_add_metadata_field(  'pb_text_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Text',
			'description' => 	'The textual content of this CreativeWork.'
		) );
		// Thumbnail Url
		x_add_metadata_field(  'pb_thumbnailUrl_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Thumbnail Url',
			'description' => 	'A thumbnail image relevant to the Thing.',
			'placeholder' =>	'http://www.example.com'
		) );

		// Translator
		x_add_metadata_field(  'pb_translator_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Translator',
			'description' => 	'Organization or person who adapts a creative work to different languages, regional differences and technical requirements of a target market, or that 								translates during some event.'
		) );

		// Version
		x_add_metadata_field(  'pb_version_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Version',
			'description' => 	'The version of the CreativeWork embodied by a specified resource.'
		) );
		// Video
		x_add_metadata_field(  'pb_video_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Video',
			'description' => 	'An embedded video object.'
		) );
		// Work Example
		x_add_metadata_field(  'pb_workExample_'.$meta_position, $meta_position, array(
			'group'       =>     'CreativeWork',
			'label'       =>     'Work Example',
			'description' => 	'Example/instance/realization/derivation of the concept of this creative work. eg. The paperback edition, first edition, or eBook.
								<br>Inverse property: exampleOfWork.'
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
		return new \schemaTypes\Pressbooks_Metadata_Thing($this->type_level);
	}

	/**
	 * Returns type level.
	 *
	 * @since    0.9
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
	 * A function that creates the metadata for creative works.
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
		$CreativeWork_data = array(

			'provider'             => 'pb_provider',
			'typicalAgeRange'      => 'pb_age_range',
			'timeRequired'         => 'pb_time_required',
			'license'              => 'pb_license_url',
			'about' => 'pb_about',
			'accessMode' => 'pb_accessMode',
			'accessModeSufficient' => 'pb_accessModeSufficient',
			'accessibilityAPI' => 'pb_accessibilityAPI',
			'accessibilityControl' => 'pb_accessibilityControl',
			'accessibilityFeature' => 'pb_accessibilityFeature',
			'accessibilityHazard' => 'pb_accessibilityHazard',
			'accessibilitySummary' => 'pb_accessibilitySummary',
			'accountablePerson' => 'pb_accountablePerson',
			'aggregateRating' => 'pb_aggregateRating',
			'alternativeHeadline'  => 'pb_alternativeHeadline',
			'associatedMedia' => 'pb_associatedMedia',
			'audience' => 'pb_audience',
			'audio' => 'pb_audio',
			'author' => 'pb_author',
			'award' => 'pb_award',
			'character' => 'pb_character',
			'citation' => 'pb_citation',
			'comment' => 'pb_comment',
			'commentCount' => 'pb_commentCount',
			'contentLocation' => 'pb_contentLocation',
			'contentRating' => 'pb_contentRating',
			'contributor' => 'pb_contributor',
			'copyrightHolder' => 'pb_copyrightHolder',
			'copyrightYear' => 'pb_copyrightYear',
			'creator' => 'pb_creator',
			'dateCreated' => 'pb_dateCreated',
			'dateModified' => 'pb_dateModified',
			'datePublished' => 'pb_datePublished',
			'discussionUrl' => 'pb_discussionUrl',
			'editor' => 'pb_editor',
			'educationalAlignment' => 'pb_educationalAlignment',
			'educationalUse' => 'pb_educationalUse',
			'encoding' => 'pb_encoding',
			'exampleOfWork' => 'pb_exampleOfWork',
			'fileFormat' => 'pb_fileFormat',
			'funder' => 'pb_funder',
			'genre' => 'pb_genre',
			'hasPart' => 'pb_hasPart',
			'headline' => 'pb_headline',
			'inLanguage' => 'pb_inLanguage',
			'interactionStatistic' => 'pb_interactionStatistic',
			'interactivityType' => 'pb_interactivityType',
			'isAccessibleForFree' => 'pb_isAccessibleForFree',
			'isBasedOn' => 'pb_isBasedOn',
			'isFamilyFriendly' => 'pb_isFamilyFriendly',
			'isPartOf' => 'pb_isPartOf',
			'keywords' => 'pb_keywords',
			'learningResourceType' => 'pb_learningResourceType',
			'locationCreated' => 'pb_locationCreated',
			'mainEntity' => 'pb_mainEntity',
			'material' => 'pb_material',
			'mentions' => 'pb_mentions',
			'offers' => 'pb_offers',
			'position' => 'pb_position',
			'producer' => 'pb_producer',
			'publication' => 'pb_publication',
			'publisher' => 'pb_publisher',
			'publishingPrinciples' => 'pb_publishingPrinciples',
			'recordedAt' => 'pb_recordedAt',
			'releasedEvent' => 'pb_releasedEvent',
			'review' => 'pb_review',
			'schemaVersion' => 'pb_schemaVersion',
			'sourceOrganization' => 'pb_sourceOrganization',
			'spatialCoverage' => 'pb_spatialCoverage',
			'sponsor' => 'pb_sponsor',
			'temporalCoverage' => 'pb_temporalCoverage',
			'text' => 'pb_text',
			'thumbnailUrl' => 'pb_thumbnailUrl',
			'translator' => 'pb_translator',
			'version' => 'pb_version',
			'video' => 'pb_video',
			'workExample' => 'pb_workExample'
		);

		$html = "<!-- Microtags --> \n";
		$html .= '<body itemscope itemtype="http://schema.org/WebPage">';
		foreach ($CreativeWork_data as $itemprop => $content){
			if ( isset( $metadata[$content.'_'.$this->type_level] ) ) {

				if(!$is_site){ //we are using the get_first function to get the value from the returned array
					$value = $this->pmdt_get_first($metadata[ $content.'_'.$this->type_level ]);
				}else{
					if($this->type_level == 'site-meta'){
						$value = $this->pmdt_get_first($metadata[ $content . '_' . $this->type_level ]);
					}else{ //We always use the get_first function except if our level is metadata coming from pressbooks
						$value = $metadata[ $content . '_' . $this->type_level ];
					}
				}
				if ( 'timeRequired' == $itemprop ) { //using a special type for showing time
					$value = 'PT'. $value.'H';
				}
				$html .= "<meta itemprop = '" . $itemprop . "' content = '" . $value . "'>\n";
			}
		}

		$id = get_the_ID();

		$html 	.= "<!-- WebPage additional microtags -->\n";
		$html .= '<meta itemprop = "headline" content = "'.get_the_title($id).'">';
		$html .= '<meta itemprop = "datePublished" content = "'.get_the_date($id).'">';
		$html .= '<meta itemprop = "dateModified" content = "'.get_the_modified_date().'">';

		if(site_cpt::pressbooks_identify()){
			//For the fields from Book Info post type
			$bookinfo = \Pressbooks\Book::getBookInformation();

			$book_data = array(
				'audience'=>'pb_audience',
				'editor'=>'pb_editor',
				'translator'=>'pb_translator',
				'author'=>'pb_section_author',
				'alternativeHeadline'=>'pb_subtitle'
			);

			foreach($book_data as $itemprop => $content){
				if(isset($bookinfo[$content])){
					$html .= '<meta itemprop = "'.$bookinfo[$itemprop].'" content = "'.$bookinfo[$content].'">\n';
				}
			}
		}
		$html .= '</div>';
		return $html;
	}
}
