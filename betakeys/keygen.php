<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Beta Key Generation</title>
		<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<?php
		if(!isset($_GET["key"])) {
			echo '<h1>No beta key was generated.</h1>';
			exit;
		}
		?>

		<h1>Beta Key Generation</h1>
		<h3>This is your newly generated beta key.</h3>
		<br>
		<form>
			<input value="<?php
			echo ($_GET['key']);
			?>">
		</form>
	</body>
</html>
