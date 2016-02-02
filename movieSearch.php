<?php 
	require 'databaseConnection.php';
	
	function getMovies() {
		global $conn;
		$sql = "SELECT movieID, title 
			FROM movieDatabase
			ORDER BY title ASC";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
		return $stmt -> fetchAll();
	}
	
	function getDirectors() {
		global $conn;
		$sql = "SELECT DISTINCT director
			FROM movieDatabase
			ORDER BY director ASC";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
		return $stmt -> fetchAll();
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
	
	function getQuery($searchMovie, $searchDirector, $searchGenre, $searchRating) {
		global $conn; 
		
		/*** Getting Movie Info Through Search by Movie ***/
		if ( $searchMovie != -1 ) {
			$whereStmt = "WHERE movieID LIKE '" . $searchMovie . "'";
		}
	
		else if ( $searchDirector != -1 && $searchGenre != -1 && $searchRating != -1 ) {
			$whereStmt = "WHERE director LIKE '" . $searchDirector .
				"' AND genre LIKE '" . $searchGenre . 
				"' AND rating = '" . $searchRating . "'";
		}
		
		else if( $searchDirector != -1 && $searchGenre != -1 ) {
			$whereStmt = "WHERE director LIKE '" . $searchDirector .
				"' AND genre LIKE '" . $searchGenre . "'";
		}
		
		else if( $searchDirector != -1 && $searchRating != -1 ) {
			$whereStmt = "WHERE director LIKE '" . $searchDirector .
				"' AND rating LIKE '" . $searchRating . "'";
		}
		
		else if( $searchGenre != -1 && $searchRating != -1 ) {
			$whereStmt = "WHERE genre LIKE '" . $searchGenre .
				"' AND rating LIKE '" . $searchRating . "'";
		}
		
		else if ( $searchDirector != -1 ) {
			$whereStmt = "WHERE director LIKE '" . $searchDirector . "'";
		}
		
		else if ( $searchGenre != -1 ) {
			$whereStmt = "WHERE genre LIKE '" . $searchGenre . "'";
		}
		
		else if ( $searchRating != -1 ) {
			$whereStmt = "WHERE rating LIKE '" . $searchRating . "'";
		}

		$sql = "SELECT *
			FROM movieDatabase
			" . $whereStmt;
			$stmt = $conn -> prepare($sql);
			$stmt -> execute();
			$searchResults = $stmt -> fetchAll();
		return $searchResults;
	}
?>

	<?php include 'topLayout.php'; ?>
	
	<table id="main">
		<tr><td colspan="4">
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
				<input type="submit" value="Search"><img src="popcorn-icon.png">

		</td></tr>
		
		<tr><td><br></td></tr>
		
		<tr><td colspan="4"><h2>Filter Movies By Director, Genre, and/or Year</h2></td></tr>
			
		<tr><td>
			<h3>Director</h3>
			<select size=1 name="director">
				<option value="-1">Choose A Director</option>
				<?php
					$directorNames = getDirectors();
					foreach ($directorNames as $director) {
						echo "<option value='" . $director['director'] . "'>" . $director['director'] . "</option>";
					}
				?>
			</select>
		</td>

		<td>
			<h3>Genre</h3>
			<select size=1 name="genre">
				<option value="-1">Choose A Genre</option>
				<?php
					$movieGenres = getGenres();
					foreach ($movieGenres as $genre) {
						echo "<option value='" . $genre['genre'] . "'>" . $genre['genre'] . "</option>";
					}
				?>
			</select>
		</td>
		
		<td>
			<h3>Rating</h3>
			<select size="1" name="rating">
				<option value="-1">Choose A Rating</option>
				<?php
					$movieRatings = getRatings();
					foreach ($movieRatings as $rating) {
						echo "<option value='" . $rating['rating'] . "'>" . $rating['rating'] . "</option>";
					}
				?>
			</select>
		</td>
		
		<td style="vertical-align: bottom;">
			<input type="submit" value="Search" size="50"><img src="popcorn-icon.png">
			</form>
		
		</td></tr>
	</table>
	
	<table id="results">
		<?php
			// Only runs the following if user has selected something
			if ( isset ($_POST['movieID']) && $_POST['movieID'] != -1 || 
			isset ($_POST['director']) && $_POST['director'] != -1 ||
			isset ($_POST['genre']) && $_POST['genre'] != -1 ||
			isset ($_POST['rating']) && $_POST['rating'] != -1 ) {
				$searchMovie = $_POST['movieID'];
				$searchDirector = $_POST['director'];
				$searchGenre = $_POST['genre'];
				$searchRating = $_POST['rating'];
				
				echo "<tr><td class='center' colspan='100'><h2>Your Movie Results</h2></td></tr>";
				echo "<tr><th>Movie Title</th>";
				echo "<th>Director</th>";
				echo "<th>Genre</th>";
				echo "<th>Rating</th></tr>";
				
				$results = getQuery($searchMovie, $searchDirector, $searchGenre, $searchRating);
				
				foreach ($results as $resultDisplay) {
					echo "<tr>";
					echo "<td>" . $resultDisplay['title'] . "</td>";
					echo "<td>" . $resultDisplay['director'] . "</td>";
					echo "<td>" . $resultDisplay['genre'] . "</td>";
					echo "<td>" . $resultDisplay['rating'] . "</td>";
					echo "</tr>";
				} 
			}
		?>
	</table>

<?php include 'bottomLayout.php'; ?>
