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

	if (!empty($_POST['title'])) {
		if (!empty($_POST['description'])) {
			if (!empty($_POST['sponsor'])) {
				if (!empty($_POST['project_manager'])) {
                    if (!empty($_POST['status'])) {
                        if (!empty($_POST['dependency'])) {
                            // Handle form data
                            $title = $_POST['title'];
                            $description = $_POST['description'];
                            $sponsor = $_POST['sponsor'];
                            $project_manager = $_POST['project_manager'];
                            $status =  $_POST['status'];
                            $dependency =  $_POST['dependency'];
                            $dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());

                            // Run INSERT SQL
                            $query = "INSERT INTO project (title,
                                    description, sponsor, project_manager,status,dependency)
                                     VALUES 
                                    ('" . $title ."','" . $description ."','" . $sponsor ."','" . 
                                     $project_manager . "','" . $status . "'," . $dependency . ")";
                            $result = mysqli_query($dbc,$query);
                            if (mysqli_affected_rows($dbc) == 1) {
                                print '<div class="container"><p>Your project information has been added to the database.</p></div>';
                            } else {
                                print '<p>Could not insert your project information to the database .  Error:<br>' . mysqli_error($dbc) . '.</p>';
                            }
                            mysqli_close($dbc); // Close the connection.

                        } else {
                            // dependency not set
                            print '<p style="color: red;">dependency not entered.</p>';
                        }
                    } else {
                        // status not set
                        print '<p style="color: red;">status not entered.</p>';
                    }
				} else {
					// project_manager not set
					print '<p style="color: red;">project_manager not entered.</p>';
				}
			} else {
				// sponsor not set
				print '<p style="color: red;">Sponsor lead not entered.</p>';

			}	
		} else {
			// description not set
			print '<p style="color: red;">Description not entered.</p>';

		}
	} else {
		// title not set
		print '<p style="color: red;">title not entered.</p>';
	}

} 
// First time show the form
// 
print '<div class="container">';
print '<h2>Project Form</h2>';
?>
<form action="insert_project.php" method="post">
<p><label>Title <input type="text" name="title" value="<?php if (isset($_POST['title'])) {print $_POST['title'];} ?>"></label></p>
<p><label>Description</label>
<textarea name="description" cols="40" rows="5"><?php if (isset($_POST['description'])) {print $_POST['description'];} ?></textarea>
</p>
<p><label>Sponsor <input type="text" name="sponsor" value="<?php if (isset($_POST['sponsor'])) {print $_POST['sponsor'];}  ?>"></label></p>
<p><label>Project Manager <input type="text" name="project_manager" value="<?php if (isset($_POST['project_manager'])) {print $_POST['project_manager'];} ?>"></label></p>
<p><label>Status <input type="text" name="status" value="<?php if (isset($_POST['status'])) {print $_POST['status'];} ?>"></label></p>
<p><label>Dependency <input type="number" name="dependency" value="<?php if (isset($_POST['dependency'])) {print $_POST['dependency'];}  ?>"></label></p>
<p><input type="submit" name="submit" value="Create"></p>
</form>
<?php

?>
</div>
</body>
</html>

