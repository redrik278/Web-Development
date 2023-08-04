<?php
  include("db.php");
  if(isset($_POST['send']) != "") {
      $username = mysqli_real_escape_string($connection, $_POST['username']);
      $usermail = mysqli_real_escape_string($connection, $_POST['usermail']);
      $usermobile = mysqli_real_escape_string($connection, $_POST['usermobile']);
      $update = mysqli_query($connection, "INSERT INTO info(username,emailid,mobileno,created)VALUES
									  ('$username','$usermail','$usermobile',now())");
  
  if($update) {
	  $msg="Successfully Updated!!";
	  echo "<script type='text/javascript'>alert('$msg');</script>";
	  header('Location:index.php');
  } else {
	 $errormsg="Something went wrong, Try again";
	  echo "<script type='text/javascript'>alert('$errormsg');</script>";
	  header('Location:index.php');
  }
  }
 ob_end_flush();
?>
