<?php
	require 'databaseConnection.php';
	
	if ( isset ($_POST['username']) && isset ($_POST['password']) && 
		isset ($_POST['name']) && isset ($_POST['submit']) ) {
			
		try {
			$sql = "INSERT INTO userAccounts
				(username, password, name)
				VALUES
				(:username, :password, :name)";
			
			$stmt = $conn -> prepare($sql);
			$stmt -> execute( array (":username" => $_POST['username'],
				":password" => hash("sha1", $_POST['password']),
				":name" => $_POST['name']) );
				
			echo "<div style='background-color: #ffffff;'> >> Thanks for registering!</div>";
		}
		
		catch (PDOException $e) {
			//echo "<div style='background-color: #ffffff;'> >> ERROR: Did you leave a field blank? Try again!</div>";
			echo $e->getMessage();
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Make An Account</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="ourStyles.css">
</head>
<body>
	<div id="header"></div>
	<div id="nav">
		<h3>Members Area</h3>
		<a href="login.php">Login Page</a><br>
	</div>
	
	<div class="center">
		<table id="login"><form method="post">
			<tr><td colspan="2">Create An Account NOW! DO IT!</td></tr>
			
			<tr>
				<td>Your Name</td>
				<td><input size="20" type="text" name="name"></td>
			</tr>
			
			<tr>
				<td>Username</td>
				<td><input size="20" type="text" name="username"></td>
			</tr>
			
			<tr>
				<td>Password</td>
				<td><input size="20" type="password" name="password"></td>
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