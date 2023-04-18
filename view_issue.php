<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" media="all" href="css/normalize.css">
	<link rel="stylesheet" media="all" href="css/skeleton.css">
	<title>Issue Form</title>
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

	print '<p>POST Method call is invalid in view_issue</p>';

} else {
	// Not POST method and retrieve all project segments
	// Setup database connection
					// Run SELECT SQL
					$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
					$query = "SELECT issueid, issue_short, issue_text, issue_text, reported_by, assigned_memberid, date_reported, date_assigned, date_resolved, resolution_text, assigned_taskid, status, person_hours_actual FROM issue";
					if ($result = mysqli_query($dbc,$query)) {
						$rowcount = $result->num_rows;
						if ($rowcount > 0) {
							print '<div class="container">';
							print '<table class="u-full-width">';
							print '<thead>';
							print '<tr>';
							print '<th>Issue Id</th>';
							print '<th>Short Desc</th>';
							print '<th>Description</th>';
                            print '<th>Reported By</th>';
                            print '<th>Assigned ID</th>';
							print '<th>Reported Date</th>';
                            print '<th>Assigned Date</th>';
                            print '<th>Resolve  Date</th>';
                            print '<th>Resolution</th>';
                            print '<th>Task IDs</th>';
                            print '<th>Status</th>';
                            print '<th>Hours</th>';
							print '</tr>';
							print '</thead>';
							print '<tbody>';
							// for each row
							for ($r = 0;$r < $rowcount;$r++) {
								$row = $result->fetch_assoc();
								print '<tr><td>' . $row['issueid'] . 
								'</td><td>' . $row['issue_short'] . 
								'</td><td>' . $row['issue_text'] . 
                                '</td><td>' . $row['reported_by'] . 
                                '</td><td>' . $row['assigned_memberid'] . 
                                '</td><td>' . $row['date_reported'] . 
								'</td><td>' . $row['date_assigned'] . 
                                '</td><td>' . $row['date_resolved'] .
                                '</td><td>' . $row['resolution_text'] .
                                '</td><td>' . $row['assigned_taskid'] .
                                '</td><td>' . $row['status'] .
                                '</td><td>' . $row['person_hours_actual'] .
								'</td><td>' . '<a href=edit_issue.php?issueid=' . $row['issueid'] . '>Edit</a>' .
								'</td><td>' . '<a href=delete_issue.php?issueid=' . $row['issueid'] . '>Delete</a>' .
								'</td></tr>';
							}
							print '</tbody>';
							print '</table>';
							print '</div>';
						} else {
							print '<p>No issues retrieved.</p>';
						}
						mysqli_close($dbc); // Close the connection
					}
					print '<div class=container><a href=insert_issue.php>Create New Issue</a></div>';
					
}
?>
</div>
</body>
</html>