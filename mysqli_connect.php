<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Connect to MySQL</title>
</head>
<body>
<?php // Script 12.1 - mysqli_connect.php
/* This script connects to the MySQL database. */

// Attempt to connect to MySQL and print out messages:
if ($dbconn = mysqli_connect('localhost', 'root', '', 'projectdb')) {
	
	print '<p>Successfully connected to the database!</p>';
	
	mysqli_close($dbconn); // Close the connection.

} else {

	print '<p style="color: red;">Could not connect to the database.</p>';

}

?>
</body>
</html>