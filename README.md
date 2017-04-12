

# pressbooks-metadata

Contributors: @colomet, @julienCXX, @masaka222 

Tags: pressbooks, metadata, lrmi

Requires: Pressbooks Plugin

Tested up to: 4.3

Stable tag: [![Current Release](https://img.shields.io/github/release/Books4Languages/pressbooks-metadata.svg)](https://github.com/Books4Languages/pressbooks-metadata/releases/latest/)

License:  [![License](https://img.shields.io/badge/license-GPL--2.0%2B-red.svg)](https://github.com/Books4Languages/pressbooks-metadata/blob/master/license.txt)

License URI: http://www.gnu.org/licenses/gpl-2.0.html

Educational Metadata for Pressbooks

## Description

Pressbooks gives you the ability to add metadata to your books thus helping Google and other search engines to recognize it. 
The problem comes if your book is for educational purposes.

Pressbooks-metadata, extends the functionality of Pressbooks and gives you the flexibility to add more metadata in your books, 
taking advantage of the LRMI schema markup.

## Installation

1. Clone (or copy) this repository to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' screen in WordPress

## Frequently Asked Questions

1. If I don't need to use all the fields of the plugin, can I leave them empty?

Yes, if one field is empty the SEO information about it will not be generated.

## Requirements

Plugin/Template Name works with:

 * PHP 5.6.X
 * PressBooks 3.9.8.X Lower versions are not supported.

## Disclaimers

The Pressbooks plugin is supplied "as is" and all use is at your own risk.

## Screenshots

1. The new metabox you are getting with this plugin
![screen shot 2017-04-10 at 19 09 28](https://cloud.githubusercontent.com/assets/23406636/24873510/598ed8bc-1e21-11e7-9dd0-a9fc9fbd41ee.png)

1. An example on how Googles Structured Data Testing Tool displays our metadata
![screen shot 2017-04-10 at 19 11 53](https://cloud.githubusercontent.com/assets/23406636/24873576/a7995c94-1e21-11e7-893a-f00cb4525c43.png)

[more screenshots](https://github.com/Books4Languages/pressbooks-metadata/blob/master/pressbooks-metadata/assets/screenshots.md)

## Roadmap
### 0.4
Review the Site metadata

### 0.5
Review the cutom post metadata

### 0.6
Reviw the Site/root metadata

### 0.7
To create documentation and accesibility in frond end

### 0.8
To create a settings page (site and network)

### 0.9
Working with administration page

### 0.XX

## Changelog

### UNRELEASED

* ENHANCED: Change labels and description of existing metafields
* FIXED: Bug Fixes: Main page became blank
* FIXED: Bug Fixes: Pressbooks schema information is being produced twice
* ENHANCED: Extend pressbooks WebPage schema

### 0.2

* REMOVED: The fields we added in the General Book Information metabox and move them to a new metabox
* FEATURE: Accessibility: New Educational Information metabox with the fields:
	* **Subject Name:** Subject name
	* **Small Description:** Small Description of the Subject
	* **ISCED field of education:** Broad field of education according to ISCED-F 2013
	* **Provider:** Provider of the Subject
	* **ISCED level of education:** Level of education according to ISCED-P 2011
	* **Age range:** 3-5, 6-7, 7-8, 8-9, 9-10, 10-11, 11-12, 12-13, 13-14, 14-15, 15-16, 16-17, 17-18 years, Adults
	* **Educational Level:** Level of the course
	* **Educational Framework:** Framework the Educational Level belongs to
	* **Learning Reasource Type:** Course, Examination, Exercise, Descriptor
	* **Interactivity Type:** Active, Expositive, Mixed
	* **Class Learning Time:** how long the students will need for the book
	* **License URL:** custom link to a licence
	* **Bibliography URL:** custom link to a bibliography

* FIXED: Make all the fields produce the expected schema information
* ENHANCED: Functions: New function header_function() that produces the microdata code
* ENHANCED: New Actions: wp_head() action for the function header_function() to be placed in the header
* ENHANCED: Functions: New function print_educationalAlignment_microdata_meta_tags() that produces the code for the educational alignment properties


### 0.1

* FEATURE: Accessibility: General Book Information: new custom metafields
  * **Target language:** Level of education according to ISCED-P 2011
  * **Level:** Level of the course
  * **Learning Reasource Type:** Course, Examination, Exercise, Descriptor
  * **Interactivity Type:** Active, Expositive, Mixed
  * **Age range:** 3-5, 6-7, 7-8, 8-9, 9-10, 10-11, 11-12, 12-13, 13-14, 14-15, 15-16, 16-17, 17-18 years, Adults
  * **Class Learning Time:** how long the students will need for the book
  * **License URL:** custom link to a licence
  * **Bibliography URL:** custom link to a bibliography
 
* FEATURE: Accessibility: Custom Chapter Metadata: new custom metaboxes for the custom page chapter
  * **Questions And Answers:** this field allows teachers to insert a custom link. 
  * **Class Learning Time (minutes):** how long the students will need for the topic.
  
## Upgrade Notice

### 0.3
To adapt the plugin to PressBooks.

### 0.2 
To make works the current old plugin.

### 0.1
To use an old version as the start point.


### Course Microdata:
```html
<div itemscope itemtype="http://schema.org/Course">
	<meta itemprop='name' content='English' id='name'>
	<meta itemprop='description' content='English Subject A1 level' id='description'>
	<meta itemprop='provider' content='My Language Skills' id='provider'>
	<meta itemprop='learningResourceType' content='Course' id='learningResourceType'>
	<meta itemprop='interactivityType' content='Active' id='interactivityType'>
	<meta itemprop='typicalAgeRange' content='Adults' id='typicalAgeRange'>
	<meta itemprop='timeRequired' content='4' id='timeRequired'>
	<meta itemprop='license' content='License URL' id='license'>
	<meta itemprop='isBasedOnUrl' content='Bibliography URL' id='isBasedOnUrl'>

	<span itemprop="educationalAlignment" itemscope itemtype="http://schema.org/AlignmentObject">	
		<meta itemprop="alignmentType" content="educationalSubject" />
		<meta itemprop="targetName" content='English' />
	</span>

    <span itemprop="educationalAlignment" itemscope itemtype="http://schema.org/AlignmentObject">
        <meta itemprop="alignmentType" content="educationalSubject" />
        <meta itemprop="educationalFramework" content='ISCED-2013'/>
        <meta itemprop="targetName" content='Education' />
    </span>

    <span itemprop="educationalAlignment" itemscope itemtype="http://schema.org/AlignmentObject">
        <meta itemprop="alignmentType" content="educationalLevel" />
        <meta itemprop="educationalFramework" content='ISCED-2011'/>
        <meta itemprop="targetName" content='Post-secondary non-tertiary education' />
        <meta itemprop="alternateName" content='ISCED 2011, Level 4' />
    </span>

	<span itemprop="educationalAlignment" itemscope itemtype="http://schema.org/AlignmentObject">
		<meta itemprop="alignmentType" content="educationalLevel" />
		<meta itemprop="educationalFramework" content='CEFR'/>
		<meta itemprop="targetName" content='A1' />
	</span>
</div>
```

## Credits

Here's a link to [Plugin Boilerplate](http://wppb.io/ "Uses the WordPress Plugin Boilerplate")

Here's a link to [WordPress](http://wordpress.org/ "Your favorite software") 

Here's a link to [PressBooks](https://pressbooks.org/get-involved/ "Your favorite ebook platform")

and one to [Markdown's Syntax Documentation][markdown syntax].

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"
