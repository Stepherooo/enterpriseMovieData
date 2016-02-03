<?php
	session_start();
	require 'databaseConnection.php';
	
	if(!isset($_SESSION['username'])) {
		header('Location: login.php');
	}
	
	if ( isset ($_POST['password']) && isset ($_POST['newPassword']) 
		&& isset ($_POST['submit']) ) {
			
		try {
			global $conn;
			
			$sql = "UPDATE userAccounts
				SET password =:newPassword
				WHERE username = :username AND password = :oldPassword";
			$stmt = $conn -> prepare($sql);
			$stmt -> execute(array(":username" => $_SESSION['username'],
				":newPassword" => hash("sha1", $_POST['newPassword']),
				":oldPassword" => hash("sha1", $_POST['password'])));
				
			echo "<div style='background-color: #ffffff;'> >> Password Updated Successfully!</div>";
		}
		
		catch (PDOException $e) {
			echo "ERROR: " . $e->getMessage;
		}
		
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Change Password</title>
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
			<tr><td colspan="2">Change Password?</td></tr>
			
			<tr>
				<td>Old Password</td>
				<td><input size="20" type="password" name="password"></td>
			</tr>
			
			<tr>
				<td>New Password</td>
				<td><input size="20" type="password" name="newPassword"></td>
			</tr>
			
			<tr>
				<td><input type="submit" value="Enter" name="submit"></td>
				<td><input type="reset" value="Clear"></td>
			</tr>
			
		</form></table>
	</div>

</body>
</html>

<?php $conn = null; ?>