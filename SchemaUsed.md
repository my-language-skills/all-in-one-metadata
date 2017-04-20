# Schema Properties Used

### We use different properties in every of these 3 levels
  - Network level
  - Site level
  - Post level
 
------------------------
##### Network level
  - WebSite

##### Site level
  - Book
  - Course
  
##### Post level
  - WebPage
  - Chapter
------------------------

### Site level

|  Book                                                           |                                                       |                                               |
| --------------------------------------------------------------- | ----------------------------------------------------- | --------------------------------------------- |
| Property                                                        |                        Type                           |                  Description                  |
| **Properties from Book**                                        |                                                       | https://schema.org/Course                     |
| [bookEdition](http://schema.org/bookEdition)                    | [Text](https://schema.org/Text)                       | The edition of the book.                      |
| [illustrator](http://schema.org/illustrator)                    | [Person](http://schema.org/Person)                    | The illustrator of the book.                  |

|  Course                                                         |                                                       |                                               |
| --------------------------------------------------------------- | ----------------------------------------------------- | --------------------------------------------- |
| Property                                                        |                        Type                           |                  Description                  |
| **Properties from Course**                                      |                                                       | https://schema.org/Course                     |
| [courseCode](https://schema.org/courseCode)                     | [Text ](https://schema.org/Text)                      | The identifier for the Course used by the course provider (e.g. CS101 or 6.001).|
| [coursePrerequisites](https://schema.org/coursePrerequisites)   | [AlignmentObject](https://schema.org/AlignmentObject) | Requirements for taking the Course            |
| **Properties from CreativeWork**                                |                                                       | https://schema.org/CreativeWork               |
| [educationalAlignment](https://schema.org/educationalAlignment) | [AlignmentObject](https://schema.org/AlignmentObject) | The educational level according to ISCED or/and to another framework of our choice. Also the Subject name and the subject type according to ISCED.|
| [interactivityType](https://schema.org/interactivityType)       | [Text ](https://schema.org/Text)                      | The predominant mode of learning supported by the learning resource. Acceptable values are 'active', 'expositive', or 'mixed'.|
| [provider](https://schema.org/provider)                         | [Thing](https://schema.org/Thing)                     | The Organization, University or Person who provides this subject. |
| [typicalAgeRange](https://schema.org/typicalAgeRange)           | [Text ](https://schema.org/Text)                      | The target age of this book.                  |
| [learningResourceType](https://schema.org/learningResourceType) | [Text ](https://schema.org/Text)                      | The kind of resource this book represents.    |
| [license](https://schema.org/license)                           | [URL](https://schema.org/URL)                         | A license document that applies to this content, typically indicated by URL. |
| [isBasedOnUrl](https://schema.org/isBasedOnUrl)                 | [URL](https://schema.org/URL)                         | The URL of a website/book this book is inspirated of |
| **Properties from Thing**                                       |                                                       | https://schema.org/Thing                      |
| [description](https://schema.org/description)                   | [Text ](https://schema.org/Text)                      | A short description about this subject.       |
| [name](https://schema.org/name)                                 | [Text ](https://schema.org/Text)                      | The name of the subject.                      |

-----

### Post level

| Chapter                                                         |                                                       |                                                |
| --------------------------------------------------------------- | ----------------------------------------------------- | ---------------------------------------------- |
| Property                                                        |                        Type                           |                   Description                  |
| **Properties from CreativeWork**                                |                                                       | https://schema.org/CreativeWork                |
| [author](http://bib.schema.org/author)                          | [Person](http://schema.org/Person)                    | The author's id name.                          |
| [dateModified](http://bib.schema.org/dateModified)              | [Date](http://bib.schema.org/Date)                    | The date on which the Chapter was most recently modified.|
| [datePublished](http://schema.org/datePublished)                | [Date](http://bib.schema.org/Date)                    | Date of first broadcast/publication.           |
| [timeRequired](http://bib.schema.org/timeRequired)              | [Duration](http://bib.schema.org/Duration)            | The class learning time in minutes.            |
| **Properties from Thing**                                       |                                                       | http://bib.schema.org/Thing                    |
| [name](https://schema.org/name)                                 | [Text ](https://schema.org/Text)                      | The title of the chapter.                      |
| [url](http://bib.schema.org/url)                                | [URL](http://bib.schema.org/URL)                      | The URL of a forum/discussion about this page. |


