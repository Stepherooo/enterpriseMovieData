<?php
	require 'databaseConnection.php';
	if ( is_numeric($_GET['id']) ) {
		$request = $_GET['id'];
	}
	
	function getMovie($request) {
		global $conn;
		
		$sql = "SELECT *
			FROM movieDatabase
			WHERE movieID = " . $request;
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
		return $stmt -> fetchAll();
	}
	
	include 'topLayout.php';
?>

	<table id="inDepth">
		<tr><td id="space" colspan="2"></td></tr>
		<tr>
			<td>Title:</td>
			<td>
				<?php
					$results = getMovie($request);
					foreach ($results as $resultDisplay) {
						echo $resultDisplay['title'] . "</td></tr>";
						
						echo "<tr><td>Director:</td>";
						echo "<td>" . $resultDisplay['director'] . "</td></tr>";
						
						echo "<tr><td>Featured Star:</td>";
						echo "<td>" . $resultDisplay['star'] . "</td></tr>";
						
						echo "<tr><td>Genre:</td>";
						echo "<td>" . $resultDisplay['genre'] . "</td></tr>";
						
						echo "<tr><td>Rating:</td>";
						echo "<td>" . $resultDisplay['rating'] . "</td></tr>";
						
						echo "<tr><td>Length:</td>";
						echo "<td>" . $resultDisplay['length'] . " minutes</td></tr>";
						
						echo "<tr><td>Year:</td>";
						echo "<td>" . $resultDisplay['year'] . "</td></tr>";
					}
				?>
			</td>
		</tr>
		
		<tr><td id="space" colspan="2"></td></tr>
		
		<tr>
			<td colspan="2">
				<button onclick="history.back();">Go Back</button><img src="popcorn-icon.png">
			</td>
		</tr>
	</table>

<?php include 'bottomLayout.php'; ?>