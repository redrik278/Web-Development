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
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;

    // Fetch the user based on email
    $stmt = $conn->prepare("SELECT * FROM Users WHERE Email = ?");
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['Password'])) {
            // Start session and store user data in session
            session_start();
            $_SESSION['userID'] = $user['ID'];
            $_SESSION['userName'] = $user['Name'];

            if ($remember) {
                setcookie("userEmail", $user['Email'], time() + (86400 * 7), "/");
                
            }

            header("Location: homepage.php");
            exit;
        } else {
            $message = "Invalid password!";
        }
    } else {
        $message = "User not found!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h2 class="text-center">Login</h2>

            <?php if ($message): ?>
            <div class="alert alert-danger">
                <?php echo $message; ?>
            </div>
            <?php endif; ?>

            <form action="login.php" method="post" class="mt-4">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>

                <div class="form-group">
                    <input type="submit" value="Login" class="btn btn-primary btn-block">
                </div>
                <div class="text-center mt-4">
                    <p>Don't have an account? <a href="register.php" class="btn btn-success">Register</a></p>
                </div>
            </form>

        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
