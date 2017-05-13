# Schema Properties Used
We use different types in every of these 3 levels
- **Network level**
  - [WebSite](#website)
  - [Educational Organization](## Educational Organization)
- **Author Page level**
  - [Person](#Person)
- **Site level**
  - [Book](#book)
  - [Course](#course)
- **Post level**
  - [WebPage](#webpage)
  - [ScholarlyArticle](#scholarlyarticle)
  
------------------------
# Network level
## Website

Properties from: [WebSite](https://schema.org/WebSite "https://schema.org/WebSite")
All the properties from the type.

| **Used By** | **Property** | **Type** | **Description** | [ShemaPlace Code](/docs/SchemaPlace.md) |
| ----------- | ------------ | -------- | --------------- | --------------------------------------
| NA | NA | NA | NA | NA

Properties from: [Creative Work](https://schema.org/CreativeWork "https://schema.org/CreativeWork")
The related propertires from the type that matters to the project.

| **Used By** | **Property** | **Type** | **Description** | [ShemaPlace Code](/docs/SchemaPlace.md) |
| ----------- | ------------ | -------- | --------------- | --------------------------------------
| Pending | [license](http://schema.org/license "http://schema.org/license") | [URL](https://schema.org/URL "https://schema.org/URL") | A license document that applies to this content. | ---
| Pending | [locationCreated](http://schema.org/locationCreated "http://schema.org/locationCreated") | [Place](https://schema.org/Place "https://schema.org/Place") | The location where the CreativeWork was created. | --- Do we need? EducationalOrganization address
| Pending | [publisher](http://schema.org/publisher "http://schema.org/publisher") | [publisher](http://schema.org/publisher "http://schema.org/publisher") | --- | ---
| Pending | [publishingPrinciples](http://schema.org/publishingPrinciples "http://schema.org/publishingPrinciples") | [URL](https://schema.org/URL "https://schema.org/URL") | Link to page describing the editorial principles of the organization primarily responsible for the creation of the Content. | ---
| Pending | [typicalAgeRange](https://schema.org/typicalAgeRange "https://schema.org/typicalAgeRange") | [Text](https://schema.org/Text "https://schema.org/Text") | 	The typical expected age range. | ---

Properties from: [Thing](https://schema.org/Thing "https://schema.org/Thing")
The related propertires from the type that matters to the project.

| **Used By** | **Property** | **Type** | **Description** | [ShemaPlace Code](/docs/SchemaPlace.md) |
| ----------- | ------------ | -------- | --------------- | --------------------------------------
| PB - Metadata | [description](http://schema.org/description "http://schema.org/description") | [Text](https://schema.org/Text "https://schema.org/Text")|The description of the Site.| WP
| PB - Metadata| [name](http://schema.org/name "http://schema.org/name") | ---| No comment | 
| PB - Metadata | [url](http://schema.org/url "http://schema.org/url") | [URL](https://schema.org/URL "https://schema.org/URL")| The URL of the site. | 

## Educational Organization
Properties from: [EducationalOrganization](http://schema.org/EducationalOrganization "http://schema.org/EducationalOrganization")
All the properties from the type.

| **Used By** | **Property** | **Type** | **Description** | [ShemaPlace Code](/docs/SchemaPlace.md) |
| ----------- | ------------ | -------- | --------------- | --------------------------------------
| NA | NA | NA | NA | NA

Properties from: [Organization](http://schema.org/Organization "http://schema.org/Organization")
The related propertires from the type that matters to the project.

| **Used By** | **Property** | **Type** | **Description** | [ShemaPlace Code](/docs/SchemaPlace.md) |
| ----------- | ------------ | -------- | --------------- | --------------------------------------
| Pending | [address](http://schema.org/address "http://schema.org/address") | [PostalAddress](http://schema.org/PostalAddress "http://schema.org/PostalAddress") | Physical address of the Educational Organization. | ---
| Pending | [award](http://schema.org/award "http://schema.org/award") | [Text](https://schema.org/Text "https://schema.org/Text") | 	An award won by the Educational Organization | ---
| Pending | [department](http://schema.org/department "http://schema.org/department") | [Organization](http://schema.org/Organization "http://schema.org/Organization") | Department of the organization. | ---
| Pending | [email](http://schema.org/email "http://schema.org/email") | [Text](https://schema.org/Text "https://schema.org/Text") | Email address. | ---
| Pending | [employee](http://schema.org/employee "http://schema.org/employee") | [Person](http://schema.org/Person "http://schema.org/Person") | Someone working for this organization. | ---
| Pending | [founder](http://schema.org/founder "http://schema.org/founder") | [Person](http://schema.org/Person "http://schema.org/Person") | A person who founded this organization. | ---
| Pending | [legalName](http://schema.org/legalName "http://schema.org/legalName") | [Text](https://schema.org/Text "https://schema.org/Text") | The official name of the organization. | ---
| Pending | [logo](http://schema.org/logo "http://schema.org/logo") | ??? | An associated logo. | ---
| Pending | [numberOfEmployees](http://schema.org/numberOfEmployees "http://schema.org/numberOfEmployees") | [QuantitativeValue](http://schema.org/QuantitativeValue "http://schema.org/QuantitativeValue") | The number of employees of the organization. | ---
| Pending | [parentOrganization](http://schema.org/parentOrganization "http://schema.org/parentOrganization") | [Organization](http://schema.org/Organization "http://schema.org/Organization") | The larger organization that this organization is a subOrganization of. | ---
| Pending | [sponsor](http://schema.org/sponsor "http://schema.org/sponsor") | ??? | A person or organization that supports a thing through a pledge, promise, or financial contribution. | ---
| Pending | [taxID](http://schema.org/taxID "http://schema.org/taxID") | [Text](https://schema.org/Text "https://schema.org/Text") | The Tax / Fiscal ID of the organization or person, e.g. the TIN in the US or the CIF/NIF in Spain. | ---
| Pending | [telephone](http://schema.org/telephone "http://schema.org/telephone") | [Text](https://schema.org/Text "https://schema.org/Text") | The telephone number. | ---

Properties from: [Thing](https://schema.org/Thing "https://schema.org/Thing")
The related propertires from the type that matters to the project.

| **Used By** | **Property** | **Type** | **Description** | [ShemaPlace Code](/docs/SchemaPlace.md) |
| ----------- | ------------ | -------- | --------------- | --------------------------------------
| Pending | [alternateName](http://schema.org/alternateName "http://schema.org/alternateName") | [Text](https://schema.org/Text "https://schema.org/Text") | An alias for the Educational Organization. | ---
| Pending | [sameAs](http://schema.org/sameAs "http://schema.org/sameAs") |  [URL](https://schema.org/URL "https://schema.org/URL") | URL of a reference Web page that unambiguously indicates the item's identity. (official website.) | ---

------------------------


# Author Page level
## Person

Properties from: [Person](http://schema.org/Person "http://schema.org/Person")
The related propertires from the type that matters to the project.

| **Used By** | **Property** | **Type** | **Description** | [ShemaPlace Code](/docs/SchemaPlace.md) |
| ----------- | ------------ | -------- | --------------- | --------------------------------------
| Pending | [additionalName]("") | []("") |  | ---
| Pending | [address](http://schema.org/address "http://schema.org/address") | [PostalAddress](http://schema.org/PostalAddress "http://schema.org/PostalAddress") | Author Address | ---
| Pending | [affiliation](http://schema.org/affiliation "http://schema.org/affiliation") | [Organization](http://schema.org/Organization "http://schema.org/Organization") | An University that this person is affiliated with. | ---
| Pending | [email](http://schema.org/email "http://schema.org/email") | [Text](https://schema.org/Text "https://schema.org/Text") | Email address. | ---
| Pending | [familyName](http://schema.org/familyName "http://schema.org/familyName") | [Text](https://schema.org/Text "https://schema.org/Text") | Family name. The last name of an Person. | ---
| Pending | [hasOfferCatalog](http://schema.org/hasOfferCatalog "http://schema.org/hasOfferCatalog") | [OfferCatalog](http://schema.org/OfferCatalog "http://schema.org/OfferCatalog") | --- Maybe in the book cover page???--- | ---
| Pending | [jobTitle](http://schema.org/jobTitle "http://schema.org/jobTitle") | [Text](https://schema.org/Text "https://schema.org/Text") | The job title of the Author. | ---
| Pending | [makesOffer](http://schema.org/makesOffer "http://schema.org/makesOffer") | [Offer](http://schema.org/Offer "http://schema.org/Offer") | A pointer to the books offered by the Author. | ---
| Pending | [memberOf](http://schema.org/memberOf "http://schema.org/memberOf") | [Organization](http://schema.org/Organization "http://schema.org/Organization") | An Organization to which this Author belongs. | ---
| Pending | [nationality](http://schema.org/nationality "http://schema.org/nationality") | [Country](http://schema.org/Country "http://schema.org/Country") | Nationality of the Author. | ---
| Pending | [telephone](http://schema.org/telephone "http://schema.org/telephone") | [Text](https://schema.org/Text "https://schema.org/Text") | The telephone number. | ---
| Pending | [worksFor](http://schema.org/worksFor "http://schema.org/worksFor") | [Organization](http://schema.org/Organization "http://schema.org/Organization") | Organizations that the Author works for. | ---


Properties from: [Thing](https://schema.org/Thing "https://schema.org/Thing")
The related propertires from the type that matters to the project.

| **Used By** | **Property**| **Type**  | **Description** | [ShemaPlace Code](/docs/SchemaPlace.md) |
| ----------- | ------------ | -------- | --------------- | --------------------------------------
| Pending | [alternateName](http://schema.org/alternateName "http://schema.org/alternateName") | [Text](https://schema.org/Text "https://schema.org/Text") | An alias for the Author | ---
| Pending | [description](http://schema.org/description "http://schema.org/description") | [Text](https://schema.org/Text "https://schema.org/Text") | A description of the Author. | ---
| Pending | [image](http://schema.org/image "http://schema.org/image") | []("") | An image of the Author. | ---
| Pending | [sameAs](http://schema.org/sameAs "http://schema.org/sameAs") | [URL](https://schema.org/URL "https://schema.org/URL") | Official website. | ---

**???  UNDER REVISION.  ?**
Properties from: [CollegeOrUniversity](http://schema.org/CollegeOrUniversity "http://schema.org/CollegeOrUniversity")
The related propertires from the type that matters to the project.

| **Used By** | **Property**| **Type**  | **Description** | [ShemaPlace Code](/docs/SchemaPlace.md) |
| ----------- | ------------ | -------- | --------------- | --------------------------------------
| Pending | [alumni](http://schema.org/alumni "http://schema.org/alumni") | ??? | ??? | ---


------------------------


# Site level
## Book

Properties from: [Book](https://schema.org/Book  "https://schema.org/Book")
All the properties from the type.

| **Used By** | **Property** | **Type** | **Description** | [ShemaPlace Code](/docs/SchemaPlace.md) |
| ----------- | ------------ | -------- | --------------- | --------------------------------------
| PB - Metadata | [bookEdition](http://schema.org/bookEdition "http://schema.org/bookEdition") | [Text](https://schema.org/Text "https://schema.org/Text")|The edition of the book.| GBI-15
|PB - Core| [bookFormat](http://schema.org/bookFormat "http://schema.org/bookFormat") | [BookFormatType](http://schema.org/BookFormatType "http://schema.org/BookFormatType")| The format of the book. | PB Fixed EBook
|PB - Metadata | [illustrator](http://schema.org/illustrator "http://schema.org/illustrator") | [Person](http://schema.org/Person "http://schema.org/Person")| The illustrator of the book. | GBI-14
| Not Used | [isbn](http://schema.org/isbn "http://schema.org/isbn")|[Text](https://schema.org/Text "https://schema.org/Text") | The ISBN of the book.| ---
| Not Used | [numberOfPages](http://schema.org/numberOfPages "http://schema.org/numberOfPages") | [ Integer ](http://schema.org/Integer "http://schema.org/Integer") | The number of pages in the book. | ---

Properties from: [Creative Work](https://schema.org/CreativeWork "https://schema.org/CreativeWork")
The related propertires from the type that matters to the project.

| **Used By** | **Property**| **Type**  | **Description** | [ShemaPlace Code](/docs/SchemaPlace.md) |
| ----------- | ------------ | -------- | --------------- | --------------------------------------
| PB - Core | [about](http://schema.org/about "http://schema.org/about") | [Thing](http://schema.org/Thing "http://schema.org/Thing")| The subject matter of the content.| ACI-12
| PB - Core | [alternativeHeadline](http://schema.org/alternativeHeadline "http://schema.org/alternativeHeadline") |  [Text](https://schema.org/Text "https://schema.org/Text") | The subtitle of the book. | GBI-03
| PB - Core | [author](http://schema.org/author "http://schema.org/author") | [Person](http://schema.org/Person "http://schema.org/Person") | The author of the book. | GBI-04
| PB - Core | [copyrightHolder](http://schema.org/copyrightHolder "http://schema.org/copyrightHolder") | [Thing](http://schema.org/Thing "http://schema.org/Thing") | Name of the copyright holder. | CR-02 
| PB - Core | [copyrightYear](http://schema.org/copyrightYear "http://schema.org/copyrightYear") | [Number](http://schema.org/Number "http://schema.org/Number") | Year that the book is/was published. | CR-01
| PB - Core | [datePublished](http://schema.org/datePublished "http://schema.org/datePublished")| [Date](http://bib.schema.org/Date "http://bib.schema.org/Date") | Date of first publication. | GBI-09
| PB - Core | [editor](http://schema.org/editor "http://schema.org/editor") | [Person](http://schema.org/Person "http://schema.org/Person") | Specifies the Person who edited the book. | ACI-03
| PB - Core | [inLanguage](http://schema.org/inLanguage "http://schema.org/inLanguage") | [Language](http://schema.org/Language "http://schema.org/Language") | The language of the book.| GBI-13
| PB - Core | [keywords](http://schema.org/keywords "http://schema.org/keywords") | [Text](https://schema.org/Text "https://schema.org/Text") | Keywords or tags used to describe this content. | ACI-05
| PB - Core | [offers](http://schema.org/offers "http://schema.org/offers") | [Offer](http://schema.org/Offer "http://schema.org/Offer") | An offer to provide this item. | PB FIXED $0.00
| PB - Core | [publisher](http://schema.org/publisher "http://schema.org/publisher") | [Person](http://schema.org/Person "http://schema.org/Person") | The publisher of the book. | GBI-07

Properties from: [Thing](https://schema.org/Thing "https://schema.org/Thing")
The related propertires from the type that matters to the project.

| **Used By** | **Property**| **Type**  | **Description** | [ShemaPlace Code](/docs/SchemaPlace.md) |
| ----------- | ------------ | -------- | --------------- | --------------------------------------
| PB - Core | [description](http://schema.org/description "http://schema.org/description") | [Text](https://schema.org/Text "https://schema.org/Text") | A short paragraph about your book. |
| PB - Core | [image](http://schema.org/image "http://schema.org/image") | [URL](https://schema.org/URL "https://schema.org/URL") | The cover of the book. | CI-01



## Course

Properties from: [Course](https://schema.org/Course  "https://schema.org/Course")
All the properties from the type.

| **Used By** | **Property** | **Type** | **Description** | [ShemaPlace Code](/docs/SchemaPlace.md) |
| ----------- | ------------ | -------- | --------------- | --------------------------------------
| PB - Metadata | [courseCode](https://schema.org/courseCode "(https://schema.org/courseCode") | [Text ](https://schema.org/Text "https://schema.org/Text" ) | The identifier for the Course used by the course provider (e.g. CS101 or 6.001). | EI-03
| PB - Metadata | [coursePrerequisites](https://schema.org/coursePrerequisites "https://schema.org/coursePrerequisites") |  [AlignmentObject](https://schema.org/AlignmentObject "https://schema.org/AlignmentObject")<ul><li>[alignmentType](http://schema.org/alignmentType "http://schema.org/alignmentType")</li><li>[educationalFramework](http://schema.org/educationalFramework "http://schema.org/educationalFramework")</li><li>[targetName](http://schema.org/targetName "http://schema.org/targetName")</li></ul> | Requirements for taking the Course. | EI-09
| Not Used | [hasCourseInstance](https://schema.org/hasCourseInstance "https://schema.org/hasCourseInstance") | [CourseInstance ](http://schema.org/CourseInstance "http://schema.org/CourseInstance") | An offering of the course at a specific time and place or through specific media or mode of study or to a specific section of students. | ---

Properties from: [Creative Work](https://schema.org/CreativeWork "https://schema.org/CreativeWork")
The related propertires from the type that matters to the project.

| **Used By** | **Property**| **Type**  | **Description** | [ShemaPlace Code](/docs/SchemaPlace.md) |
| ----------- | ------------ | -------- | --------------- | --------------------------------------
| PB - Metadata | [educationalAlignment](https://schema.org/educationalAlignment "https://schema.org/educationalAlignment") | [AlignmentObject](https://schema.org/AlignmentObject "https://schema.org/AlignmentObject")<ul><li>[alignmentType](http://schema.org/alignmentType "http://schema.org/alignmentType")</li><li>[educationalFramework](http://schema.org/educationalFramework "http://schema.org/educationalFramework")</li><li>[targetName](http://schema.org/targetName "http://schema.org/targetName")</li><li>[alternateName](http://schema.org/alternateName "http://schema.org/alternateName")</li></ul> | The educational level according to ISCED or/and to another framework of our choice. Also the Subject name and the subject type according to ISCED. | EI-04, EI-06, EI-08, EI-10 
| PB - Metadata | [interactivityType](https://schema.org/interactivityType "https://schema.org/interactivityType") | [Text](https://schema.org/Text "https://schema.org/Text") | The predominant mode of learning supported by the learning resource. Acceptable values are 'active', 'expositive', or 'mixed'. | EI-12
| PB - Metadata | [isBasedOnUrl](https://schema.org/isBasedOnUrl "https://schema.org/isBasedOnUrl") | [URL](https://schema.org/URL "https://schema.org/URL") | The URL of a website/book this book is inspirated of. | EI-15
| PB - Metadata | [learningResourceType](https://schema.org/learningResourceType "https://schema.org/learningResourceType") | [Text ](https://schema.org/Text "https://schema.org/Text") | The kind of resource this book represents. | EI-11
| PB - Metadata |  [license](https://schema.org/license "https://schema.org/license") | [URL](https://schema.org/URL "https://schema.org/URL")  | A license document that applies to this content, typically indicated by URL. | EI-14
| PB - Metadata | [provider](https://schema.org/provider "https://schema.org/provider") |  [Thing](https://schema.org/Thing "https://schema.org/Thing") | The Organization, University or Person who provides this subject. | EI-05
| PB - Metadata | [timeRequired](https://schema.org/timeRequired "https://schema.org/timeRequired") | [Text](https://schema.org/Text "https://schema.org/Text") | The time required for this book. | EI-13
| PB - Metadata | [typicalAgeRange](https://schema.org/typicalAgeRange "https://schema.org/typicalAgeRange") | [Text](https://schema.org/Text "https://schema.org/Text") |The target age of this book. | EI-07

Properties from: [Thing](https://schema.org/Thing "https://schema.org/Thing")
The related propertires from the type that matters to the project.

| **Used By** | **Property**| **Type**  | **Description** | [ShemaPlace Code](/docs/SchemaPlace.md) |
| ----------- | ------------ | -------- | --------------- | --------------------------------------
| PB - Metadata | [description](https://schema.org/description "https://schema.org/description") | [Text ](https://schema.org/Text "https://schema.org/Text") | A short description about this subject. | EI-02 
| PB - Metadata | [name](https://schema.org/name "https://schema.org/name") | [Text ](https://schema.org/Text "https://schema.org/Text")|The name of the subject. | EI-01

------------------------

# Post level

## WebPage

Properties from: [Creative Work](https://schema.org/CreativeWork "https://schema.org/CreativeWork")
The related propertires from the type that matters to the project.

| **Used By** | **Property**| **Type**  | **Description** | [ShemaPlace Code](/docs/SchemaPlace.md) |
| ----------- | ------------ | -------- | --------------- | --------------------------------------
| PB - Core | [about](http://schema.org/about "http://schema.org/about") | [Thing](http://schema.org/Thing "http://schema.org/Thing")| The subject matter of the content.| ACI-12
| PB - Core | [copyrightHolder](http://schema.org/copyrightHolder "http://schema.org/copyrightHolder") | [Thing](http://schema.org/Thing "http://schema.org/Thing") | Name of the copyright holder. | CR-02 
| PB - Core | [copyrightYear](http://schema.org/copyrightYear "http://schema.org/copyrightYear") | [Number](http://schema.org/Number "http://schema.org/Number") | Year that the book is/was published. | CR-01
| PB - Core | [inLanguage](http://schema.org/inLanguage "http://schema.org/inLanguage") | [Language](http://schema.org/Language "http://schema.org/Language") | The language of the Post.| GBI-13 
| PB - Core | [publisher](http://schema.org/publisher "http://schema.org/publisher") | [Person](http://schema.org/Person "http://schema.org/Person") | The publisher of the book. | GBI-07
| Not Used | [breadcrumb](http://schema.org/breadcrumb "http://schema.org/breadcrumb") | [Text](https://schema.org/Text "https://schema.org/Text") | --- | ---
| Not Used | [lastReviewed](http://schema.org/lastReviewed "http://schema.org/lastReviewed") |  [Date](http://bib.schema.org/Date "http://bib.schema.org/Date") | --- | ---
| Not Used | [mainContentOfPage](http://schema.org/mainContentOfPage "http://schema.org/mainContentOfPage") | [WebPageElement](http://schema.org/WebPageElement "http://schema.org/WebPageElement") | --- | ---
| Not Used | [primaryImageOfPage](http://schema.org/primaryImageOfPage "http://schema.org/primaryImageOfPage") | [ImageObject](http://schema.org/ImageObject "http://schema.org/ImageObject") | --- | ---
| Not Used | [relatedLink](http://schema.org/relatedLink "http://schema.org/relatedLink") | [URL](https://schema.org/URL "https://schema.org/URL") | --- | ---
| Not Used | [reviewedBy](http://schema.org/reviewedBy "http://schema.org/reviewedBy") |  [Person](http://schema.org/Person "http://schema.org/Person") | --- | ---
| Not Used | [significantLink](http://schema.org/significantLink "http://schema.org/significantLink") | [URL](https://schema.org/URL "https://schema.org/URL") | --- | ---
| Not Used | [specialty](http://schema.org/specialty "http://schema.org/specialty") | [Specialty](http://schema.org/Specialty"http://schema.org/Specialty")  | --- | ---

## ScholarlyArticle

Properties from: [Scholarly Article](https://schema.org/ScholarlyArticle "https://schema.org/ScholarlyArticle")
All the properties from the type.

| **Used By** | **Property**| **Type**  | **Description** | [ShemaPlace Code](/docs/SchemaPlace.md) |
| ----------- | ------------ | -------- | --------------- | --------------------------------------
| PB - Metadata |[wordCount](http://bib.schema.org/wordCount "http://bib.schema.org/wordCount") | [Integer](https://schema.org/Integer "https://schema.org/Integer") | The number of words in the text of the Article. | WP Post Word count


Properties from: [Creative Work](https://schema.org/CreativeWork "https://schema.org/CreativeWork")
The related propertires from the type that matters to the project.

| **Used By** | **Property**| **Type**  | **Description** | [ShemaPlace Code](/docs/SchemaPlace.md) |
| ----------- | ------------ | -------- | --------------- | --------------------------------------
| PB - Metadata |[alternativeHeadline](http://bib.schema.org/alternativeHeadline "http://bib.schema.org/alternativeHeadline") | [Text](https://schema.org/Text "https://schema.org/Text") | The subtitle of the chapter. | CCM-02
| PB - Metadata |[audience](http://bib.schema.org/audience "http://bib.schema.org/audience") | [Audience](https://schema.org/Audience "https://schema.org/Audience") | The audience from Book Info. | EI-07
| PB - Metadata |[author](http://bib.schema.org/author "http://bib.schema.org/author") | [Person](http://schema.org/Person "http://schema.org/Person") | The author's id name. | CCM-03
| PB - Metadata |[citation](http://bib.schema.org/citation "http://bib.schema.org/citation") | [URL](http://bib.schema.org/URL "http://bib.schema.org/URL") | The Bibliography URL. |
| by PB - Core | [copyrightHolder](http://schema.org/copyrightHolder "http://schema.org/copyrightHolder") | [Thing](http://schema.org/Thing "http://schema.org/Thing") | Name of the copyright holder. | CR-02
| by PB - Core | [copyrightYear](http://schema.org/copyrightYear "http://schema.org/copyrightYear") | [Number](http://schema.org/Number "http://schema.org/Number") | Year that the book is/was published. | CR-01
| PB - Metadata | [dateModified](http://bib.schema.org/dateModified "http://bib.schema.org/dateModified") | [Date](http://bib.schema.org/Date "http://bib.schema.org/Date") | The date on which the Chapter was most recently modified. | WP Post Updating Time
| PB - Metadata | [datePublished](http://schema.org/datePublished "http://schema.org/datePublished") | [Date](http://bib.schema.org/Date "http://bib.schema.org/Date") | Date of first broadcast/publication. | WP Post Publishing Time
| PB - Metadata | [discussionUrl](http://bib.schema.org/discussionUrl "http://bib.schema.org/discussionUrl") | [URL](http://bib.schema.org/URL "http://bib.schema.org/URL") | The URL of a forum/discussion about this page. |
| PB - Metadata |[editor](http://bib.schema.org/editor "http://bib.schema.org/editor") | [Person](http://schema.org/Person "http://schema.org/Person") | Specifies the Person who edited the book. | ACI-03
| PB - Metadata |[headline](http://bib.schema.org/headline "http://bib.schema.org/headline") | [Text](https://schema.org/Text "https://schema.org/Text") | The title of the chapter. |
| by PB - Core | [inLanguage](http://schema.org/inLanguage "http://schema.org/inLanguage") | [Language](http://schema.org/Language "http://schema.org/Language") | The language of the Post.| GBI-13 
| PB - Metadata | [license](http://schema.org/license "http://schema.org/license") | [URL](http://bib.schema.org/URL "http://bib.schema.org/URL") | A license document that applies to this content, typically indicated by URL.| EI-14
| PB - Metadata |[locationCreated](http://bib.schema.org/locationCreated "http://bib.schema.org/locationCreated") | [Place](https://schema.org/Place "https://schema.org/Place") | The Publisher City of the book. | GBI-08
| by PB - Core |[publisher](http://bib.schema.org/publisher "http://bib.schema.org/publisher") | [Thing](http://schema.org/Thing "http://schema.org/Thing") | The publisher of the book. |GBI-07
| PB - Metadata | [timeRequired](http://bib.schema.org/timeRequired "http://bib.schema.org/timeRequired") | [Duration](http://bib.schema.org/Duration "http://bib.schema.org/Duration") | The class learning time in minutes. |
| PB - Metadata |[translator](http://bib.schema.org/translator "http://bib.schema.org/translator") | [Thing](http://schema.org/Thing "http://schema.org/Thing") | The translator of the book. |ACI-04 
| PB - Metadata | [typicalAgeRange](https://schema.org/typicalAgeRange "https://schema.org/typicalAgeRange") | [Text](https://schema.org/Text "https://schema.org/Text") | The target age of this book. | EI-07


Properties from: [Thing](https://schema.org/Thing "https://schema.org/Thing")
The related propertires from the type that matters to the project.

| **Used By** | **Property**| **Type**  | **Description** | [ShemaPlace Code](/docs/SchemaPlace.md) |
| ----------- | ------------ | -------- | --------------- | --------------------------------------
| PB - Metadata | [image](https://schema.org/image "https://schema.org/image") | [URL](https://schema.org/URL "https://schema.org/URL") | The cover of the book. | CI-01





[up](#schema-properties-used)

(Descriptions here are full descriptions)

