<?php
	session_start();
	require 'databaseConnection.php';
	
	if(!isset($_SESSION['username'])) {
		header('Location: login.php');
	}
	
	function getGenres() {
		global $conn;
		$sql = "SELECT DISTINCT genre
			FROM movieDatabase
			ORDER BY genre ASC";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
		return $stmt -> fetchAll();
	}
	
	function getRatings() {
		global $conn;
		$sql = "SELECT DISTINCT rating
			FROM movieDatabase
			ORDER BY rating ASC";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
		return $stmt -> fetchAll();
	}
	
	if( isset ($_POST['submit']) ) {
		try {
			// insert records into userMovies table
			$sql = "INSERT INTO userMovies
				(title, director, star, genre, rating, length, year)
				VALUES
				(:title, :director, :star, :genre, :rating, :length, :year)";
			
			$stmt = $conn -> prepare($sql);
			$stmt -> execute( array (":title" => $_POST['title'],
				":director" => $_POST['director'],
				":star" => $_POST['star'],
				":genre" => $_POST['genre'],
				":rating" => $_POST['rating'],
				":length" => $_POST['length'],
				":year" => $_POST['year']) );
			
			echo "<div class='adminMessage'> >> Data Submitted for Approval!</div>";
		}
		catch (PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Add Movies To Database</title>
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
			<tr><td colspan="2">Add A Movie!</td></tr>
			
			<tr>
				<td>Title</td>
				<td><input size="20" type="text" name="title"></td>
			</tr>
			
			<tr>
				<td>Director</td>
				<td><input size="20" type="text" name="director"></td>
			</tr>
			
			<tr>
				<td>Featured Star</td>
				<td><input size="20" type="text" name="star"></td>
			</tr>
			
			<tr>
				<td>Genre</td>
				<td><select size=1 name="genre">
					<option value="-1">Choose A Genre</option>
					<?php
						$movieGenres = getGenres();
						foreach ($movieGenres as $genre) {
							echo "<option value='" . $genre['genre'] . "'>" . $genre['genre'] . "</option>";
						}
					?>
				</select></td>
			</tr>
			
			<tr>
				<td>Rating</td>
				<td><select size="1" name="rating">
					<option value="-1">Choose A Rating</option>
					<?php
						$movieRatings = getRatings();
						foreach ($movieRatings as $rating) {
							echo "<option value='" . $rating['rating'] . "'>" . $rating['rating'] . "</option>";
						}
					?>
				</select></td>
			</tr>
			
			<tr>
				<td>Length (in total minutes)</td>
				<td><input size="20" type="text" name="length"></td>
			</tr>
			
			<tr>
				<td>Year</td>
				<td><select size=1 name="year">
					<option value="-1">Choose A Year</option>
					<?php
						for ($i=2016; $i>1900; $i--) {
							echo "<option value='" . $i . "'>" . $i . "</option>";
						}
					?>
				</select></td>
			</tr>
			
			<tr>
				<td><input type="submit" value="Enter" name="submit"><img src="popcorn-icon.png"></td>
				<td><input type="reset" value="Clear"><img src="popcorn-icon.png"></td>
			</tr>
			
		</form></table>
	</div>

</body>
</html>

<?php $conn = null; ?>