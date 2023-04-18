<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" media="all" href="css/normalize.css">
	<link rel="stylesheet" media="all" href="css/skeleton.css">
	<title>Member Form</title>
</head>
<body>
<?php
/* 
   This page shows a form to register a team member 
   The variables are retrieved from the post method
   A connection is established to the database
   SQL is prepared to insert the data in the database
*/
include('include/header.php');
//
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (!empty($_POST['name'])) {
		if (!empty($_POST['email'])) {
			if (!empty($_POST['role'])) {
				if (!empty($_POST['isActive'])) {
					if (!empty($_POST['teamid'])) {
						// Handle form data
						$name = $_POST['name'];
						$email = $_POST['email'];
						$role = $_POST['role'];
						$isActive = $_POST['isActive'];
						$teamid = $_POST['teamid'];
						// Setup database connection
						$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());

						// Run INSERT SQL
						$query = "INSERT INTO member (name, email, role, isActive, teamid) VALUES 
								('" . $name ."','" . $email . "','" . $role ."','" . $isActive ."'," . $teamid .")";
						$result = mysqli_query($dbc,$query);
						if (mysqli_affected_rows($dbc) == 1) {
							print '<p>Your member information has been added to the database.</p>';
						} else {
							print '<p>Could not insert your member information to the database .  Error:<br>' . mysqli_error($dbc) . '.</p>';
						}

						mysqli_close($dbc); // Close the connection.
					} else {
						// Teamid not set
						print '<p style="color: red;">Teamid not entered.</p>';
					}
				} else {
					// isActive not set
					print '<p style="color: red;">isActive not entered.</p>';
				}
			} else {
				// role not set
				print '<p style="color: red;">Role not entered.</p>';

			}	
		} else {
			// email not set
			print '<p style="color: red;">Email not entered.</p>';

		}
	} else {
		// name not set
		print '<p style="color: red;">Name not entered.</p>';
	}

} 
// First time show the form
// 
print '<div class="container">';
print '<h2>Member Form</h2>';
?>
<form action="insert_member.php" method="post">
<p><label>Name <input type="text" name="name" value="<?php if (isset($_POST['name'])) {print $_POST['name'];} ?>"></label></p>
<p><label>Email <input type="email" name="email" value="<?php if (isset($_POST['email'])) {print $_POST['email'];} ?>"></label></p>
<p><label>Role <input type="text" name="role" value="<?php if (isset($_POST['role'])) {print $_POST['role'];}  ?>"></label></p>
<p><label>IsActive <input type="text" name="isActive" value="<?php if (isset($_POST['iActive'])) {print $_POST['isActive'];} ?>"></label></p>
<p><label>teamid <input type="number" name="teamid" value="<?php if (isset($_POST['teamid'])) {print $_POST['teamid'];} ?>"></label></p>
<p><input type="submit" name="submit" value="Member"></p>
</form>
<?php

?>
</div>
</body>
</html>

