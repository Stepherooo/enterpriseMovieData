<?php 
	require 'databaseConnection.php';
	
	function getMovies() {
		global $conn;
		$sql = "SELECT movieID, title 
			FROM movies
			ORDER BY title ASC";
		$stmt = $conn->prepare($sql);
		$stmt -> execute();
		return $stmt -> fetchAll();
	}
	
	function getDirectors() {
		global $conn;
		$sql = "SELECT directorID, director
			FROM movie_director
			ORDER BY director ASC";
		$stmt = $conn->prepare($sql);
		$stmt -> execute();
		return $stmt -> fetchAll();
	}
	
	function getGenres() {
		global $conn;
		$sql = "SELECT genreID, genre
			FROM movie_genre
			ORDER BY genre ASC";
		$stmt = $conn->prepare($sql);
		$stmt -> execute();
		return $stmt -> fetchAll();
	}
	
	function getYears() {
		global $conn;
		$sql = "SELECT yearID, year
			FROM movie_year
			ORDER BY year ASC";
		$stmt = $conn->prepare($sql);
		$stmt -> execute();
		return $stmt -> fetchAll();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>MOVIES!</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="ourStyles.css">
</head>
<body>
	<div id="header"> TESTING </div>
	
	<table id="main">
		<tr><td colspan="3">
			<h2>Choose a Movie Title!</h2>
			<form method="post">
				<select size=1 name="movieID">
					<option value="-1">Choose A Movie Title</option>
					<?php
						$movieTitles = getMovies();
						// loop through options with foreach
						foreach ($movieTitles as $movie) {
							echo "<option value='" . $movie['movieID'] . "'>" . $movie['title'] . "</option>";
						}
					?>
				</select>
				<input type="submit" value="Search">
			</form>
		</td></tr>
		
		<tr><td>
			<h2>Search By Director!</h2>
			<form method="post">
				<select size=1 name="directorID">
					<option value="-1">Choose A Director</option>
					<?php
						$directorNames = getDirectors();
						foreach ($directorNames as $director) {
							echo "<option value='" . $director['directorID'] . "'>" . $director['director'] . "</option>";
						}
					?>
				</select>
				<input type="submit" value="Search">
			</form>
		</td>

		<td>
			<h2>Search By Genre!</h2>
			<form method="post">
				<select size=1 name="genreID">
					<option value="-1">Choose A Genre</option>
					<?php
						$movieGenres = getGenres();
						foreach ($movieGenres as $genre) {
							echo "<option value='" . $genre['genreID'] . "'>" . $genre['genre'] . "</option>";
						}
					?>
				</select>
				<input type="submit" value="Search">
			</form>
		</td>
		
		<td>
			<h2>Search By Year!</h2>
			<form method="post">
				<select size="1" name="yearID">
					<option value="-1">Choose A Year</option>
					<?php
						$movieYears = getYears();
						foreach ($movieYears as $year) {
							echo "<option value='" . $year['yearID'] . "'>" . $year['year'] . "</option>";
						}
					?>
				</select>
			</form>
		</td>
		</tr>
	</table>

</body>
</html>

<?php $conn = null; ?>