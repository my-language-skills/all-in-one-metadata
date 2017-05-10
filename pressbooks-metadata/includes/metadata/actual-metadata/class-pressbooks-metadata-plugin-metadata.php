<?php


require_once plugin_dir_path( __FILE__ )
	. '../class-pressbooks-metadata-metadata-fetcher.php';


require_once plugin_dir_path( __FILE__ )
	. '../include-concrete-metadata-fields.php';

/**
 * The metadata included/used by this plugin.
 *
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes/metadata/actual-metadata
 * @author     julienCXX <software@chmodplusx.eu>
 * @author 	   Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */
abstract class Pressbooks_Metadata_Plugin_Metadata {

	/**
	 * The metadata components contained in this object.
	 *
	 * @since  0.1
	 * @access private
	 * @var    array   $components The metadata components contained in this
	 * object.
	 */
	private $components;

	/**
	 * The post types used in the components used by the components
	 * contained in this object.
	 *
	 * @since  0.1
	 * @access private
	 * @var    SplObjectStorage $post_types The post types used in the
	 * components used by the components contained in this object.
	 * The SplObjectStorage object ensures the post types unicity.
	 */
	private $post_types;

	/**
	 * The prefix to prepend to each slug, when adding metadata to the
	 * dashboard.
	 *
	 * @since  0.1
	 * @access private
	 * @var    string $slug_prefix The slug prefix.
	 */
	private static $slug_prefix = 'lb_';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  0.1
	 */
	protected function __construct() {

		$this->components = array();
		$this->post_types = array();

	}

	/**
	 * Returns the metadata components contained in this object.
	 *
	 * @since  0.1
	 * @return array The metadata components contained in this object.
	 */
	protected function get_components() {

		return $this->name;

	}

	/**
	 * Returns the metadata components contained in this object.
	 *
	 * @since  0.1
	 * @return array The metadata components contained in this object.
	 */
	private function add_post_type( $post_type ) {

		if ( FALSE !== array_search( $post_type, $this->post_types ) ) {
			return; // type already present
		}
		$this->post_types[] = $post_type;

	}

	/**
	 * Adds a metadata component to the components managed by this object.
	 *
	 * @since 0.1
	 * @param Pressbooks_Metadata_Abstract_Metadata $component The component to add.
	 */
	protected function add_component(
		Pressbooks_Metadata_Abstract_Metadata $component ) {

		foreach ( $component->get_post_types() as $type ) {
			$this->add_post_type( $type );
		}
		$this->components[] = $component;

	}

	/**
	 * Adds an array of metadata components to the components managed by
	 * this object.
	 *
	 * @since 0.1
	 * @param array $components The components to add.
	 */
	protected function add_components( $components ) {

		foreach ( $components as $cpnt ) {
			$this->add_component( $cpnt );
		}

	}

	/**
	 * Adds the metadata components from this object to the current post
	 * metadata dashboard.
	 *
	 * @since 0.1
	 */
	public function add_to_current_post_metadata() {

		foreach ( $this->components as $cpnt ) {
			$cpnt->add_to_current_post_metadata(
				Pressbooks_Metadata_Plugin_Metadata::$slug_prefix );
		}

	}

	/**
	 * Returns the metadata objects for the current post (book, page, etc.)
	 * with their values.
	 *
	 * @since  0.1
	 * @return array The metadata objects with their values as an array of
	 * Pressbooks_Metadata_Abstract_Metadata.
	 */
	public function get_current_metadata() {

		// retrieve metadata from all concerned post types
		$fetched_meta = array();
		foreach ( $this->post_types as $post_type) {
			$fetched_meta = array_merge( $fetched_meta,
				Pressbooks_Metadata_Metadata_Fetcher::fetch_unprefixed_metadata(
					$post_type,
					Pressbooks_Metadata_Plugin_Metadata::$slug_prefix ) );
		}
		$ret = array();
		foreach ( $this->components as $cpnt ) {
			$clone = $cpnt->clone_with_value( $fetched_meta );
			if ( NULL !== $clone ) {
				$ret = array_merge( $ret,
					array( $cpnt->get_slug() => $clone ) );
			}
		}
		return $ret;

	}

