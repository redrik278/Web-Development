<?php
session_start();

if (!isset($_SESSION['userID']) || !isset($_SESSION['userName'])) {
    header("Location: login.php");
    exit;
}

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
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];

    $stmt = $conn->prepare("SELECT Password FROM Users WHERE ID = ?");
    $stmt->bind_param("i", $_SESSION['userID']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($currentPassword, $user['Password'])) {
            // Update password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE Users SET Password = ? WHERE ID = ?");
            $stmt->bind_param("si", $hashedPassword, $_SESSION['userID']);
            $stmt->execute();

            $message = "Password updated successfully!";
        } else {
            $message = "Current password is incorrect!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Change Password</h2>

    <?php if ($message): ?>
    <div class="alert alert-info">
        <?php echo $message; ?>
    </div>
    <?php endif; ?>

    <form action="change_password.php" method="post" class="mt-4">
        <div class="form-group">
            <label for="currentPassword">Current Password:</label>
            <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
        </div>

        <div class="form-group">
            <label for="newPassword">New Password:</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
        </div>

        <div class="form-group">
            <input type="submit" value="Change Password" class="btn btn-primary btn-block">
        </div>
    </form>
    <a href="homepage.php" class="btn btn-secondary">Back to Home</a>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
