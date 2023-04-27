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

$old_dep = -1;

function checkFormInputs() {
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
                                                if ((!empty($_POST['dependency'])) || $_POST['dependency'] == 0) {
                                                    $i = 0;
                                                    $dependencynum =  $_POST['dependency'];
                                                    if($_POST['dependency'] != 0){
                                                        while($i < $dependencynum){
                                                            if(empty($_POST["dependency_$i"])){
                                                                $i++;
                                                                print '<p style="color: red;">TaskID #' . $i . ' is not entered</p>';
                                                                return false;
                                                            }
                                                            if(isset($_POST["dependency_$i"])){
                                                                $id = $_POST["dependency_$i"];
                                                                $dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
                                                                $check_query = "SELECT * FROM task WHERE taskid = '$id'";
                                                                $result = mysqli_query($dbc, $check_query);
                                                                if (mysqli_num_rows($result) < 1){
                                                                    $i++;
                                                                print '<p style="color: red;">TaskID #' . $i . ' is not valid</p>';
                                                                    return false;
                                                                }
                                                            }
                                                            $i++;
                                                        };
                                                    }
                                                    return true;
                                                } else {
                                                    print '<p style="color: red;">Dependency not entered.</p>';
                                                }
                                            } else {
                                                print '<p style="color: red;">Status Hours Actual not entered.</p>';
                                            }
                                        } else {
                                            print '<p style="color: red;">Person Hours Actual not entered.</p>';
                                        }
                                    } else {
                                        print '<p style="color: red;">Person Hours Estimate not entered.</p>';
                                    }
                                } else {
                                    print '<p style="color: red;">Actual Completion Date not entered.</p>';
                                }
                            } else {
                                print '<p style="color: red;">Actual Start Date not entered.</p>';
                            }
                        } else {
                            print '<p style="color: red;">Target Date not entered.</p>';
                        }
                    } else {
                        print '<p style="color: red;">Start Date not entered.</p>';
                    }
                } else {
                    print '<p style="color: red;">Memberid not entered.</p>';
                }
            } else {
                print '<p style="color: red;">Project id not entered.</p>';
            }   
        } else {
            print '<p style="color: red;">Description not entered.</p>';
        }
    } else {
        print '<p style="color: red;">Title not entered.</p>';
    }
    return false;
}

//
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $flag = checkFormInputs();
    if($flag == true){
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

        // Run INSERT SQL
        $query = "UPDATE task " . 
                " set title = '" . $title ."'," . 
                " description = '" . $description ."'," . 
                " projectid = ". $projectid .", " . 
                " memberid = " . $memberid . ", " .
                " date_start = '" . $date_start . "'," . 
                " date_target = '" . $date_target . "'," . 
                " date_actual_start = '" . $date_actual_start . "'," . 
                " date_actual_completion = '" . $date_actual_completion . "'," . 
                " person_hours_estimate = " . $person_hours_estimate . "," . 
                " person_hours_actual = " . $person_hours_actual . "," . 
                " status = '" . $status . "'," . 
                " dependency = " . $dependency . 
                " WHERE taskid = " . $taskid;
        $query2 = "DELETE FROM task_dependencies WHERE task_id = " . $taskid;
        mysqli_query($dbc, $query2);
        if($dependency > 0){
            for($i = 0; $i < $dependency; $i++ ){
                $dependency_id = $_POST["dependency_$i"];
                $sql = "INSERT INTO task_dependencies (task_id, dependency_id) VALUES ('$taskid', '$dependency_id')";
                $result = mysqli_query($dbc, $sql);
            }
        }
        if ($result = mysqli_query($dbc,$query)) {
            if ($result) {
                print '<div class="container"><p>Task information has been updated in the database.</p></div>';
            } else {
                print '<div class="container"><p>No rows were updated.</p></div>';
            }
        } else {
            print '<div class="container"><p>Could not update your task information to the database .  Error:<br>' . mysqli_error($dbc) . '.</p></div>';
        }
        mysqli_close($dbc); // Close the connection.
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
<form action="edit_task.php" method="post">
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
<p><label>Dependency <input type="number" id="myDependency" name="dependency" value="<?php if (isset($_POST['dependency'])) {print $_POST['dependency'];}  ?>"></label></p>
<?php
    if(isset($_POST['dependency'])){
        for($i = 0; $i < $dependency; $i++){
            $taskId = $i + 1;
            $dependencyValue = isset($_POST["dependency_$i"]) ? $_POST["dependency_$i"] : '';
            echo '<p class="dom-del"><label>TaskID #' . $taskId . '  <input type="number" name="dependency_' . $i . '" class="dom-button" value="' . $dependencyValue . '"></label></p>';
        }
    }
?>
<div id="task-dom-con"></div>
<p><input type="submit" name="submit" value="Update"></p>
</form>
<?php

?>
</div>
</body>
<script src="js/task_dependency.js"></script>
</html>

