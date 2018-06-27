
# All In One Metadata

Contributors: @colomet, @julienCXX, @masaka222, @MashRoofa and @danzhik

Tags: pressbooks, metadata, lrmi

Tested up to: [![WordPress](https://img.shields.io/wordpress/v/akismet.svg)](https://wordpress.org/download/)

Requires:  [![Pressbooks](https://img.shields.io/badge/Pressbooks-V%205.3-red.svg)](https://github.com/pressbooks/pressbooks/releases/tag/5.3)

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


* [General documentation](/doc/documentation-1.md)
* [Specifical documentation](/doc/documentation-2.md)
* [Technical Documentation Single Site](/doc/documentation-3.md)
* [Technical Documentation Multisite](/doc/documentation-4.md)
* [Installation, Integrations and Compatibilities](/doc/documentation-5.md)
---
https://github.com/pressbooks/pressbooks/issues/950

## Installation

1. Clone (or copy) this repository folder `all-in-one-metadata` to the `/wp-content/plugins/` directory
1. Navigate into `/wp-content/plugins/all-in-one-metadata` and run `composer install` and then `composer dump-autoload -o`
1. Activate the plugin through the 'Plugins' screen in WordPress

## upgrades

For upgrades, download the las stable version from github, delete from FTP the old plugin and install the new one.

## Frequently Asked Questions

1. If I don't need to use all the fields of the plugin, can I leave them empty?
Yes, if one field is empty the SEO information about it will not be generated.

1. How can I check if the metadata is update?
by running [Google structured data testing tool](https://search.google.com/structured-data/testing-tool/u/0/) in each one of the places (Main page of the Root theme, Main page of the Single Site and post page of a Site)

1. If I ue PressBooks, how can I know wich is the version I should give to my book?
We use [Explicit Books Versioning](https://github.com/software-development-guidelines/explicit-book-versioning)

1. Which metadata can I find?
All in one metadata have the Types XXX and XXX with all the subtipes and properties till [schema](http://webschemas.org/docs/releases.html) version [3.3](http://webschemas.org/version/3.3/)


## Requirements

Plugin/Template Name works with:

 * ![PHP](https://img.shields.io/badge/PHP-7.2.X-blue.svg)
 * [![Pressbooks](https://img.shields.io/badge/Pressbooks-V%205.3-red.svg)](https://github.com/pressbooks/pressbooks/releases/tag/4.0) [![Join the chat at https://gitter.im/my-language-skills/all-in-one-metadata](https://badges.gitter.im/my-language-skills/all-in-one-metadata.svg)](https://gitter.im/my-language-skills/all-in-one-metadata?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

 Lower versions are not supported.

## Disclaimers

The All in one metadata plugin is supplied "as is" and all use is at your own risk.

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


### Changelog
[See changelog](/CHANGELOG.md)


## Upgrade Notice

### 0.17
Improved database interaction and options storing, which decreases overhead of database entries by tens of times and also improves plugin performance. **Since this moment in order for plugin to work properly**, install this version of a plugin, delete it from plugins page (**IMPORTANT! Not manually via FTP**) so that your database get cleaned from entries of elder versions of a plugin and install it again.

### 0.16
Plugin now properly uninstalls itself, no remaining data in database is kept after uninstalling. In order for users to see how plugin works without requiring initial setting, we have added some enabled options out-of-the-box in order to see how actually plugin works. The predefined options can be disabled after activation. Schema location options now stays more logical, multisite control setting is also supported from this moment.

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

Here's a link to [Debug Bar](https://wordpress.org/plugins/debug-bar/#description)

Here's a link to [Debug Bar PHP/MySQL console](https://wordpress.org/plugins/debug-bar-console/)

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
[Up](/README.md)
