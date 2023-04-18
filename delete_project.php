<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" media="all" href="css/normalize.css">
	<link rel="stylesheet" media="all" href="css/skeleton.css">
	<title>Project Delete</title>
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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  print '<div class="container">';
	if (!empty($_POST['projectid'])) {
		if (!empty($_POST['title'])) {
			if (!empty($_POST['description'])) {
				if (!empty($_POST['date_entered'])) {
					if (!empty($_POST['sponsor'])) {
						if (!empty($_POST['project_manager'])) {
							if (!empty($_POST['status'])) {
								if (!empty($_POST['dependency'])) {
					// Handle form data
					$projectid = $_POST['projectid'];
					$title = $_POST['title'];
					$description = $_POST['description'];
					$date_entered = $_POST['date_entered'];
					$sponsor = $_POST['sponsor'];
					$project_manager = $_POST['project_manager'];
					$status = $_POST['status'];
					$dependency = $_POST['dependency'];
					// Run UPDATE SQL
					$query = "DELETE FROM project " . 
          " WHERE projectid = " . $projectid;
		  $dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
					if ($result = mysqli_query($dbc,$query)) {
						if ($result) {
							print '<p>Project information has been deleted in the database.</p>';
						} else {
							print '<p>No rows were updated.</p>';
						}
					} else {
						print '<p>Mysql query error occured.</p>';
					}
					mysqli_close($dbc); // Close the connection.
								} else {
									// dependency not set
									print '<p style="color: red;">Dependency not entered.</p>';
								}
							} else {
								// status not set
								print '<p style="color: red;">Status not entered.</p>';
							}
						} else {
							// project_manager not set
							print '<p style="color: red;">Project Manager not entered.</p>';
						}
					} else {
						// sponsor not set
						print '<p style="color: red;">Sponsor not entered.</p>';
					}
				} else {
					// date_entered not set
					print '<p style="color: red;">Date Entered not entered.</p>';
				}
			} else {
				// team not set
				print '<p style="color: red;">Description not entered.</p>';

			}	
		} else {
			// email not set
			print '<p style="color: red;">Title not entered.</p>';

		}
	} else {
		// name not set
		print '<p style="color: red;">Projectid not entered.</p>';
	}
  print '</div>';
} else {
	// GET method and retrieve project data from projectid argument
  if (!empty($_GET['projectid'])) {
    $projectid = $_GET['projectid'];
    $query = "SELECT projectid, title, description, date_entered, sponsor, project_manager, status, dependency FROM project WHERE projectid = " . $projectid ;
    $dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
	if ($result = mysqli_query($dbc,$query)) {
      $row = $result->fetch_assoc();
      $title = $row['title'];
      $description = $row['description'];
      $date_entered = $row['date_entered'];
	  $sponsor = $row['sponsor'];
	  $project_manager = $row['project_manager'];
	  $status = $row['status'];
	  $dependency = $row['dependency'];
      $_POST['projectid'] = $projectid;
      $_POST['title'] = $title;
      $_POST['description'] = $description;
      $_POST['date_entered'] = $date_entered;
	  $_POST['sponsor'] = $sponsor;
	  $_POST['project_manager'] = $project_manager;
	  $_POST['status'] = $status;
	  $_POST['dependency'] = $dependency;
      mysqli_close($dbc); // Close the connection
    }
  }				
}
print '<div class="container">';
print '<h2>Project Form</h2>';
?>
<form action="delete_project.php" method="post">
<p><label>Project Id <input type="text" name="projectid" value="<?php if (isset($_POST['projectid'])) {print $_POST['projectid'];} ?>"></label></p>
<p><label>Title <input type="text" name="title" value="<?php if (isset($_POST['title'])) {print $_POST['title'];} ?>"></label></p>
<p><label>Description</label>
<textarea name="description" cols="40" rows="5"><?php if (isset($_POST['description'])) {print $_POST['description'];} ?></textarea>
</p>
<p><label>Date Entered <input type="datetime" name="date_entered" value="<?php if (isset($_POST['date_entered'])) {print $_POST['date_entered'];} ?>"></label></p>
<p><label>Sponsor <input type="text" name="sponsor" value="<?php if (isset($_POST['sponsor'])) {print $_POST['sponsor'];}  ?>"></label></p>
<p><label>Project Manager <input type="text" name="project_manager" value="<?php if (isset($_POST['project_manager'])) {print $_POST['project_manager'];} ?>"></label></p>
<p><label>Status <input type="text" name="status" value="<?php if (isset($_POST['status'])) {print $_POST['status'];} ?>"></label></p>
<p><label>Dependency <input type="number" name="dependency" value="<?php if (isset($_POST['dependency'])) {print $_POST['dependency'];}  ?>"></label></p>
<p><input type="submit" name="submit" value="Delete"></p>
</form>

</div>
</body>
</html>