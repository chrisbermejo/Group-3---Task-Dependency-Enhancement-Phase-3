<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" media="all" href="css/normalize.css">
	<link rel="stylesheet" media="all" href="css/skeleton.css">
	<title>Project Form</title>
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

	print '<p>POST Method call is invalid in view_team</p>';

} else {
	// Not POST method and retrieve all project segments
	// Setup database connection
					$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
					// Run SELECT SQL
					$query = "SELECT teamid, teamname, description, team_lead, isActive FROM team";
					if ($result = mysqli_query($dbc,$query)) {
						$rowcount = $result->num_rows;
						if ($rowcount > 0) {
							print '<div class="container">';
							print '<table class="u-full-width">';
							print '<thead>';
							print '<tr>';
							print '<th>Team Id</th>';
							print '<th>Team Name</th>';
							print '<th>Description</th>';
							print '<th>Team Lead</th>';
							print '<th>Active</th>';
							print '</tr>';
							print '</thead>';
							print '<tbody>';
							// for each row
							for ($r = 0;$r < $rowcount;$r++) {
								$row = $result->fetch_assoc();
								print '<tr><td>' . $row['teamid'] . 
								'</td><td>' . $row['teamname'] .
								'</td><td>' . $row['description'] .
								'</td><td>' . $row['team_lead'] . 
								'</td><td>' . $row['isActive'] . 
								'</td><td>' . '<a href=edit_team.php?teamid=' . $row['teamid'] . '>Edit</a>' .
								'</td><td>' . '<a href=delete_team.php?teamid=' . $row['teamid'] . '>Delete</a>' .
								'</td></tr>';
							}
							print '</tbody>';
							print '</table>';
							print '</div>';
						} else {
							print '<p>No team rows retrieved.</p>';
						}
						mysqli_close($dbc); // Close the connection
					}
					print '<div class=container><a href=insert_team.php>Create New Team</a></div>';
					
}
?>
</div>
</body>
</html>