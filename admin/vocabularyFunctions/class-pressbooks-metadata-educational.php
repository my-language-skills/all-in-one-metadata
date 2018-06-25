<?php

namespace vocabularyFunctions;
use schemaFunctions\Pressbooks_Metadata_Create_Metabox as create_metabox;
use schemaFunctions\Pressbooks_Metadata_General_Functions as genFunc;

/**
 * The class for the educational custom vocabulary including operations and metaboxes
 *
 * @link       https://github.com/Books4Languages/pressbooks-metadata
 * @since      0.x
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/admin/vocabularyFunctions
 * @author     Christos Amyrotos <christosv2@hotmail.com>
 * @author     Vasilis Georgoudis <vasilios.georgoudis@gmail.com>
 */
class Pressbooks_Metadata_Educational{

	/**
	 * The type level that identifies where these metaboxes will be created
	 *
	 * @since    0.x
	 * @access   public
	 */
	public $type_level;

	/**
	 * The variable that holds the values from the database for the vocabulary output
	 *
	 * @since    0.x
	 * @access   public
	 */
	public $metadata;

	/**
	 * The variable that holds the group id of the metabox
	 *
	 * @since    0.x
	 * @access   public
	 */
	public $groupId;

	/**
	 * The variable that holds the properties of this vocabulary
	 *
	 * @since    0.x
	 * @access   public
	 */
	private $type_properties = array(
		//For all the properties on external vocabularies we use the true paramenter
		//We do this because we dont select properties for other vocabularies except from schema
		//Without the true parameter the fields will not render
        'educationalType' => array(true,'Educational Metadata Type','Choose the type of data your educational data best describes',
        array('Default'=>'Default',
            'WebPage'=>'WebPage',
            'Article'=>'Article',
            'Course'=>'Course',
            'WebSite'=>'WebSite',
            'Book' => 'Book')),
		'isced_field' => array(true,'ISCED field of education','Broad field of education according to ISCED-F 2013.'. '<br><a target="_blank" href="http://alliance4universities.eu/wp-content/uploads/2017/03/ISCED-2013-Fields-of-education.pdf">Click Here for more information</a>',
			array(
				'--Select--'										=> '--Select--',
				'Generic programmes and qualifications' 			=>	'Generic programmes and qualifications',
				'Education' 										=>	'Education',
				'Arts and humanities' 							=> 	'Arts and humanities',
				'Social sciences, journalism and information' 	=> 	'Social sciences, journalism and information',
				'Business, administration and law' 				=> 	'Business, administration and law',
				'Natural sciences, mathematics and statistics' 	=> 	'Natural sciences, mathematics and statistics',
				'Information and Communication Technologies' 		=> 	'Information and Communication Technologies',
				'Engineering, manufacturing and construction' 	=> 	'Engineering, manufacturing and construction',
				'Agriculture, forestry, fisheries and veterinary' => 	'Agriculture, forestry, fisheries and veterinary',
				'Health and welfare' 								=> 	'Health and welfare',
				'Services' 										=> 	'Services',)),
		'isced_level'=>array(true,'ISCED level of education','Level of education according to ISCED-P 2011'.'<br><a target="_blank" href="http://www.uis.unesco.org/Education/Documents/isced-2011-en.pdf">Click Here for more information</a>',
			array(
				'' => '--Select--',
				'10' => 'Early Childhood Education',
				'1' => 'Primary education',
				'2' => 'Lower secondary education',
				'3' => 'Upper secondary education',
				'4' => 'Post-secondary non-tertiary education',
				'5' => 'Short-cycle tertiary education',
				'6' => 'Bachelor’s or equivalent level',
				'7' => 'Master’s or equivalent level',
				'8' => 'Doctoral or equivalent level',
				'9' => 'Not elsewhere classified')),
		'typicalAgeRange' => array(true,'Age Range','The target age of this book',
			array('18-' 		=> 	'Adults',
			      '17-18'		=> 	'17-18 years',
			      '16-17' 	=> 	'16-17 years',
			      '15-16' 	=> 	'15-16 years',
			      '14-15' 	=> 	'14-15 years',
			      '13-14' 	=> 	'13-14 years',
			      '12-13' 	=> 	'12-13 years',
			      '11-12' 	=> 	'11-12 years',
			      '10-11' 	=> 	'10-11 years',
			      '9-10'  	=> 	 '9-10 years',
			      '8-9'  		=> 	  '8-9 years',
			      '7-8'  		=> 	  '7-8 years',
			      '6-7'  		=> 	  '6-7 years',
			      '3-5'	  	=> 	  '3-5 years')),
		'edu_level'=>array(true,'Educational Level','The level of this subject. For ex. B1 for an English Course, or Grade 2 for a Physics Course.'),
		'edu_frame'=>array(true,'Educational Framework','The Framework that the educational level belongs to. Example: CEFR, Common Core, European Baccalaureate'),
		'learningResourceType'=>array(true,'Learning Resource Type','The kind of resource this book represents',
			array('course'	=> 	'Course',
			      'exam'		=> 	'Examination',
			      'exercise'	=> 	'Exercise')),
		'interactivityType'=>array(true,'Interactivity Type','The interactivity type of this book',
			array('expositive'=> 	'Expositive',
			      'mixed' 	=> 	'Mixed',
			      'active' 	=> 	'Active')),
		'timeRequired'=>array(true,'Class Learning Time (hours)','The study time required for the book','number'),
		'edu_role'=>array(true,'Educational Role','An educationalRole of an EducationalAudience.',
			array('Students'	=> 	'Students',
			      'Teachers'  => 	'Teachers')),
		'educationalUse'=>array(true,'Educational Use','The purpose of a work in the context of education; for example, \'assignment\', \'group work\'.'),
		'trg_desc'=>array(true,'Target Description','The description of a node in an established educational framework. <a href="https://ceds.ed.gov/element/001408">Find more here</a>',
			array('General'	      =>'General',
			      'Mobility'      =>'Mobility',
			      'Communication' =>'Communication',
			      'Hearing'       =>'Hearing',
			      'Vision'        =>'Vision')),
		'trg_url'=>array(true,'Target Url','The URL of a node in an established educational framework. http://example.com')
	);

