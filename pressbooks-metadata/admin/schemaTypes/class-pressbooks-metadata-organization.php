<?php

namespace schemaTypes;

/**
 * The class for the Organization type including just the properties, this type will inject properties on its child types
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.12
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Organization {

	const type_name = array('Organization Properties','organization_properties');

	const type_properties = array(
		'actionableFeedbackPolicy' => array(false,'Actionable Feedback Policy','For a NewsMediaOrganization or other news-related Organization, a statement about public engagement activities (for news media, the newsroom’s), including involving the public - digitally or otherwise -- in coverage decisions, reporting and activities after publication.'),
		'address' => array(false,'Address','Physical address of the item.'),
		'aggregateRating' => array(false,'Aggregate Rating','The overall rating, based on a collection of reviews or ratings, of the item.'),
		'alumni' => array(false,'Alumni','Alumni of an organization. Inverse property: alumniOf.'),
		'areaServed' => array(false,'Area Served','The geographic area where a service or offered item is provided. Supersedes serviceArea.'),
		'award' => array(false,'Award','An award won by or for this item. Supersedes awards.'),
		'brand' => array(false,'Accessibility Hazard','The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.'),
		'contactPoints' => array(false,'Contact Points','A contact point for a person or organization.'),
		'correctionsPolicy' => array(false,'Correction Policy','For an Organization (e.g. NewsMediaOrganization), a statement describing (in news media, the newsroom’s) disclosure and correction policy for errors.'),
		'department' => array(false,'Department','	A relationship between an organization and a department of that organization, also described as an organization (allowing different urls, logos, opening hours). For example: a store with a pharmacy, or a bakery with a cafe.'),
		'dissolutionDate' => array(false,'Dissolution Date','The date that this organization was dissolved.'),
		'diversityPolicy' => array(false,'Diversity Policy','	Statement on diversity policy by an Organization e.g. a NewsMediaOrganization. For a NewsMediaOrganization, a statement describing the newsroom’s diversity policy on both staffing and sources, typically providing staffing data.'),
		'duns' => array(false,'Duns','The Dun & Bradstreet DUNS number for identifying an organization or business person.'),
		'email' => array(false,'Email','Email address.'),
		'employee' => array(false,'Employee','Someone working for this organization.'),
		'ethicsPolicy' => array(false,'Ethics Policy','Statement about ethics policy, e.g. of a NewsMediaOrganization regarding journalistic and publishing practices, or of a Restaurant, a page describing food source policies. In the case of a NewsMediaOrganization, an ethicsPolicy is typically a statement describing the personal, organizational, and corporate standards of behavior expected by the organization.'),
		'event' => array(false,'Event','Upcoming or past events associated with this place or organization. Supersedes events.'),
		'faxNumber' => array(false,'Fax Number','The fax number.'),
		'founder' => array(false,'Founder','A person who founded this organization. Supersedes founders.'),
		'foundingDate' => array(false,'Founding Date','The date that this organization was founded.'),
		'foundingLocation' => array(false,'Founding Location','The place where the Organization was founded.'),
		'funder' => array(false,'Funder','A person or organization that supports (sponsors) something through some kind of financial contribution.'),
		'globalLocationNumber' => array(false,'Global Location Number','The Global Location Number (GLN, sometimes also referred to as International Location Number or ILN) of the respective organization, person, or place. The GLN is a 13-digit number used to identify parties and physical locations.'),
		'hasOfferCatalog' => array(false,'Has Offer Catalog','Indicates an OfferCatalog listing for this Organization, Person, or Service.'),
		'hasPOS' => array(false,'Has POS','Points-of-Sales operated by the organization or person.'),
		'isicV4' => array(false,'ISIC V4','The International Standard of Industrial Classification of All Economic Activities (ISIC), Revision 4 code for a particular organization, business person, or place.'),
		'legalName' => array(false,'Legal Name','The official name of the organization, e.g. the registered company name.'),
		'leiCode' => array(false,'Lei Code','An organization identifier that uniquely identifies a legal entity as defined in ISO 17442.'),
		'location' => array(false,'Location','The location of for example where the event is happening, an organization is located, or where an action takes place.'),
		'logo' => array(false,'Logo','An associated logo.'),
		'makesOffer' => array(false,'Makes Offer','A pointer to products or services offered by the organization or person. Inverse property: offeredBy.'),
		'member' => array(false,'Member','A member of an Organization or a ProgramMembership. Organizations can be members of organizations; ProgramMembership is typically for individuals.'),
		'memberOf' => array(false,'Member Of','An Organization (or ProgramMembership) to which this Person or Organization belongs.'),
		'naics' => array(false,'Naics','The North American Industry Classification System (NAICS) code for a particular organization or business person.'),
		'numberOfEmployees' => array(false,'Number Of Employees','The number of employees in an organization e.g. business.'),
		'owns' => array(false,'Owns','Products owned by the organization or person.'),
		'parentOrganization' => array(false,'Parent Organization','The larger organization that this organization is a subOrganization of, if any. Supersedes branchOf. Inverse property: subOrganization.'),
		'publishingPrinciples' => array(false,'Publishing Principles','The publishingPrinciples property indicates (typically via URL) a document describing the editorial principles of an Organization (or individual e.g. a Person writing a blog) that relate to their activities as a publisher, e.g. ethics or diversity policies. When applied to a CreativeWork (e.g. NewsArticle) the principles are those of the party primarily responsible for the creation of the CreativeWork. While such policies are most typically expressed in natural language, sometimes related information (e.g. indicating a funder) can be expressed using schema.org terminology.'),
		'review' => array(false,'Review','A review of the item. Supersedes reviews.'),
		'seeks' => array(false,'Seeks','A pointer to products or services sought by the organization or person (demand).'),
		'sponsor' => array(false,'Sponsor','A person or organization that supports a thing through a pledge, promise, or financial contribution. e.g. a sponsor of a Medical Study or a corporate sponsor of an event.'),
		'subOrganization' => array(false,'Sub Organization','A relationship between two organizations where the first includes the second, e.g., as a subsidiary. See also: the more specific \'department\' property. Inverse property: parentOrganization.'),
		'taxID' => array(false,'Tax ID','The Tax / Fiscal ID of the organization or person, e.g. the TIN in the US or the CIF/NIF in Spain.'),
		'telephone' => array(false,'telephone','The telephone number.'),
		'unnamedSourcesPolicy' => array(false,'Unnamed Sources Policy','For an Organization (typically a NewsMediaOrganization), a statement about policy on use of unnamed sources and the decision process required.'),
		'vatID' => array(false,'Vat ID','The Value-added Tax ID of the organization or person.')
	);
}