	/**
	 * Returns the metadata objects for the current post (book, page, etc.)
	 * with their values.
	 * Keeps only actual fields with a value and flattens the metadata tree
	 * (the fields in a group are extracted from this group).
	 *
	 * @since  0.1
	 * @return array The metadata objects with their values as an array of
	 * Pressbooks_Metadata_Data_Field.
	 */
	public function get_current_metadata_flat() {

		$tree = $this->get_current_metadata();
		$ret = array();
		foreach ( $tree as $key => $val ) {
			if ( $val->is_group_of_fields() ) {
				$ret = array_merge( $ret, $val->get_fields() );
			} else {
				$ret[ $key ] = $val;
			}
		}

		return $ret;

	}

	/**
	 * Prints the HTML meta tags containing microdata information of
	 * metadata contained in this object, for the public part of the book.
	 * 
	 * Produces the microdata code for the fields that have the $itemprop argument filled.
	 *
	 * @since 0.1
	 */
	public function print_microdata_meta_tags() {

		$meta = $this->get_current_metadata_flat();

		foreach ( $meta as $elt ) {
			$it = $elt->get_itemprop();
			if( ! empty( $it ) ) {
				//if the schema is timeRequired, we are using a specific format to display it, like the example here: https://schema.org/timeRequired
				if ( 'timeRequired' == $it ) { ?>
	<meta itemprop = '<?php echo $it; ?>' content = '<?php echo 'PT'. $elt->toMicrodataString() . ($elt->get_slug() == 's_md_class_learning_time'? 'M' : 'H'); ?>' />
				<?php
				}else{
?>
	<meta itemprop = '<?php echo $it; ?>' content = '<?php echo $elt->toMicrodataString(); ?>' id='<?php echo $it; ?>' />
<?php
				}
			}
		}

	}

/**
	 * Returns the ISCED level code according to what is
	 * chosen in the 's_md_isced_level' field.
	 *
	 * @since  0.3
	 * @return string 
	 */
	public function get_isced_level_code() {

		$meta = $this->get_current_metadata_flat();

		if ($meta['s_md_isced_level'] == 'Early Childhood Education'){
			$level_code = '0';
		}
		elseif ($meta['s_md_isced_level'] == 'Primary education') {
			$level_code = '1';
		}
		elseif ($meta['s_md_isced_level'] == 'Lower secondary education') {
			$level_code = '2';
		}
		elseif ($meta['s_md_isced_level'] == 'Upper secondary education') {
			$level_code = '3';
		}
		elseif ($meta['s_md_isced_level'] == 'Post-secondary non-tertiary education') {
			$level_code = '4';
		}
		elseif ($meta['s_md_isced_level'] == 'Short-cycle tertiary education') {
			$level_code = '5';
		}
		elseif ($meta['s_md_isced_level'] == 'Bachelor’s or equivalent level') {
			$level_code = '6';
		}
		elseif ($meta['s_md_isced_level'] == 'Master’s or equivalent level') {
			$level_code = '7';
		}
		elseif ($meta['s_md_isced_level'] == 'Doctoral or equivalent level') {
			$level_code = '8';
		}
		else{
			$level_code = '9';
		}

		return $level_code;

	}

