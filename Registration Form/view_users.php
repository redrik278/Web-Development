<?php
session_start();

// Check if user is logged in
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

// Fetch all users from the database
$sql = "SELECT * FROM Users";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>All Users</h2>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>User Type</th>
            </tr>
        </thead>
        <tbody>
            <?php while($user = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $user['ID']; ?></td>
                <td><?php echo $user['Name']; ?></td>
                <td><?php echo $user['Email']; ?></td>
                <td><?php echo $user['UserType']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="homepage.php" class="btn btn-primary">Back to Home</a>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
