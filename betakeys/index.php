<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Unlock Beta Access</title>
		<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<h1>Unlock Beta Access</h1>
		<h3>If you have been given a beta key, you may redeem it here to gain access to the server.</h3>
		<br>

		<?php

		if(isset($_GET["use"])){

			if($_GET["use"] === "key"){
				$username = $_POST["username"];
				$key = $_POST["key"];

				if(strpos($username, "'") !== false) {
					echo '<strong><p id="error">You used an unauthorized key.</p></strong>';
					echo '<form action="index.php?use=key" method="post">
						<input type="text" name="username" placeholder="Username" required>
						<input type="text" name="key" placeholder="Beta key" required>
						<input type="submit" value="Submit" class="button">
					</form>';
					exit;
				}

				if(strpos($key, "'") !== false) {
					echo '<strong><p id="error">You used an unauthorized key.</p></strong>';
					echo '<form action="index.php?use=key" method="post">
						<input type="text" name="username" placeholder="Username" required>
						<input type="text" name="key" placeholder="Beta key" required>
						<input type="submit" value="Submit" class="button">
					</form>';
				}

				include('database.php');

				$query = "SELECT * FROM `keys` WHERE `KEY` = '$key'";
				$result = mysqli_query($mysqli,$query) or die (mysqli_error($mysqli));

				$num_row = mysqli_num_rows($result);
				$row = mysqli_fetch_array($result);

				if($num_row == 1){
					$content = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . urlencode($username));

					if($content == ''){

						echo '<strong><p id="error">The username provided was invalid.</p></strong>';

					} else {

						$json = json_decode($content);
						if (!empty($json->error)) {
							die('Error: ' . $json->errorMessage);
						}
						$uuid = $json->id;

						$query4 = "SELECT UUID FROM `players` WHERE `UUID` = '$uuid'";
						$result4 = mysqli_query($mysqli,$query4) or die (mysqli_error($mysqli));

						$num_row2 = mysqli_num_rows($result4);
						$row2 = mysqli_fetch_array($result4);

						if($num_row2 == 1){

						$query2 = "UPDATE players SET BETA = 1 WHERE UUID = '$uuid'";
						$result2 = mysqli_query($mysqli,$query2) or die (mysqli_error($mysqli));

						if($num_row == 1){

							$query3 = "DELETE FROM `keys` WHERE `KEY` = '$key'";
							$result3 = mysqli_query($mysqli,$query3) or die (mysqli_error($mysqli));

							echo '<strong><p id="success">Your beta key has been redeemed, and you now have access to the server.</p></strong>';

						}

					} else {
						echo '<strong><p id="error">Please attempt to join the server before using a beta key.</p></strong>';
					}

					}
				} else {
					echo '<strong><p id="error">This beta key is invalid, or has already been used.</p></strong>';
				}
			}
		}

		?>

		<form action="index.php?use=key" method="post">
			<input type="text" name="username" placeholder="Username" required>
			<input type="text" name="key" placeholder="Beta key" required>
			<input type="submit" value="Submit" class="button">
		</form>
	</body>
</html>
