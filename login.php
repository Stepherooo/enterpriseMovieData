<?php
	session_start(); 
	
	if (isset ($_POST['username']) && isset ($_POST['password']) ) {
		
	    require 'databaseConnection.php';
		$sql = "SELECT * FROM userAccounts 
			WHERE username = :username
			AND password = :password";
			
		$stmt = $conn -> prepare($sql);
		$stmt -> execute( array(":username" => $_POST['username'], 
			":password" => hash("sha1", $_POST['password'])) );
		
		$record = $stmt -> fetch();
		
		if (empty($record)){
			echo "Wrong username/password!";
		} 
		
		else {
			$sql = "INSERT INTO userLog (username)
				VALUES (:username)";
			$stmt = $conn -> prepare($sql);
			$stmt -> execute( array(":username" => $_POST['username']) );
			
			$_SESSION['username'] = $record['username'];
			$_SESSION['name'] = $record['name'];
			header("Refresh:1 url='movieSearch.php'");
		}
	
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
	<div class="center">
		<table id="login"><form method="post">
			<tr><td colspan="2">Welcome!</td></tr>
			
			<tr>
				<td>Username</td>
				<td><input size="20" type="text" name="username"></td>
			</tr>
			
			<tr>
				<td>Password</td>
				<td><input size="20" type="password" name="password"></td>
			</tr>
			
			<tr>
				<td colspan="2"><a href="register.php">Create an Account</a></td>
			</tr>
			
			<tr>
				<td><input type="submit" value="Enter"></td>
				<td><input type="reset" value="Clear"></td>
			</tr>
			
			<tr>
				<td colspan="2"><i class="credit">Team Enterprise: Stephanie Gan, Chris Mendonca, Randall Rood</i></td>
			</tr>
			
		</form></table>
	</div>

</body>
</html>

<?php $conn = null; ?>