

# All In One Metadata

Contributors: @colomet, @julienCXX, @masaka222, @MashRoofa

Tags: pressbooks, metadata, lrmi

Tested up to: [![WordPress](https://img.shields.io/wordpress/v/akismet.svg)](https://wordpress.org/download/)

Requires:  [![Pressbooks](https://img.shields.io/badge/Pressbooks-V%204.0-red.svg)](https://github.com/pressbooks/pressbooks/releases/tag/4.0)

Stable tag: [![Current Release](https://img.shields.io/github/release/Books4Languages/pressbooks-metadata.svg)](https://github.com/Books4Languages/pressbooks-metadata/releases/latest/)

License:  [![License](https://img.shields.io/badge/license-GPL--2.0%2B-red.svg)](https://github.com/Books4Languages/pressbooks-metadata/blob/master/license.txt)

License URI: http://www.gnu.org/licenses/gpl-2.0.html

Educational Metadata for Pressbooks

## Description

Pressbooks gives you the ability to add metadata to your books thus helping Google and other search engines to recognize it.
The problem comes if your book is for educational purposes.

Pressbooks-metadata, extends the functionality of Pressbooks and gives you the flexibility to add more metadata in your books,
taking advantage of the LRMI schema markup.

You can see the [schema properties that we use here](https://github.com/Books4Languages/pressbooks-metadata/blob/master/docs/SchemaUsed.md)


[General documentation](/docs/documentation-1.md)

[Specifical documentation](/docs/documentation-2.md)


---
https://github.com/pressbooks/pressbooks/issues/950


## Installation

1. Clone (or copy) this repository to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' screen in WordPress

## Frequently Asked Questions

1. If I don't need to use all the fields of the plugin, can I leave them empty?
Yes, if one field is empty the SEO information about it will not be generated.

1. How can I check if the metadata is update?
by running [Google structured data testing tool](https://search.google.com/structured-data/testing-tool/u/0/) in each one of the places (Main page of the Root theme, Main page of the Single Site and post page of a Site)

1. How can I know wich is the version I should give to my book?
We use [Explicit Books Versioning](explicit-book-versioning/VERSIONING.md)


## Requirements

Plugin/Template Name works with:

 * ![PHP](https://img.shields.io/badge/PHP-5.6.X-blue.svg)
 * [![Pressbooks](https://img.shields.io/badge/Pressbooks-V%204.0-red.svg)](https://github.com/pressbooks/pressbooks/releases/tag/4.0)

 Lower versions are not supported.

## Disclaimers

The Pressbooks plugin is supplied "as is" and all use is at your own risk.

## Screenshots

You can see all of the screenshots of the plugin [here](https://github.com/Books4Languages/pressbooks-metadata/blob/master/pressbooks-metadata/assets/screenshots.md)

## Roadmap


### Now
## 0.xx
* **ADDITIONS**

* **ENHANCEMENTS**

* **List of Files revised**


### Soon
New types
Use the library from Spatie that auto generates schema [Schema](https://github.com/spatie/schema-org)
Detection of various other popular SEO tools to prevent duplicated output
Review: https://yoast.com/hreflang-ultimate-guide/
Maybe if a book have a version name (once is achive) we can have automatic link to the original one
https://moz.com/learn/seo/duplicate-content

### Later


### Future


## Changelog

## 0.13
* **ADDITIONS**
    *  Added more types on creative workds and organisation parents
    *  Added 'types' for the educational vocabulary -> Book, Course, Website, Webpage and Article
    *  Enabled Required Parent Properties for types
    *  Documentation Update for adding new types
    *  Admin can clean and disable properties that were overwritten
    *  Plugin is fully compatible with the addon Isced Plugin
* **ENHANCEMENTS**
    *  Required plugin error and link improved
    *  In network settings empty types are noted with red color
    *  Multi site schemaLocation is disabled from settings on a single site
    *  Improved parent filtering with radio buttons
    *  Made the engine more efficient
    *  Loading only properties for activated types
    *  Enhanced Dublin Core and Coins vocabularies
    *  Fully implemented Educational Vocabulary
    *  Auto activation of types and properties on all sites when super admin adds a property
    *  Auto activation of types and properties for chapter/post when admin overwrites a property
    *  Frozen and Overwritten fields now display much better to the user
    *  Showing last visited tab in settings
    *  Fixed the overlap of metaboxes in the settings
* **List of Files revised**
    *  Schema type files
    *  Engine file
    *  All files in partials folder
    *  Admin JavaScript file
    *  All vocabulary files
    *  Network admin files

## 0.12
* **ADDITIONS**
    *  Added Organisation Parent and Types

* **List of Files revised**
    * schemaTypes Folder
    * composer.json

## 0.11
* **ADDITIONS**
    * Enable the cloning of properties from each site (Book Info/Site-Meta) to (Chapter/Post)  #140

* **List of Files revised**
    * class-pressbooks-metadata-engine.php
    * class-pressbooks-metadata-property-overwrite.php
    * class-pressbooks-metadata-property-fields.php

## 0.10
* **ADDITIONS**
    * Show parent activation and info for empty Types #113
    * Add parent sections under each tab level  #123
    * Add a link that will pop up a lightbox for the properties for every type #120
    * Add the coins and the dublin core vocabulary into the plugin #116
* **ENHANCEMENTS**
    * Fix Tab Navigation in Settings #133
    * Each type link is opening in a new page #132
    * Fixed Positioning of the filters #127
    * Fix the loading animation and the saving of the first type #125
    * Change color for warnings on settings page  #122
    * Change the architecture of the schemaType classes, autoload them and include settings for each type inside the class #121
* **List of Files revised**
    * Changes in the engine file
    * Creation of new files that handle the structure of types
    * Creation of new settings files for handling the property fields
    * New files for the new vocabularies

### 0.9
* **ADDITIONS**
    * Added Webpage Schema Type
    * Added Course Schema Type
    * Added Educational Information Metabox in Book Info #108
* **ENHANCEMENTS**
    * Chapter metadata is now being exported and imported as expected #24
    * File structure changed - addition of new types is more modular
    * Namespaces are being used for a better file structure - Composer psr-4 standard
    * Parent types of schema are handled more efficiently
    * New CPT site-meta is being added every time pressbooks is disabled #102
    * The plugin now works without pressbooks
    * The Creative Works Type is cleaned up
    * Automatic display of active post types for schema manipulation
    * Changes on settings page -- More user friendly
    * Interactivity Type default value #70
* **List of Files revised**
    * Code rewriting for optimisation.

### 0.8.1
* **ADDITIONS**
	* To create a settings page #25

* **ENHANCEMENTS**
    * To write type and property name inside each field inside of the code #61
    * Each group of features as an independen file #56
    * To enable and dissable metadata fields #20

### 0.8
* **ADDITIONS**
	* Rewriting of the plugin #78
	* Creation of the fields using a plugin: Custom Metadata Manager for WordPress

* **BUGFIXES:**
	* Extend Pressbooks default types, instead of using different ones #91

### 0.7
* **ADDITIONS**
	* **Google Scholar microtags**
		* New property: **citation_journal_title**
		* New property: **citation_author**
		* New property: **citation_isbn**
		* New property: **citation_publisher**
		* New property: **citation_publication_date**

* **ENHANCEMENTS**
	* Educational Framework info Update #69
	* ISCED field and level of education default values #67
	* Course Prerequisites Info Update #68
	* Book Edition #66
	* Prefixing: to chage it to a more neutral name #59

* **BUGFIXES:** 	

* **List of Files revised**
 	* class-pressbooks-metadata-admin.php
	* class-pressbooks-metadata-plugin-metadata.php

### 0.6
* **ADDITIONS**
	* **[WebSite](https://github.com/Books4Languages/pressbooks-metadata/blob/master/pressbooks-metadata/SchemaUsed.md) type**. (#6)
		* New property: **description**
		* New property: **name**
		* New property: **url**
	* Meet minimum requeriments (PB and PB Version)
* **ENHANCEMENTS**
	* To finish the documentation
	* function prefixing #47
	* timeRequired formating for Site and Chapter #55
* **REMOVED:**
	* **[ScholarlyArticle](https://github.com/Books4Languages/pressbooks-metadata/blob/master/pressbooks-metadata/SchemaUsed.md) type**. (#35)
		* Delete property: **copyrightYear**
		* Delete property: **inLanguage**
		* Delete property: **copyrightHolder**
		* Delete property: **publisher**
* **BUGFIXES:**
	* Change the name of the plugin (from draft name to default name)
	* Author and Alternative headline from PB Chapter level instead of Site level
	* ScholarlyArticle Bug #58

* **List of Files revised**
 	* class-pressbooks-metadata-admin.php
	* class-pressbooks-metadata.php
	* class-pressbooks-metadata-plugin-metadata.php
	* class-pressbooks-metadata-data-field.php

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

### 0.13
Plugin now is much more efficient wasting less memory on the server as the engine file had improvements. The plugin had many improvements
on both the visual interface and the engine. The user experience has improved as we are saving the tabs that were used before reloading the settings page.
Many new types were added along with improvements on how the type requires parent properties. Now the external vocabularies along with the
educational vocabulary are fully implemented. The admin and the super admin can simply clone properties without having to enable types manually on site/posts/chapters.
Another handy feature is the clear and disable feature on overwritten properties. For the educational vocabulary the plugin now is accepting data from a secondary addon plugin named Isced Fields.

### 0.12
Added Organization Parent and Types

### 0.11
Administrator can overwrite Chapter and Post property values from Book-Info and Site-Meta.The administrator can populate type property values in all chapters
or posts. This is done by selecting the toPost or toChapter option on a property of any type from the Site-Meta tab of the settings

### 0.10
Code rewriting for optimisation. All the types inherit as classes from a base class called type. The creation of new types is way simpler and faster.
Each property for each level and each type can be enabled and disabled. Dublin core and Coins vocabularies were added, also the schema types now can be
filtered by parent.

### 0.9
Code rewriting for optimisation. Introduced new types and new file system. Plugin works independently of pressbooks.
Importing and exporting for pressbooks is fixed.

### 0.8.1
To use google scholar. To extend metadata for an integration of the content.

### 0.8
Rewriting of the plugin and integration with Custom Metadata Manager for WordPress.

### 0.7
To use google scholar. To extend metadata for an integration of the content.

### 0.6
Reviw the Site/root metadata and Documentation

### 0.5
Review the custom post metadata.

### 0.4
Review the Site metadata.

### 0.3
To adapt the plugin to PressBooks.

### 0.2
To make the current old plugin work.

### 0.1
To use an old version as the start point.


## Credits

Here's a link to [Plugin Boilerplate](http://wppb.io/ "Uses the WordPress Plugin Boilerplate")

Here's a link to [Composer](https://getcomposer.org/)

Here's a link to [WordPress](http://wordpress.org/ "Your favorite software")

Here's a link to [PressBooks](https://pressbooks.org/get-involved/ "Your favorite ebook platform")

Here's a link to [Custom Metadata Manager for WordPress](https://wordpress.org/plugins/custom-metadata/ "Framework for custom field creation")

Here's a link to [PHP Sandbox](http://sandbox.onlinephpfunctions.com/) for PHP code testing

Here's a link to [Dillinger](http://dillinger.io/ "Text Editor for markdown")

and one to [Markdown's Syntax Documentation][markdown syntax].

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"



[AllMyChanges](https://allmychanges.com/p/new/) will track release notes for you and will send you a digest with information about new updates.





---
[Up](/Readme.md)
