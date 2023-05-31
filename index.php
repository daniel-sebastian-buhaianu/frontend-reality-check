<?php  

session_start();

if ( isset( $_POST['reset'] ) ) {

	unset( $_SESSION['birth_date'] );
	unset( $_SESSION['age'] );

	header('Location: index.php');
	return;
}

if ( isset( $_POST['submit'] ) ) {

	if ( '' !== $_POST['birth_date'] ) {

		$_SESSION['birth_date'] = $_POST['birth_date'];
	}

	if ( $_POST['age'] > 0 ) {

		$_SESSION['age'] = $_POST['age'];
	}

	header('Location: index.php');
	return;
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Watch Me Die</title>
	<style>
		.error {
			color: red;
		}
		.alert {
			padding: 0.5rem;
			border: 1px solid red;
			background-color: indianred;
			color: white;
			max-width: 300px;
		}
		.box {
			height: 15px;
			width: 15px;
			background-color: red;
		}
		.box.unlived {
			background-color: green;
		}
		.row {
			display: flex;
			flex-wrap: nowrap;
			margin-top: 0.5rem;
		}
		.row > * {
			margin-left: 0.2rem;
		}
	</style>
</head>
<body>
	<header>
		<h1>Watch Me Die</h1>
	</header>
	<main>
		<section id="input">
			<form method="post">
				<label for="birth_date">
					When's your birthday?:
				</label>
				<input type="date" name="birth_date">
				<br>

				<label for="age">
					How many years do you expect to live?:
				</label>
				<input type="number" name="age">

				<input type="submit" name="submit" value="Submit">
			</form>

			<form method="post">
				<input type="submit" name="reset" value="Reset">
			</form>
		</section>

		<section id="output">
			<?php

				if (   ! isset ( $_SESSION['birth_date'] ) 
					|| ! isset ( $_SESSION['age'] ) ) {

					if ( ! isset ( $_SESSION['birth_date'] ) ) {
						echo '<p class="error">Warning: Birthday is empty.</p>';
					}

					if ( ! isset ( $_SESSION['age'] ) ) {
						echo '<p class="error">Warning: Years expected to live is empty.</p>';
					}

					echo '<p class="alert">Please fill in all required fields.</p>';
					return;
				}

				$months_old = get_months_since( $_SESSION['birth_date'] );
				$temp       = $months_old;
				for ( $i = 1; $i <= $_SESSION['age']; $i++ ) {

					$year = $i < 10 ? "0{$i}" : "{$i}";

					echo '<div class="row">' . $year;

					for ( $j = 1; $j <= 12; $j++ ) {

						if ( $months_old > 0 ) {

							echo '<div class="box"></div>';

							$months_old--;

						} else {

							echo '<div class="box unlived"></div>';

						}
					}

					echo '</div>';
				}

			?>
		</section>
	</main>
</body>
</html>

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

?>