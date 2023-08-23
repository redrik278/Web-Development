<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "registration";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $user_type = $_POST['user_type'];

    $name_pattern = "/^[a-zA-Z\s]{2,50}$/";
    $email_pattern = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/";
    $password_pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$/";

    if (!preg_match($name_pattern, $name)) {
        $message = "Invalid name format.";
    } elseif (!preg_match($email_pattern, $email)) {
        $message = "Invalid email format.";
    } elseif (!preg_match($password_pattern, $password)) {
        $message = "Password must be between 8-20 characters and contain at least one uppercase letter, one lowercase letter, one digit, and one special character.";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        // Check if the email already exists in the database
        $stmt = $conn->prepare("SELECT * FROM Users WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Email already exists, show an error message
            $message = "This email is already registered.";
        } else {
            // Email doesn't exist, proceed with registration
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO Users (Name, Email, UserType, Password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $user_type, $hashed_password);

            if ($stmt->execute()) {
                $message = "Registered successfully!";
            } else {
                $message = "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h2 class="text-center">Registration Form</h2>

            <?php if ($message): ?>
            <div class="alert alert-danger">
                <?php echo $message; ?>
            </div>
            <?php endif; ?>

            <form action="register.php" method="post" class="mt-4">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>

                <div class="form-group">
                    <label for="user_type">User Type:</label>
                    <select class="form-control" id="user_type" name="user_type">
                        <option value="Admin">Admin</option>
                        <option value="User">User</option>
                    </select>
                </div>

                <div class="form-group">
                    <input type="submit" value="Register" class="btn btn-primary btn-block">
                </div>
                <div class="text-center mt-4">
                    <p><a href="login.php" class="btn btn-danger btn-block">Login</a></p>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