	public function __construct($typeLevelInput) {
		$this->modify_isced_field();
		$this->groupId = 'edu_vocab';
		$this->type_level = $typeLevelInput;
		//Removing the EducationalType dropdown form the array because Pressbooks Book Info is a Book By Default
		if($this->type_level == 'metadata'){
		    unset($this->type_properties['educationalType']);
        }
		$this->pmdt_add_metabox( $this->type_level );
	}

	/**
	 * The function which modifies the isced field depending on the addon plugin
	 *
	 * @since 0.x
	 */
	function modify_isced_field(){
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( is_plugin_active( 'pressbooks-isced-fields/pressbooks-isced-fields.php' ) ) {
			require_once( ABSPATH . '/wp-content/plugins/pressbooks-isced-fields/admin/class-pressbooks-isced-fields-admin.php');
			$isced_field = \Pressbooks_Isced_Fields_Admin::get_isced_field();
			if($isced_field != null){
				unset($this->type_properties['isced_field']);
				$this->type_properties['isced_field'] = $isced_field['isced_field'];
			}
		}
	}

	/**
	 * The function which produces the metaboxes for the vocabulary
	 *
	 * @param string Accepting a string so we can distinguish on witch place each metabox is created
	 *
	 * @since 0.x
	 */
	public function pmdt_add_metabox( $meta_position ) {
		new create_metabox( $this->groupId, 'Educational Metadata', $meta_position, $this->type_properties );
	}

	/**
	 * A function needed for the array of metadata that comes from each post site-meta cpt or chapter
	 * It automatically returns the first item in the array.
	 * @since 0.x
	 *
	 */
	private function pmdt_get_first( $my_array ) {
		if ( $my_array == '' ) {
			return '';
		} else {
			return $my_array[0];
		}
	}

	/**
	 * Gets the value for the microtags from $this->metadata.
	 *
	 * @since    0.x
	 * @access   public
	 */
	private function pmdt_get_value( $propName ) {
		$array = isset( $this->metadata[ $propName ] ) ? $this->metadata[ $propName ] : '';
		if ( $this->type_level != 'metadata' ) {
			$value = $this->pmdt_get_first( $array );
		} else {
			//We always use the get_first function except if our level is metadata coming from pressbooks
			$value = $array;
		}

		return $value;
	}

	/**
	 * Gets the value from isced using the level.
	 *
	 * @since    0.x
	 * @access   private
	 */
	private function get_isced_level($level){
		$isced_level_data = array(
			''  => '--Select--',
			'10' => 'Early Childhood Education',
			'1' => 'Primary education',
			'2' => 'Lower secondary education',
			'3' => 'Upper secondary education',
			'4' => 'Post-secondary non-tertiary education',
			'5' => 'Short-cycle tertiary education',
			'6' => 'Bachelor’s or equivalent level',
			'7' => 'Master’s or equivalent level',
			'8' => 'Doctoral or equivalent level',
			'9' => 'Not elsewhere classified');
		return $isced_level_data[$level];
	}

