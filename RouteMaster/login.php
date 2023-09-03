<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "RouteMaster";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$loginError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Regular expression to validate username format
    $usernamePattern = "/^[a-zA-Z0-9_-]{3,20}$/";

    $selectQuery = "SELECT UserID, Password, UserType FROM users WHERE Username = ?";

    $stmt = $conn->prepare($selectQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($userID, $hashedPassword, $userType);
        $stmt->fetch();

        if (!preg_match($usernamePattern, $username)) {
            $loginError = "Invalid username format.";
        } elseif (password_verify($password, $hashedPassword)) {
            $_SESSION["userID"] = $userID;
            $_SESSION["userType"] = $userType;

            // Set a cookie to remember login (example: valid for 1 day)
            setcookie("user_login", $userID, time() + 86400, "/"); // 86400 seconds = 1 day

            // Redirect to dashboard
            header("Location: homepage.php");
            exit();
        } else {
            $loginError = "Invalid credentials";
        }
    } else {
        $loginError = "Invalid credentials";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <a class="navbar-brand" href="#">RouteMaster</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        
        <?php if (isset($loginError)) { echo "<p class='text-danger'>$loginError</p>"; } ?>
        
        <?php
        // Display logout alert message if set
        if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
            echo '<div class="alert alert-success mt-3">Successfully logged out!</div>';
        }
        ?>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
