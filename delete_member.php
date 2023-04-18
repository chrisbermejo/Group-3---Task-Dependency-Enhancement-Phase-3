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
//
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  print '<div class="container">';
	if (!empty($_POST['memberid'])) {
		if (!empty($_POST['name'])) {
			if (!empty($_POST['email'])) {
				if (!empty($_POST['role'])) {
					if (!empty($_POST['isActive'])) {
                        if (!empty($_POST['teamid'])) {
                            // Handle form data
                            $memberid = $_POST['memberid'];
                            $name = $_POST['name'];
                            $email = $_POST['email'];
                            $role = $_POST['role'];
                            $isActive = $_POST['isActive'];
                            $teamid = $_POST['teamid'];
                            $dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
                            // Run UPDATE SQL
                            $query = "DELETE FROM member " . 
                " WHERE memberid = " . $memberid;
                
                            if ($result = mysqli_query($dbc,$query)) {
                                if ($result) {
                                    print '<p>Member information has been deleted in the database.</p>';
                                } else {
                                    print '<p>No rows were updated.</p>';
                                }
                            } else {
                                print '<p>Mysql query error occured.</p>';
                            }
                            mysqli_close($dbc); // Close the connection.
                        } else {
                            // teamid not set
                            print '<p style="color: red;">teamid not entered.</p>';
                        }
					} else {
						// isActive not set
						print '<p style="color: red;">isActive not entered.</p>';
					}
				} else {
					// role not set
					print '<p style="color: red;">Role not entered.</p>';
				}
			} else {
				// Email not set
				print '<p style="color: red;">Email not entered.</p>';

			}	
		} else {
			// Name not set
			print '<p style="color: red;">Name not entered.</p>';

		}
	} else {
		// memberid not set
		print '<p style="color: red;">Member id not entered.</p>';
	}
  print '</div>';
} else {
	// GET method and retrieve team data from memeberid argument
  if (!empty($_GET['memberid'])) {
    $memberid = $_GET['memberid'];
    // Setup database connection
	$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) OR die ('Could not connect to MySQL: ' . mysqli_connect_error());
    $query = "SELECT memberid, name, email, role, isActive, teamid FROM member WHERE memberid = " . $memberid ;
    if ($result = mysqli_query($dbc,$query)) {
      $row = $result->fetch_assoc();
      $name = $row['name'];
      $email = $row['email'];
      $role = $row['role'];
      $isActive = $row['isActive'];
      $teamid = $row['teamid'];
      $_POST['memberid'] = $memberid;
      $_POST['name'] = $name;
      $_POST['email'] = $email;
      $_POST['role'] = $role;
      $_POST['isActive'] = $isActive;
      $_POST['teamid'] = $teamid;
      mysqli_close($dbc); // Close the connection
    }
  }				
}
print '<div class="container">';
print '<h2>Team Form</h2>';
?>
<form action="delete_member.php" method="post">
<p><label>Member Id <input type="number" name="memberid" value="<?php if (isset($_POST['memberid'])) {print $_POST['memberid'];} ?>"></label></p>
<p><label>Name <input type="text" name="name" value="<?php if (isset($_POST['name'])) {print $_POST['name'];} ?>"></label></p>
<p><label>Email <input type="email" name="email" value="<?php if (isset($_POST['email'])) {print $_POST['email'];} ?>"></label></p>
<p><label>Roled <input type="text" name="role" value="<?php if (isset($_POST['role'])) {print $_POST['role'];} ?>"></label></p>
<p><label>Active <input type="text" name="isActive" value="<?php if (isset($_POST['isActive'])) {print $_POST['isActive'];} ?>"></label></p>
<p><label>Team Id <input type="number" name="teamid" value="<?php if (isset($_POST['teamid'])) {print $_POST['teamid'];} ?>"></label></p>
<p><input type="submit" name="submit" value="Delete"></p>
</form>

</div>
</body>
</html>