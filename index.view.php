<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="styles.css">
	<title>Reality Check App</title>
</head>
<body>
	<header>
		<p>Reality Check App</p>
	</header>
	<main>
		<section id="input">		
			<form method="post">
				<?php
					if ( isset( $_SESSION['alert'] ) ) {
						echo $_SESSION['alert'];
					}
				?>

				<div class="form-item">
					<label for="date_of_birth">Date of Birth:</label>
					<input 
						type="date" 
						name="date_of_birth" 
						value="<?php echo $input['date_of_birth']; ?>"
					>
				</div>
				<?php
					if ( isset( $_SESSION['errors']['date_of_birth'] ) ) {
						echo $_SESSION['errors']['date_of_birth'];
					}
				?>

				<div class="form-item">
					<label for="life_expectancy">Life Expectancy (in years): </label>
					<input 
						type="number" 
						name="life_expectancy" 
						min="1" 
						max="120" 
						value="<?php echo $input['life_expectancy']; ?>"
					>
				</div>
				<?php
					if ( isset( $_SESSION['errors']['life_expectancy'] ) ) {
						echo $_SESSION['errors']['life_expectancy'];
					}
				?>

				<div class="form-item submit">
					<input type="submit" name="submit" value="Get Reality Check">
				</div>
				<?php
					if ( isset( $_SESSION['result'] ) ) {
						echo <<<HTML
							<div class="form-item clear">
								<input type="submit" name="clear_result" value="Clear Result">
							</div>
						HTML;
					}
				?>
			</form>
		</section>

		<?php
		
			if ( isset( $_SESSION['result'] ) ) {
				echo $_SESSION['result'];
			}
		?>

		<footer>
			<p>&copy; Daniel-Sebastian Buhaianu</p>
		</footer>
	</main>
</body>
</html>