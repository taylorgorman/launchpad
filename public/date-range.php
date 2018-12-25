<?php
/**
 * Verbose Beautified Date Range
 *
 * @access public
 * @param mixed $start_date
 * @param mixed $end_date
 * @return $date_range (beautified date range)
 * @license WTFPL
 *
 * @author Jon Brown <jb@9seeds.com---->
 * @since 1.0
 */

function date_range( $start_date = '', $end_date = '' ) {

    $date_range = '';

    // If only one date, or dates are the same set to FULL verbose date
    if ( empty($start_date) || empty($end_date) || ( date('FjY',$start_date) == date('FjY',$end_date) ) ) { // FjY == accounts for same day, different time
        $start_date_pretty = date( 'F j, Y', $start_date );
        $end_date_pretty = date( 'F j, Y', $end_date );
    } else {
         // Setup basic dates
        $start_date_pretty = date( 'F j', $start_date );
        $end_date_pretty = date( 'j, Y', $end_date );
        // If years differ add suffix and year to start_date
        if ( date('Y',$start_date) != date('Y',$end_date) ) {
            $start_date_pretty .= date( ', Y', $start_date );
        }

        // If months differ add suffix and year to end_date
        if ( date('F',$start_date) != date('F',$end_date) ) {
            $end_date_pretty = date( 'F ', $end_date) . $end_date_pretty;
        }
    }

    // build date_range return string
    if( ! empty( $start_date ) ) {
          $date_range .= $start_date_pretty;
    }

    // check if there is an end date and append if not identical
    if( ! empty( $end_date ) ) {
        if( $end_date_pretty != $start_date_pretty ) {
              $date_range .= ' - ' . $end_date_pretty;
          }
     }
    return $date_range;
}
