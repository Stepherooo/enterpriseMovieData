<?php
    /* Connects to our Database */
    $servername = "localhost";
	$dbname = "gan1832";
	$username = "gan1832";
	$password = "sleepyOwl12";
	
	try {
		$conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		echo "Connected Successfully.<br>"; // connection test
	}
	
	catch (PDOException $e) {
		echo "ERROR! " . $e->getMessage();
	}
	
	// Disconnect
	$conn = null;
?>