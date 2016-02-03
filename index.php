<?php
	session_start(); 
	
	if (isset ($_POST['username']) && isset ($_POST['password']) ) {
		
	    require 'databaseConnection.php';
		$sql = "SELECT * FROM userAccounts 
			WHERE username = :username
			AND password = :password";
			
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(":username" => $_POST['username'], ":password" => hash("sha1", $_POST['password'])));
		
		$record = $stmt -> fetch();
		
		if (empty($record)){
			echo "Wrong username/password!";
		} 
		
		else {
			$_SESSION['username'] = $record['username'];
			$_SESSION['name'] = $record['firstname'] . " " . $record['lastname'];
			header("Location: movieSearch.php");
		}
	
	}
	
	include 'topLayout.php';
?>

<div class="center">
	<table id="login"><form method="post">
		<tr><td colspan="2">Welcome!</td></tr>
		
		<tr>
			<td>Username</td>
			<td><input size="20" type="text" name="username" value=""></td>
		</tr>
		
		<tr>
			<td>Password</td>
			<td><input size="20" type="password" name="password" value=""></td>
		</tr>
		
		<tr>
			<td colspan="2"><a href="">Register</a></td>
		</tr>
		
		<tr>
			<td><input type="submit" value="Enter"></td>
			<td><input type="reset" value="Clear"></td>
		</tr>
		
	</form></table>
</div>

<?php
	include 'bottomLayout.php';
?>
