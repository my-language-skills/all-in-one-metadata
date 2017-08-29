<?php

namespace schemaTypes;

/**
 * File containing an array for loading the types automatically
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.10
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 */

class Pressbooks_Metadata_Type_Structure{
	public static $allSchemaTypes = array(
		//CreativeWorks
		'schemaTypes\cw\Pressbooks_Metadata_Book',
		'schemaTypes\cw\Pressbooks_Metadata_Blog',
		'schemaTypes\cw\Pressbooks_Metadata_Message',
		'schemaTypes\cw\Pressbooks_Metadata_Article',
		'schemaTypes\cw\Pressbooks_Metadata_Clip',
		'schemaTypes\cw\Pressbooks_Metadata_Comment',
		'schemaTypes\cw\Pressbooks_Metadata_Course',
		'schemaTypes\cw\Pressbooks_Metadata_CreativeWorkSeason',
		'schemaTypes\cw\Pressbooks_Metadata_CreativeWorkSeries',
		'schemaTypes\cw\Pressbooks_Metadata_DataCatalog',
		'schemaTypes\cw\Pressbooks_Metadata_Dataset',
		'schemaTypes\cw\Pressbooks_Metadata_DigitalDocument',
		'schemaTypes\cw\Pressbooks_Metadata_Episode',
		'schemaTypes\cw\Pressbooks_Metadata_Game',
		'schemaTypes\cw\Pressbooks_Metadata_HowTo',
		'schemaTypes\cw\Pressbooks_Metadata_Map',
		'schemaTypes\cw\Pressbooks_Metadata_MediaObject',
		'schemaTypes\cw\Pressbooks_Metadata_Menu',
		'schemaTypes\cw\Pressbooks_Metadata_MenuSection',
		'schemaTypes\cw\Pressbooks_Metadata_Movie',
		'schemaTypes\cw\Pressbooks_Metadata_MusicComposition',
		'schemaTypes\cw\Pressbooks_Metadata_MusicPlaylist',
		'schemaTypes\cw\Pressbooks_Metadata_MusicRecording',
		'schemaTypes\cw\Pressbooks_Metadata_Painting',
		'schemaTypes\cw\Pressbooks_Metadata_Photograph',
		'schemaTypes\cw\Pressbooks_Metadata_PublicationIssue',
		'schemaTypes\cw\Pressbooks_Metadata_PublicationVolume',
		'schemaTypes\cw\Pressbooks_Metadata_Question',
		'schemaTypes\cw\Pressbooks_Metadata_Review',
		'schemaTypes\cw\Pressbooks_Metadata_Sculpture',
		'schemaTypes\cw\Pressbooks_Metadata_Series',
		'schemaTypes\cw\Pressbooks_Metadata_SoftwareApplication',
		'schemaTypes\cw\Pressbooks_Metadata_SoftwareSourceCode',
		'schemaTypes\cw\Pressbooks_Metadata_TVSeason',
		'schemaTypes\cw\Pressbooks_Metadata_TVSeries',
		'schemaTypes\cw\Pressbooks_Metadata_VisualArtwork',
		'schemaTypes\cw\Pressbooks_Metadata_WebPage',
		'schemaTypes\cw\Pressbooks_Metadata_WebPageElement',
		'schemaTypes\cw\Pressbooks_Metadata_WebSite',
		//Organization
		'schemaTypes\organization\Pressbooks_Metadata_Airline',
		'schemaTypes\organization\Pressbooks_Metadata_Corporation',
		'schemaTypes\organization\Pressbooks_Metadata_EducationalOrganization',
		'schemaTypes\organization\Pressbooks_Metadata_LocalBusiness',
		'schemaTypes\organization\Pressbooks_Metadata_MedicalOrganization',
		'schemaTypes\organization\Pressbooks_Metadata_SportsOrganization',
		'schemaTypes\organization\Pressbooks_Metadata_PerformingGroup',
		'schemaTypes\organization\Pressbooks_Metadata_GovernmentOrganization',
		'schemaTypes\organization\Pressbooks_Metadata_NGO'
	);

	public static $allParents = array(
		'schemaTypes\Pressbooks_Metadata_Thing',
		'schemaTypes\Pressbooks_Metadata_CreativeWork',
		'schemaTypes\Pressbooks_Metadata_Organization'
	);
}