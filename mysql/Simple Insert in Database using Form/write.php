<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
// define variables and set to empty values
$nameErr = $markErr = "";
$name = $mark = "";

if ($_POST) {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
  }
  
  if (empty($_POST["mark"])) {
    $markErr = "mark is required";
  } else {
    $mark = test_input($_POST["mark"]);
  }
 
  // redirect to another page
  if(!empty($_POST["name"]) && !empty($_POST["mark"]))
  {	
	$link = mysqli_connect("localhost", "root", "", "student");
 
	// Check connection
	if($link === false)
	{
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
 
	// Attempt insert query execution
	echo $name." ". $mark;
	$sql = "INSERT INTO info VALUES ('$name', '$mark')";
	if(mysqli_query($link, $sql)){
		echo "Records inserted successfully.";
	} else{
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}
	 
	// Close connection
	  mysqli_close($link);
	  
	//  header("Location: success.php");
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>PHP Form Validation Example</h2>
<p><span class="error">* required field.</span></p>
<form method="post" action="">
  Name: <input type="text" name="name" value="<?php if(isset($_POST['name'])) echo $_POST['name']; ?>" /> 
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  mark: <input type="mark" name="mark" value="<?php if(isset($_POST['mark'])) echo $_POST['mark']; ?>" /> 
  <span class="error">* <?php echo $markErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>

</body>
</html>


