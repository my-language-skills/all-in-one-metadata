# Use this file if you want to extend Pressbooks Metadata Plugin.
## Extending: Schema Types
### STEPS:

1.	Create a new file in the schemaTypes -> class-pressbooks-metadata-‘name of the type’.php
2.	Use the template below and replace the text whenever you see [schematype] or [schemaprop] or [schema-meta-value].
Remember some schema types need modifications on how they present the metadata,
sometimes you will have to change the function [pmdt_get_metatags()]. This is the only function you are likely to change,
all other structure must remain the same for the correct functionality of the plugin.
Use the x_add_metadata_field() function in the pmdt_add_metabox() function to create the desired input fields for the schema type.

**EDIT TEMPLATE CODE**
```
<?php
/**
 * The class for the [schematype] type including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/schemaTypes
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */

class Pressbooks_Metadata_[schematype] {

   /**
    * The type level where these metaboxes and their schema operations will go
    *
    * @since    0.x
    * @access   private
    */
   private $type_level;

   public function __construct($type_level_input) {
      $this->type_level = $type_level_input;
      $this->pmdt_add_metabox($this->type_level);
   }
   /**
    * The function which produces the metaboxes for the [schematype] type
    * @param string Accepting a string so we can distinguish on witch place each metabox is created
    * The value passed here is also used when calling the metadata functions in the header and the footer.
    * @since 0.8.1
    */
   private function pmdt_add_metabox($meta_position){
      //----------- metabox ----------- //
      x_add_metadata_group(  '[schematype]', $meta_position, array(
         'label'       => '[schematype] Type Properties',
         'priority'        => 'high',
     ) );
     //----------- metafields ----------- //
     // [schemaprop]
     x_add_metadata_field(  'pb_[schemaprop]_'.$meta_position, $meta_position, array(
        'group'       =>     '[schematype]',
        'label'       =>     '[schemaprop]',
     ) );
  }

     /* FUNCTIONS FOR THIS TYPE START HERE */

  /**
   * Returns type level.
   *
   * @since    0.x
   * @access   public
   */
  public function pmdt_get_type_level(){
        return $this->type_level;
     }

  /**
   * A function needed for the array of metadata that comes from each post or chapter
   * It automatically returns the first item in the array.
   * @since 0.8.1
   *
   */
  private function pmdt_get_first($my_array){
     return $my_array[0];
  }
  /**
   * A function that creates the metadata for the [schematype] type.
   * @since 0.8.1
   *
   */
  public function pmdt_get_metatags() {
     //Distinguishing if we are working on a post --- chapter level or on the main site level
     //The type_level variable is the string we used to create the metabox

     if ( $this->type_level == 'chapter' ) { //loading the appropriate metadata depending on the type level
        $metadata = get_post_meta( get_the_ID() );
     } else {
        $metadata = \Pressbooks\Book::getBookInformation();
     }

     // array of the items needed to become microtags
     $book_data = array(

        '[schemaprop]' => '[schema-meta-vlaue]',
        '[schemaprop]' => '[schema-meta-value]' 
     );

     $html = "<!-- Microtags --> \n";

     //This code is needed for the [schemtaype] type on chapter 
	 level because by default the chapter is a website
	       $html .= ( $this->type_level == 'chapter' ? '<div itemscope itemtype="http://schema.org/[schematype]">' : '' );

	       foreach ( $book_data as $itemprop => $content ) {
	          if ( isset( $metadata[ $content . '_' . $this->type_level ] ) ) {

	             if ( $this->type_level == 'chapter' ) { //we are using the get_first function to get the value from the returned array
	                $value = $this->pmdt_get_first( $metadata[ $content . '_' . $this->type_level ] );
	             } else {
	                $value = $metadata[ $content . '_' . $this->type_level ];
	             }

	             $html .= "<meta itemprop = '" . $itemprop . "' content = '" . $value . "'>\n";
	          }
	       }
	       $html .= ( $this->type_level == 'chapter' ? '</div>' : '' );
	       return $html;
	    }
	 }
```
**EDIT ADMIN CODE #1**
Editing the admin file of the plugin: class-pressbooks-metadata-admin.php

```
//Every setting you create can be accessed using the example here
//book_type -> This is the id of a field in the array below
//book_level -> This is the section id that this fields exists (we have 2 sections for now BOOK AND CHAPTER)
//if you add them together with a '_' you have the setting -> book_type_book_level
//Use get_option() to get the value from the database (Process is Automatic)
$this->metaSettings =
   array(
      //For every new type we add we need to add the settings here, url can be empty
   'book_type'    => array( 'Book Type', 'http://schema.org/Book' ),
   'course_type'  => array( 'Course Type', 'http://schema.org/Course' ),
   'webpage_type' => array( 'Webpage Type', 'http://schema.org/WebPage' ),
   'educational_info' => array('Educational Information','')
);
```

Here you have to add new values to the array, this array is used for the settings page of the plugin and also for the generation of class instances for the types.
For example if we are adding a new type named custom type we would add this to the array [custom_type => array(‘Custom Type’),’url’].
Url is optional because the creation of custom types is also available.

**EDIT ADMIN CODE #2**
Here we will see the final process of adding a new schema type,
we are still editing the admin file. Be aware this is one of the most important steps as this is the place where all schema type objects are instantiated.
This function is called for creating an array variable named $instances. This variable is used for running metadata and for creating the metaboxes.
The variable contents are all the classes for the schema types enabled from the settings. Each enabled type on each level has one instance in this variable.

```
	/**
 * Function used to return all instances for the selected types,
 * Instances are used to create the metaboxes and the metadata
 * For every new type that we add we need to make modifications here
 *
 * @since  0.x
 */
private function pmdt_engine_run(){
   $instances = array();
   $levels = array(
      //For every new level / custom post type we add we need modifications here
      'book_level' => 'metadata',
      'chapter_level' => 'chapter'
   );

   foreach ($levels as $level => $cpt) {
      foreach ($this->metaSettings as $type => $link){

         if(get_option($type.'_'.$level)){
            switch($type){

               case 'book_type':
                  $instances[] = new Pressbooks_Metadata_Book($cpt);
                  break;

               case 'course_type':
                  $instances[] = new Pressbooks_Metadata_Course($cpt);
                  break;

               case 'webpage_type':
                  $instances[] = new Pressbooks_Metadata_WebPage($cpt);
                  break;

               case 'educational_info':
                  //Preventing the Educational metadata being created or run on chapter level (for now)
                  if($cpt != 'chapter'){
                     $instances[] = new Pressbooks_Metadata_Educational($cpt);
                  }
                  break;
            }

         }

      }
   }
   $instances = $this->pmdt_handle_parent_types($instances);
   return $instances;
}
```

For our example we used a type, named custom type.
So this is the code we need to add for it to work.
Please append this code to the switch statement,
be careful when creating the new object, 
use the correct name of the class. 
Make sure that the value you are using on the case matches the first value from the settings array.

```
case 'custom_type':
                  $instances[] = new Pressbooks_Metadata_Custom($cpt);
                  break;
```