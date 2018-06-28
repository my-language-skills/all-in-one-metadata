## Setup the plugin

All in one metadata will create two new tabs. Network Metadata in Network Admin and Site metadata in Site Admin (For PressBooks users, Site metadata is integrated with Book Info).

All in one metadata metadata is put into Object cache when a caching plugin is available. The descriptions and Schema.org scripts are put into Transients. Please be sure to clear your cache.

### All In One Metadata settings
The settings page slplit the settings in
* Location of Metadata
* Activated locations for schema Types
* Specific metadata

#### Location of metadata
Location of metadata allow the configuration of the metadata for Post level, Site level and Multisite level.

* Post level will load all the WordPress posts (Page and Post) and all the Custom Post Types (in a PressBooks installation just the Part, Chapter, Frond Page and Back page CPTs)
* Site level allows to load the metadata for the front page.
* Multisite (comming soon)

After activate the metadata trough the checkbox in the different tabs (Post Level, Site Level or Multisite) in the ‘Location Of Metadata’ and saving, the metabox named ‘Activated Locations For Schema Types’ will display the active places for the metadata.

For Post level

![location of metadata](images/location_of_metadata_post.png)

For Site level

![location of metadata](images/location_of_metadata_site.png)

Multisite (comming soon)

#### Activated locations for schema Types
The second metabox in the settings page displays all the active locations that schema metadata will go in, if did not enable any post-type from the above metabox you will see this

![no active locations](images/no_active_locations.png)

For each one of the activated locations, the different Types and Properties can be activated.

![active locations](images/active_locations.png)

By activating a Type and the properties, the activated properties are show in the location (in Posts or in Site Metadata or Book Info).

