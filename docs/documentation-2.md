#abc-xyz

## Installation and Upgrades

* Clone (or copy) this repository to the /wp-content/plugins/ directory
* Activate the plugin through the 'Plugins' screen in WordPress

For upgrades, download the las stable version from github, delete from FTP the old plugin and install the new one.
## Installing Required Plugins

If we were to try to create our plugin without the use of existing plugin solutions we simply would not exist. There is no sustainable way to develop all the functionality needed for our plugin while still being able to offer a competitive price.

* [Custom Metadata Manager](https://github.com/Automattic/custom-metadata) An easy way to add custom fields to your object types (post, pages, custom post types, users) & to generate option pages. PressBooks users have Custom Metadata Manager integrated in the code.

## Integrations

All in one metadata works out of the box with:

* [PressBooks](http://github.com/pressbooks/pressbooks/) is a book content management system which exports in multiple formats: ebooks, webbooks, print-ready PDF, and various XML flavours. Pressbooks is built on top of WordPress Multisite.

We are focus with the metadata, all the other SEO solutions can be find trough other plugins:

* [The SEO Framework](https://wordpress.org/plugins/autodescription/)
* [All in one SEO](https://wordpress.org/plugins/all-in-one-seo-pack/)
* [Yoast SEO](https://wordpress.org/plugins/wordpress-seo/)

Not all the plugins are 100% integrated with All in one metadata, some of them works in the site for an enhancement of the features of the site. From the settings page, you can choose to deactivate some of the JSON-LD schema metadata for some integrated plugins.

* Comming soon

## Integrated Theme

Any theme can work with All in one metadata.

## This plugin supports:

* PHP 5.3 and higher.
* WordPress 4.8 and higher.
* Internationalization through WordPress.org.
* MultiSite.
* **Detection of various other popular SEO tools to prevent duplicated output.**
* Translation plugins WPML, Polylang and qTranslate X.
* Custom Post Types.


## Setup the plugin
By activating the plugin, a warming appear in the administrator page with the message:
  Please make sure that the custom-metadata plugin is installed for the full PB Metadata Functionality -- Get it Here

All in one metadata use Custom Metadata Manager (no for PressBooks users) as an easy way to add custom fields to your object types (post, pages, custom post types, users)

All in one metadata will create two new tabs. Metadata settings in Settings and Site metadata in Tools.

All in one metadata metadata is put into Object cache when a caching plugin is available. The descriptions and Schema.org scripts are put into Transients. Please be sure to clear your cache.

### Plugin settings
The settings page slplit the settings in
* Location of Metadata
* Activated locations for schema Types
* Specific metadata

#### Location of metadata
Location of metadata allow the configuration of the metadata for Post level, Site level and Multisite level.

* Post level will load all the wordpres posts (Page and Post) and all the Custom Post Types (in a PressBooks installation just the Part, Chapter, Frond Page and Back page CPTs)
* Site level allows to load the metadata for the front page.
* Multisite (comming soon)

#### Activated locations for schema Types
For each one of the activated locations, the different Types and Properties can be activated.

By activating a Type and the properties, the activated properties are show in the location. A **BOOK INFO** page

## Site metadata
Site metadata allow to create the metadata for the main page. But is also the place where the metadata must be site available can be writing for all the posts, pages or CPTs.

Each Type is a secction with all the Properties of the Type and the supersedes Type.