	/**
	 * Prints the HTML educationalAlignment meta tags containing microdata information of
	 * metadata contained in this object, for the public part of the book.
	 *
	 * The educationalAlignment properties are not just one line of code but they are more complicated
	 * than the normal ones. So the print_microdata_meta_tags() functions will not work.
	 * Here, if some specific fields are set (subject, isced_field, isced_level...), the code is 
	 * being produced.
	 * 
	 * @since 0.2
	 */
	public function print_educationalAlignment_microdata_meta_tags() {

		$meta = $this->get_current_metadata_flat();
		$level = $this->get_isced_level_code();

		if ( isset( $meta['s_md_subject_name'] ) ) {
?>

	<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>	
		<meta itemprop = 'alignmentType' content = 'educationalSubject' />
		<meta itemprop = 'targetName' content = '<?php echo $meta['s_md_subject_name']->toMicrodataString(); ?>' />
	</span>

<?php
		}

		if ( $meta['s_md_isced_field'] != 'ISCED field of education' ) {
?>
	<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>
		<meta itemprop = 'alignmentType' content = 'educationalSubject' />
		<meta itemprop = 'educationalFramework' content = 'ISCED-2013'/>
		<meta itemprop = 'targetName' content = '<?php echo $meta['s_md_isced_field']->toMicrodataString(); ?>' />
	</span>

<?php
		}

		if ( $meta['s_md_isced_level'] != 'ISCED level of education' ) {
?>
	<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>
		<meta itemprop = 'alignmentType' content = 'educationalLevel' />
		<meta itemprop = 'educationalFramework' content = 'ISCED-2011'/>
		<meta itemprop = 'targetName' content = '<?php echo $meta['s_md_isced_level']->toMicrodataString(); ?>' />
		<meta itemprop = 'alternateName' content = 'ISCED 2011, Level <?php echo $level; ?>' />
	</span>

<?php
		}

		if ( isset( $meta['s_md_edu_level'] ) && isset( $meta['s_md_edu_framework'] )) {
?>
	<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>
		<meta itemprop = 'alignmentType' content = 'educationalLevel' />
		<meta itemprop = 'educationalFramework' content = '<?php echo $meta['s_md_edu_framework']->toMicrodataString(); ?>'/>
		<meta itemprop = 'targetName' content = '<?php echo $meta['s_md_edu_level']->toMicrodataString(); ?>' />
	</span>

<?php
		} elseif ( isset( $meta['s_md_edu_level'] ) && !isset( $meta['s_md_edu_framework'] )) {
?>
	<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>
		<meta itemprop = 'alignmentType' content = 'educationalLevel' />
		<meta itemprop = 'targetName' content = '<?php echo $meta['s_md_edu_level']->toMicrodataString(); ?>' />
	</span>

<?php
		}

		if ( isset( $meta['s_md_course_prerequisites'] ) && isset( $meta['s_md_edu_framework'] )) {
?>
	<span itemprop = 'coursePrerequisites' itemscope itemtype = 'http://schema.org/AlignmentObject'>
		<meta itemprop = 'alignmentType' content = 'educationalLevel' />
		<meta itemprop = 'educationalFramework' content = '<?php echo $meta['s_md_edu_framework']->toMicrodataString(); ?>'/>
		<meta itemprop = 'targetName' content = '<?php echo $meta['s_md_course_prerequisites']->toMicrodataString(); ?>' />
	</span>

<?php
		} elseif ( isset( $meta['s_md_course_prerequisites'] ) && !isset( $meta['s_md_edu_framework'] )) {
?>
	<span itemprop = 'coursePrerequisites' itemscope itemtype = 'http://schema.org/AlignmentObject'>
		<meta itemprop = 'alignmentType' content = 'educationalLevel' />
		<meta itemprop = 'targetName' content = '<?php echo $meta['s_md_course_prerequisites']->toMicrodataString(); ?>' />
	</span>

<?php
		}
		

	}

