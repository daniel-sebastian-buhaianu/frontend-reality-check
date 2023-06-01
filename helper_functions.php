<?php  

// $date format: "YYYY-MM-DD"
function get_seconds_since( $date ) {

	$current_time = time();
	$given_time   = strtotime("$date 00:00:00");

	$time_diff    = $current_time - $given_time;

	return $time_diff;
}

// $date format: "YYYY-MM-DD"
function get_days_since( $date ) {

	$seconds = get_seconds_since( $date );
	$days  = $seconds / 60 / 60 / 24;

	return $days;
}

function get_months_since ( $date ) {

	$months = 0;

	$birth_year  = intval( date( 'Y', strtotime( $date ) ) );
	$birth_month = intval( date( 'm', strtotime( $date ) ) );
	$birth_day   = intval( date( 'd', strtotime( $date ) ) );

	$current_year  = intval( date( 'Y', strtotime( 'now' ) ) );
	$current_month = intval( date( 'm', strtotime( 'now' ) ) );
	$current_day   = intval( date( 'd', strtotime( 'now' ) ) );

	$year = $birth_year + 1;
	while ( $year < $current_year ) {

		$months += 12;

		$year++;
	}

	if ( $current_month > $birth_month ) {

		$months += 12 + ( $current_month - $birth_month - 1 );

		if ( $current_day >= $birth_day ) {

			$months++;
		}

		return $months;
	}

	if ( $current_month < $birth_month ) {

		$months += 12 - ( $birth_month - $current_month  + 1 );

		if ( $current_day >= $birth_day ) {

			$months++;
		}

		return $months;
	}

	if ( $current_day >= $birth_day ) {

		$months += 12;

	} else {

		$months += 11;

	}

	return $months;
}

function is_leap_year( $year ) {

    if (($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0) {
        return true;
    }
    
    return false;
}

function debug_print( $description, $data ) {

	echo '<p>' . $description . ': ' . $data . '</p>';
}

function create_error( $message ) {

	$error = '<p class="error">' . $message . '</p>';

	return $error;
}

function create_alert( $message ) {

	$alert = '<p class="alert">' . $message .'</p>';

	return $alert;
}

// $date_of_birth format: "YYYY-MM-DD"
function is_date_of_birth_valid ( $date_of_birth ) {

    $date_parts = explode( '-', $date_of_birth );
    
    if ( 3 !== count( $date_parts ) ) {

        return false; // Invalid format: not enough parts
    }
    
    $year  = (int) $date_parts[0];
    $month = (int) $date_parts[1];
    $day   = (int) $date_parts[2];
    
    if ( !checkdate( $month, $day, $year ) ) {

        return false; // Invalid date
    }
    
    // Check if date is not in the future
    $current_date = new DateTime();
    $input_date = DateTime::createFromFormat( 'm/d/Y', $date_of_birth );
    
    if ( $input_date > $current_date ) {

        return false; // Born in the future
    }

    // Check if year is not too long ago
    if ( $year < 1910) {

    	return false; // Too old
    }
    
    return true; // Valid date of birth
}

function is_life_expectancy_valid ( $life_expectancy ) {

	$life_expectancy = (int) $life_expectancy; // Convert to integer
    
    if ( $life_expectancy >= 1 && $life_expectancy <= 120 ) {
    	
        return true; // Valid life expectancy
    }

    return false;
}