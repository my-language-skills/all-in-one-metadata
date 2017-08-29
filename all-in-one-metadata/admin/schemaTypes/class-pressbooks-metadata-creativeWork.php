<?php

namespace schemaTypes;

/**
 * The class for the CreativeWork type including just the properties, this type will inject properties on its child types
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.12
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_CreativeWork {

	const type_name = array('Creative Work Properties','creative_work_properties');

	const type_properties = array(
		'about' => array(false,'About','The subject matter of the content.'),
		'accessMode' => array(false,'Access Mode Sufficient','The human sensory perceptual system or cognitive faculty through which a person may process or perceive information. Expected values include: auditory, tactile, textual, visual, colorDependent, chartOnVisual, chemOnVisual, diagramOnVisual, mathOnVisual, musicOnVisual, textOnVisual.'),
		'accessModeSufficient' => array(false,'Text','A list of single or combined accessModes that are sufficient to understand all the intellectual content of a resource. Expected values include: auditory, tactile, textual, visual.'),
		'accessibilityAPI' => array(false,'Accessibility API','Indicates that the resource is compatible with the referenced accessibility API (WebSchemas wiki lists possible values).'),
		'accessibilityControl' => array(false,'Accessibility Control','The identifier property represents any kind of identifier for any kind of Thing, such as ISBNs, GTIN codes, UUIDs etc.'),
		'accessibilityFeature ' => array(false,'Accessibility Feature','Content features of the resource, such as accessible media, alternatives and supported enhancements for accessibility (WebSchemas wiki lists possible values).'),
		'accessibilityHazard ' => array(false,'Accessibility Hazard','A characteristic of the described resource that is physiologically dangerous to some users. Related to WCAG 2.0 guideline 2.3 (WebSchemas wiki lists possible values).'),
		'accessibilitySummary ' => array(false,'Accessibility Summary','A human-readable summary of specific accessibility features or deficiencies, consistent with the other accessibility metadata but expressing subtleties such as "short descriptions are present but long descriptions will be needed for non-visual users" or "short descriptions are present and no long descriptions are needed."'),
		'accountablePerson' => array(false,'Accountable Person','Specifies the Person that is legally accountable for the CreativeWork.'),
		'aggregateRating' => array(false,'Aggregate Rating','The overall rating, based on a collection of reviews or ratings, of the item.'),
		'alternativeHeadline ' => array(false,'Alternative Headline','A secondary title of the CreativeWork.'),
		'associatedMedia' => array(false,'Associated Media','A media object that encodes this CreativeWork. This property is a synonym for encoding.'),
		'audience' => array(false,'Audience','An intended audience, i.e. a group for whom something was created. Supersedes serviceAudience.'),
		'audio' => array(false,'Audio Object','An embedded audio object.'),
		'author ' => array(false,'Author','Specifies the Person that is legally accountable for the CreativeWork.'),
		'award' => array(false,'Award','An award won by or for this item. Supersedes awards.'),
		'character' => array(false,'Character','Fictional person connected with a creative work.'),
		'citation' => array(false,'Citation','Fictional person connected with a creative work.'),
		'comment' => array(false,'Comment','A media object that encodes this CreativeWork. This property is a synonym for encoding.'),
		'commentCount' => array(false,'Comment Count','The location depicted or described in the content. For example, the location in a photograph or painting.'),
		'contentLocation' => array(false,'Content Location','The number of comments this CreativeWork (e.g. Article, Question or Answer) has received. This is most applicable to works published in Web sites with commenting system; additional comments may exist elsewhere.'),
		'contentRating' => array(false,'Content Rating','The location depicted or described in the content. For example, the location in a photograph or painting.'),
		'contentReferenceTime' => array(false,'Content Reference Time','The specific time described by a creative work, for works (e.g. articles, video objects etc.) that emphasise a particular moment within an Event.'),
		'contributor'	=> array(false,'Contributor','A secondary contributor to the CreativeWork or Event.'),
		'copyrightHolder' => array(false,'Copyright Holder','The party holding the legal copyright to the CreativeWork.'),
		'copyrightYear' => array(false,'Copyright Year','The year during which the claimed copyright for the CreativeWork was first asserted.'),
		'creator' => array(false, 'Creator','The year during which the claimed copyright for the CreativeWork was first asserted.'),
		'dateCreated' => array(false,'Date Created','The date on which the CreativeWork was created or the item was added to a DataFeed.'),
		'dateModified'	=> array(false,'Date Modified','The date on which the CreativeWork was most recently modified or when the item\'s entry was modified within a DataFeed.'),
		'datePublished ' => array(false,'Date Published','Date of first broadcast/publication.'),
		'discussionUrl' => array(false,'Discussion URL','A link to the page containing the comments of the CreativeWork.'),
		'editor' => array(false, 'Editor','Specifies the Person who edited the CreativeWork.'),
		'educationalAlignment' => array(false, 'Educational Alignment','An alignment to an established educational framework.'),
		'educationalUse' => array(false,'Educational Use','The purpose of a work in the context of education; for example, \'assignment\', \'group work\'.'),
		'encoding' => array(false,'Encoding','A creative work that this work is an example/instance/realization/derivation of. Inverse property: workExample.'),
		'exampleOfWork ' => array(false,'Example Of Work ','A creative work that this work is an example/instance/realization/derivation of. Inverse property: workExample.'),
		'expires ' => array(false,'Expires','Date the content expires and is no longer useful or available. For example a VideoObject or NewsArticle whose availability or relevance is time-limited, or a ClaimReview fact check whose publisher wants to indicate that it may no longer be relevant (or helpful to highlight) after some date.'),
		'fileFormat' => array(false,'File Format','Media type, typically MIME format (see IANA site) of the content e.g. application/zip of a SoftwareApplication binary. In cases where a CreativeWork has several media type representations, \'encoding\' can be used to indicate each MediaObject alongside particular fileFormat information. Unregistered or niche file formats can be indicated instead via the most appropriate URL, e.g. defining Web page or a Wikipedia entry.'),
		'funder'	=> array(false,'Funder','A person or organization that supports (sponsors) something through some kind of financial contribution.'),
		'genre' => array(false,'Genre','Genre of the creative work, broadcast channel or group.'),
		'hasPart' => array(false,'Has Part','Indicates a CreativeWork that is (in some sense) a part of this CreativeWork.Inverse property: isPartOf.'),
		'headline' => array(false, 'Headline','Headline of the article.'),
		'inLanguage' => array(false,'In Language','The language of the content or performance or used in an action. Please use one of the language codes from the IETF BCP 47 standard. See also availableLanguage. Supersedes language.'),
		'interactionStatistic'	=> array(false,'interaction Statistic ','The number of interactions for the CreativeWork using the WebSite or SoftwareApplication. The most specific child type of InteractionCounter should be used. Supersedes interactionCount.'),
		'interactivityType' => array(false,'Interactivity Type','The predominant mode of learning supported by the learning resource. Acceptable values are \'active\', \'expositive\', or \'mixed\'.'),
		'isAccessibleForFree' => array(false,'Is Accessible For Free','A flag to signal that the item, event, or place is accessible for free. Supersedes free.'),
		'isBasedOn' => array(false, 'Is Based On','Specifies the Person who edited the CreativeWork.'),
		'isFamilyFriendly' => array(false,'Is Family Friendly','Indicates whether this content is family friendly.'),
		'isPartOf' => array(false,'Is Part Of','Indicates a CreativeWork that this CreativeWork is (in some sense) part of. Inverse property: hasPart.'),
		'keywords' => array(false,'Keywords','Keywords or tags used to describe this content. Multiple entries in a keywords list are typically delimited by commas.'),
		'learningResourceType ' => array(false,'Learning Resource Type','The predominant type or kind characterizing the learning resource. For example, \'presentation\', \'handout\'.'),
		'license' => array(false,'License','A license document that applies to this content, typically indicated by URL.'),
		'locationCreated' => array(false,'Location Created','The location where the CreativeWork was created, which may not be the same as the location depicted in the CreativeWork.'),
		'mainEntity' => array(false,'Main Entity','Indicates the primary entity described in some page or other CreativeWork.'),
		'material' => array(false,'Material','A material that something is made from, e.g. leather, wool, cotton, paper.'),
		'mentions'	=> array(false,'Mentions','Indicates that the CreativeWork contains a reference to, but is not necessarily about a concept.'),
		'offers' => array(false,'Offers','An offer to provide this item—for example, an offer to sell a product, rent the DVD of a movie, perform a service, or give away tickets to an event.'),
		'position' => array(false,'Position','The position of an item in a series or sequence of items.'),
		'producer' => array(false, 'Producer','The person or organization who produced the work (e.g. music album, movie, tv/radio series etc.).'),
		'provider' => array(false,'Provider','The service provider, service operator, or service performer; the goods producer. Another party (a seller) may offer those services or goods on behalf of the provider. A provider may also serve as the seller. Supersedes carrier.'),
		'publication' => array(false,'Publication','A publication event associated with the item.'),
		'publisher' => array(false,'Publisher','The publisher of the creative work.'),
		'publisherImprint' => array(false,'Publisher Imprint','The publishing division which published the comic.'),
		'publishingPrinciples' => array(false,'Publishing Principles','The publishingPrinciples property indicates (typically via URL) a document describing the editorial principles of an Organization (or individual e.g. a Person writing a blog) that relate to their activities as a publisher, e.g. ethics or diversity policies. When applied to a CreativeWork (e.g. NewsArticle) the principles are those of the party primarily responsible for the creation of the CreativeWork. While such policies are most typically expressed in natural language, sometimes related information (e.g. indicating a funder) can be expressed using schema.org terminology.'),
		'recordedAt' => array(false,'Recorded At','The Event where the CreativeWork was recorded. The CreativeWork may capture all or part of the event. Inverse property: recordedIn.'),
		'releasedEvent' => array(false,'Released Event','The place and time the release was issued, expressed as a PublicationEvent.'),
		'review' => array(false,'Review','A review of the item. Supersedes reviews.'),
		'schemaVersion' => array(false,'Schema Version','Indicates (by URL or string) a particular version of a schema used in some CreativeWork. For example, a document could declare a schemaVersion using an URL such as http://schema.org/version/2.0/ if precise indication of schema version was required by some application.'),
		'sourceOrganization' => array(false,'Source Organization','The Organization on whose behalf the creator was working.'),
		'spatialCoverage' => array(false,'Spatial Coverage','The spatialCoverage of a CreativeWork indicates the place(s) which are the focus of the content. It is a subproperty of contentLocation intended primarily for more technical and detailed materials. For example with a Dataset, it indicates areas that the dataset describes: a dataset of New York weather would have spatialCoverage which was the place: the state of New York. Supersedes spatial.'),
		'sponsor' => array(false,'Sponsor','A person or organization that supports a thing through a pledge, promise, or financial contribution. e.g. a sponsor of a Medical Study or a corporate sponsor of an event.'),
		'temporalCoverage' => array(false,'Temporal Coverage','The temporalCoverage of a CreativeWork indicates the period that the content applies to, i.e. that it describes, either as a DateTime or as a textual string indicating a time period in ISO 8601 time interval format. In the case of a Dataset it will typically indicate the relevant time period in a precise notation (e.g. for a 2011 census dataset, the year 2011 would be written "2011/2012"). Other forms of content e.g. ScholarlyArticle, Book, TVSeries or TVEpisode may indicate their temporalCoverage in broader terms - textually or via well-known URL. Written works such as books may sometimes have precise temporal coverage too, e.g. a work set in 1939 - 1945 can be indicated in ISO 8601 interval format format via "1939/1945". Supersedes datasetTimeInterval, temporal.'),
		'text' => array(false,'Text','The textual content of this CreativeWork.'),
		'thumbnailUrl' => array(false,'Thumbnail URL','A thumbnail image relevant to the Thing.'),
		'timeRequired' => array(false,'Time Required','Approximate or typical time it takes to work with or through this learning resource for the typical intended target audience, e.g. \'P30M\', \'P1H25M\'.'),
		'translationOfWork' => array(false,'Translation Of Work','An embedded audio object.The work that this work has been translated from. e.g. 物种起源 is a translationOf “On the Origin of Species”. Inverse property: workTranslation.'),
		'translator' => array(false,'Translator','Organization or person who adapts a creative work to different languages, regional differences and technical requirements of a target market, or that translates during some event.'),
		'typicalAgeRange' => array(false,'Typical Age Range','The typical expected age range, e.g. \'7-9\', \'11-\'.'),
		'version' => array(false,'Version','The version of the CreativeWork embodied by a specified resource.'),
		'video' => array(false,'Video','An embedded video object.'),
		'workExample' => array(false,'Comment','A media object that encodes this CreativeWork. This property is a synonym for encoding.'),
		'workTranslation' => array(false,'Work Translation','A work that is a translation of the content of this work. e.g. 西遊記 has an English workTranslation “Journey to the West”,a German workTranslation “Monkeys Pilgerfahrt” and a Vietnamese translation Tây du ký bình khảo. Inverse property: translationOfWork.')
	);
}
