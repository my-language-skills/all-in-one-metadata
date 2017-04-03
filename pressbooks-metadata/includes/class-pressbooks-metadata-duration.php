<?php

/**
 * The class handling a duration.
 *
 * @since      0.1
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes
 */

/**
 * The class handling a duration.
 *
 * @package    Pressbooks_Metadata
 * @subpackage Pressbooks_Metadata/includes
 * @author     julienCXX <software@chmodplusx.eu>
 */
class Pressbooks_Metadata_Duration {

	/**
	 * The variable containing the amount of minutes.
	 *
	 * @since  0.1
	 * @access private
	 * @var    Pressbooks_Metadata_Date_Duration $minutes Stores the "minutes" parameter.
	 */
	private $minutes;

	/**
	 * The variable containing the amount of hours.
	 *
	 * @since  0.1
	 * @access private
	 * @var    Pressbooks_Metadata_Date_Duration $hours Stores the "hours" parameter.
	 */
	private $hours;

	/**
	 * The variable containing the amount of days.
	 *
	 * @since  0.1
	 * @access private
	 * @var    Pressbooks_Metadata_Date_Duration  $days Stores the "days" parameter.
	 */
	private $days;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  0.1
	 * @param  string $minutes The number of minutes of the duration.
	 * @param  string $hours   The number of hours of the duration.
	 * @param  string $days    The number of days of the duration.
	 * @throws DomainException If at least one component has a value outside its expected range (negative or over its maximum value).
	 */
	public function __construct( $minutes = 0, $hours = 0, $days = 0 ) {

		if ( $minutes < 0 || $minutes > 59 ) {
			throw new DomainException( $minutes . ' is not a valid amount of minutes' );
		}
		if ( $hours < 0 || $hours > 23 ) {
			throw new DomainException( $hours . ' is not a valid amount of hours' );
		}
		if ( $days < 0 ) {
			throw new DomainException( $days . ' is not a valid amount of days' );
		}
		$this->minutes = $minutes;
		$this->hours = $hours;
		$this->days = $days;

	}

	/**
	 * Formats the duration to the ISO 8601 standard.
	 *
	 * @since    0.1
	 * @return   $string   The ISO 8601 formatted string
	 */
	public function to_iso_8601() {

		$ret = 'P';
		if ( $this->days > 0 ) {
			$ret .= $this->days . 'D';
		}
		$ret .= 'T';
		if ( $this->hours > 0 ) {
			$ret .= $this->hours . 'H';
		}
		$ret .= $this->minutes . 'M';
		return $ret;

	}

	/**
	 * Formats the duration to a localized readable format.
	 *
	 * @since    0.1
	 * @return   $string   The localized duration
	 */
	public function to_localized() {

		$ret = '';
		$pad = ''; // padding between each field
		if ( $this->days > 0 ) {
			$pad = ', ';
			if ( $this->days > 1 ) {
				$ret .= $this->days . ' days';
			} else {
				$ret .= '1 day';
			}
		}
		if ( $this->hours > 0 ) {
			$ret .= $pad;
			$pad = ', ';
			if ( $this->hours > 1 ) {
				$ret .= $this->hours . ' hours';
			} else {
				$ret .= '1 hour';
			}
		}
		if ( $this->minutes > 0 ) {
			$ret .= $pad;
			if ( $this->minutes > 1 ) {
				$ret .= $this->minutes . ' minutes';
			} else {
				$ret .= '1 minute';
			}
		}
		return $ret;

	}

	/**
	 * Formats the duration to a localized readable format.
	 *
	 * @since    0.1
	 * @return   $string   The localized duration
	 */
	public function __toString() {

		return $this->to_localized();

	}


}
