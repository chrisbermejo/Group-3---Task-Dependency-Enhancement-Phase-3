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

include('include/header.php');

print '<div class="container">';
if (!empty($_GET['taskid'])) {
    $taskid = $_GET['taskid'];
	$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
    $query = "SELECT dependency_id FROM task_dependencies WHERE task_id = " . $taskid ;
    $result = mysqli_query($dbc,$query);
    if(mysqli_num_rows($result) == 0) {
        echo "<h2>No task dependency found</h2>";
    }else{
        print '<h2>Task Dependency</h2>';
        if ($result = mysqli_query($dbc,$query)) {
            while($row = $result->fetch_assoc()){
              $dep = $row['dependency_id'];
              print 'Task ID: ' . $dep . '<br>';
              print " ";
            } 
          }
    }				
}

?>
</div>
</body>
</html>

