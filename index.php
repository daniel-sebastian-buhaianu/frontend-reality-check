<?php  

include './helper_functions.php';

session_start();

if ( 'POST' === $_SERVER['REQUEST_METHOD'] ) {
     
    if ( isset( $_POST['submit'] ) ) {

    	if ( isset( $_SESSION['alert'] ) ) {
    		unset( $_SESSION['alert'] );
    	}

    	if ( isset( $_SESSION['errors'] ) ) {
    		unset( $_SESSION['errors'] );
    	}

    	if ( isset( $_SESSION['result'] ) ) {
    		unset( $_SESSION['result'] );
    	}

    	if ( isset( $_SESSION['date_of_birth'] ) ) {
    		unset( $_SESSION['date_of_birth'] );
    	}

    	if ( isset( $_SESSION['life_expectancy'] ) ) {
    		unset( $_SESSION['life_expectancy'] );
    	}

    	if ( empty( $_POST['date_of_birth'] )
    		|| empty( $_POST['life_expectancy'] ) ) {

    		if ( empty( $_POST['date_of_birth'] ) ) {
    			$_SESSION['errors']['date_of_birth'] = create_error( '* required' );
    		}

    		if ( empty( $_POST['life_expectancy'] ) ) {
    			$_SESSION['errors']['life_expectancy'] = create_error( '* required' );
    		}

    		$_SESSION['alert'] = create_alert( 'Please fill in all the required fields.' );

    		header( 'Location: index.php' );
    		return;
    	}

    	if ( is_date_of_birth_valid( $_POST['date_of_birth'] ) 
    		&& is_life_expectancy_valid( $_POST['life_expectancy'] ) ) {

			$_SESSION['date_of_birth']   = $_POST['date_of_birth'];
			$_SESSION['life_expectancy'] = $_POST['life_expectancy'];

			$_SESSION['result'] = get_result( $_SESSION['date_of_birth'], $_SESSION['life_expectancy'] ); 

			header('Location: index.php');
			return;

    	} else {

    		if ( ! is_date_of_birth_valid( $_POST['date_of_birth'] ) ) {
    			$_SESSION['errors']['date_of_birth'] = create_error( 'Invalid!' );
    			$_SESSION['alert'] = create_alert( 'Please enter a valid date of birth using the format: MM/DD/YYYY.' );

    			header( 'Location: index.php' );
    			return;
    		}

    		if ( ! is_life_expectancy_valid( $_POST['life_expectancy'] ) ) {
    			$_SESSION['errors']['life_expectancy'] = create_error( 'Invalid!' );
    			$_SESSION['alert'] = create_alert( 'Please enter a reasonable life expectancy value between 1 and 120.' );

    			header( 'Location: index.php' );
    			return;
    		}
    	}
	}

	if ( isset( $_POST['reset'] ) ) {

		unset( $_SESSION['date_of_birth'] );
		unset( $_SESSION['life_expectancy'] );

		header('Location: index.php');
		return;
	}
}


if ( 'GET' === $_SERVER['REQUEST_METHOD'] ) {

	$input['date_of_birth'] = isset( $_SESSION['date_of_birth'] ) ? $_SESSION['date_of_birth'] : '';
	$input['life_expectancy'] = isset( $_SESSION['life_expectancy'] ) ? $_SESSION['life_expectancy'] : '';

	include './index.view.php';

	return;
}


function get_result( $date_of_birth, $life_expectancy ) {

	$months_old = get_months_since( $date_of_birth );

	define ( 'MAX_MONTHS_IN_A_YEAR', 12 );

	$tbody = '<tbody>';

	for ( $i = 0; $i < $life_expectancy; $i++ ) {

		$tbody .= "<tr><td class='age'>$i</td>";

		for ( $j = 0; $j < MAX_MONTHS_IN_A_YEAR; $j++ ) {

			if ( $months_old > 0 ) {

				$tbody .= '<td class="lived">X</td>';

				$months_old--;

			} else {

				$tbody .= '<td></td>';

			}
		}

		$tbody .= '</tr>';
	}
	
	$tbody .= '</tbody>';

	$months = array(
		'Jan',
		'Feb',
		'Mar',
		'Apr',
		'May',
		'Jun',
		'Jul',
		'Aug',
		'Sep',
		'Oct',
		'Nov',
		'Dec'
	);
	
	$birth_month = intval( date( 'm', strtotime( $date_of_birth ) ) );

	$ths = '';
	
	for ( $i = 0, $j = $birth_month - 1; $i < 12; $i++, $j++ ) {

		$month = $months[ $j % 12 ];

		$ths .= "<th>$month</th>";

	}

	$result = <<<HTML
		<h4>Your Result:</h4>
		<section id="result">
			<table>
				<thead>
					<tr>
						<th class="age">Age</th>
						$ths
					</tr>
				</thead>

				$tbody
			</table>
		</section>
	HTML;

	$letter_copy = <<<HTML
		<p>You might be wondering...</p>

		<p><b>What the heck does this table mean?</b></p>

		<p>You see...</p>

		<p>The <b>X-marked black cells</b> represent the months of your life which you have already lived, a.k.a <b>Months Already Lived</b>.</p> 
		
		<p>Whereas the <b>white cells</b> represent the total opposite, a.k.a <b>Months Not Lived Yet</b>.</p>

		<p>Unfortunately, you can't change the past.</p>

		<p>So... if you feel like you have wasted a lot of time, it's ok.</p>

		<p>However, the good news is...</p>

		<p><b>You still have some time available to fix some of the mistakes you have made in the past, or achieve some goals you've always dreamed of.</b></p>

		<p>And...</p>

		<p>To help you get things moving in the right direction, I can give you <b>a little known secret to achieve any goal you want</b>.</p>

		<p>It's not gonna be easy...</p>

		<p>But if you give it a hard try, you will be shocked by the result of this simple, but powerful exercise.</p>

		<p><b>Here it is:</b></p>

		<p>Take a good look at the white cells from the table above.</p>

		<p>Now, make commitment to use every pixel of each white cell to the fullest, every single day.</p>

		<p>If you don't know how you're gonna do that yet, that's perfectly fine, it's how it's supposed to be, so don't worry.</p>

		<p><b>Creativity Follows Commitment!</b></p>

		<p>After you have made the commitment, you will ask yourself one simple question every day, first thing in the morning:</p>

		<p><b>- What is ONE thing that if I do today, I will move closer towards my goal?</b></p>

		<p>Take 5 minutes to really think about the answer to this simple but powerful question.</p>

		<p>Once you've come up with the answer, it's time to get to work.</p>

		<p>Make sure you do that ONE thing by the end of the day.</p>

		<p><b>If you do this exercise every single day, you will move closer, and closer towards your goal, every day.</b></p>

		<p>And before you know it, that one thing that you've always dreamed of... has now become a reality.</p>

		<p>Just stop procrastinating, and get to work!</p>

		<p>And remember: </p>

		<p><b>Fast Imperfect Action > Slow Perfect Action</b></p> 
	HTML;

	$letter = <<<HTML
		<section id="letter">

			$letter_copy

			<div class="signature">

				<p>All the best,</p>
				
				<p>Daniel-Sebastian Buhaianu</p>
				
				<p>Software Engineer</p>
			</div>

		</section>
	HTML;

	$html = $result . $letter;
		

	return $html;
}