	/**
	 * Function that creates the vocabulary metatags
	 *
	 * @since    0.x
	 * @access   public
	 */
	public function pmdt_get_metatags() {
		//Getting the information from the database
        if($this->type_level == 'metadata' || $this->type_level == 'site-meta'){
            $this->metadata = genFunc::get_metadata();
        }else{
            $this->metadata = get_post_meta( get_the_ID() );
        }

		//Keys for looping
		$loop_keys = array(
			'typicalAgeRange',
			'learningResourceType',
			'interactivityType',
			'timeRequired',
			'educationalUse'
		);

        //Starting point of educational schema part 1
        $html  = "<!-- Educational Microtags -->\n";
        //If not Pressbooks Book Info we show the selected educationalType
        if($this->type_level != 'metadata'){
            //Constructing the key
            $dataKey = strtolower('pb_educationalType_' . $this->groupId .'_'. $this->type_level);
            //Getting the data
            $val = $this->pmdt_get_value($dataKey);
            //Checking for default value
            if(empty($val) || $val == 'Default'){
                switch ($this->type_level){
                    case 'post':
                    case 'chapter':
                        $val = 'WebPage';
                        break;
                    case 'site-meta':
                        $val = 'WebSite';
                        break;
                }
            }
            $html .= '<div itemscope itemtype="http://schema.org/'.$val.'">';
        }

		$partTwoMetadata = null;

		foreach ( $this->type_properties as $key => $desc ) {
			//Constructing the key for the data
			//Add strtolower in all vocabs remember
			$dataKey = strtolower('pb_' . $key . '_' . $this->groupId .'_'. $this->type_level);
			//Getting the data
			$val = $this->pmdt_get_value($dataKey);
			//Checking if the value exists and that the key is in the array for the schema
			if(empty($val) || $val == '--Select--'){
				continue;
			}else{
				if(in_array($key,$loop_keys)){
					//if the schema is timeRequired, we are using a specific format to display it,
					//like the example here: https://schema.org/timeRequired
					if ( 'timeRequired' == $key ) {
						$val = 'PT'. $val.'H';
					}
					$html .= "<meta itemprop = '" . $key . "' content = '" . $val . "'>\n";
				}else{
					$partTwoMetadata[$key] = $val;
				}
			}
		}
		//Ending schema part 1

		//Starting point of educational schema part 2
		if ( isset( $this->metadata['pb_title'] ) ) {
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
			         ."	<meta itemprop = 'alignmentType' content = 'educationalSubject'/>\n"
			         ."	<meta itemprop = 'targetName' content = '" .$this->metadata['pb_title']. "'>\n"
			         ."</span>\n";
		}
		if ( isset($partTwoMetadata['isced_field']) ) {
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
			         ."	<meta itemprop = 'alignmentType' content = 'educationalSubject'/>\n"
			         ."	<meta itemprop = 'educationalFramework' content = 'ISCED-2013'/>\n"
			         ."	<meta itemprop = 'targetName' content = '" .$partTwoMetadata['isced_field']. "'>\n"
			         ."</span>\n";
		}
		if ( isset($partTwoMetadata['isced_level']) && !empty($partTwoMetadata['isced_level']) ) {
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
			         ."	<meta itemprop = 'alignmentType' content = 'educationalLevel'/>\n"
			         ."	<meta itemprop = 'educationalFramework' content = 'ISCED-2011'/>\n"
			         ."	<meta itemprop = 'targetName' content = '" .$this->get_isced_level($partTwoMetadata['isced_level']). "'>\n"
			         ."	<meta itemprop = 'alternateName' content = 'ISCED 2011, Level  " .$partTwoMetadata['isced_level']. "' />"
			         ."</span>\n";
		}

		if ( isset( $partTwoMetadata['edu_level'] ) && isset( $partTwoMetadata['edu_frame'] )) {
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
			         ."	<meta itemprop = 'alignmentType' content = 'educationalSubject'/>\n"
			         ."	<meta itemprop = 'educationalFramework' content = '" .$partTwoMetadata['edu_frame']. "'>\n"
			         ."	<meta itemprop = 'targetName' content = '" .$partTwoMetadata['edu_level']. "'>\n"
			         ."</span>\n";

		} elseif ( isset( $partTwoMetadata['edu_level'] ) && !isset( $partTwoMetadata['edu_frame'] )) {
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
			         ."	<meta itemprop = 'alignmentType' content = 'educationalLevel'/>\n"
			         ."	<meta itemprop = 'targetName' content = '" .$partTwoMetadata['edu_level']. "'>\n"
			         ."</span>\n";
		}

		if(isset( $partTwoMetadata['trg_url'] ) || isset( $partTwoMetadata['trg_desc'] )){
			$html .= "<span itemprop = 'educationalAlignment' itemscope itemtype = 'http://schema.org/AlignmentObject'>\n"
			         ."	<meta itemprop = 'alignmentType' content = 'educationalLevel'/>\n";
			if(isset( $partTwoMetadata['trg_url'] )){
				$html .= "	<link itemprop='targetUrl' href='".$partTwoMetadata['trg_url']."' />\n";
			}
			if(isset( $partTwoMetadata['trg_desc'] )){
				$html .= "	<link itemprop='targetDescription' content='".$partTwoMetadata['trg_desc']."' />\n";
			}
			$html .= "</span>\n";
		}

		if(isset( $partTwoMetadata['edu_role'] )){
			$html .= "<span itemprop = 'audience' itemscope itemtype = 'http://schema.org/EducationalAudience'>\n"
			         ."	<meta itemprop = 'educationalRole' content = '$partTwoMetadata[edu_role]'/>\n"
			         ."</span>\n";
		}
		if($this->type_level != 'metadata'){
            $html .= '</div>';
        }
		echo $html;
	}
}