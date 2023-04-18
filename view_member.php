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
					$query = "SELECT memberid, name, email, role, isActive, teamid FROM member";
					if ($result = mysqli_query($dbc,$query)) {
						$rowcount = $result->num_rows;
						if ($rowcount > 0) {
							print '<div class="container">';
							print '<table class="u-full-width">';
							print '<thead>';
							print '<tr>';
							print '<th>Mamber Id</th>';
							print '<th>Name</th>';
							print '<th>Email</th>';
							print '<th>Role</th>';
							print '<th>Active</th>';
							print '<th>Team Id</th>';
							print '</tr>';
							print '</thead>';
							print '<tbody>';
							// for each row
							for ($r = 0;$r < $rowcount;$r++) {
								$row = $result->fetch_assoc();
								print '<tr><td>' . $row['memberid'] . 
								'</td><td>' . $row['name'] .
								'</td><td>' . $row['email'] .
								'</td><td>' . $row['role'] . 
								'</td><td>' . $row['isActive'] . 
								'</td><td>' . $row['teamid'] . 
								'</td><td>' . '<a href=edit_member.php?memberid=' . $row['memberid'] . '>Edit</a>' .
								'</td><td>' . '<a href=delete_member.php?memberid=' . $row['memberid'] . '>Delete</a>' .
								'</td></tr>';
							}
							print '</tbody>';
							print '</table>';
							print '</div>';
						} else {
							print '<p>No Member rows retrieved.</p>';
						}
						mysqli_close($dbc); // Close the connection
					}
					print '<div class=container><a href=insert_member.php>Create New Member</a></div>';
					
}
?>
</div>
</body>
</html>