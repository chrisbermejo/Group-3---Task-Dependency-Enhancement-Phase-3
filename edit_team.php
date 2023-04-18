<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" media="all" href="css/normalize.css">
	<link rel="stylesheet" media="all" href="css/skeleton.css">
	<title>Project Edit</title>
</head>
<body>
<?php
/* 
   This page shows a form to view a project list 
   The variables are retrieved from the post method
   A connection is established to the database
   SQL is prepared to insert the data in the database
*/
include('include/header.php');
//
//
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  print '<div class="container">';
	if (!empty($_POST['teamid'])) {
		if (!empty($_POST['teamname'])) {
			if (!empty($_POST['description'])) {
				if (!empty($_POST['team_lead'])) {
					if (!empty($_POST['isActive'])) {
						// Handle form data
						$teamid = $_POST['teamid'];
						$teamname = $_POST['teamname'];
						$description = $_POST['description'];
						$team_lead = $_POST['team_lead'];
						$isActive = $_POST['isActive'];
						// Setup database connection
						$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
						// Run UPDATE SQL
						$query = "UPDATE team " . 
						"set teamname = '" . $teamname . "'," .
						" description = '" . $description . "'," .
						" team_lead = " . $team_lead . "," .
						" isActive = '" . $isActive . "' " .
	          " WHERE teamid = " . $teamid;
          
						if ($result = mysqli_query($dbc,$query)) {
							if ($result) {
								print '<p>Team information has been updated in the database.</p>';
							} else {
								print '<p>No rows were updated.</p>';
							}
						} else {
							print '<p>Mysql query error occured.</p>';
						}
						mysqli_close($dbc); // Close the connection.
					} else {
						// isActive not set
						print '<p style="color: red;">isActive not entered.</p>';
					}
				} else {
					// team_lead not set
					print '<p style="color: red;">Team Lead not entered.</p>';
				}
			} else {
				// team not set
				print '<p style="color: red;">Description not entered.</p>';

			}	
		} else {
			// email not set
			print '<p style="color: red;">Teamname not entered.</p>';

		}
	} else {
		// name not set
		print '<p style="color: red;">Team id not entered.</p>';
	}
  print '</div>';
} else {
	// GET method and retrieve project data from projectid argument
  if (!empty($_GET['teamid'])) {
    $teamid = $_GET['teamid'];
    // Setup database connection
    $dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
    $query = "SELECT teamid, teamname, description, team_lead, isActive FROM team WHERE teamid = " . $teamid ;
    if ($result = mysqli_query($dbc,$query)) {
      $row = $result->fetch_assoc();
      $teamname = $row['teamname'];
      $description = $row['description'];
      $team_lead = $row['team_lead'];
      $isActive = $row['isActive'];
      $_POST['teamid'] = $teamid;
      $_POST['teamname'] = $teamname;
      $_POST['description'] = $description;
      $_POST['team_lead'] = $team_lead;
      $_POST['isActive'] = $isActive;
      mysqli_close($dbc); // Close the connection
    }
  }				
}
print '<div class="container">';
print '<h2>Team Form</h2>';
?>
<form action="edit_team.php" method="post">
<p><label>Team Id <input type="text" name="teamid" value="<?php if (isset($_POST['teamid'])) {print $_POST['teamid'];} ?>"></label></p>
<p><label>Team Name <input type="text" name="teamname" value="<?php if (isset($_POST['teamname'])) {print $_POST['teamname'];} ?>"></label></p>
<p><label>Description</label>
<textarea name="description" cols="40" rows="5"><?php if (isset($_POST['description'])) {print $_POST['description'];} ?></textarea>
</p>
<p><label>Team Lead <input type="number" name="team_lead" value="<?php if (isset($_POST['team_lead'])) {print $_POST['team_lead'];} ?>"></label></p>
<p><label>Active <input type="text" name="isActive" value="<?php if (isset($_POST['isActive'])) {print $_POST['isActive'];} ?>"></label></p>
<p><input type="submit" name="submit" value="Update"></p>
</form>

</div>
</body>
</html>