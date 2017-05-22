<?php
/**
 * Globally-accessible functions
 *
 * @link 		http://books4languages.com
 * @since 		0.8
 *
 * @package		Pressbooks_Metadata
 * @subpackage 	Pressbooks_Metadata/includes
 */

/**
	 * A function that produces the micrptags of Book
	 *
	 * @since 0.8
	 */
	public function print_Book_metatags(){

		//array of the items that we need from the General Book Information metabox
		$book_info_data = array(
			'illustrator' 				=>	'pb_illustrator',
			'bookEdition'				=>	'pb_edition',
		);

		//For the fields of General Book Information Metabox
		$metadata = \Pressbooks\Book::getBookInformation();

		foreach ($book_info_data as $itemprop => $content){
			if ( isset( $metadata[$content] ) ) {
?>
	<meta itemprop = '<?php echo $itemprop ?>' content = '<?php echo $metadata[$content] ?>' />
<?php
			}
		}

	}


?>