<?php
session_start();

// Check if user is not logged in
if (!isset($_SESSION['userID'])) {
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

// Fetch user data based on session userID
$stmt = $conn->prepare("SELECT * FROM Users WHERE ID = ?");
$stmt->bind_param("i", $_SESSION['userID']);

$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>User Profile</h2>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Attribute</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>ID</td>
                <td><?php echo $user['ID']; ?></td>
            </tr>
            <tr>
                <td>Name</td>
                <td><?php echo $user['Name']; ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?php echo $user['Email']; ?></td>
            </tr>
            <tr>
                <td>User Type</td>
                <td><?php echo $user['UserType']; ?></td>
            </tr>
            <!-- You can continue adding rows for other attributes as needed -->
        </tbody>
    </table>

    <a href="homepage.php" class="btn btn-primary">Back to Home</a>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
