<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body  style="margin-left:20px;">  

<?php
// define variables and set to empty values
$nameErr = $emailErr = $passwordErr = $ipErr = $websiteErr = $dobErr = $genderErr = $mobileNumberErr = $briefInfoErr = "";
$name = $email = $password = $ipAddress = $website = $dob = $gender = $mobileNumber = $briefInfo = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }
  
  if (empty($_POST["email"])) {
    
  } else {
    $email = test_input($_POST["email"]);
    if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/",$email)  ) {
      $emailErr = "Invalid email format";
    }
  }
  
  if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
  } else {
    $password = test_input($_POST["password"]);
    // check if password meets the required conditions
    $password_regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{7,25}$/';
    if (!preg_match($password_regex, $password)) {
      $passwordErr = "Password must contain an uppercase, a lowercase, a number, and no special characters. It should be 7-25 characters long.";
    }
  }

  if (empty($_POST["ip_address"])) {
    $ipAddressErr = "IP address is required";
  } else {
    $ipAddress = test_input($_POST["ip_address"]);
    // check if IP address is valid
    $ip_regex = '/^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/';
    if (!preg_match($ip_regex, $ipAddress)) {
      $ipErr = "Invalid IP address format.";
    }
  }

  if (!empty($_POST["website"])) {
    $website = test_input($_POST["website"]);
    // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
      $websiteErr = "Invalid URL";
    }
  }

  if (!empty($_POST["dob"])) {
    $dob = test_input($_POST["dob"]);
    // check if date of birth is valid (DD-MM-YYYY format)
    $dob_regex = '/^(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-\d{4}$/';
    if (!preg_match($dob_regex, $dob)) {
      $dobErr = "Invalid date format. (DD-MM-YYYY)";
    }
  }

  if (!empty($_POST["gender"])) {
    $gender = test_input($_POST["gender"]);
  }

  if (!empty($_POST["mobile_number"])) {
    $mobileNumber = test_input($_POST["mobile_number"]);
    // check if mobile number is valid (Bangladeshi number)
    $mobile_regex = '/^(\+?88)?01[3-9]\d{8}$/';
    if (!preg_match($mobile_regex, $mobileNumber)) {
      $mobileNumberErr = "Invalid mobile number format. (e.g., +88017XXXXXXXX or 017XXXXXXXX)";
    }
  }

  if (!empty($_POST["brief_info"])) {
    $briefInfo = test_input($_POST["brief_info"]);
    // check if brief info meets the required conditions
    $brief_info_regex = '/^(?:\w+\s?){1,50}$/';
    if (!preg_match($brief_info_regex, $briefInfo)) {
      $briefInfoErr = "Brief info must not exceed 50 words and contain only alphanumeric characters.";
    }
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h1> Register Form</h1>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Name: <input type="text" name="name" placeholder="Enter a name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  E-mail: <input type="text" name="email" placeholder="Enter a valid email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>
  Password: <input type="password" name="password" placeholder="Enter a valid password" value="<?php echo $password;?>">
  <span class="error">* <?php echo $passwordErr;?></span>
  <br><br>
  IP address: <input type="text" name="ip_address" placeholder="Enter the ip" value="<?php echo $ipAddress;?>">
  <span class="error">* <?php echo $ipErr;?></span>
  <br><br>
  Personal web URL: <input type="text" name="website" placeholder="Enter your personal website" value="<?php echo $website;?>">
  <span class="error"><?php echo $websiteErr;?></span>
  <br><br>
  Date of Birth: <input type="text" name="dob" placeholder="Enter DOB" value="<?php echo $dob;?>" placeholder="DD-MM-YYYY">
  <span class="error">* <?php echo $dobErr;?></span>
  <br><br>
  Gender:
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">Female
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">Male
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="other") echo "checked";?> value="other">Other  
  <span class="error">* <?php echo $genderErr;?></span>
  <br><br>
  Mobile Number: <input type="text" name="mobile_number" placeholder="Enter Mobile Number" value="<?php echo $mobileNumber;?>">
  <span class="error"><?php echo $mobileNumberErr;?></span>
  <br><br>
  Brief info: <textarea name="brief_info" placeholder="Enter brief description about yourself" rows="30" cols="30"><?php echo $briefInfo;?></textarea>
  <br><br>
  <input type="submit" name="Register" value="Submit">  
</form>

<?php
echo "<h2>Your Input:</h2>";
echo $name;
echo "<br>";
echo $email;
echo "<br>";
echo $password;
echo "<br>";
echo $ipAddress;
echo "<br>";
echo $website;
echo "<br>";
echo $dob;
echo "<br>";
echo $gender;
echo "<br>";
echo $mobileNumber;
echo "<br>";
echo $briefInfo;
?>

</body>
</html>
