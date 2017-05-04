

# pressbooks-metadata

Contributors: @colomet, @julienCXX, @masaka222 

Tags: pressbooks, metadata, lrmi

Tested up to: [![WordPress](https://img.shields.io/wordpress/v/akismet.svg)](https://wordpress.org/download/)

Requires:  [![Pressbooks](https://img.shields.io/badge/Pressbooks-V%203.9.8.2-red.svg)](https://github.com/pressbooks/pressbooks/releases/tag/3.9.8.2)

Stable tag: [![Current Release](https://img.shields.io/github/release/Books4Languages/pressbooks-metadata.svg)](https://github.com/Books4Languages/pressbooks-metadata/releases/latest/)

License:  [![License](https://img.shields.io/badge/license-GPL--2.0%2B-red.svg)](https://github.com/Books4Languages/pressbooks-metadata/blob/master/license.txt)

License URI: http://www.gnu.org/licenses/gpl-2.0.html

Educational Metadata for Pressbooks

## Description

Pressbooks gives you the ability to add metadata to your books thus helping Google and other search engines to recognize it. 
The problem comes if your book is for educational purposes.

Pressbooks-metadata, extends the functionality of Pressbooks and gives you the flexibility to add more metadata in your books, 
taking advantage of the LRMI schema markup.

You can see the [schema properties that we use here](https://github.com/Books4Languages/pressbooks-metadata/blob/master/pressbooks-metadata/docs/SchemaUsed.md)

## Installation

1. Clone (or copy) this repository to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' screen in WordPress

## Frequently Asked Questions

1. If I don't need to use all the fields of the plugin, can I leave them empty?
Yes, if one field is empty the SEO information about it will not be generated.

1. How can I check if the metadata is update?
by running [Google structured data testing tool](https://search.google.com/structured-data/testing-tool/u/0/) in each one of the places (Main page of the Root theme, Main page of the Single Site and post page of a Site)


## Requirements

Plugin/Template Name works with:

 * ![PHP](https://img.shields.io/badge/PHP-5.6.X-blue.svg)
 * [![Pressbooks](https://img.shields.io/badge/Pressbooks-V%203.9.8.2-red.svg)](https://github.com/pressbooks/pressbooks/releases/tag/3.9.8.2)
 
 Lower versions are not supported.

## Disclaimers

The Pressbooks plugin is supplied "as is" and all use is at your own risk.

## Screenshots

You can see all of the screenshots of the plugin [here](https://github.com/Books4Languages/pressbooks-metadata/blob/master/pressbooks-metadata/assets/screenshots.md)

## Roadmap

### 0.6
Reviw the Site/root metadata and Documentation
* Additions
	* **[WebSite](https://github.com/Books4Languages/pressbooks-metadata/blob/master/pressbooks-metadata/SchemaUsed.md) type**. (#6)
		* New property: **description**
		* New property: **name**
		* New property: **url**
	* Meet minimum requeriments (PB and PB Version)
* Enhancements
	* To finisht the documentation
* **REMOVED:**
	* **[ScholarlyArticle](https://github.com/Books4Languages/pressbooks-metadata/blob/master/pressbooks-metadata/SchemaUsed.md) type**. (#35) 
		* Delete property: **copyrightYear**
		* Delete property: **inLanguage**
		* Delete property: **copyrightHolder**
		* Delete property: **publisher**

* List of Files revisded
 	* class-pressbooks-metadata-admin.php
	* class-pressbooks-metadata.php
	 

### 0.7
To create google schoolar. To extend metadata for an integration of the content

### 0.8
To create a settings page (site and network)

### 0.9
Working with administration page

### 0.XX

## Changelog

### 0.5
* **ADDITIONS**
	* **[ScholarlyArticle](https://github.com/Books4Languages/pressbooks-metadata/blob/master/pressbooks-metadata/SchemaUsed.md) type**. (#9) 
		* New property: **headline**
		* New property: **image**
		* New property: **wordCount**
		* New property: **author**
		* New property: **alternativeHeadline**
		* New property: **audience**
		* New property: **citation**
		* New property: **copyrightHolder**
		* New property: **copyrightYear**
		* New property: **datePublished**
		* New property: **dateModified**
		* New property: **discussionUrl**
		* New property: **editor**
		* New property: **inLanguage**
		* New property: **license**
		* New property: **locationCreated**
		* New property: **publisher**
		* New property: **timeRequired**
		* New property: **translator**
		* New property: **typicalAgeRange**
* **ENHANCEMENTS**
	* Code changes to make it the pressbooks-way (#38)
	* Code changes to use one common prefix $slug to our fields (#39) 
		* **Breaking Change:** The data will disapear.  The previous data still remains saved in the database with the old $slug.
	* Documentation
* **BUGFIXES:** 
	* Change the Schema type of Chapter to ScholarlyArticle
	* Change License URL and Bibliography URL fields from Text Fields to Url Fields (#40)

### 0.4
* **ADDITIONS**
	* New detailed SchemaUsed.md file, with all the information about the Structured Data that is being produced.
	* Book Type (#7)
		* New property: **Illustrator:** The illustrator of the book.
		* New property: **Book Edition:** The edition of the book.
	* Course Type (#30)
		* New property: **Course Code:** identifier for the Course (e.g. CS101 or 6.001).
		* New property: **coursePrerequisites**: Course Prerequisites.
	
### 0.3
* **ADDITIONS**
	* Course Type
		* **educationalAlignment** (#12) ISCED field of education: Broad field of education according to ISCED-F 2013.
		* **educationalAlignment** (#14) ISCED level of education: Level of education according to ISCED-P 2011.
	* Make the plugin activation available only in the Network level. (#28)
* **ENHANCEMENTS**
	* Change labels and description of existing metafields
	* Organize the plugin for an easy extension of types. (#10)
	* Review the code of the plugin, comment and organization. (#11)
	* Correct the order of the fields.
* **BUGFIXES:** 
	* Bug Fixes: Main page became blank.
	* Bug Fixes: Pressbooks schema information is being produced twice .(#27)

### 0.2
* **ADDITIONS**
	* Accessibility: New Educational Information metabox with the fields:
		* New property: **name**: Subject name.
		* New property: **description**: Small Description of the Subject.
		* New property: **educationalAlignment**: ISCED field of education.
		* New property: **Provider:** Provider.
		* New property: **educationalAlignment**: ISCED level of education.
		* New property: **typicalAgeRange**: Age range (3-5, 6-7, 7-8, 8-9, 9-10, 10-11, 11-12, 12-13, 13-14, 14-15, 15-16, 16-17, 17-18 years, Adults).
		* New property: **educationalAlignment**: Educational Level.
		* New property: **coursePrerequisites**: Educational Framework.
		* New property: **learningResourceType:** Learning Reasource Type (Course, Examination, Exercise, Descriptor).
		* New property: **interactivityType**: Interactivity Type (Active, Expositive, Mixed).
		* New property: **timeRequired:** Class Learning Time.
		* New property: **license**:  License URL.
		* New property: **isBasedOnUrl**: Bibliography URL.
	* Functions: New function header_function() that produces the microdata code
	* New Actions: wp_head() action for the function header_function() to be placed in the header
	* Functions: New function print_educationalAlignment_microdata_meta_tags() that produces the code for the educational alignment properties
* **BUGFIXES:** 
	* Make all the fields produce the expected schema information
* **REMOVED:**
	* The fields we added in the General Book Information metabox and move them to a new metabox

### 0.1
* **DRAFT VERSION - OLD CODE**
	* Accessibility: General Book Information: new custom metafields: **Target language:** Level of education according to ISCED-P 2011; **Level:** Level of the course; **Learning Reasource Type:** Course, Examination, Exercise, Descriptor; **Interactivity Type:** Active, Expositive, Mixed; **Age range:** 3-5, 6-7, 7-8, 8-9, 9-10, 10-11, 11-12, 12-13, 13-14, 14-15, 15-16, 16-17, 17-18 years, Adults; **Class Learning Time:** how long the students will need for the book; **License URL:** custom link to a licence; **Bibliography URL:** custom link to a bibliography
	* Accessibility: Custom Chapter Metadata: new custom metaboxes for the custom page chapter: **Questions And Answers:** this field allows teachers to insert a custom link; **Class Learning Time (minutes):** how long the students will need for the topic.
  
## Upgrade Notice

### 0.5
Review the custom post metadata

### 0.4
Review the Site metadata

### 0.3
To adapt the plugin to PressBooks.

### 0.2 
To make works the current old plugin.

### 0.1
To use an old version as the start point.


## Credits

Here's a link to [Plugin Boilerplate](http://wppb.io/ "Uses the WordPress Plugin Boilerplate")

Here's a link to [WordPress](http://wordpress.org/ "Your favorite software") 

Here's a link to [PressBooks](https://pressbooks.org/get-involved/ "Your favorite ebook platform")

Here's a link to [Dillinger](http://dillinger.io/ "Text Editor for markdown")

and one to [Markdown's Syntax Documentation][markdown syntax].

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"
	    
	    
	    
[AllMyChanges](https://allmychanges.com/p/new/) will track release notes for you and will send you a digest with information about new updates.
