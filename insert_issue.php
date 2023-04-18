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
   This page shows a form to create an issue 
   The variables are retrieved from the post method
   A connection is established to the database
   SQL is prepared to insert the data in the database
   task table contains:
   issueid
   issue_short
   issue_text
   reported_by
   assigned_memberid
   date_reported
   date_assigned
   date_resolved
   resolution_text
   assigned_taskid
   status
   person_hours_actual
*/
include('include/header.php');
//
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (!empty($_POST['issue_short'])) {
		if (!empty($_POST['issue_text'])) {
			if (!empty($_POST['reported_by'])) {
				if (!empty($_POST['assigned_memberid'])) {
                    if (!empty($_POST['date_reported'])) {
                        if (!empty($_POST['date_assigned'])) {
                            if (!empty($_POST['date_resolved'])) {
                                if (!empty($_POST['resolution_text'])) {
                                    if (!empty($_POST['assigned_taskid'])) {
                                        if (!empty($_POST['status'])) {
                                            if (!empty($_POST['person_hours_actual'])) {
                                                
                            // Handle form data
                            $issue_short = $_POST['issue_short'];
                            $issue_text = $_POST['issue_text'];
                            $reported_by = $_POST['reported_by'];
                            $assigned_memberid = $_POST['assigned_memberid'];
                            $date_reported = $_POST['date_reported'];
                            $date_assigned = $_POST['date_assigned'];
                            $date_resolved = $_POST['date_resolved'];
                            
                            $resolution_text = $_POST['resolution_text'];
                            $assigned_taskid = $_POST['assigned_taskid'];
                            $status =  $_POST['status'];
                            $person_hours_actual =  $_POST['person_hours_actual'];
                            $dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());

                            // Run INSERT SQL
                            $query = "INSERT INTO issue (issue_short,
                                    issue_text, reported_by, assigned_memberid,
                                    date_reported, date_assigned,
                                    date_resolved, resolution_text,
                                    assigned_taskid,
                                    status, person_hours_actual)
                                     VALUES 
                                    ('" . $issue_short ."','" . $issue_text ."','" . $reported_by ."', " . $assigned_memberid . ", '" .
                                     $date_reported . "','" . $date_assigned . "','" . 
                                     $date_resolved . "','" . $resolution_text . "'," .
                                     $assigned_taskid . ",'" .
                                     $status . "'," . $person_hours_actual . 
                                     ")";
                            $result = mysqli_query($dbc,$query);
                            if (mysqli_affected_rows($dbc) == 1) {
                                print '<div class="container"><p>Your issue information has been added to the database.</p></div>';
                            } else {
                                print '<p>Could not insert your issue information to the database .  Error:<br>' . mysqli_error($dbc) . '.</p>';
                            }
                            mysqli_close($dbc); // Close the connection.
                                                
                                            } else {
                                                // Hours not set
                                                print '<p style="color: red;">Actual Hours not entered.</p>';
                                            }
                                        } else {
                                            // Status not set
                                            print '<p style="color: red;">Status not entered.</p>';
                                        }
                                    } else {
                                        // Assigned Taskid not set
                                        print '<p style="color: red;">Assigned as Taskid not entered.</p>';
                                    }
                                } else {
                                    // Resolution Text not set
                                    print '<p style="color: red;">Resolution information not entered.</p>';
                                }
                            } else {
                                // Resolved Date not set
                                print '<p style="color: red;">Resolved Date not entered.</p>';
                            }
                        } else {
                            // Assigned Date not set
                            print '<p style="color: red;">Assigned Date not entered.</p>';
                        }
                    } else {
                        // Reported Date  not set
                        print '<p style="color: red;">Reported Date not entered.</p>';
                    }
				} else {
					// Assigned memberid not set
					print '<p style="color: red;">Assigned to memberid not entered.</p>';
				}
			} else {
				// Reported by not set
				print '<p style="color: red;">Reported by not entered.</p>';

			}	
		} else {
			// description not set
			print '<p style="color: red;">Description not entered.</p>';

		}
	} else {
		// issue short desc not set
		print '<p style="color: red;">Issue short description not entered.</p>';
	}

} 
// First time show the form
// 
print '<div class="container">';
print '<h2>Issue Form</h2>';
?>
<form action="insert_issue.php" method="post">
<p><label>Short Description <input type="text" name="issue_short" value="<?php if (isset($_POST['issue_short'])) {print $_POST['issue_short'];} ?>"></label></p>
<p><label>Description</label>
<textarea name="issue_text" cols="40" rows="5"><?php if (isset($_POST['issue_text'])) {print $_POST['issue_text'];} ?></textarea>
</p>
<p><label>Reported By <input type="text" name="reported_by" value="<?php if (isset($_POST['reported_by'])) {print $_POST['reported_by'];}  ?>"></label></p>
<p><label>Member ID <input type="number" name="assigned_memberid" value="<?php if (isset($_POST['assigned_memberid'])) {print $_POST['assigned_memberid'];}  ?>"></label></p>
<p><label>Reported Date <input type="date" name="date_reported" value="<?php if (isset($_POST['date_reported'])) {print $_POST['date_reported'];}  ?>"></label></p>
<p><label>Assigned Date <input type="date" name="date_assigned" value="<?php if (isset($_POST['date_assigned'])) {print $_POST['date_assigned'];}  ?>"></label></p>
<p><label>Resolved Start <input type="date" name="date_resolved" value="<?php if (isset($_POST['date_resolved'])) {print $_POST['date_resolved'];}  ?>"></label></p>
<p><label>Resolution <input type="text" name="resolution_text" value="<?php if (isset($_POST['resolution_text'])) {print $_POST['resolution_text'];}  ?>"></label></p>
<p><label>New Task ID<input type="number" name="assigned_taskid" value="<?php if (isset($_POST['assigned_taskid'])) {print $_POST['assigned_taskid'];} ?>"></label></p>
<p><label>Status <input type="text" name="status" value="<?php if (isset($_POST['status'])) {print $_POST['status'];} ?>"></label></p>
<p><label>Hours Worked <input type="number" name="person_hours_actual" value="<?php if (isset($_POST['person_hours_actual'])) {print $_POST['person_hours_actual'];}  ?>"></label></p>
<p><input type="submit" name="submit" value="Create"></p>
</form>
<?php

?>
</div>
</body>
</html>

