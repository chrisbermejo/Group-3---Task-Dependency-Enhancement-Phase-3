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
   This page shows a form to create a team  
   The variables are retrieved from the post method
   A connection is established to the database
   SQL is prepared to insert the data in the database
*/
include('include/header.php');
//
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (!empty($_POST['teamname'])) {
		if (!empty($_POST['description'])) {
			if (!empty($_POST['team_lead'])) {
				if (!empty($_POST['isActive'])) {
					// Handle form data
					$teamname = $_POST['teamname'];
					$description = $_POST['description'];
					$team_lead = $_POST['team_lead'];
					$isActive = $_POST['isActive'];
					// Setup database connection
					$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());

					// Run INSERT SQL
					$query = "INSERT INTO team (teamname,description,team_lead, isActive) VALUES 
							 ('" . $teamname ."','" . $description ."'," . $team_lead ." ,'" . $isActive . "')";
					$result = mysqli_query($dbc,$query);
					if (mysqli_affected_rows($dbc) == 1) {
						print '<div class="container"><p>Your team information has been added to the database.</p></div>';
					} else {
						print '<p>Could not insert your team information to the database .  Error:<br>' . mysqli_error($dbc) . '.</p>';
					}

					mysqli_close($dbc); // Close the connection.

				} else {
					// isActive not set
					print '<p style="color: red;">isActive not entered.</p>';
				}
			} else {
				// team_lead not set
				print '<p style="color: red;">Team lead not entered.</p>';

			}	
		} else {
			// description not set
			print '<p style="color: red;">Description not entered.</p>';

		}
	} else {
		// teamname not set
		print '<p style="color: red;">teamname not entered.</p>';
	}

} 
// First time show the form
// 
print '<div class="container">';
print '<h2>Team Form</h2>';
?>
<form action="insert_team.php" method="post">
<p><label>Team Name <input type="text" name="teamname" value="<?php if (isset($_POST['teamname'])) {print $_POST['teamname'];} ?>"></label></p>
<p><label>Description <input type="text" name="description" value="<?php if (isset($_POST['description'])) {print $_POST['description'];} ?>"></label></p>
<p><label>Team Lead <input type="number" name="team_lead" value="<?php if (isset($_POST['team_lead'])) {print $_POST['team_lead'];}  ?>"></label></p>
<p><label>Active <input type="text" name="isActive" value="<?php if (isset($_POST['isActive'])) {print $_POST['isActive'];} ?>"></label></p>
<p><input type="submit" name="submit" value="Create"></p>
</form>
<?php

?>
</div>
</body>
</html>