The full list of Types and Properties can be find [here](http://schema.org/doc/full.html).

By selecting the first checkbox and saving, the page will refresh and you will see this under all activated types a new option **Edit Type Properties** where the different Properties of the Type can be selected.

![active Type](images/active_type.png)

##### Edit Type Properties

Edit Type Properties open a new window with all the Properties for a selected Type. The window will be different for the Post level and Site level.

###### Edit Type Properties for Post level

For Post level we can see a checkbox for each Property of the Type

![active Type](images/post_book_type_properties.png)

![active Type](images/post_book_type_properties_saved.png)

###### Edit Type Properties for Site level

For Site level we have two columns with chekboxes.

![active Type](images/site_book_type_properties.png)

By activating the clone of the information from the Site level to all the posts, the Home page metadata of the selected properties will be clone to all the Post. Also the Clear and Disable buttom will desappear.

![active Type](images/site_book_type_properties_saved.png)

The new checkboxes copy the information for a specific property from the Site level to all the Post. By uncheck, the value will remain in the field, but it would be editable by the Site Administrator.

![active Type](images/site_book_type_properties_saved_freezed.png)

An example of the metabox with the Properties frozzen are [here](https://github.com/Books4Languages/pressbooks-metadata/blob/master/doc/documentation-2.md#frozzen-post-metadata-post-page-or-cpt).

###### Edit Type Properties extended

The drop down menu on the bottom shows alternative properties (organised in 3 groups) for the type that you selected.

![properties group](images/type_properties_group.png)

* Show basic properties (The specifical properties of the Type).
* Show General Properties (The general properties of all the Types)
* Show Creative Work Properties (The properties of the group of types of the current Type)

When the mouse cursor is over the meta box it's display the description for each property so you don’t have to go to the schema website all the times, once you select or deselect an item from the list the data is saving automatically, some properties will be enabled by default for some types, it means that these properties are mandatory from the schema.org and it’s always good to fill them when creating the post.

 NOTE: that if you activate a Type and you don’t select any properties the metabox will not show in your posts because you simply did not choose anything to describe, if the Type though has required properties by activating it the required properties will show in the metabox.

###### Site Edit Type Properties extended

In Site level, two new bottoms allow new functionalities.

![properties group](images/site_editing_type_properties_extended.png)

**Clear:** allow to clear all the fiels for a specific Property. Useful if we did clone to all the posts and later we do not whant to show any more such data and we whant to have an empty field.

**Disable:**  allo to disable the selected property from the post level. Note that this will just disable the property NOT the schema type or the active post level.

#### Specific metadata

Offer other types of specific Metadata vocabularies
* Coins
* Dublin Core
* Educational (LRMI)

![Coins metadata](images/specific_metadata_coins.png)

![Dublin Core metadata](images/specific_metadata_dc.png)

![Educational metadata](images/specific_metadata_educational.png)

----
![Specific metadata](images/specific_metadata.png)

Coins and Dublin Core have just one checkbox (for Site level or Home page activation) but Educational have two checkboxes. One for Site level and the second one for Post level

##### Coins

Is a method to embed bibliographic metadata on the homepage by going to its tab checking the checkbox and clicking Save Changes. As before, all metadata related to our homepage can be edited under the Tools tab by selecting Site Metadata (or Book info for PressBooks users).

![Coins vocabulary](images/vocabularies_coins.png)

##### Dublin Core

Is a small set of vocabulary terms that can be used to describe web resources on the homepage by going to its tab checking the checkbox and clicking Save Changes. As before, all metadata related to our homepage can be edited under the Tools tab by selecting Site Metadata (or Book info for PressBooks users).
The original set of 15 classic metadata terms, known as the Dublin Core Metadata Element Set.

    Title
    Creator
    Subject
    Description
    Publisher
    Contributor
    Date
    Type
    Format
    Identifier
    Source
    Language
    Relation
    Coverage
    Rights

![Coins vocabulary](images/vocabularies_dc.png)

###### Dublin Core Metadata Terms

The Dublin Core Metadata Initiative (DCMI) Metadata Terms is the current set of the Dublin Core vocabulary.[13] This set includes the fifteen terms of the Dublin Core Metadata Element Set (in italic), as well as the qualified terms. Each term has a unique URI in the namespace http://purl.org/dc/terms, and all are defined as RDF properties.

    abstract
    accessRights
    accrualMethod
    accrualPeriodicity
    accrualPolicy
    alternative
    audience
    available
    bibliographicCitation
    conformsTo
    *contributor*
    *coverage*
    created
    *creator*
    *date*
    dateAccepted
    dateCopyrighted
    dateSubmitted
    *description*
    educationLevel
    extent
    *format*
    hasFormat
    hasPart
    hasVersion
    *identifier*
    instructionalMethod
    isFormatOf
    isPartOf
    isReferencedBy
    isReplacedBy
    isRequiredBy
    issued
    isVersionOf
    *language*
    license
    mediator
    medium
    modified
    provenance
    *publisher*
    references
    *relation*
    replaces
    requires
    *rights*
    rightsHolder
    *source*
    spatial
    *subject*
    tableOfContents
    temporal
    *title*
    *type*
    valid

##### Educational Metadata (LRMI)

Is a method to embed educational metadata on the homepage or in the Post (chapter for PressBooks users) by going to its tab checking the checkbox and clicking Save Changes. As before, all metadata related to our homepage can be edited under the Tools tab by selecting Site Metadata (or Book info for PressBooks users) for Site level or in the Post (chapter) for Post level.

The [LRMI specification](http://dublincore.org/dcx/lrmi-terms/1.1) is a collection of classes and properties for markup and description of educational resources. The specification builds on the extensive vocabulary provided by Schema.org and other standards. [LRMI terms](http://dublincore.org/dcx/lrmi-terms/) not included in schema.org may nevertheless be used to augment and enrich Schema.org markup.

Index of Terms in the /lrmi-terms/ Namespace
  Classes
  AlignmentObject
  EducationalAudience
  Properties
  alignmentType
  educationalAlignment
  educationalFramework
  educationalRole
  educationalUse
  interactivityType
  isBasedOnUrl
  learningResourceType
  targetDescription
  targetName
  targetUrl
  timeRequired
  typicalAgeRange
  useRightsUrl

![lrmi vocabuary](images/vocabularies_lrmi_1.png)
![lrmi vocabuary](images/vocabularies_lrmi_2.png)

### Post metadata (Post, Page or CPT) ¿¿¿¿¿¿¿ la jerarquía es la correcta? es un nivel de 3 almohadillas ### ????????????????????????????????????

In your selected Post, Page or a Custom Post Type will appear a new metabox for the creation of the metadata. Simply add the info in the fields from the new metabox to describe the selected properties.

![Post Book Type metadata metabox](images/post_book_type_metabox.png)

Once the information is created-updated, click Save Changes.

![Post Book Type metadata metabox completed](images/post_book_type_metabox_complete.png)

#### Frozzen Post metadata (Post, Page or CPT)

If the Properties are frozzen from the Site level, instead of cells for writing the information, we will see for each frozzen property the values from the same property in written in Site level.

![Post Book Type metadata freezed values](images/post_book_type_properties_freezed_values.png)

google will be able to read the metadata in the post (Test with [Google structured data testing tool](https://search.google.com/structured-data/testing-tool/u/0/)).

![Google Structured Data Testing Tool](images/google-structured-data-testing-tool.png)

### Site metadata (Book Info for PressBooks)

Site metadata allow to create the metadata for the main page. Also is the place where the metadata must be site available can be writing for all the posts, pages or CPTs.

Each Type is a section with all the Properties of the Type and the supersedes Type.

Now, simply add the info in the fields from the new metabox to describe the selected properties

![Chapter Book Type metadata metabox](images/post_book_type_metabox.png)

Once the information is created-updated, click Save Changes.

![Chapter Book Type metadata metabox completed](images/post_book_type_metabox_complete.png)

google will be able to read the metadata in the Main Page (Test with [Google structured data testing tool](https://search.google.com/structured-data/testing-tool/u/0/)).

![Google Structured Data Testing Tool](images/google-structured-data-testing-tool.png)

  #### Location of metadata
  Location of metadata allow the configuration of the metadata for Post level, Site level and Multisite level.

  * Post level will load all the WordPress posts (Page and Post) and all the Custom Post Types (in a PressBooks installation just the Part, Chapter, Frond Page and Back page CPTs)
  * Site level allows to load the metadata for the front page.
  * Multisite (coming soon)

---

[Readme](/Readme.md)
