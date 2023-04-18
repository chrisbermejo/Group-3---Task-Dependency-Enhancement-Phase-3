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

	print '<p>POST Method call is invalid in view_task</p>';

} else {
	// Not POST method and retrieve all project segments
	// Setup database connection
					// Run SELECT SQL
					$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
					$query = "SELECT taskid, title, description, projectid, memberid, date_start, date_target, date_actual_start, date_actual_completion, person_hours_estimate, person_hours_actual, status, dependency FROM task";
					if ($result = mysqli_query($dbc,$query)) {
						$rowcount = $result->num_rows;
						if ($rowcount > 0) {
							print '<div class="container">';
							print '<table class="u-full-width">';
							print '<thead>';
							print '<tr>';
							print '<th>Task Id</th>';
							print '<th>Title</th>';
							print '<th>Description</th>';
                            print '<th>Project ID</th>';
                            print '<th>Member ID</th>';
							print '<th>Start Date</th>';
                            print '<th>Target Date</th>';
                            print '<th>Actual Start</th>';
                            print '<th>Completion Date</th>';
                            print '<th>Est Hours</th>';
                            print '<th>Actual Hours</th>';
                            print '<th>Status</th>';
                            print '<th>Dependency</th>';
							print '</tr>';
							print '</thead>';
							print '<tbody>';
							// for each row
							for ($r = 0;$r < $rowcount;$r++) {
								$row = $result->fetch_assoc();
								print '<tr><td>' . $row['taskid'] . 
								'</td><td>' . $row['title'] . 
								'</td><td>' . $row['description'] . 
                                '</td><td>' . $row['projectid'] . 
                                '</td><td>' . $row['memberid'] . 
                                '</td><td>' . $row['date_start'] . 
								'</td><td>' . $row['date_target'] . 
                                '</td><td>' . $row['date_actual_start'] .
                                '</td><td>' . $row['date_actual_completion'] .
                                '</td><td>' . $row['person_hours_estimate'] .
                                '</td><td>' . $row['person_hours_actual'] .
                                '</td><td>' . $row['status'] .
                                '</td><td>' . $row['dependency'] .
								'</td><td>' . '<a href=edit_task.php?taskid=' . $row['taskid'] . '>Edit</a>' .
								'</td><td>' . '<a href=delete_task.php?taskid=' . $row['taskid'] . '>Delete</a>' .
								'</td></tr>';
							}
							print '</tbody>';
							print '</table>';
							print '</div>';
						} else {
							print '<p>No project rows retrieved.</p>';
						}
						mysqli_close($dbc); // Close the connection
					}
					print '<div class=container><a href=insert_task.php>Create New Task</a></div>';
					
}
?>
</div>
</body>
</html>