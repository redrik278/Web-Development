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

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["userID"]) && $_SESSION["userType"] === 'user' && isset($_POST["bookTicket"])) {
    $routeID = $_POST["routeID"];
    $userID = $_SESSION["userID"];
    $ticketType = $_POST["ticketType"];
    $priceAmount = $_POST["priceAmount"];

    // Insert booking information into the bookings table
    $insertBookingQuery = "INSERT INTO bookings (RouteID, UserID) VALUES (?, ?)";
    $stmt = $conn->prepare($insertBookingQuery);
    $stmt->bind_param("ii", $routeID, $userID);

    if ($stmt->execute()) {
        // Booking successful, you can add more logic here if needed
        $message = "Ticket booked successfully!";
    } else {
        $message = "Error booking ticket: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Ticket</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Book Ticket</h2>
        <p><?php echo $message; ?></p>
        <a href="homepage.php" class="btn btn-primary">Back to Homepage</a>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
