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
  if (!empty($_POST['issueid'])) { 
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
                            $issueid = $_POST['issueid'];
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

                            // Run update SQL
                            $query = "UPDATE issue set " . 
                                    "issue_short = '" . $issue_short . "', " .
                                    "issue_text = '" . $issue_text . "'," . 
                                    "reported_by = '" . $reported_by . "'," . 
                                    "assigned_memberid = " . $assigned_memberid . "," .
                                    "date_reported = '" . $date_reported . "'," . 
                                    "date_assigned = '" . $date_assigned . "'," .
                                    "date_resolved = '" . $date_resolved . "'," .
                                    "resolution_text = '" . $resolution_text . "'," .
                                    "assigned_taskid = " . $assigned_taskid . "," .
                                    "status = '" . $status . "'," .
                                    "person_hours_actual = " . $person_hours_actual . 
                                    "where issueid = " . $issueid ;
                            if ($result = mysqli_query($dbc,$query)) {
                                if ($result) {
                                    print '<div class="container"><p>Issue has been updated in the database.</p></div>';
                                } else {
                                    print '<div class="container"><p>No rows were updated.</p></div>';
                                }
                            } else {
                                print '<div class="container"><p>Could not edit your issue information in the database .  Error:<br>' . mysqli_error($dbc) . '.</p></div>';
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
  } else {
    // issueid not set
    print '<p style="color: red;">issue id not entered.</p>';
  }
} else {
	// GET method and retrieve project data from projectid argument
  if (!empty($_GET['issueid'])) {
    $issueid = $_GET['issueid'];
	$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
    $query = "SELECT issueid, issue_short, issue_text, reported_by, assigned_memberid, date_reported, date_assigned, date_resolved, resolution_text, assigned_taskid, status, person_hours_actual FROM issue WHERE issueid = " . $issueid ;
    if ($result = mysqli_query($dbc,$query)) {
      $row = $result->fetch_assoc();
      $issueid = $row['issueid'];
      $issue_short = $row['issue_short'];
      $issue_text = $row['issue_text'];
      $reported_by = $row['reported_by'];
      $assigned_memberid = $row['assigned_memberid'];
      $date_reported = $row['date_reported'];
      $date_assigned = $row['date_assigned'];
      $date_resolved = $row['date_resolved'];
      $resolution_text = $row['resolution_text'];
      $assigned_taskid = $row['assigned_taskid'];
      $status =  $row['status'];
      $person_hours_actual =  $row['person_hours_actual'];

      $_POST['issueid'] = $issueid;
      $_POST['issue_short'] = $issue_short;
      $_POST['issue_text'] = $issue_text;
      $_POST['reported_by'] = $reported_by;
      $_POST['assigned_memberid'] = $assigned_memberid;
      $_POST['date_reported'] = $date_reported;
      $_POST['date_assigned'] = $date_assigned;
      $_POST['date_resolved'] = $date_resolved;
      $_POST['resolution_text'] = $resolution_text;
      $_POST['assigned_taskid'] = $assigned_taskid;
      $_POST['person_hours_actual'] = $person_hours_actual;
      $_POST['status'] = $status;
      $_POST['person_hours_actual'] = $person_hours_actual;
      
      mysqli_close($dbc); // Close the connection
    }
  }	
}

// First time show the form
// 
print '<div class="container">';
print '<h2>Issue Form</h2>';
?>
<form action="edit_issue.php" method="post">
<p><label>Issue ID <input type="number" name="issueid" value="<?php if (isset($_POST['issueid'])) {print $_POST['issueid'];} ?>"></label></p>
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
<p><input type="submit" name="submit" value="Update"></p>
</form>
<?php

?>
</div>
</body>
</html>

