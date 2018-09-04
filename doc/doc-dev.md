# Technical Documentation For Developers

This document provides information for developers if this plugin on how the plugin works, the workflow of code and database interaction.

## Vocabulary for terms used

* schema - set of types and properties, provided by [Schema.org](schema.org) service
* schema_type - type of Schema.org schemas. Schema types have properties to describe metadata of site
* schema_property - property of schema type, like 'Author' property for 'Book' schema type
* schema_location - for our plugin, it describes which post types or CPTs will be able to use schemas
* metadata or site-meta - separate outstanding post type, created to describe whole blog metadata. Site-Meta is name of such post for regular WP installation, Metadata is set for Pressbooks installation as they have such post integrated in their plugin.
* network admin - administrator user, which has control over the whole sites network in WP multisite installation
* $postType_level - description of a location of schema, eg which exact post type or CPT is enabled with schema locations
* parent_type - a general schema type, which spreads its properties to its daughter types. Like Creative Works schema type and its daughter Book schema type
* $typeId - a string, which represents ID of Schema type with word 'type' in the end, like 'book_type'
* overwrite - flood the value, stored by Site-Meta post to all posts with post type 'post'
* freeze - flood the value of network defined property to all the Site-Meta posts on every site in a multisite installation
* property_network_value - value of property, which is spread trough all of sites in multisite installation
* native properties - properties, which are present only in given schema type
* parent properties - properties, which are inherited by schema types from their parent schema types

## Database Interaction

For All In One Metadata workflow, the plugin registers and stores several options. Most of them are stored serialized, so in order to update one of the settings in a desired entry it is needed first to get the option from database(the output will be array), change the value with corresponding key in array and then update the option with that array. All the options, except 'property_network_value', only have value 1 or 0, which correspondingly mean enabled or disabled. The options registered are following:

* ```schema_locations```(serialized) - stores values for enabling schema at desired post types (post, chapter, page etc.)
    * *Example*: ```schema_locations['post_level' => 1]``` - allows schemas to be activated on post level  
* ```metadata_checkbox or site-meta_checkbox``` - the same meaning as a previous one, but separately for site-meta level
* ```site-meta_saoverwr or metadata_saoverwr``` - enables network admin ability to control site-meta properties values on all of the sites in multisite (only in multisite installation)
* ```schema_types_$postType_level_$parentType```(serialized) - stores enabled schema types depending on post type and parent schema
    * *Example*:
        * ```schema_types_post_level_schemaTypes\Pressbooks_Metadata_CreativeWork[book_type_post_level => 1]``` - enables Book type schema on a post level
        * ```schema_types_site-meta_level_schemaTypes\Pressbooks_Metadata_Organization[corporation_type_site-meta_level => 1, airline_type_site-meta_level => 1]``` - enables Corporation and Airline schema types on site-meta level
* ```schema_properties_$typeId_$postType_level```(serialized) - stores values responsible for active native properties of schema types
    * *Example*:
        * ```schema_properties_book_type_post_level[illustrator => 1]``` - enables Illustrator property of Book schema type active on post level
* ```$typeId_$postType_level_$parentTypeSlug_dis```(serialized) - stores values responsible for active parent properties of schema types
    * *Example*:
        * ```book_type_post_level_creativeWork_properties_dis[about => 1]``` - enables About property of Creative Work parent schema type, involved from its daughter Book schema type in post level
* ```property_network_value```(serialized) - stores values of properties in network level (multisite installation only)
    * *Example*:
        * ```preperty_network_value[illustrator => ' Jhon ']``` - stores value of illustrator property in network level. This value will be spread to all subsites site-meta values.
* ```property_network_value_freeze```(serialized) - stores values responsible for active native properties (no parent properties for network level) of schema types on network level (multisite installation only)
    * *Example*:
        * ```property_network_value_freeze[illustrator => 1]``` - freezes illustrator property on every subsite site-meta level, so it can be changed only by administrator of sites network
* ```parent_filter_settings```(serialized) - stores current active parent type to show daughter types on settings page(radio buttons on settings page to change current active parent type)
* ```schema_properties_$typeId_overwrite```(serialized) - select which native properties will be overwritten from site-meta/metadata to post/chapter level(selected in site-meta tab on \'Active Schemas\' tab in settings)
    * *Example*:
        * ```schema_properties_book_type_overwrite[illustrator => 1]``` - sets the value of illustrator property in every post equal to site-meta illustrator property (so, it can only be changed in site-meta page)
* ```$typeId_overwrite_$parentType_dis```(serialized) - select which parent properties will be overwritten from site-meta/metadata to post/chapter level
    * *Example*:
        * ```corporation_type_overwrite_organzation_properties_dis[address => 1]``` - sets the address property (which is natively property of Organization parent type) of corporation schema type, which is daughter type of Organization schema-type, on every post equal to site-meta address property defined
* ```jsonld_output``` - activate output of metadata in JSON-LD notation

---


* ```dublin_checkbox``` - activate Dublin metadata for site-meta level
* ```coins_checkbox``` - activate CoIns metadata on site-meta level
* ```educational_checkbox_site-meta``` - activate Educational metadata on site-meta level
* ```educational_checkbox_post``` - activate Educational metadata on post level

---

[Readme](/Readme.md)
