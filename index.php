<?php
    require 'databaseConnection.php';
	include 'topLayout.php';
?>

<div class="center">
	<table id="login"><form method="post">
		<tr><td colspan="2">Welcome!</td></tr>
		
		<tr>
			<td>Username</td>
			<td><input size="20" type="text" name="userName" value=""></td>
		</tr>
		
		<tr>
			<td>Password</td>
			<td><input size="20" type="text" name="userPass" value=""></td>
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
