
# All In One Metadata

Contributors: @colomet, @julienCXX, @masaka222, @MashRoofa and @danzhik

Tags: wordpress, multisite, pressbooks, metadata, schema, lrmi

Tested up to: [![WordPress](https://img.shields.io/wordpress/v/akismet.svg)](https://wordpress.org/download/)

Requires:  [![Pressbooks](https://img.shields.io/badge/Pressbooks-V%205.3-red.svg)](https://github.com/pressbooks/pressbooks/releases/tag/5.3)

Stable tag: [![Current Release](https://img.shields.io/github/release/Books4Languages/pressbooks-metadata.svg)](https://github.com/my-language-skills/all-in-one-metadata/releases/latest/)

License:  [![License](https://img.shields.io/badge/license-GPL--3.0-red.svg)](https://github.com/my-language-skills/all-in-one-metadata/blob/master/LICENSE.txt)

License URI: http://www.gnu.org/licenses/gpl-3.0.txt

Educational Metadata for Pressbooks

## Description

Pressbooks gives you the ability to add metadata to your books thus helping Google and other search engines to recognize it.
The problem comes if your book is for educational purposes.

Pressbooks-metadata, extends the functionality of Pressbooks and gives you the flexibility to add more metadata in your books,
taking advantage of the LRMI schema markup.

You can see the [schema properties that we use here](https://github.com/Books4Languages/pressbooks-metadata/blob/master/docs/SchemaUsed.md)

* [Introduction](/doc/doc-intro.md)
* [Installation, Integrations and Compatibilities](/doc/doc-general.md)
* [Multisite documentation](/doc/doc-settings-mu.md)
* [Single Site documentation](/doc/doc-settings-site.md)
* [Page documentation](/doc/doc-settings-post.md)
* [Developers documentation](/doc/doc-dev.md)
---
https://github.com/pressbooks/pressbooks/issues/950

## Installation

1. Clone (or copy) this repository folder `all-in-one-metadata` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' screen in WordPress

## upgrades

For upgrades, download the las stable version from github, delete from FTP the old plugin and install the new one.

## Frequently Asked Questions

1. If I don't need to use all the fields of the plugin, can I leave them empty?
Yes, if one field is empty the SEO information about it will not be generated.

1. How can I check if the metadata is update?
by running [Google structured data testing tool](https://search.google.com/structured-data/testing-tool/u/0/) in each one of the places (Main page of the Root theme, Main page of the Single Site and post page of a Site)

1. If I use PressBooks, how can I know which is the version I should give to my book?
We use [Explicit Books Versioning](https://github.com/software-development-guidelines/explicit-book-versioning)

1. Which metadata can I find?
All in one metadata have the Types XXX and XXX with all the subtipes and properties till [schema](http://webschemas.org/docs/releases.html) version [3.3](http://webschemas.org/version/3.3/)


## Requirements

Plugin/Template Name works with:

 * ![PHP](https://img.shields.io/badge/PHP-7.2.X-blue.svg)
 * [![Pressbooks](https://img.shields.io/badge/Pressbooks-V%205.3-red.svg)](https://github.com/pressbooks/pressbooks/releases/tag/4.0)

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



## Credits

* Here's a link to [Plugin Boilerplate](http://wppb.io/ "Uses the WordPress Plugin Boilerplate")
* Here's a link to [Composer](https://getcomposer.org/)
* Here's a link to [PressBooks](https://pressbooks.org/get-involved/ "Your favorite ebook platform")
* Here's a link to [Custom Metadata Manager for WordPress](https://wordpress.org/plugins/custom-metadata/ "Framework for custom field creation")

---
[Up](/README.md)
