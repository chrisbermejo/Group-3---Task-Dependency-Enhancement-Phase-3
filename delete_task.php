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
   This page shows a form to edit a task 
   The taskid is retrieved from the get method on first pass
   The variables are retrieved from the post method to retreive the changes from the screen
   A connection is established to the database
   SQL is prepared to insert the data in the database
   task table contains:
   taskid
   title
   description
   projectid
   memberid
   date_start
   date_target
   date_actual_start
   date_actual_completion
   person_hours_estimate
   person_houts_actual
   status
   dependency
*/
include('include/header.php');

$query_flag = false;
//
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!empty($_POST['taskid'])) {
	if (!empty($_POST['title'])) {
		if (!empty($_POST['description'])) {
			if (!empty($_POST['projectid'])) {
				if (!empty($_POST['memberid'])) {
                    if (!empty($_POST['date_start'])) {
                        if (!empty($_POST['date_target'])) {
                            if (!empty($_POST['date_actual_start'])) {
                                if (!empty($_POST['date_actual_completion'])) {
                                    if (!empty($_POST['person_hours_estimate'])) {
                                        if (!empty($_POST['person_hours_actual'])) {
                                            if (!empty($_POST['status'])) {
                                                if ((!empty($_POST['dependency'])) || $_POST['dependency'] == 0){
                            // Handle form data
                            $taskid = $_POST['taskid'];
                            $title = $_POST['title'];
                            $description = $_POST['description'];
                            $projectid = $_POST['projectid'];
                            $memberid = $_POST['memberid'];
                            $date_start = $_POST['date_start'];
                            $date_target = $_POST['date_target'];
                            $date_actual_start = $_POST['date_actual_start'];
                            $date_actual_completion = $_POST['date_actual_completion'];
                            $person_hours_estimate = $_POST['person_hours_estimate'];
                            $person_hours_actual = $_POST['person_hours_actual'];
                            $status =  $_POST['status'];
                            $dependency =  $_POST['dependency'];
                            $dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());

                            // Run Delete SQL
                            $query = "delete FROM task " . " WHERE taskid = " . $taskid;
                            if (mysqli_query($dbc,$query)) {
                                $query_flag = true;
                                $query = "SELECT task_id FROM task_dependencies WHERE dependency_id IS NULL";
                                $result = mysqli_query($dbc, $query);   
                                $num_rows = mysqli_num_rows($result);
                                
                                if($num_rows > 0){
                                    while ($row = mysqli_fetch_array($result)) {
                                    $update_query = "UPDATE task SET dependency = dependency - 1 WHERE taskid = " . $row['task_id'];
                                    mysqli_query($dbc, $update_query);
                                }
                                $query2 = "DELETE FROM task_dependencies WHERE dependency_id IS NULL";
                                $result2 = mysqli_query($dbc,$query2);
                                }

                                if (mysqli_affected_rows($dbc) > 0 || $query_flag) {
                                    print '<div class="container"><p>Task information has been deleted from the database.</p></div>';
                                } else {
                                    print '<div class="container"><p>No rows were deleted.</p></div>';
                                }
                            } else {
                                print '<div class="container"><p>Could not delete your task information from the database .  Error:<br>' . mysqli_error($dbc) . '.</p></div>';
                            }
                            mysqli_close($dbc); // Close the connection.
                                                } else {
                                                    // Dependency not set
                                                    print '<p style="color: red;">Dependency not entered.</p>';
                                                }
                                            } else {
                                                // Status not set
                                                print '<p style="color: red;">Status Hours Actual not entered.</p>';
                                            }
                                        } else {
                                            // Person Hours Actual not set
                                            print '<p style="color: red;">Person Hours Actual not entered.</p>';
                                        }
                                    } else {
                                        // Person Hours Estimate not set
                                        print '<p style="color: red;">Person Hours Estimate not entered.</p>';
                                    }
                                } else {
                                    // Actual Completion Date not set
                                    print '<p style="color: red;">Actual Completion Date not entered.</p>';
                                }
                            } else {
                                // Actual Start Date not set
                                print '<p style="color: red;">Actual Start Date not entered.</p>';
                            }
                        } else {
                            // Target Date not set
                            print '<p style="color: red;">Target Date not entered.</p>';
                        }
                    } else {
                        // Start Date  not set
                        print '<p style="color: red;">Start Date not entered.</p>';
                    }
				} else {
					// memberid not set
					print '<p style="color: red;">Memberid not entered.</p>';
				}
			} else {
				// projectid not set
				print '<p style="color: red;">Project id not entered.</p>';

			}	
		} else {
			// description not set
			print '<p style="color: red;">Description not entered.</p>';

		}
	} else {
		// title not set
		print '<p style="color: red;">title not entered.</p>';
	}
  } else {
    // taskid not set
    print '<p style="color: red;">taskid not entered.</p>';
  }
} else {
	// GET method and retrieve project data from projectid argument
  if (!empty($_GET['taskid'])) {
    $taskid = $_GET['taskid'];
	$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
    $query = "SELECT taskid, title, description, projectid, memberid, date_start, date_target, date_actual_start, date_actual_completion, person_hours_estimate, person_hours_actual, status, dependency FROM task WHERE taskid = " . $taskid ;
    if ($result = mysqli_query($dbc,$query)) {
      $row = $result->fetch_assoc();
      $taskid = $row['taskid'];
      $title = $row['title'];
      $description = $row['description'];
      $projectid = $row['projectid'];
      $memberid = $row['memberid'];
      $date_start = $row['date_start'];
      $date_target = $row['date_target'];
      $date_actual_start = $row['date_actual_start'];
      $date_actual_completion = $row['date_actual_completion'];
      $person_hours_estimate = $row['person_hours_estimate'];
      $person_hours_actual = $row['person_hours_actual'];
      $status = $row['status'];
      $dependency = $row['dependency'];

      $_POST['taskid'] = $taskid;
      $_POST['title'] = $title;
      $_POST['description'] = $description;
      $_POST['projectid'] = $projectid;
      $_POST['memberid'] = $memberid;
      $_POST['date_start'] = $date_start;
      $_POST['date_target'] = $date_target;
      $_POST['date_actual_start'] = $date_actual_start;
      $_POST['date_actual_completion'] = $date_actual_completion;
      $_POST['person_hours_estimate'] = $person_hours_estimate;
      $_POST['person_hours_actual'] = $person_hours_actual;
      $_POST['status'] = $status;
      $_POST['dependency'] = $dependency;
      $sql = "SELECT * FROM task_dependencies WHERE task_id = $taskid";
      $result = $dbc->query($sql);
      $i = 0;
      while ($row = $result->fetch_assoc()) {
            $_POST["dependency_$i"] = $row['dependency_id'];
            $i++;
      }
      mysqli_close($dbc); // Close the connection
    }
  }				
}
// 
print '<div class="container">';
print '<h2>Task Form</h2>';
?>
<form action="delete_task.php" method="post">
<p><label>Task ID <input type="number" name="taskid" value="<?php if (isset($_POST['taskid'])) {print $_POST['taskid'];} ?>"></label></p>
<p><label>Title <input type="text" name="title" value="<?php if (isset($_POST['title'])) {print $_POST['title'];} ?>"></label></p>
<p><label>Description</label>
<textarea name="description" cols="40" rows="5"><?php if (isset($_POST['description'])) {print $_POST['description'];} ?></textarea>
</p>
<p><label>Project ID <input type="number" name="projectid" value="<?php if (isset($_POST['projectid'])) {print $_POST['projectid'];}  ?>"></label></p>
<p><label>Member ID <input type="number" name="memberid" value="<?php if (isset($_POST['memberid'])) {print $_POST['memberid'];}  ?>"></label></p>
<p><label>Start Date <input type="date" name="date_start" value="<?php if (isset($_POST['date_start'])) {print $_POST['date_start'];}  ?>"></label></p>
<p><label>Target Date <input type="date" name="date_target" value="<?php if (isset($_POST['date_target'])) {print $_POST['date_target'];}  ?>"></label></p>
<p><label>Actual Start <input type="date" name="date_actual_start" value="<?php if (isset($_POST['date_actual_start'])) {print $_POST['date_actual_start'];}  ?>"></label></p>
<p><label>Completion Date <input type="date" name="date_actual_completion" value="<?php if (isset($_POST['date_actual_completion'])) {print $_POST['date_actual_completion'];}  ?>"></label></p>
<p><label>Person Hours Est<input type="number" name="person_hours_estimate" value="<?php if (isset($_POST['person_hours_estimate'])) {print $_POST['person_hours_estimate'];} ?>"></label></p>
<p><label>Person Hours Actual<input type="number" name="person_hours_actual" value="<?php if (isset($_POST['person_hours_actual'])) {print $_POST['person_hours_actual'];} ?>"></label></p>
<p><label>Status <input type="text" name="status" value="<?php if (isset($_POST['status'])) {print $_POST['status'];} ?>"></label></p>
<p><label>Dependency <input type="number" id="dependencyID" name="dependency" value="<?php if (isset($_POST['dependency'])) {print $_POST['dependency'];}  ?>"></label></p>
<?php
        if(isset($_POST['dependency'])){
            for($i = 0; $i < $dependency; $i++){
                $taskId = $i + 1;
                $dependencyValue = isset($_POST["dependency_$i"]) ? $_POST["dependency_$i"] : '';
                echo '<p class="dom-del"><label>TaskID #' . $taskId . '  <input type="number" name="dependency_' . $i . '" class="dom-button" value="' . $dependencyValue . '"></label></p>';
            }
        }
?>
<p><input type="submit" name="submit" value="Delete"></p>
</form>
<?php

?>
</div>
</body>

</html>

