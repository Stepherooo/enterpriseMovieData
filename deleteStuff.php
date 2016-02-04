<?php
	session_start();
	require 'databaseConnection.php';
	
	if(!isset($_SESSION['username'])) {
		header('Location: login.php');
	}
	
	function getMovies() {
		global $conn;
		$sql = "SELECT movieID, title 
			FROM movieDatabase
			ORDER BY title ASC";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
		return $stmt -> fetchAll();
	}
	
	if( isset ($_POST['submit']) ) {
		try {
			$sql = "DELETE FROM movieDatabase
				WHERE movieID = :movieID";
			
			$stmt = $conn -> prepare($sql);
			$stmt -> execute(array(':movieID'=> $_POST['movieID']));
			
			echo "<div class='adminMessage'> >> Data Deleted!</div>";
		}
		catch (PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Delete Movies From Database?!</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="ourStyles.css">
</head>
<body>
	<div id="header"></div>
	<div id="nav">
		<h3>Members Area</h3>
		<a href="movieSearch.php">Home</a><br>
		<a href="editDatabase.php">Add to Database</a><br>
		<a href="deleteStuff.php">Delete from Database</a><br>
		<a href="changePassword.php">Change Password</a><br>
		<a href="logout.php">Logout</a>
	</div>
	
	<div class="center">
		<table id="login"><form method="post">
			<tr><td colspan="2">Delete A Movie</td></tr>
			
			<tr>
				<td>Delete A Movie</td>
				<td><select size=1 name="movieID">
					<option value="-1">Choose A Movie Title</option>
					<?php
						$movieTitles = getMovies();
						foreach ($movieTitles as $movie) {
							echo "<option value='" . $movie['movieID'] . "'>" . $movie['title'] . "</option>";
						}
					?>
				</select></td>
			</tr>
			
			<tr>
				<td colspan="2"><input type="submit" value="DELETE" name="submit"><img src="popcorn-icon.png"></td>
			</tr>
			
		</form></table>
	</div>

</body>
</html>

<?php $conn = null; ?>