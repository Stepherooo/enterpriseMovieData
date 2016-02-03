<?php
	session_start();
	
	if(!isset($_SESSION['username'])) {
		header('Location: login.php');
	}
?>

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>MOVIES!</title>
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
		
		
	</table>

</body>
</html>

<?php $conn = null; ?>