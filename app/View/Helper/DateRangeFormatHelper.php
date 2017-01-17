<?php
	App::uses('AppHelper', 'View/Helper');
	class DateRangeFormatHelper extends AppHelper
	{
		public function __construct(View $view, $settings=array())
		{
			parent::__construct($view, $settings);
		}
		
		/**
		 * Takes one or two TIMESTAMPs, and an optional formatting array of the form ($year, $month, $day),
		 * and returns a date that is appropriate to the situation
		 * @param int $start
		 * @param int $end
		 * @param array $fmt
		 * @param string $separator
		 * @return boolean|string
		 */
		public function FormatDateRange($start, $end = NULL, $fmt = NULL, $separator = "&ndash;") {
		    if( ! isset( $start ) ) {
				return false;
		    }
		    
		    if( ! isset( $fmt ) ) {
			// default formatting
				$fmt = array( 'Y', 'M', 'd' );
		    }
		    list( $yr, $mon, $day ) = $fmt;
		    
		    if( ! isset( $end) || $start == $end ) {
				return( date( "$mon $day, $yr", $start ) );
		    }
		    if( date( 'M-j-Y', $start ) == date( 'M-j-Y', $end ) ) {
			// close enough
				return date( "$mon $day, $yr", $start );
		    }
		    
		    
		    // ok, so $end != $start
				    
		    // let's look at the YMD individually, and make a pretty string
		    $dates = array( 
			's_year' => date( $yr, $start ),
			'e_year' => date( $yr, $end ),
		
			's_month' => date( $mon, $start ),
			'e_month' => date( $mon, $end ),
		
			's_day' => date( $day, $start),
			'e_day' => date( $day, $end),
		
		    );
		    // init dates
		    $start_date = '';
		    $end_date = '';
		
		    $start_date .= $dates['s_month'];
		    if( $dates['s_month'] != $dates['e_month'] ) {
				$end_date .= $dates['e_month'];
		    }
		
		    $start_date .= ' '. $dates['s_day'];
		    if( $dates['s_day'] != $dates['e_day'] || $dates['s_month'] != $dates['e_month'] ) {
				$end_date .= ' ' . $dates['e_day'];
		    }
		
		    if( $dates['s_year'] != $dates['e_year'] ) {
				$start_date .= ', ' . $dates['s_year'];
				if( $dates['s_month'] == $dates['e_month'] ) {
				    if( $dates['s_day'] == $dates['e_day'] ) {
					// same day, same month, different year
					$end_date = ' ' . $dates['e_day'] . $end_date;
				    }
				    // same month, but a different year
				    
				    $end_date = $dates['e_month'] . $end_date;
				}
		    }
		    $end_date .= ', ' . $dates['e_year'];
		
		    $complete_date = trim( $start_date ) . $separator . trim( $end_date );
		    
		    return $complete_date;
		}
	}