	/**
	 * A function to retrieve the data we need from the custom fields of PressBooks
	 * for ScholarlyArticle plus the wordCount
	 *
	 * @since 0.5
	 */
	public function print_ScolarlyArticle_meta_tags(){

		//array of the items that we need from the General Book Information metabox
		$book_info_data = array(
			'image' 				=>	'pb_cover_image',
		//	'author' 				=>	'pb_section_author',
			'audience' 				=>	'pb_audience',
			'editor'				=>	'pb_editor',
			'translator'			=>	'pb_translator',
		//	'contributor' 			=>	'pb_contributing_authors',		//To review for multiple contributors
		//	'alternativeHeadline'	=>	'pb_subtitle',
			'locationCreated'		=>	'pb_publisher_city',
			'license'				=>	'pb_section_license'
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

		//To retrieve the word count number
		global $post;
    
    	$char_list = '';
   		$wordCount = str_word_count(strip_tags($post->post_content), 0, $char_list);
?>
	<meta itemprop = 'wordCount' content='<?php echo $wordCount?>' />
<?php

	}


	/**
	 * A function to retrieve the data we need to add to the
	 * ScholarlyArticle from the fields of Educational Information metabox
	 *
	 * @since 0.5
	 */
	public function print_ScolarlyArticle_meta_tags_from_Edu_Info(){
		
	//array of the items that we need from the Educational Information metabox
		$book_info_data = array(
			'citation'			=> 	's_md_bibliography_url',
			'license'			=>	's_md_license_url',
			'typicalAgeRange'	=>	's_md_age_range'
		);

		$metadata = $this->get_current_metadata_flat();

		foreach ($book_info_data as $itemprop => $content){
			if ( isset( $metadata[$content] ) ) {
?>
	<meta itemprop = '<?php echo $itemprop ?>' content = '<?php echo $metadata[$content] ?>' />
<?php
			}
		}
	}


	/**
	 * A function to retrieve the data we need to add to the
	 * ScholarlyArticle from the fields of Chapter Metadata metabox
	 *
	 * @since 0.6
	 */
	public function print_Chapter_Metadata_meta_tags(){

		global $post;

		$id = $post->ID; 
		$post_meta = get_post_meta( $id );

	//array of the items that we need from the Chapter Metadata metabox
		$chapter_info_data = array(
			'author'					=> 	'pb_section_author',
			'alternativeHeadline'		=>	'pb_subtitle'
		);

		foreach ($chapter_info_data as $itemprop => $content){
			if ( isset( $post_meta[$content] ) ) {
?>
	<meta itemprop = '<?php echo $itemprop ?>' content = '<?php echo $post_meta[$content][0] ?>' />
<?php
			}
		}
	}

	/**
	 * A function to retrieve the data we need from the custom fields of PressBooks
	 * for Google Scholar use
	 *
	 * @since 0.7
	 */
	public function print_Google_Scolar_meta_tags(){

		//array of the items that we need from the General Book Information metabox
		$book_info_data = array(
			'citation_journal_title'	=>	'pb_title',
			'citation_author' 			=>	'pb_author',
			'citation_language'         => 	'pb_language',
			'citation_keywords'         =>	'pb_keywords_tags',
	//		'citation_pdf_url'          => 	s_md_get_citation_pdf_url(),
			'citation_isbn' 			=>	'pb_ebook_isbn',
			'citation_publisher'		=>	'pb_publisher',
			'citation_publication_date'	=>	'pb_publication_date'
		);

		//For the fields of General Book Information Metabox
		$metadata = \Pressbooks\Book::getBookInformation();

		foreach ($book_info_data as $name => $content){
			if ( isset( $metadata[$content] ) ) {
				if ( 'pb_publication_date' == $content ) {
					$metadata[$content] = date( 'Y/m/d', (int) $metadata[ $content ] );
				}
?>
	<meta name = '<?php echo $name ?>' content = '<?php echo $metadata[$content] ?>' />
<?php
			}
			elseif ('citation_pdf_url' == $name) {
?>
<!--	<meta name = '<?php echo $name ?>' content = 'omorfonios' /> -->
<?php
			}
		}

	}

	/**
	 * A function that returns the url of the pdf downloadable file
	 *
	 * @since 0.7
	 */
	function s_md_get_citation_pdf_url() {
		$url    = '';
		$domain = site_url();

		if ( method_exists( '\Pressbooks\Utility', 'latest_exports' ) ) {
			$files = \Pressbooks\Utility\latest_exports();

			$options = get_option( 'pbt_redistribute_settings' );
			if ( ! empty( $files ) && ( true == $options['latest_files_public'] ) ) {

				foreach ( $files as $filetype => $filename ) {
					if ( 'pdf' == $filetype || 'mpdf' == $filetype ) {
						$filename = preg_replace( '/(-\d{10})(.*)/ui', "$1", $filename );
						// rewrite rule
						$url = $domain . "/open/download?filename={$filename}&type={$filetype}";
					}
				}
			}
		}

		return $url;
	}

}

